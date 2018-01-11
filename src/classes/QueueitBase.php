<?php

use QueueIT\KnownUserV3\SDK\QueueEventConfig;

/**
 * Base class implementing Queue-it framework.
 */
class QueueitBase {

  /* Protected variables */
  protected $apiKey;         // API Key.
  protected $customerID;     // Customer ID.
  protected $secretKey;      // Secret key.
  protected $eventConfig;    // Event config.
  protected $configJson;     // Integration config.

  /* Variables used for 'configuration in code' method */
  protected $eventID;        // Event ID (code only).
  protected $queueDomain;    // Domain name of the queue (code only).
  protected $cookieValidity; // Session cookie validity time (in min).
  protected $extendCookie;  // Extended validity of session cookie (bool).
  protected $cookieDomain;   // Cookie domain.
  protected $layoutName;     // Name of the queue ticket layout.
  protected $cultureLayout;  // Culture of the queue ticket layout.

  /* Other variables */
  protected $isDebug;        // Debug mode.

  /* Constants */
  const QI_API_DOMAIN    = 'queue-it.net';
  const QI_CONFIG_URI    = '/status/integrationconfig';
  const QI_JS_CLIENT_URL = '//static.queue-it.net/script/queueclient.min.js';
  const QI_JS_LOADER_URL = '//static.queue-it.net/script/queueconfigloader.min.js';

  /**
   * Class constructor.
   */
  public function __construct($customer_id = '', $secret_key = '', $api_key = '') {
    $this->apiKey = $api_key
      ?: variable_get('queueit_api_key');
    $this->customerID = $customer_id
      ?: variable_get('queueit_customer_id');
    $this->secretKey = $secret_key
      ?: variable_get('queueit_secret_key');
    $this->eventID = variable_get('queueit_event_id');
    $this->queueDomain = variable_get('queueit_queue_domain');
    $this->cookieValidity = (int) variable_get('queueit_cookie_validity', 10) ?: 10;
    $this->extendCookie = (bool) variable_get('queueit_extend_cookie_validity', TRUE);
    $this->cookieDomain = variable_get('queueit_queue_domain');
    $this->layoutName = variable_get('queueit_layout_name');
    $this->cultureLayout = variable_get('queueit_culture_of_layout');
    $this->isDebug = variable_get('queueit_culture_of_layout', FALSE);
  }

  /**
   * Validate config.
   *
   * @return bools
   *   Returns TRUE if config is valid (e.g. credentials aren't empty).
   */
  public function validateConfig() {
    return $this->getCustomerId() && $this->secretKey;
  }

  /**
   * Validate JS endpoints.
   */
  public function validateJsEndpoints() {
    return file_get_contents(self::QI_JS_CLIENT_URL)
      && file_get_contents(self::QI_JS_LOADER_URL);
  }

  /* Setters */

  /**
   * Sets event config.
   */
  public function setEventConfig() {
    $eventConfig = new QueueEventConfig();

    // ID of the queue to use.
    $eventConfig->eventId = $this->eventID;

    // Domain name of the queue.
    // Usually in the format [CustomerId].queue-it.net.
    $eventConfig->queueDomain = $this->queueDomain;

    // Domain name where the Queue-it session cookie should be saved.
    // Optional.
    $eventConfig->cookieDomain = $this->cookieDomain;

    // Validity of the Queue-it session cookie.
    // Optional. Default is 10 minutes.
    $eventConfig->cookieValidityMinute = $this->cookieValidity;

    // Should the Queue-it session cookie validity time be extended each time the validation runs?
    // Optional. Default is true.
    $eventConfig->extendCookieValidity = $this->extendCookie;

    // Name of the queue ticket layout - e.g. "Default layout by Queue-it".
    // Optional. Default is to take what is specified on the Event.
    $eventConfig->layoutName = $this->layoutName;

    // Culture of the queue ticket layout in the format specified at:
    // https://msdn.microsoft.com/en-us/library/ee825488(v=cs.20).aspx
    // Default is to use what is specified on Event. E.g. "en-GB".
    $eventConfig->culture = $this->cultureLayout;

    $this->eventConfig = $eventConfig;
  }

  /* Getters */

  /**
   * Retrieve the integration config.
   *
   * @return string
   *   Returns plain JSON content.
   */
  public function getIntegrationConfig() {
    // Ignore fetching on invalid configuration.
    if (!$this->validateConfig()) {
      return NULL;
    }

    // Get the auto-generated config file published on Queue-it Go platform.
    // URL: https://[your-customer-id].queue-it.net/status/integrationconfig/[your-customer-id]
    // @todo: Consider caching the config to minimalize external requests.
    return file_get_contents($this->getIntegrationConfigPath());
  }

  /**
   * Get the integration config URL.
   */
  public function getIntegrationConfigPath() {
    return sprintf("http://%s.%s%s/%s",
      $this->getCustomerId(),
      self::QI_API_DOMAIN,
      self::QI_CONFIG_URI,
      $this->getCustomerId()
    );
  }

  /**
   * Get API Key.
   */
  public function getAPIKey() {
    return $this->apiKey;
  }

  /**
   * Get customer ID.
   */
  public function getCustomerId() {
    return $this->customerID;
  }

  /**
   * Get secret key.
   */
  public function getSecretKey() {
    return $this->secretKey;
  }

  /**
   * Get a queue token.
   */
  public function getQueueToken() {
    return filter_input(INPUT_GET, 'queueittoken');
  }

  /**
   * Helper method to get the current URL.
   */
  public function getFullRequestUri() {
    return file_create_url(current_path());
  }

  /**
   * Gets event config.
   */
  public function getEventConfig() {
    return $this->eventConfig;
  }

}

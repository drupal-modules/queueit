<?php

use QueueIT\KnownUserV3\SDK\KnownUser;
use QueueIT\KnownUserV3\SDK\QueueEventConfig;

/**
 * Class implementing Queue-it Known User API.
 */
class QueueitKnownUser extends QueueitBase {

  /* Protected variables */
  protected $eventConfig;    // Event config.
  protected $apiKey;         // API Key.
  protected $secretKey;      // Secret key.
  protected $configJson;     // Integration config.

  /* Variables used for 'configuration in code' method */
  protected $eventID;        // Event ID (code only).
  protected $queueDomain;    // Domain name of the queue (code only).
  protected $cookieValidity; // Session cookie validity time (in min).
  protected $extendCookie;  // Extended validity of session cookie (bool).
  protected $cookieDomain;   // Cookie domain.
  protected $layoutName;     // Name of the queue ticket layout.
  protected $cultureLayout;  // Culture of the queue ticket layout.

  /* Constants */
  const QI_CONFIG_URI    = '/status/integrationconfig';

  /**
   * Class constructor.
   */
  public function __construct($int_method = 'integration', $customer_id = '', $secret_key = '', $api_key = '') {

    // Initialize base class constructor.
    parent::__construct($customer_id);

    // Initialize class variables.
    $this->intMethod = $int_method
      ?: variable_get('queueit_mode');
    $this->apiKey = $api_key
      ?: variable_get('queueit_api_key');
    $this->secretKey = $secret_key
      ?: variable_get('queueit_secret_key');
    $this->eventID = variable_get('queueit_event_id');
    $this->queueDomain = variable_get('queueit_queue_domain');
    $this->cookieValidity = (int) variable_get('queueit_cookie_validity', 10) ?: 10;
    $this->extendCookie = (bool) variable_get('queueit_extend_cookie_validity', TRUE);
    $this->cookieDomain = variable_get('queueit_queue_domain');
    $this->layoutName = variable_get('queueit_layout_name');
    $this->cultureLayout = variable_get('queueit_culture_of_layout');
  }

  /**
   * Validate config.
   *
   * @return bools
   *   Returns TRUE if config is valid (e.g. credentials aren't empty).
   */
  public function validateConfig() {
    return $this->getCustomerId() && $this->getSecretKey();
  }

  /**
   * Validate that the user has been through the queue.
   */
  public function validateRequestByIntegrationConfig() {
    /*
     * This call will validate the timestamp and hash
     * and if valid create a cookie with a TTL like:
     * "QueueITAccepted-SDFrts345E-V3_[EventId]"
     * as specified in the configuration.
     * If the timestamp or hash is invalid,
     * the user is send back to the queue.
     */
    return KnownUser::validateRequestByIntegrationConfig(
      $this->getFullRequestUri(),
      $this->getQueueToken(),
      $this->getIntegrationConfig(),
      $this->getCustomerId(),
      $this->getSecretKey()
    );
  }

  /**
   * Verify if the user has been through the queue.
   */
  public function resolveRequestByLocalEventConfig() {
    $this->setEventConfig();
    return KnownUser::resolveRequestByLocalEventConfig(
      $this->getFullRequestUri(),
      $this->getQueueToken(),
      $this->getEventConfig(),
      $this->getCustomerId(),
      $this->getSecretKey()
    );
  }

  /* Setters */

  /**
   * Set API Key.
   */
  public function setAPIKey($api_key) {
    return $this->apiKey = $api_key;
  }

  /**
   * Set secret key.
   */
  public function setSecretKey($secret_key) {
    return $this->secretKey = $secret_key;
  }


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
   * Gets event config.
   */
  public function getEventConfig() {
    return $this->eventConfig;
  }

  /**
   * Get API Key.
   */
  public function getAPIKey() {
    return $this->apiKey;
  }

  /**
   * Get secret key.
   */
  public function getSecretKey() {
    return $this->secretKey;
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


}

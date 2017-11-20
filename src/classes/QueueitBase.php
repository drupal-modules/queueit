<?php

/**
 * Base class implementing Queue-it framework.
 */
class QueueitBase {

  protected $apiKey;         // API Key.
  protected $customerID;     // Customer ID.
  protected $secretKey;      // Secret key.
  protected $eventConfig;    // Event config.
  protected $arrConfig;      // Integration config.
	protected $queueDomain;    // Domain name of the queue.
	protected $cookieValidity; // Session cookie validity time (in min).
	protected $extCookieTime;  // Extended validity of session cookie (bool).
	protected $cookieDomain;   // Cookie domain.
	protected $layoutName;     // Name of the queue ticket layout.
	protected $cultureLayout;  // Culture of the queue ticket layout.

  /**
   * Class constructor.
   */
  function __construct($customer_id = '', $secret_key = '', $api_key = '') {
    $this->apiKey = $api_key
      ?: variable_get('queueit_api_key');
    $this->customerID = $customer_id
      ?: variable_get('queueit_customer_id');
    $this->secretKey = $secret_key
      ?: variable_get('queueit_secret_key');
    $this->queueDomain = variable_get('queueit_queue_domain');
    $this->cookieValidity = variable_get('queueit_cookie_validity');
    $this->extCookieTime = variable_get('queueit_extend_cookie_validity', TRUE);
    $this->cookieDomain = variable_get('queueit_queue_domain');
    $this->layoutName = variable_get('queueit_layout_name');
    $this->cultureLayout = variable_get('queueit_culture_of_layout');
  }

  /* Setters */

  /**
   * Sets event config.
   */
  function setEventConfig() {
		$eventConfig = new QueueIT\KnownUserV3\SDK\QueueEventConfig();

		$eventConfig->eventId = ""; // ID of the queue to use.

    // Domain name of the queue.
    // Usually in the format [CustomerId].queue-it.net
		$eventConfig->queueDomain = $this->queueDomain;

    // Domain name where the Queue-it session cookie should be saved.
    // Optional.
		$eventConfig->cookieDomain = $this->cookieDomain;

    // Validity of the Queue-it session cookie.
    // Optional. Default is 10 minutes.
		$eventConfig->cookieValidityMinute = $this->cookieValidity; 

    // Should the Queue-it session cookie validity time be extended each time the validation runs?
    // Optional. Default is true.
		$eventConfig->extendCookieValidity = $this->extCookieTime;

    // Name of the queue ticket layout - e.g. "Default layout by Queue-it".
    // Optional. Default is to take what is specified on the Event
		$eventConfig->layoutName = $this->layoutName;

    // Culture of the queue ticket layout in the format specified at:
    // https://msdn.microsoft.com/en-us/library/ee825488(v=cs.20).aspx
    // Default is to use what is specified on Event. E.g. "en-GB".
		$eventConfig->culture = $this->cultureLayout;

		$this->eventConfig = eventConfig;
  }

  /* Getters */

  /**
   * Get API Key.
   */
  function getAPIKey() {
    return $this->apiKey;
  }

  /**
   * Get customer ID.
   */
  function getCustomerId() {
    return $this->customerID;
  }

  /**
   * Get secret key.
   */
  function getSecretKey() {
    return $this->secretKey;
  }

  /**
   * Get a queue token.
   */
  function getQueueToken() {
    return filter_input(INPUT_GET, 'queueittoken');
  }

  /**
   * Helper method to get the current URL.
   */
  function getFullRequestUri() {
    return file_create_url(current_path());
  }

}

<?php

/**
 * Base class implementing Queue-it platform.
 */
class QueueitBase {

  /* Protected variables */
  protected $customerID;     // Customer ID.

  /* Other variables */
  protected $isDebug;        // Debug mode.

  /* Constants */
  const QI_API_DOMAIN    = 'queue-it.net';
  const QI_JS_CLIENT_URL = '//static.queue-it.net/script/queueclient.min.js';
  const QI_JS_LOADER_URL = '//static.queue-it.net/script/queueconfigloader.min.js';

  /**
   * Class constructor.
   */
  public function __construct($customer_id = '') {

    // Initialize base class constructor.
    $this->customerID = $customer_id
      ?: variable_get('queueit_customer_id');
    $this->isDebug = variable_get('queueit_debug', FALSE);
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
  static public function validateJsEndpoints() {
    return file_get_contents('http:' . self::QI_JS_CLIENT_URL)
      && file_get_contents('http:' . self::QI_JS_LOADER_URL);
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
   * Get customer ID.
   */
  public function getCustomerId() {
    return $this->customerID;
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

}

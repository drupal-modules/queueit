<?php

/**
 * Base class implementing Queue-it platform.
 */
class QueueitBase {

  /* Protected variables */
  protected $intMethod;      // Integration method (integration, js, code).
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
  public function __construct($int_method = 'js', $customer_id = '') {

    // Initialize base class constructor.
    $this->intMethod = $int_method
      ?: variable_get('queueit_mode');
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
    return $this->getCustomerId();
  }

  /**
   * Validate JS endpoints.
   */
  static public function validateJsEndpoints() {
    return file_get_contents('http:' . self::QI_JS_CLIENT_URL)
      && file_get_contents('http:' . self::QI_JS_LOADER_URL);
  }

  /* Setters */

  /**
   * Set integration method.
   */
  public function setIntegrationMethod($method) {
    return $this->intMethod = $method;
  }

  /**
   * Set customer ID.
   */
  public function setCustomerId($customer_id) {
    return $this->customerID = $customer_id;
  }

  /* Getters */

  /**
   * Get customer ID.
   */
  public function getCustomerId() {
    return $this->customerID;
  }

  /**
   * Get integration method.
   */
  public function getIntegrationMethod() {
    return $this->intMethod;
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

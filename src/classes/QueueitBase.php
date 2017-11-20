<?php

use QueueIT\KnownUserV3\SDK;

/**
 * Base class implementing Queue-it framework.
 */
class QueueitBase {

  private $customerID; // Queue-it customer ID.
  private $secretKey;  // Queue-it secret key.

  /**
   * Class constructor.
   */
  function __construct($customer_id, $secret_key) {
    $this->customerID = $customer_id;
    $this->secretKey = $secret_key;
  }

  /* Getters */

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

}

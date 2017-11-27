<?php

use QueueIT\KnownUserV3\SDK\KnownUser;

/**
 * Class implementing Queue-it Known User API.
 */
class QueueitKnownUser extends QueueitBase {

  /**
   * Verify if the user has been through the queue.
   */
  function validateRequestByIntegrationConfig() {
    return KnownUser::validateRequestByIntegrationConfig(
      $this->getFullRequestUri(),
      $this->getQueueToken(),
			$this->getIntegrationConfig(),
			$this->customerID,
			$this->secretKey
    );
  }

  /**
   * Verify if the user has been through the queue.
   */
  function resolveRequestByLocalEventConfig() {
    return KnownUser::resolveRequestByLocalEventConfig(
      $this->getFullRequestUri(), $this->getQueueToken(),
			$this->eventConfig, $this->customerID, $this->secretKey);
  }

}

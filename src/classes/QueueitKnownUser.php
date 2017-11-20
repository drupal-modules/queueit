<?php

use QueueIT\KnownUserV3\SDK\KnownUser;

/**
 * Class implementing Queue-it Known User API.
 */
class QueueitKnownUser extends QueueitBase {

  /**
   * Verify if the user has been through the queue.
   */
  function verifyUser() {
    return QueueIT\KnownUserV3\SDK\KnownUser::validateRequestByIntegrationConfig(
      getFullRequestUri(), getQueueToken(),
			$configText, $this->customerID, $this->secretKey);
  }
}

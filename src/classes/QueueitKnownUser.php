<?php

use QueueIT\KnownUserV3\SDK\KnownUser;

/**
 * Class implementing Queue-it Known User API.
 */
class QueueitKnownUser extends QueueitBase {

  /**
   * Validate that the user has been through the queue.
   */
  function validateRequestByIntegrationConfig() {
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
  function resolveRequestByLocalEventConfig() {
    $this->setEventConfig();
    return KnownUser::resolveRequestByLocalEventConfig(
      $this->getFullRequestUri(),
      $this->getQueueToken(),
      $this->getEventConfig(),
      $this->getCustomerId(),
      $this->getSecretKey()
    );
  }

}

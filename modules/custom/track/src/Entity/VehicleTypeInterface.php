<?php

namespace Drupal\track\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Vehicle type entities.
 *
 * @ingroup track
 */
interface VehicleTypeInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Vehicle type name.
   *
   * @return string
   *   Name of the Vehicle type.
   */
  public function getName();

  /**
   * Sets the Vehicle type name.
   *
   * @param string $name
   *   The Vehicle type name.
   *
   * @return \Drupal\track\Entity\VehicleTypeInterface
   *   The called Vehicle type entity.
   */
  public function setName($name);

  /**
   * Gets the Vehicle type creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Vehicle type.
   */
  public function getCreatedTime();

  /**
   * Sets the Vehicle type creation timestamp.
   *
   * @param int $timestamp
   *   The Vehicle type creation timestamp.
   *
   * @return \Drupal\track\Entity\VehicleTypeInterface
   *   The called Vehicle type entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Vehicle type published status indicator.
   *
   * Unpublished Vehicle type are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Vehicle type is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Vehicle type.
   *
   * @param bool $published
   *   TRUE to set this Vehicle type to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\track\Entity\VehicleTypeInterface
   *   The called Vehicle type entity.
   */
  public function setPublished($published);

}

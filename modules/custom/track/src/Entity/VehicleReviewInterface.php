<?php

namespace Drupal\track\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Vehicle review entities.
 *
 * @ingroup track
 */
interface VehicleReviewInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Vehicle review name.
   *
   * @return string
   *   Name of the Vehicle review.
   */
  public function getName();

  /**
   * Sets the Vehicle review name.
   *
   * @param string $name
   *   The Vehicle review name.
   *
   * @return \Drupal\track\Entity\VehicleReviewInterface
   *   The called Vehicle review entity.
   */
  public function setName($name);

  /**
   * Gets the Vehicle review creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Vehicle review.
   */
  public function getCreatedTime();

  /**
   * Sets the Vehicle review creation timestamp.
   *
   * @param int $timestamp
   *   The Vehicle review creation timestamp.
   *
   * @return \Drupal\track\Entity\VehicleReviewInterface
   *   The called Vehicle review entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Vehicle review published status indicator.
   *
   * Unpublished Vehicle review are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Vehicle review is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Vehicle review.
   *
   * @param bool $published
   *   TRUE to set this Vehicle review to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\track\Entity\VehicleReviewInterface
   *   The called Vehicle review entity.
   */
  public function setPublished($published);

}

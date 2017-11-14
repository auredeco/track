<?php

namespace Drupal\track\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Brand entities.
 *
 * @ingroup track
 */
interface BrandInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Brand name.
   *
   * @return string
   *   Name of the Brand.
   */
  public function getName();

  /**
   * Sets the Brand name.
   *
   * @param string $name
   *   The Brand name.
   *
   * @return \Drupal\track\Entity\BrandInterface
   *   The called Brand entity.
   */
  public function setName($name);

  /**
   * Gets the Brand creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Brand.
   */
  public function getCreatedTime();

  /**
   * Sets the Brand creation timestamp.
   *
   * @param int $timestamp
   *   The Brand creation timestamp.
   *
   * @return \Drupal\track\Entity\BrandInterface
   *   The called Brand entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Brand published status indicator.
   *
   * Unpublished Brand are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Brand is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Brand.
   *
   * @param bool $published
   *   TRUE to set this Brand to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\track\Entity\BrandInterface
   *   The called Brand entity.
   */
  public function setPublished($published);

}

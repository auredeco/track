<?php

namespace Drupal\track\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Vehicle type entities.
 */
class VehicleTypeViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}

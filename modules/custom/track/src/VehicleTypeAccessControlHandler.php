<?php

namespace Drupal\track;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Vehicle type entity.
 *
 * @see \Drupal\track\Entity\VehicleType.
 */
class VehicleTypeAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\track\Entity\VehicleTypeInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished vehicle type entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published vehicle type entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit vehicle type entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete vehicle type entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add vehicle type entities');
  }

}

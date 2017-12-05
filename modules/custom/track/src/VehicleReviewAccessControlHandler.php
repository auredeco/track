<?php

namespace Drupal\track;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Vehicle review entity.
 *
 * @see \Drupal\track\Entity\VehicleReview.
 */
class VehicleReviewAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\track\Entity\VehicleReviewInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished vehicle review entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published vehicle review entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit vehicle review entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete vehicle review entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add vehicle review entities');
  }

}

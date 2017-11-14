<?php

namespace Drupal\track;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Brand entity.
 *
 * @see \Drupal\track\Entity\Brand.
 */
class BrandAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\track\Entity\BrandInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished brand entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published brand entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit brand entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete brand entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add brand entities');
  }

}

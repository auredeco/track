<?php

/**
 * @file
 * Contains vehicle_review.page.inc.
 *
 * Page callback for Vehicle review entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Vehicle review templates.
 *
 * Default template: vehicle_review.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_vehicle_review(array &$variables) {
  // Fetch VehicleReview Entity Object.
  $vehicle_review = $variables['elements']['#vehicle_review'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}

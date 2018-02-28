<?php

namespace Drupal\ales_custom_entity\Plugin\DsField;

use Drupal\ds\Plugin\DsField\DsFieldBase;
use Drupal\Component\Render\FormattableMarkup;

/**
 * Plugin that renders the terms from a chosen taxonomy vocabulary.
 *
 * @DsField(
 *   id = "recommendation_link_1",
 *   title = @Translation("Recommendation link"),
 *   entity_type = "node",
 *   provider = "ales_custom_entity",
 * )
 */
class CompanyReviews extends DsFieldBase {
  //link, ki se veže na controller..ki bo v popup odpro ustrezno formo (location recommendation)

  //popup -
  /**
   * {@inheritdoc}
   */
  public function build() {
    // Writing the object of the current entity into a variable for the convenience
    $entity = $this->entity();
    // Check if there is a value in a body field. If the field returnes nothing
    // it takes like empty field and it isn't outputed.
    if ($body_value = $entity->body->value) {
      return [
        '#type' => 'markup',
        '#markup' =>'KREBS',
      ];
    }
  }
}
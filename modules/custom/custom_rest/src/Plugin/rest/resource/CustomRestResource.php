<?php

namespace Drupal\custom_rest\Plugin\rest\resource;


use Drupal\node\Entity\Node;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ModifiedResourceResponse;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "custom_rest_resource",
 *   label = @Translation("Custom rest resource"),
 *   serialization_class = "Drupal\node\Entity\Node",
 *   uri_paths = {
 *     "canonical" = "/api/custom",
 *     "https://www.drupal.org/link-relations/create" = "/api/custom"
 *   }
 * )
 */
class CustomRestResource extends ResourceBase {

  /**
   * {@inheritdoc}
   */
  public function post($node) {
    $obj = json_decode(json_encode($node), FALSE);

    $newNode = Node::create([
      'type' => 'event',
      'title' => $obj->title->value,
      'field_description' => $obj->field_description->value,
      'field_organizer' => $obj->field_organizer->target_id,
      'field_event_type' => $obj->field_event_type->target_id,
      'field_location' => $obj->field_location->target_id,
      'field_start_end_date' => [
        'value' => $obj->field_start_end_date->value,
        'end_value' => $obj->field_start_end_date->end_value,
      ],
    ]);
    $newNode->save();

    return new ModifiedResourceResponse($node);
  }

}

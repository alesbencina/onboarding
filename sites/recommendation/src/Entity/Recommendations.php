<?php

namespace Drupal\recommendation\Entity;

use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\user\UserInterface;

/**
 * Defines the event entity.
 *
 * @ContentEntityType(
 *   id = "recommendations",
 *   label = @Translation("Recommendations"),
 *   base_table = "recommendations",
 *   data_table = "recommendations_field_data",
 *   revision_table = "recommendations_revision",
 *   revision_data_table = "recommendations_field_revision",
 *   translatable = true,
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "bundle" = "type",
 *   },
 *   bundle_entity_type = "recommendation_type",
 *   bundle_label = @Translation("Type"),
 *   handlers = {
 *     "view_builder" = "Drupal\recommendation\Entity\EventViewBuilder",
 *     "list_builder" = "Drupal\recommendation\Entity\EventListBuilder",
 *     "form" = {
 *       "add" = "Drupal\recommendation\Form\RecommendationAddForm",
 *       "edit" = "Drupal\recommendation\Form\RecommendationEditForm",
 *       "default" = "Drupal\recommendation\Form\RecommendationEditForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html_default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider"
 *     },
 *     "views_data" = "Drupal\views\EntityViewsData",
 *   },
 *   links = {
 *     "canonical" = "/recommendations/{event}",
 *     "add-form" = "/admin/content/recommendations/add/{recommendation_type}",
 *     "edit-form" =
 *   "/admin/content/recommendations/manage/{recommendation}/edit",
 *     "delete-form" =
 *   "/admin/content/recommendations/manage/{recommendation}/delete",
 *     "add-page" = "/admin/content/recommendations/add",
 *     "collection" = "/admin/content/recommendations",
 *   },
 *   field_ui_base_route = "entity.recommendation_type.edit_form",
 *   admin_permission = "administer recommendation",
 * )
 */
class Recommendations extends RevisionableContentEntityBase implements RecommendationInterface {

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->get('type')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function setType(RecommendationTypeInterface $type) {
    return $this->set('type', $type);
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->get('title')->value ?: '';
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle($title) {
    return $this->set('title', $title);
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->get('description')->processed ?: '';
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($text, $format) {
    return $this->set('description', [
      'value' => $text,
      'format' => $format,
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('owner')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('owner')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    return $this->set('owner', $uid);
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    return $this->set('owner', $account->id());
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    /** @var \Drupal\Core\Field\BaseFieldDefinition[] $fields */
    $fields = parent::baseFieldDefinitions($entity_type);
    $fields['revision_user']->setDefaultValueCallback(static::class . '::getDefaultOwnerIds');

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'weight' => 10,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'weight' => 5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['owner'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Owner'))
      ->setSetting('target_type', 'user')
      ->setRevisionable(TRUE)
      ->setDefaultValueCallback(static::class . '::getDefaultOwnerIds');

    return $fields;
  }

  /**
   * Returns the default value for the owner field.
   *
   * It always returns a single value which is the current user's ID.
   *
   * @see \Drupal\event\Entity\Event::baseFieldDefinitions()
   *
   * @return array
   *   An array of default values.
   */
  public static function getDefaultOwnerIds() {
    return [\Drupal::currentUser()->id()];
  }

}

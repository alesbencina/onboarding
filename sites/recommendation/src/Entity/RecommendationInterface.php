<?php

namespace Drupal\recommendation\Entity;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface for events.
 */
interface RecommendationInterface extends ContentEntityInterface {

  /**
   * Gets the type of the event.
   *
   * @return \Drupal\event\Entity\EventTypeInterface
   */
  public function getType();

  /**
   * Sets the type of the event.
   *
   * @param \Drupal\event\Entity\EventTypeInterface $type
   *   The event type.
   *
   * @return $this
   */
  public function setType(RecommendationTypeInterface $type);

  /**
   * Gets the title of an event.
   *
   * @return string
   *   The title of the event.
   */
  public function getTitle();

  /**
   * Sets the title of the event.
   *
   * @param string $title
   *   The title to set.
   *
   * @return $this
   */
  public function setTitle($title);

  /**
   * Gets the description of the event.
   *
   * @return \Drupal\Component\Render\MarkupInterface
   *   The description of the event.
   */
  public function getDescription();

  /**
   * Sets the description text of the event.
   *
   * @param string $text
   *   The description text.
   * @param string $format
   *   The ID of the text format to use for the description.
   *
   * @return $this
   */
  public function setDescription($text, $format);


}

<?php
/**
 * Created by PhpStorm.
 * User: alesbencina
 * Date: 19/02/2018
 * Time: 13:44
 */

namespace Drupal\ales_custom_entity\Controller;


use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

class ReviewListBuilder extends EntityListBuilder {
  public function buildHeader() {
    $header = [];
    $header['title'] = $this->t('Title');
    $header['published'] = $this->t('Published');
    return $header + parent::buildHeader();
  }

  public function buildRow(EntityInterface $review) {
    /** @var \Drupal\event\Entity\EventInterface $review */
    $row = [];
    $row['title'] = $review->toLink($review->getTitle());
    $row['published'] = $review->isPublished() ? $this->t('Yes') : $this->t('No');
    return $row + parent::buildRow($review);
  }
}
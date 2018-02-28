<?php
/**
 * Created by PhpStorm.
 * User: alesbencina
 * Date: 21/02/2018
 * Time: 09:28
 */

namespace Drupal\ales_custom_entity\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;


class RecommendationController extends ControllerBase {

  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World!'),
    ];
  }
}
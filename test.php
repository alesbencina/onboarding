<?php

use Drupal\ales_custom_entity\Entity\ReviewType;

/*
$review = Review::load(2);
$review->setDescription('IASJDIAJSD');
$review->setTitle('aoskdoaksdoasd');
$review->save();
*/
ReviewType::create([
  'id' => 'webinar',
  'label' => 'Webinar',
])->save();


?>
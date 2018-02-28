<?php

namespace Drupal\link_formatter\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Path\PathValidatorInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Url;
use Drupal\link\LinkItemInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Plugin implementation of the 'link' to convert into Link formatter.
 *
 * @FieldFormatter(
 *   id = "link_formatter",
 *   label = @Translation("Link Formatter"),
 *   field_types = {
 *     "link",
 *   }
 * )
 */
class LinkFormatter extends FormatterBase {
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();
    $entity = $items->getEntity();
    $settings = $this->getSettings();
    foreach ($items as $delta => $item) {
      $url = $this->buildUrl($item);
      $link_title = $url->toString();
      $checkheaders = check_headers($link_title);
      if ($checkheaders) {
        $elements[$delta] = array(
          '#type' => 'markup',
          '#theme' => 'link_formatter_display',
          '#value' => $link_title,
          '#width' => $settings['width'],
          '#height' => $settings['height'],
        );
      }
      else {
        $elements[$delta] = array(
          '#markup' => '<b> X-Frame-Options </b> for given URL is Denied to show in <b>iFrame</b>',
        );
      }
    }
    return $elements;
  }


  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'width' => '480',
      'height' => '640',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['width'] = array(
      '#type' => 'number',
      '#title' => $this->t('Width'),
      '#default_value' => $this->getSetting('width'),
      '#min' => 1,
      '#description' => $this->t('Width of iFrame.'),
    );

    $elements['height'] = array(
      '#type' => 'number',
      '#title' => $this->t('Height'),
      '#default_value' => $this->getSetting('height'),
      '#min' => 1,
      '#description' => $this->t('Height of iFrame.'),
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    return [
      $this->t('Width: @width px', [
        '@width' => $this->getSetting('width'),
      ]),
      $this->t('Height: @height px', [
        '@height' => $this->getSetting('height'),
      ]),
    ];
  }

  /**
   * Builds the \Drupal\Core\Url object for a link field item.
   *
   * @param \Drupal\link\LinkItemInterface $item
   *   The link field item being rendered.
   *
   * @return \Drupal\Core\Url
   *   A Url object.
   */
  protected function buildUrl(LinkItemInterface $item) {
    $url = $item->getUrl() ?: Url::fromRoute('<none>');

    $settings = $this->getSettings();
    $options = $item->options;
    $options += $url->getOptions();

    // Add optional 'rel' attribute to link options.
    if (!empty($settings['rel'])) {
      $options['attributes']['rel'] = $settings['rel'];
    }
    // Add optional 'target' attribute to link options.
    if (!empty($settings['target'])) {
      $options['attributes']['target'] = $settings['target'];
    }
    $url->setOptions($options);

    return $url;
  }
}

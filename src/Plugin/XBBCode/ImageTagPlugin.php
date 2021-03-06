<?php

/**
 * @file
 * Contains \Drupal\xbbcode\Plugin\XBBCode\TableTagPlugin.
 */

namespace Drupal\xbbcode\Plugin\XBBCode;

use Drupal;
use Drupal\Core\Url;
use Drupal\xbbcode\ElementInterface;
use Drupal\xbbcode\Plugin\TagPlugin;

/**
 * Inserts an image.
 *
 * @XBBCodeTag(
 *   id = "image",
 *   label = @Translation("Image"),
 *   description = @Translation("Inserts an image."),
 *   name = "img",
 * )
 */
class ImageTagPlugin extends TagPlugin {
  /**
   * {@inheritdoc}
   */
  public function getDefaultSample() {
    return $this->t('[{{ name }} width=57 height=66]@url[/{{ name }}]', [
      '@url' => Url::fromUri('base:core/themes/bartik/logo.svg')->toString(),
    ]);
  }
  /**
   * {@inheritdoc}
   */
  public function process(ElementInterface $tag) {
    $style = [];
    if ($width = $tag->getAttr('width')) {
      $style[] = "width:{$width}px";
    }
    if ($height = $tag->getAttr('height')) {
      $style[] = "height:{$height}px";
    }

    $element = [
      '#type' => 'inline_template',
      '#template' => '<img src="{{ tag.content }}" alt="{{ tag.content }}" style="{{ style }}" />',
      '#context' => [
        'tag' => $tag,
        'style' => implode(';', $style),
      ],
    ];

    return Drupal::service('renderer')->render($element);
  }

}

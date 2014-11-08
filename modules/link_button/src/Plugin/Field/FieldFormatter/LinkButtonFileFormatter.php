<?php

/**
 * @file
 * Contains \Drupal\drupalci_link_button\Plugin\field\formatter\LinkButtonFileFormatter.
 */

namespace Drupal\link_button\Plugin\Field\FieldFormatter;

use Drupal\file\Plugin\Field\FieldFormatter\FileFormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'file_link_button' formatter.
 *
 * @FieldFormatter(
 *   id = "file_link_button",
 *   label = @Translation("Link button file"),
 *   field_types = {
 *     "file"
 *   }
 * )
 */
class LinkButtonFileFormatter extends FileFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();

    foreach ($items as $delta => $item) {
      if ($item->isDisplayed() && $item->entity) {
        $elements[$delta] = array(
          '#theme' => 'file_link',
          '#file' => $item->entity,
          '#description' => $item->description,
          '#attributes' => array(
            'class' => 'btn btn-default',
          ),
        );
      }
    }

    return $elements;
  }

}

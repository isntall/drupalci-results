<?php

/**
 * @file
 * Contains \Drupal\drupalci_progressbar\Plugin\field\formatter\OptionsProgressbarFormatter.
 */

namespace Drupal\drupalci_progressbar\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'list_progressbar' formatter.
 *
 * @FieldFormatter(
 *   id = "list_progressbar",
 *   label = @Translation("Progressbar"),
 *   field_types = {
 *     "list_string",
 *   }
 * )
 */
class OptionsProgressbarFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['20'] = array(
      '#title' => t('20%'),
      '#type' => 'number',
      '#default_value' => $this->getSetting('20'),
      '#min' => 1,
      '#required' => TRUE,
    );
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();
    $summary[] = t('Trim length: @trim_length', array('@trim_length' => $this->getSetting('trim_length')));
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();
    $percentages = array(
      'new' => array(
        'percentage' => '0',
        'title' => 'New',
      ),
      'building' => array(
        'percentage' => '40',
        'title' => 'Building',
      ),
      'calculating' => array(
        'percentage' => '80',
        'title' => 'Calculating',
      ),
      'pass' => array(
        'percentage' => '100',
        'title' => 'Passed',
      ),
      'fail' => array(
        'percentage' => '100',
        'title' => 'Failed',
      ),
    );

    foreach ($items as $delta => $item) {
      $output = '<div class="progress">';
      if (!empty($percentages[$item->value])) {
        $percentage = $percentages[$item->value]['percentage'];
        $title = $percentages[$item->value]['title'];
      }
      else {
        $percentage = $percentages['new']['percentage'];
        $title = $percentages['new']['title'];
      }
      $output .= '<div class="progress-bar" role="progressbar" aria-valuenow="' . $percentage . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%">';
      $output .= $title;
      $output .= '</div>';
      $output .= '</div>';
      $elements[$delta] = array('#markup' => $output);
    }
    return $elements;
  }

}

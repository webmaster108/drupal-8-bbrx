<?php

namespace Drupal\clearstone\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class ClearstoneFormMergesEditForm.
 */
class ClearstoneFormMergesEditForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'clearstone_form_merges_edit_form';
  }

  /**
   * {@inheritdoc}
   */

  public $id = '';

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $mid = '') {

    $this->id = $mid;
    $query = \Drupal::database()->select('clearstone_form_merge', 'm')
      ->fields('m')
      ->condition('m.id', $mid)
      ->execute();
    $result = $query->fetchObject();
    $form['merges'] = [
      '#type' => 'fieldset',
      '#title' => t('Manage Merges'),
      '#collapsible' => FALSE,
      '#description' => t('Create and manage merges that forms will be exported into.'),
    ];
    $form['merges']['merge_title'] = [
      '#type' => 'textfield',
      '#title' => t('Title of Merge'),
      '#default_value' => $result->title,
      '#required' => TRUE,
    ];
    $form['merges']['filename'] = [
      '#type' => 'textfield',
      '#title' => t('Filename'),
      '#default_value' => $result->filename,
      '#required' => TRUE,
      '#description' => t('Leave off date/time and extension. ex. PFire2CLR_enrollazmapd15'),
    ];
    $form['merges']['output_folder'] = [
      '#type' => 'textfield',
      '#title' => t('Output Folder'),
      '#default_value' => $result->output_folder,
      '#description' => t('ex: Full folder stucture, /var/www/.'),
      '#required' => TRUE,
    ];
    $form['merges']['root_tag'] = [
      '#type' => 'textfield',
      '#title' => t('Root Tag'),
      '#default_value' => $result->root_tag,
      '#required' => TRUE,
      '#description' => t('Leave off <>. ex. hp_online_enrollement'),
    ];
    $form['merges']['record_tag'] = [
      '#type' => 'textfield',
      '#title' => t('Record Tag'),
      '#default_value' => $result->record_tag,
      '#required' => TRUE,
      '#description' => t('Leave off <>. ex. enrollee'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Save'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // parent::validateForm($form, $form_state);.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $id = $this->id;

    $values = $form_state->getValues();
    if (!empty($values)) {
      $title = $values['merge_title'];
      $filename = $values['filename'];
      $root_tag = $values['root_tag'];
      $record_tag = $values['record_tag'];
      $output_folder = $values['output_folder'];
      $array = [
        'title' => $title,
        'filename' => $filename,
        'output_folder' => $output_folder,
        'record_tag' => $record_tag,
        'root_tag' => $root_tag,
      ];

      $update_data = \Drupal::database()->update('clearstone_form_merge')
        ->fields($array)
        ->condition('id', $id)
        ->execute();
      \Drupal::messenger()->addMessage('Form Merges data updated successsfully.');
      $url = Url::fromRoute('clearstone.form_merges');
      return $form_state->setRedirectUrl($url);
    }
    else {
      \Drupal::messenger()->addMessage(t('Some error occurred'), 'error');
    }
  }

}

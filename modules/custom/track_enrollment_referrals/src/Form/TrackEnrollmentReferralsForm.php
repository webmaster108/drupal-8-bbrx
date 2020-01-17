<?php

namespace Drupal\track_enrollment_referrals\Form;

use Drupal\node\Entity\Node;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Class TrackEnrollmentReferralsForm.
 */
class TrackEnrollmentReferralsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'track_enrollment_referrals_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $webforms = [];

    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple();

    $webforms[0] = 'Select Form';
    foreach ($nodes as $node) {
      $type = $node->getType();

      if ($type == 'webform') {
        $label = $node->label();
        $id = $node->id();
        $webforms[$id] = $label;
      }
    }

    $form['available_webforms'] = [
      '#type' => 'select',
      '#title' => t('Select Form'),
      '#options' => $webforms,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Save',
      '#attributes' => [
        'class' => [
          'btn-',
        ],
      ],
    ];

    $db_select = \Drupal::database()->select('track_enrollment_referrals', 'tr')
      ->fields('tr')
      ->orderBy('id', 'DESC');
    $ids = $db_select->execute()->fetchAll();
    $output = [];
    if (!empty($ids)) {
      foreach ($ids as $key => $data) {
        $node = Node::load($data->webform_id);
        if (isset($node)) {
          $ref_webform = $node->get('webform')->getValue();
          $ref_webform_machine_name = $ref_webform[0]['target_id'];
          $storage = \Drupal::entityTypeManager()->getStorage('webform');
          $ref_webform_name = $storage->load($ref_webform_machine_name);
          $name = $ref_webform_name->get('title');

          
          $delete_url = Url::fromRoute('track_enrollment_referrals.trackenrollment_delete_referrals', ['cid' => $data->webform_id]);
          $delete = Link::fromTextAndUrl(t('Delete'), $delete_url);

          $output[$key] = [
            'fid' => [$data->webform_id],
            'form' => [$name],
            'delete' => [$delete],
          ];
        }
        

      }
      
    }
    
    
    $header = [
      'fid' => t('FORM ID'),
      'form' => t('Form'),
      'delete' => t('Delete'),
    ];
    $form['table'] = [
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $output,
      '#empty' => t('No submissions found'),
    ];

    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('available_webforms') == 0) {
      $form_state->setErrorByName('available_webforms', t('Please Select a Webform.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    try {

      $conn = Database::getConnection();
      $conn->insert('track_enrollment_referrals')->fields(
      [
        'webform_id' => $form_state->getValue('available_webforms'),
        'webform' => 'webform',
        'row_insert_date' => time(),
        'row_update_date' => time(),
      ])->execute();

      drupal_set_message(t('The data has been saved'), 'status');
    }
    catch (Exception $e) {
      drupal_set_message(t('Sorry there was an error'), 'error');
    }

  }

}

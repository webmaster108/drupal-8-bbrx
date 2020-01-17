<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\file\Entity\File;

/**
 * Class RegionsEditForm.
 */
class RegionsEditForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'regions_content_editform';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $region_id = '') {
    $form = [];
    $values = state_content_get_region($region_id);
    
    $form['regions'] = [
      '#type' => 'fieldset',
      '#title' => t('Manage Regions'),
      '#collapsible' => FALSE,
      '#description' => t('Create and manage state based regions.'),
    ];
    $form['regions']['id'] = [
      '#type' => 'hidden',
      '#value' => $values['id'],
    ];
    $form['regions']['region'] = [
      '#type' => 'textfield',
      '#title' => t('Region'),
      '#default_value' => $values['region'],
    ];
    $form['regions']['states'] = [
      '#type' => 'textarea',
      '#title' => t('States'),
      '#default_value' => $values['states'],
    ];
    $form['regions']['logo'] = [
      '#type' => 'managed_file',
      '#title' => t('Region Logo'),
      '#upload_location' => 'public://logos',
      '#default_value' => [$values['logo']],
      '#upload_validators' => [
        'file_validate_extensions' => ['jpg, gif, png'],
      ],
    ];
    $form['regions']['favicon'] = [
      '#type' => 'managed_file',
      '#title' => t('Region Favicon'),
      '#upload_location' => 'public://favicons',
      '#default_value' => [$values['favicon']],
      '#upload_validators' => [
        'file_validate_extensions' => ['jpg, gif, png, ico'],
      ],
    ];

    $form['regions']['standard_plan'] = [
      '#type' => 'checkbox',
      '#title' => t('Only Standard Plan'),
      '#default_value' => $values['standard_plan']
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Update Region'),
      
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
    // $input = $form_state->getUserInput();
    $values = $form_state->getValues();
    $logo_fid = '';
    $fav_fid = '';
    $form_logo = $form_state->getValue('logo', 0);
    if (isset($form_logo[0]) && !empty($form_logo[0])) {
      $file = File::load($form_logo[0]);
      $file->setPermanent();
      $file->save();
      $logo_fid = $file->id();
    }

    $form_fav = $form_state->getValue('favicon', 0);
    if (isset($form_fav[0]) && !empty($form_fav[0])) {
      $file_fav = File::load($form_fav[0]);
      $file_fav->setPermanent();
      $file_fav->save();
      $fav_fid = $file_fav->id();
    }
    // kint($form_state->getValue('logo'));.
    $conn = Database::getConnection();
    $conn->update('state_content_regions')->fields(
    [
      'region' => $form_state->getValue('region'),
      'states' => $form_state->getValue('states'),
      'logo' => $logo_fid,
      'favicon' => $fav_fid,
      'standard_plan' => $form_state->getValue('standard_plan')
    ]
    )->condition('id', $form_state->getValue('id'), '=')->execute();
    $form_state->setRedirect('state_content.regions_form');
    drupal_set_message(t('Region has been Updated.'));
  }

}

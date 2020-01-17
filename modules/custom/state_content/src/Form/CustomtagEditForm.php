<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Class CustomtagEditForm.
 */
class CustomtagEditForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'customtagedit_content_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $tag_id = '') {
    $values = state_content_get_tags($tag_id);
    $regions = state_content_get_all_regions();
    $regions[0] = 'N/A';
    ksort($regions);
    $form = [];
    $form['add_tag'] = [
      '#type' => 'fieldset',
      '#title' => t('Add Tag'),
      '#collapsible' => FALSE,
      '#description' => t('Create and manage custom tags for articles.'),
    ];
    $form['add_tag']['id'] = [
      '#type' => 'hidden',
      '#value' => $values['id'],
    ];
    $form['add_tag']['custom_tag'] = [
      '#type' => 'textfield',
      '#title' => t('Custom Tag'),
      '#description' => t('This will be the tag that gets replaced with content.'),
      '#default_value' => $values['tag'],
    ];
    $form['add_tag']['region'] = [
      '#type' => 'select',
      '#multiple' => TRUE,
      '#title' => t('Region'),
      '#options' => $regions,
      '#default_value' => unserialize($values['region']),
      '#description' => t('Set region to N/A for fallback.'),
    ];
    $form['add_tag']['tag_default'] = [
      '#type' => 'checkbox',
      '#title' => t('Fallback for if a user selects a state not in a region.'),
      '#default_value' => $values['tag_default'],
    ];
    $form['add_tag']['tag_content'] = [
      '#type' => 'text_format',
      '#title' => t('Tag Content'),
      '#description' => t('This will be the content that replaces the tag.'),
      '#default_value' => $values['content'],
    ];
    $form['add_tag']['submit'] = [
      '#type' => 'submit',
      '#value' => t('Save Region'),
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
    $values = $form_state->getValues();
    $serialize_regions = serialize($values['region']);
    // kint($form_state->getValue('tag_content'));exit;.
    $conn = Database::getConnection();
    $conn->update('state_content_custom_tags')->fields([
      'tag' => $form_state->getValue('custom_tag'),
      'region' => $serialize_regions,
      'tag_default' => !empty($form_state->getValue('tag_default')) ? 1 : 0,
      'content' => $form_state->getValue('tag_content')['value'],
    ])->condition('id', $form_state->getValue('id'), '=')->execute();
    $form_state->setRedirect('state_content.customtag_form');
    drupal_set_message(t('New Custom Tag data has been saved.'));
  }

}

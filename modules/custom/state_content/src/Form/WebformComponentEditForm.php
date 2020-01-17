<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Url;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Class WebformComponentEditForm.
 */
class WebformComponentEditForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'webform_component_edit_form';
  }

  /**
   * {@inheritdoc}
   */

  public $id = '';

  /**
   * Build WebformComponentEdit.
   */
  public function buildForm(array $form, FormStateInterface $form_state, $cid = '') {

    $query = \Drupal::database()->select('webform_state_field_by_nid', 'w')
      ->fields('w', ['nid', 'form_key'])
      ->condition('id', $cid)
      ->execute();
    $result = $query->fetchAll();

    foreach ($result as $key => $value) {
      $nid = $value->nid;
      $webform_key = $value->form_key;
    }

    $this->id = $cid;

    $entities = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple();
    $webform_title = [];
    $webform_title['none'] = 'Please select a webform';
    foreach ($entities as $entitie) {
      $type = $entitie->getType();
      if ($type == 'webform') {
        $label = $entitie->label();
        $id = $entitie->id();
        $webform_title[$id] = $label;
      }
    }

    $form['webform_name'] = [
      '#type' => 'select',
      '#title' => t('Webforms (by page)'),
      '#description' => 'Filter by Webforms.',
      '#options' => $webform_title,
      '#default_value' => $nid,
      '#ajax' => [
        'event' => 'change',
        'callback' => '::ajaxRefreshWebformComponents',
        'wrapper' => 'dropdown-second-replace',
      ],
    ];

    $selected = $form_state->getValue('webform_name');
    if (empty($selected) && !empty($nid)) {
      $option_values = $this->getWebformComponents($nid);
    }
    else {
      $option_values = $this->getWebformComponents($selected);
    }

    $form['components'] = [
      '#type' => 'select',
      '#prefix' => '<div id="dropdown-second-replace">',
      '#suffix' => '</div>',
      '#title' => t('Webform Components'),
      '#empty_option' => t('Please select a webform first'),
      '#description' => 'Select the state webform component.',
      '#options' => $option_values,
      '#default_value' => $webform_key,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Save',
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
    $webform_nid = $values['webform_name'];
    $form_key = $values['components'];

    if ((isset($webform_nid)) && !empty($webform_nid)) {

      $update_query = \Drupal::database()->update('webform_state_field_by_nid')
        ->fields([
          'nid' => $webform_nid,
          'form_key' => $form_key,
        ])
        ->condition('id', $id)
        ->execute();
      \Drupal::messenger()->addMessage('Webform component values updated successsfully.');
      $url = Url::fromRoute('state_content.webform_component_form');
      return $form_state->setRedirectUrl($url);
    }
    else {
      \Drupal::messenger()->addMessage(t('some error occurred'), 'error');
    }
  }

  /**
   * Ajax callaback.
   */
  public function ajaxRefreshWebformComponents($form, $form_state) {
    return $form['components'];
  }

  /**
   * GetWebformComponents.
   */
  public function getWebformComponents($web_id = NULL) {
    $webform_node = \Drupal::entityTypeManager()->getStorage('node')->load($web_id);
    if (isset($webform_node)) {
      $selected_webform = $webform_node->get('webform')->getValue();
      $select = $selected_webform[0]['target_id'];
    }
    $entites = \Drupal::entityTypeManager()->getStorage('webform')->loadMultiple();
    $components = [];
    foreach ($entites as $entity) {
      if ($entity->id() == $select) {
        $elements = $entity->getElementsInitializedFlattenedAndHasValue('view');
        foreach ($elements as $key => $element) {
          $components[$key] = $key;
        }
      }
    }
    return $components;
  }

}

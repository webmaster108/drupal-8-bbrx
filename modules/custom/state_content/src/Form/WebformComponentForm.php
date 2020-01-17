<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\node\Entity\Node;

/**
 * Class WebformComponentForm.
 */
class WebformComponentForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'web_form_component_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $nids = \Drupal::entityQuery('node')->condition('type', 'webform')->execute();
    if (!empty($nids)) {
      $entities = Node::loadMultiple($nids);
    }
    $webform_title = [];
    $webform_title['none'] = 'Please select a webform';
    if (!empty($entities)) {
      foreach ($entities as $entitie) {
        $type = $entitie->getType();
        if ($type == 'webform') {
          $label = $entitie->label();
          $id = $entitie->id();
          $webform_title[$id] = $label;
        }
      }
    }
    $form['webform_name'] = [
      '#type' => 'select',
      '#title' => t('Webforms (by page)'),
      '#placeholder' => 'Select a Webform',
      '#description' => 'Filter by Webforms.',
      '#options' => $webform_title,
      '#ajax' => [
        'event' => 'change',
        'callback' => '::ajaxRefreshWebformComponents',
        'wrapper' => 'dropdown-second-replace',
      ],
    ];
    $selected = $form_state->getValue('webform_name');
    $form['components'] = [
      '#type' => 'select',
      '#prefix' => '<div id="dropdown-second-replace">',
      '#suffix' => '</div>',
      '#title' => t('Webform Components'),
      '#empty_option' => t('Please select a webform first'),
      '#description' => 'Select the state webform component.',
      '#options' => $this->getWebformComponents($selected),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];
    // Get components data.
    $db_select = \Drupal::database()->select('webform_state_field_by_nid', 'r')
      ->fields('r')
      ->orderBy('id', 'DESC');
    $ids = $db_select->execute()->fetchAll();
    $output = [];
    foreach ($ids as $key => $data) {
      $edit_url = Url::fromRoute('state_content.webform_component_edit_form', ['cid' => $data->id]);
      $edit = Link::fromTextAndUrl(t('Edit'), $edit_url);
      // $edit = $edit->toRenderable();
      $delete_url = Url::fromRoute('state_content.webform_component_delete_form', ['cid' => $data->id]);
      $delete = Link::fromTextAndUrl(t('Delete'), $delete_url);

      if ($data->status == 1) {
        $state_field = 'Enabled';
      }
      else {
        $state_field = 'Disabled';
      }

      $output[$key] = [
        'nid' => [$data->nid],
        'cid' => [$data->id],
        'form_key' => [$data->form_key],
        'state_field' => [$state_field],
        'edit' => [$edit],
        'delete' => [$delete],
      ];

    }
    $header = [
      'nid' => t('Node ID'),
      'cid' => t('Component ID'),
      'form_key' => t('Form Key'),
      'state_field' => t('State Field'),
      'edit' => t('Edit'),
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

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $webform_nid = $values['webform_name'];
    $state_field = \Drupal::database()->select('state_content', 's')
      ->fields('s', ['enable'])
      ->condition('entity_id', $webform_nid)
      ->execute()->fetchCol();
    $state_field = array_shift($state_field);
    if ((isset($state_field)) && ($state_field == 1)) {
      $state_field_value = 1;
    }
    else {
      $state_field_value = 0;
    }
    if ((isset($webform_nid)) && !empty($webform_nid)) {
      $array = [
        'nid' => $webform_nid,
        'cid' => NULL,
        'form_key' => $values['components'],
        'status' => $state_field_value,
      ];
      $update_data = \Drupal::database()->insert('webform_state_field_by_nid')
        ->fields($array)
        ->execute();
      \Drupal::messenger()->addMessage('Webform component values saved successsfully.');
    }
    else {
      \Drupal::messenger()->addMessage(t('There is no webform node associated with this webform'), 'error');
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
  public function getWebformComponents($node_id = NULL) {
    $components = [];
    if (is_numeric($node_id)) {
      $webform_node = \Drupal::entityTypeManager()->getStorage('node')->load($node_id);
      if (isset($webform_node)) {
        $selected_webform = $webform_node->get('webform')->getValue();
        $select = $selected_webform[0]['target_id'];
        $entites = \Drupal::entityTypeManager()->getStorage('webform')->loadMultiple();
        foreach ($entites as $entity) {
          if ($entity->id() == $select) {
            $elements = $entity->getElementsInitializedFlattenedAndHasValue('view');
            foreach ($elements as $key => $element) {
              $components[$key] = $key;
            }
          }
        }
      }
    }
    return $components;
  }

}

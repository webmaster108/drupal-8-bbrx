<?php

namespace Drupal\clearstone\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class ClearstoneFormExportEditForm.
 */
class ClearstoneFormExportEditForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'clearstone_form_export_edit_form';
  }

  /**
   * {@inheritdoc}
   */

  public $id = '';

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $eid = '') {

    $this->id = $eid;
    $query = \Drupal::database()->select('clearstone_form_export', 'm')
      ->fields('m')
      ->condition('m.id', $eid)
      ->execute();
    $result = $query->fetchObject();
    $form['forms'] = [
      '#type' => 'fieldset',
      '#title' => t('Manage Forms'),
      '#collapsible' => FALSE,
      '#description' => t('Create and manage forms to be exported.'),
    ];

    if (\Drupal::moduleHandler()->moduleExists('domain')) {
      $domains = clearstone_get_domains();
      if (!empty($domains)) {
        $form['forms']['domain'] = [
          '#type' => 'select',
          '#title' => t('Select a Domain'),
          '#options' => $domains,
          '#default_value' => $result->domain,
          '#empty_option' => t('Please select a domain'),
          '#ajax' => [
            'event' => 'change',
            'callback' => '::clearstoneDomainFormIds',
            'wrapper' => 'formids',
          ],
        ];
      }
    }
    $form['forms']['form_node_id'] = [
      '#type' => 'select',
      '#title' => t('Form to Export'),
      '#prefix' => '<div id="formids">',
      '#suffix' => '</div>',
      '#empty_option' => t('Please select a Form'),
      '#options' => clearstone_get_form_ids(),
      '#default_value' => $result->form_node_id,
    ];

    $form['forms']['merge'] = [
      '#type' => 'checkbox',
      '#title' => t('Merge with Other Forms?'),
      '#default_value' => $result->merge,
    ];
    $form['forms']['merge_set'] = [
      '#type' => 'select',
      '#title' => t('Set to Merge With'),
      '#empty_option' => t('Please select a set to merge with'),
      '#options' => clearstone_get_merge_sets(),
      '#default_value' => $result->merge_set,
      '#states' => [
        'visible' => [
          ':input[name="merge"]' => ['checked' => TRUE],
        ],
      ],
    ];
    $form['forms']['root_tag'] = [
      '#type' => 'textfield',
      '#title' => t('Root Tag'),
      '#default_value' => $result->root_tag,
      '#states' => [
        'visible' => [
          ':input[name="merge"]' => ['checked' => FALSE],
        ],
      ],
      '#description' => t('Leave off <>. ex. hp_online_enrollment'),
    ];
    $form['forms']['record_tag'] = [
      '#type' => 'textfield',
      '#title' => t('Record Tag'),
      '#default_value' => $result->record_tag,
      '#states' => [
        'visible' => [
          ':input[name="merge"]' => ['checked' => FALSE],
        ],
      ],
      '#description' => t('Leave off <>. ex. enrollee'),
    ];
    $form['forms']['filename'] = [
      '#type' => 'textfield',
      '#title' => t('Filename'),
      '#default_value' => $result->filename,
      '#states' => [
        'visible' => [
          ':input[name="merge"]' => ['checked' => FALSE],
        ],
      ],
      '#description' => t('Leave off date/time and extension. ex. PFire2CLR_enrollazmapd15'),
    ];
    $form['forms']['output_folder'] = [
      '#type' => 'textfield',
      '#title' => t('Output Folder'),
      '#default_value' => $result->output_folder,
      '#description' => t('ex: Full folder stucture, /var/www/.'),
      '#states' => [
        'visible' => [
          ':input[name="merge"]' => ['checked' => FALSE],
        ],
      ],
    ];
    $form['forms']['csv'] = [
      '#type' => 'checkbox',
      '#title' => t('CSV Export'),
      '#default_value' => $result->csv,
      '#description' => t('This will replace the XML export and export as a CSV instead.'),
      '#states' => [
        'visible' => [
          ':input[name="merge"]' => ['checked' => FALSE],
        ],
      ],
    ];
    $form['forms']['submit'] = [
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
    $domain = '';
    $values = $form_state->getValues();
    $node_id = $values['form_node_id'];
    $filename = $values['filename'];
    $root_tag = $values['root_tag'];
    $record_tag = $values['record_tag'];
    $output_folder = $values['output_folder'];
    $merge = $values['merge'];
    $csv = $values['csv'];
    if (isset($values['domain'])) {
      $domain = $values['domain'];
    }
    if ($merge == 0) {
      $merge_set = '';
    }
    else {
      $merge_set = $values['merge_set'];
    }
    if (!empty($values)) {
      if ((isset($node_id)) && !empty($node_id)) {
        $array = [
          'form_node_id' => $node_id,
          'filename' => $filename,
          'root_tag' => $root_tag,
          'record_tag' => $record_tag,
          'output_folder' => $output_folder,
          'domain' => $domain,
          'merge' => $merge,
          'merge_set' => $merge_set,
          'csv' => $csv,
        ];

        $update_data = \Drupal::database()->update('clearstone_form_export')
          ->fields($array)
          ->condition('id', $id)
          ->execute();
        \Drupal::messenger()->addMessage('Form Export data updated successsfully.');
        $url = Url::fromRoute('clearstone.form_export');
        return $form_state->setRedirectUrl($url);
      }
      else {
        \Drupal::messenger()->addMessage(t('Please select a form'), 'error');
      }
    }
    else {
      \Drupal::messenger()->addMessage(t('Please Enter values'), 'error');
    }
  }

}

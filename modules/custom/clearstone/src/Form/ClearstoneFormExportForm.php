<?php

namespace Drupal\clearstone\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Class ClearstoneFormExportForm.
 */
class ClearstoneFormExportForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'clearstone_form_export_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $domain_name = '';
    $form_name = '';

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
    ];

    $form['forms']['merge'] = [
      '#type' => 'checkbox',
      '#title' => t('Merge with Other Forms?'),
    ];
    $form['forms']['merge_set'] = [
      '#type' => 'select',
      '#title' => t('Set to Merge With'),
      '#empty_option' => t('Please select a set to merge with'),
      '#options' => clearstone_get_merge_sets(),
      '#states' => [
        'visible' => [
          ':input[name="merge"]' => ['checked' => TRUE],
        ],
      ],
    ];
    $form['forms']['root_tag'] = [
      '#type' => 'textfield',
      '#title' => t('Root Tag'),
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
    $header = [
      'id' => t('ID'),
      'form_node_id' => t('Form'),
      'filename' => t('Filename'),
      'root_tag' => t('Root Tag'),
      'record_tag' => t('Record Tag'),
      'output_folder' => t('Output Folder'),
      'merge' => t('Merge?'),
      'merge_set' => t('Set to Merge With'),
      'csv' => t('CSV Export'),
      'edit' => t('Edit'),
      'delete' => t('Delete'),
    ];
    $dmod = FALSE;
    if (\Drupal::moduleHandler()->moduleExists('domain')) {
      $header = [
        'id' => t('ID'),
        'form_node_id' => t('Form'),
        'filename' => t('Filename'),
        'root_tag' => t('Root Tag'),
        'record_tag' => t('Record Tag'),
        'output_folder' => t('Output Folder'),
        'merge' => t('Merge?'),
        'merge_set' => t('Set to Merge With'),
        'csv' => t('CSV Export'),
        'domain' => t('Domain'),
        'edit' => t('Edit'),
        'delete' => t('Delete'),
      ];
      $dmod = TRUE;
    }
    $db_select = \Drupal::database()->select('clearstone_form_export', 'e');
    $db_select->leftjoin('clearstone_form_merge', 'cm', 'cm.id = e.merge_set');
    $db_select->fields('e',
     ['id',
       'form_node_id',
       'filename', 'root_tag',
       'record_tag',
       'output_folder',
       'domain', 'merge', 'merge_set', 'csv',
     ])
      ->fields('cm',
       [
         'title',
         'filename',
         'output_folder',
         'root_tag',
         'record_tag',
       ])
      ->orderBy('id', 'DESC');
    $ids = $db_select->execute()->fetchAll();
    $forms = clearstone_get_form_ids();
    $output = [];
    if (!empty($ids)) {
      foreach ($ids as $key => $data) {
        foreach ($forms as $fm_key => $fm_value) {
          if (($data->form_node_id) == $fm_key) {
            $form_name = $fm_value;
          }
        }
        $edit_url = Url::fromRoute('clearstone.form_export_edit', ['eid' => $data->id]);
        $edit = Link::fromTextAndUrl(t('Edit'), $edit_url);

        $delete_url = Url::fromRoute('clearstone.form_export_delete', ['eid' => $data->id]);
        $delete = Link::fromTextAndUrl(t('Delete'), $delete_url);

        if (($dmod == TRUE) && (!empty($domains)) && (!empty($data->domain))) {
          foreach ($domains as $dm_key => $dm_value) {
            if (($data->domain) == $dm_key) {
              $domain_name = $dm_value;
            }
          }
        }
        if ((!empty($domain_name)) || ($dmod == TRUE)) {
          $output[$key] = [
            'id' => [$data->id],
            'form_node_id' => [$form_name],
            'filename' => [$data->merge == 1 ? $data->cm_filename : $data->filename],
            'root_tag' => [$data->merge == 1 ? $data->cm_root_tag : $data->root_tag],
            'record_tag' => [$data->merge == 1 ? $data->cm_record_tag : $data->record_tag],
            'output_folder' => [$data->merge == 1 ? $data->cm_output_folder : $data->output_folder],
            'merge' => [$data->merge == 0 ? 'No' : 'Yes'],
            'merge_set' => [$data->title],
            'csv' => [$data->csv],
            'domain' => [$domain_name],
            'edit' => [$edit],
            'delete' => [$delete],
          ];
        }
        else {
          $output[$key] = [
            'id' => [$data->id],
            'form_node_id' => [$data->form_node_id],
            'filename' => [$data->merge == 1 ? $data->cm_filename : $data->filename],
            'root_tag' => [$data->merge == 1 ? $data->cm_root_tag : $data->root_tag],
            'record_tag' => [$data->merge == 1 ? $data->cm_record_tag : $data->record_tag],
            'output_folder' => [$data->merge == 1 ? $data->cm_output_folder : $data->output_folder],
            'merge' => [$data->merge == 0 ? 'No' : 'Yes'],
            'merge_set' => [$data->title],
            'csv' => [$data->csv],
            'edit' => [$edit],
            'delete' => [$delete],
          ];
        }

      }
    }
    $form['table'] = [
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $output,
      '#empty' => t('No submissions found'),
    ];
    return $form;
  }

  /**
   * Ajax callaback.
   */
  public function clearstoneDomainFormIds($form, &$form_state) {
    return $form['forms']['form_node_id'];
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
    $domain = '';
    $values = $form_state->getValues();
    $node_id = $values['form_node_id'];
    $filename = $values['filename'];
    $root_tag = $values['root_tag'];
    $record_tag = $values['record_tag'];
    $output_folder = $values['output_folder'];
    $merge = $values['merge'];
    $merge_set = $values['merge_set'];
    $csv = $values['csv'];
    if (isset($values['domain'])) {
      $domain = $values['domain'];
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

        $update_data = \Drupal::database()->insert('clearstone_form_export')
          ->fields($array)
          ->execute();
        \Drupal::messenger()->addMessage('Form Export data saved successsfully.');
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

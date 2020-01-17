<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\file\Entity\File;
use Drupal\Component\Render\FormattableMarkup;

/**
 * Class RegionsForm.
 */
class RegionsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'regions_content_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = [];
    $form['regions'] = [
      '#type' => 'fieldset',
      '#title' => t('Manage Regions'),
      '#collapsible' => FALSE,
      '#description' => t('Create and manage state based regions.'),
    ];
    $form['regions']['region'] = [
      '#type' => 'textfield',
      '#title' => t('Region'),
    ];
    $form['regions']['states'] = [
      '#type' => 'textarea',
      '#title' => t('States'),
    ];
    $form['regions']['logo'] = [
      '#type' => 'managed_file',
      '#title' => t('Region Logo'),
      '#upload_location' => 'public://logos',
      '#upload_validators' => [
        'file_validate_extensions' => ['jpg, gif, png'],
      ],
    ];
    $form['regions']['favicon'] = [
      '#type' => 'managed_file',
      '#title' => t('Region Favicon'),
      '#upload_location' => 'public://favicons',
      '#upload_validators' => [
        'file_validate_extensions' => ['jpg, gif, png, ico'],
      ],
    ];

    $form['regions']['standard_plan'] = [
      '#type' => 'checkbox',
      '#title' => t('Only Standard Plan')
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Add New Region',
    ];

    $header = [
      'id' => ['data' => t('ID')],
      'url' => ['data' => t('Region')],
      'title' => ['data' => t('States')],
      'logo' => ['data' => t('Logo')],
      'favicon' => ['data' => t('Favicon')],
      'edit' => ['data' => t('Edit')],
      'delete' => ['data' => t('Delete')],
    ];
    $dmod = FALSE;
    $database = \Drupal::database();
    $results = $database->select('state_content_regions', 'z')
      ->fields('z', ['id', 'region', 'states', 'logo', 'favicon'])
      ->execute()
      ->fetchAll();
    $rows = [];
    foreach ($results as $result => $val) {
      $edit_link = [
        'data' => new FormattableMarkup('<a href=":link">@name</a>',
       [
         ':link' => '/admin/state-content/regions/' . $val->id . '/edit',
         '@name' => 'Edit',
       ]),
      ];
      $delete_link = [
        'data' => new FormattableMarkup('<a href=":link">@name</a>',
       [
         ':link' => '/admin/state-content/regions/' . $val->id . '/delete',
         '@name' => 'Delete',
       ]),
      ];

      $logo = '';
      if (is_numeric($val->logo) && !empty($val->logo)) {

        $logo_file = File::load($val->logo);
        // kint($logo_file);
        if ($logo_file != NULL) {
          $logo = new FormattableMarkup('<img src=":logo_url" width="150" />', [':logo_url' => $logo_file->url()]);
        }
      }

      $favicon = '';
      if (!empty($val->favicon)) {
        $fav_file = File::load($val->favicon);
        if ($fav_file != NULL) {
          $favicon = new FormattableMarkup('<img src=":fav_url" width="150" />', [':fav_url' => $fav_file->url()]);
        }
      }

      $rows[] = [
        $val->id,
        $val->region,
        $val->states,
        $logo,
        $favicon,
        $edit_link,
        $delete_link,
      ];

    }
    $form['table_regions'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => t('No regions.'),
    ];
    // $form['pager'] = array('#markup' => theme('pager'));.
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

    $conn = Database::getConnection();
    $conn->insert('state_content_regions')->fields(
    [
      'region' => $form_state->getValue('region'),
      'states' => $form_state->getValue('states'),
      'logo' => $logo_fid,
      'favicon' => $fav_fid,
      'standard_plan' => $form_state->getValue('standard_plan')
    ]
    )->execute();
    drupal_set_message(t('Your Region has been saved.'));
  }

}

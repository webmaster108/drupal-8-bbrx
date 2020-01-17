<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Component\Render\FormattableMarkup;

/**
 * Class ProfitAndLossForm.
 */
class SettingsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'state_content_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // $domain_storages = \Drupal::entityTypeManager()->getStorage('domain');
    $regions = state_content_get_all_regions();
    $form['urls'] = [
      '#type' => 'fieldset',
      '#title' => t('Manage URLs'),
      '#collapsible' => FALSE,
      '#description' => t('Create and manage zip code based urls.'),
    ];
    $form['urls']['url_title'] = [
      '#type' => 'textfield',
      '#title' => t('Page Title'),
    ];
    $form['urls']['url'] = [
      '#type' => 'textfield',
      '#title' => t('URL'),
      '#description' => t('Add urls without beginning or ending slashes. ex: admin/configure'),
    ];
    $form['urls']['region'] = [
      '#type' => 'select',
      '#title' => t('Region'),
      '#multiple' => TRUE,
      '#options' => $regions,
    ];
    $domains_name = [];
    $domains_name['none'] = 'Please select a domain.';
    $module_exist = \Drupal::moduleHandler()->moduleExists('domain');
    if ($module_exist) {
      $storage = \Drupal::entityTypeManager()->getStorage('domain');
      if ($storage) {
        $domains = $storage->loadMultiple();
        foreach ($domains as $val) {
          $domain_id = $val->id();
          $domains_name[$domain_id] = $val->get('name');
        }
      }
    }
    $form['urls']['domain_url'] = [
      '#type' => 'select',
      '#title' => t('Domain URL is available on.'),
      '#options' => $domains_name,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Add New URL'),
    ];

    $header = [
      'id' => ['data' => t('ID')],
      'url' => ['data' => t('Title')],
      'title' => ['data' => t('URL')],
      'logo' => ['data' => t('Region')],
      'domain' => ['data' => t('Domain')],
      'edit' => ['data' => t('Edit')],
      'delete' => ['data' => t('Delete')],
    ];
    /*$dmod = FALSE;
    // if(module_exists('domain')){
    // $header = array(
    //     'id' => array('data' => t('ID')),
    //       'region' => array('data' => t('Region')),
    //     'states' => array('data' => t('States')),
    //     'logo' => array('data' => t('Logo')),
    //     'favicon' => array('data' => t('Favicon')),
    //     'operations' => array('data' => t('Operations'))
    // );
    // $dmod = TRUE;
    // $domains = state_content_getdomains();
    // }*/
    $database = \Drupal::database();
    $do_name = '';
    $results = $database->select('state_content_urls', 'z')
      ->fields('z', ['id', 'url', 'title', 'region', 'domain'])
      ->execute()
      ->fetchAll();
    $rows = [];
    foreach ($results as $result) {
      $module_exist = \Drupal::moduleHandler()->moduleExists('domain');
      if ($module_exist) {
        $storage_domain = \Drupal::entityTypeManager()->getStorage('domain');
        if ($storage_domain) {
          $domains_name = $storage->load($result->domain);
          if ($domains_name) {
            $do_name = $domains_name->get('name');
          }
        }
      }
      else {
        $do_name = '';
      }
      $edit_link = [
        'data' => new FormattableMarkup('<a href=":link">@name</a>',
       [
         ':link' => '/admin/state-content/urls/' . $result->id . '/edit',
         '@name' => 'Edit',
       ]),
      ];
      $delete_link = [
        'data' => new FormattableMarkup('<a href=":link">@name</a>',
       [
         ':link' => '/admin/state-content/urls/' . $result->id . '/delete',
         '@name' => 'Delete',
       ]),
      ];

      $regions = unserialize($result->region);
      $regionNames = [];
      // kint($regions);
      if (!empty($regions) || $regions != FALSE) {
        foreach ($regions as $region) {
          $convertID = state_content_get_region($region);
          $regionNames[] = $convertID['region'];
        }
        $regionFriendly = implode(', ', $regionNames);
      }
      else {
        $regionFriendly = '';
      }
      $rows[] = [
        $result->id,
        $result->title,
        $result->url,
        $regionFriendly,
        $do_name,
        $edit_link,
        $delete_link,
      ];

    }
    $form['table_urls'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => t('No regions.'),
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
    // kint($values);
    $conn = Database::getConnection();
    $conn->insert('state_content_urls')->fields([
      'url' => $form_state->getValue('url'),
      'title' => $form_state->getValue('url_title'),
      'region' => $serialize_regions,
      'domain' => $form_state->getValue('domain_url'),
    ])->execute();
    drupal_set_message(t('New URL data has been saved.'));
  }

}

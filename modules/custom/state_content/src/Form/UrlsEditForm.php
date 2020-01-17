<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Class UrlsEditForm.
 */
class UrlsEditForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'state_urls_edit_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $url_id = '') {
    $regions = state_content_get_all_regions();
    $url = state_content_editurl($url_id);

    // kint($url);exit;
    $form['urls'] = [
      '#type' => 'fieldset',
      '#title' => t('Manage URLs'),
      '#collapsible' => FALSE,
      '#description' => t('Create and manage zip code based urls.'),
    ];
    $form['urls']['id'] = [
      '#type' => 'hidden',
      '#value' => $url_id,
    ];
    $form['urls']['url_title'] = [
      '#type' => 'textfield',
      '#title' => t('Page Title'),
      '#default_value' => $url['title'],
    ];
    $form['urls']['url'] = [
      '#type' => 'textfield',
      '#title' => t('URL'),
      '#description' => t('Add urls without beginning or ending slashes. ex: admin/configure'),
      '#default_value' => $url['url'],
    ];
    $selectedRegions = unserialize($url['region']);
    $form['urls']['region'] = [
      '#type' => 'select',
      '#title' => t('Region'),
      '#multiple' => TRUE,
      '#options' => $regions,
      '#default_value' => $selectedRegions,
    ];
    $default_domain = $url['domain'];
    $domains_name = [];
    $domains_name['none'] = 'Please select a domain.';
    $storage = \Drupal::entityTypeManager()->getStorage('domain');
    $domains = $storage->loadMultiple();
    foreach ($domains as $val) {
      $domain_id = $val->id();
      $domains_name[$domain_id] = $val->get('name');
    }
    $form['urls']['domain_url'] = [
      '#type' => 'select',
      '#title' => t('Domain URL is available on.'),
      '#options' => $domains_name,
      '#default_value' => $default_domain,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Edit URL'),
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

    $conn = Database::getConnection();
    $conn->update('state_content_urls')->fields([
      'url' => $form_state->getValue('url'),
      'title' => $form_state->getValue('url_title'),
      'region' => $serialize_regions,
      'domain' => $form_state->getValue('domain_url'),
    ])->condition('id', $form_state->getValue('id'), '=')->execute();
    $form_state->setRedirect('state_content.settings');
    drupal_set_message(t('URL data has been Updated.'));

  }

}

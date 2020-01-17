<?php

namespace Drupal\clearstone\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\Exception\RequestException;

/**
 * Clearstone configuration form.
 */
class ConfirmtaionNumberSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['clearstone.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'clearstone_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('clearstone.settings');

    $form['prefix_confirm_no'] = [
      '#type'           => 'textfield',
      '#title'          => $this->t("Prefix for confirmation number"),
      '#description'    => $this->t("Prefix for confirmation number."),
      '#default_value' => $config->get('prefix_confirm_no'),
    ];

    $form['starting_confirm_no'] = [
      '#type'           => 'textfield',
      '#title'          => $this->t('Starting confirmation number'),
      '#description'    => $this->t('Starting confirmation number.'),
      '#default_value' => !empty($config->get('starting_confirm_no')) ? $config->get('starting_confirm_no') : 1,
    ];

    $form['exclude_nodes'] = [
      '#type'           => 'textfield',
      '#title'          => $this->t("Exclude nodes from incrementing"),
      '#description'    => $this->t("Nodes to exclude from incrementing the confirmation number. Input multiples as comma separated. ex: 1,2,3"),
      '#default_value' => !empty($config->get('exclude_nodes')) ? $config->get('exclude_nodes') : 0,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('clearstone.settings')
      ->set('prefix_confirm_no', $form_state->getValue('prefix_confirm_no'))
      ->set('starting_confirm_no', $form_state->getValue('starting_confirm_no'))
      ->set('exclude_nodes', $form_state->getValue('exclude_nodes'))
      ->save();
  }

}

<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ChangestateForm.
 */
class ChangestateForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'change_state_content_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $path = \Drupal::service('path.current')->getPath();
    $availableStates = state_content_get_page_region($path);

    $states = state_content_get_states();
    if (empty($availableStates)) {
      $availableStates = state_content_get_all_regions_states();
    }

    foreach ($states as $k => $state) {
      if (array_search($k, $availableStates) === FALSE) {
        unset($states[$k]);
      }
    }
    $session = \Drupal::request()->getSession();
    $selected_state = $session->get('selected_state');
    if ($selected_state != NULL && array_key_exists($selected_state, $states)) {
      $label =  '<button type="button" class="btn btn-orange" data-toggle="modal" data-target="#myModal">Change your State</button>';
       $form['#attributes']['class'][] = 'state_selected_section';
    }
    else {
      $label = 'Choose Your State';
      $form['#attributes']['class'][] = 'state_not_selected_section';
    }

    $form['btn_choose_state'] = [
      '#type' => 'inline_template',
      '#template' => '<button type="button" id="change-state-popup" class="btn btn-info area-search radius border-0" data-toggle="modal" data-target="#myModal">' . $label . '</button>
      <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog modal-sm ">
              <div class="modal-content p-5">
                 <div class="modal-header position-absolute cross-sign">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                 </div>
               <div class="modal-body p-0">',
    ];

    $form['state'] = [
      '#type' => 'select',
      '#options' => $states,
      '#title' => t('Please select a State'),
      '#default_value' => $selected_state,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Go'),
      '#attributes' => ['class' => ['btn btn-default']],
    ];
    $form['results'] = [
      '#type' => 'inline_template',
    // '#prefix' => '<div id="state-results">',.
      '#template' => '</div></div></div></div>',
    // '#markup' => ''.
    ];
    $form['#cache'] = ['max-age' => 0];
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

    // $session = new \Symfony\Component\HttpFoundation\Session\Session();
    // Set session attributes.
    $input = $form_state->getUserInput();
    $values = $form_state->getValues();
    $session = \Drupal::request()->getSession();
    $session->set('selected_state', $values['state']);
  }

}

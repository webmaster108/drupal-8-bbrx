<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class WebformComponentDeleteForm.
 */
class WebformComponentDeleteForm extends ConfirmFormBase {
  /**
   * ID of the item to delete.
   *
   * @var int
   */
  protected $id;

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $cid = NULL) {
    $this->id = $cid;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $delete_id = $this->id;
    $query = \Drupal::database()->delete('webform_state_field_by_nid');
    $query->condition('id', $delete_id, '=');
    $query->execute();
    $form_state->setRedirect('state_content.webform_component_form');
    drupal_set_message(t('Componet has been deleted successfully'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "confirm_webform_component_delete_form";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('state_content.webform_component_form');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure?');
  }

}

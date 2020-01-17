<?php

namespace Drupal\clearstone\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class ClearstoneFormMergesDeleteForm.
 */
class ClearstoneFormMergesDeleteForm extends ConfirmFormBase {
  /**
   * ID of the item to delete.
   *
   * @var int
   */
  protected $id;

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $mid = NULL) {
    $this->id = $mid;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $delete_id = $this->id;
    $query = \Drupal::database()->delete('clearstone_form_merge');
    $query->condition('id', $delete_id, '=');
    $query->execute();
    $form_state->setRedirect('clearstone.form_merges');
    drupal_set_message(t('Merge Form has been deleted successfully'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "confirm_Form_merges_delete_form";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('clearstone.form_merges');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete this merge?');
  }

}

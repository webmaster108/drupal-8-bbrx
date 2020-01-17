<?php

namespace Drupal\clearstone\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class ClearstoneFormExportDeleteForm.
 */
class ClearstoneFormExportDeleteForm extends ConfirmFormBase {
  /**
   * ID of the item to delete.
   *
   * @var int
   */
  protected $id;

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $eid = NULL) {
    $this->id = $eid;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $delete_id = $this->id;
    $query = \Drupal::database()->delete('clearstone_form_export');
    $query->condition('id', $delete_id, '=');
    $query->execute();
    $form_state->setRedirect('clearstone.form_export');
    drupal_set_message(t('Form has beedn deleted successfully'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "confirm_Form_export_delete_form";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('clearstone.form_export');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete this form from exporting?');
  }

}

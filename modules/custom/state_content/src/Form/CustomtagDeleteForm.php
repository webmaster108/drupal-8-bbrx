<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class CustomtagDeleteForm.
 */
class CustomtagDeleteForm extends ConfirmFormBase {
  /**
   * ID of the item to delete.
   *
   * @var int
   */
  protected $id;

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $tag_id = NULL) {
    $this->id = $tag_id;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // kint($this->id);exit;.
    $delete_id = $this->id;
    $query = \Drupal::database()->delete('state_content_custom_tags');
    $query->condition('id', $delete_id, '=');
    $query->execute();
    $form_state->setRedirect('state_content.customtag_form');
    drupal_set_message(t('Region has been deleted'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "confirm_tag_delete_form";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('state_content.customtag_form');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Do you want to delete %id?', ['%id' => $this->id]);
  }

}

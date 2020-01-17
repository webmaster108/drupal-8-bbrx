<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class UrlsDeleteForm.
 */
class UrlsDeleteForm extends ConfirmFormBase {
  /**
   * ID of the item to delete.
   *
   * @var int
   */
  protected $id;

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $url_id = NULL) {
    $this->id = $url_id;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $delete_id = $this->id;
    // kint($delete_id);exit;
    $query = \Drupal::database()->delete('state_content_urls');
    $query->condition('id', $delete_id, '=');
    $query->execute();
    $form_state->setRedirect('state_content.settings');
    drupal_set_message(t('Url has been deleted'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "confirm_url_delete_form";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('state_content.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Do you want to delete %id?', ['%id' => $this->id]);
  }

}

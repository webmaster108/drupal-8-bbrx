<?php

namespace Drupal\track_enrollment_referrals\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;

/**
 * Class TrackEnrollmentReferralsDeleteForm.
 */
class TrackEnrollmentReferralsDeleteForm extends ConfirmFormBase {
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
    $query = \Drupal::database()->delete('track_enrollment_referrals');
    $query->condition('webform_id', $delete_id, '=');
    $query->execute();
    $form_state->setRedirect('track_enrollment_referrals.trackenrollment_referrals');
    drupal_set_message(t('Data has been deleted successfully'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "confirm_track_delete_form";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('track_enrollment_referrals.trackenrollment_referrals');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure?');
  }

}

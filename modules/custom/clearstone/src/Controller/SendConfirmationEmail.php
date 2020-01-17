<?php

namespace Drupal\clearstone\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Utility\Html;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Defines SendConfirmationEmail class.
 */
class SendConfirmationEmail extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function confirmation() {
    $email = $_POST['email'];
    $webnid = $_POST['webnid'];
    $sid = '';
    $conf = '';
    $request = \Drupal::request();
    $session = $request->getSession();
    $secret = $_SESSION['conf'];
    if ($secret != NULL) {
      if (db_table_exists('clearstone_submission_conf')) {
        $connection = \Drupal::database();
        $results = $connection->select('clearstone_submission_conf', 'c')
          ->fields('c', ['sid', 'conf_number'])
          ->condition('c.secret', $secret)
          ->range(0, 1)
          ->orderBy('c.sid', 'DESC')
          ->execute()->fetchAll();
      }
      foreach ($results as $result) {
        $sid = $result->sid;
        $conf = $result->conf_number;
      }
      $webform_submission = \Drupal\webform\Entity\WebformSubmission::load($sid);
      $data = $webform_submission->getdata();

      $body = '';
        if($webnid == 48){
          $body .= 'Thank you! You have successfully submitted your your Basic Blue Rx premium payment option.';
        }else if($webnid == 46){
          $body .= 'Thank you! You have successfully submitted your your Basic Blue Rx contact information changes.';
        }else{
          $body .= 'Thank you! You have successfully submitted your enrollment election. Upon Medicare\'s review of your election we will notify you by mail regarding your enrollment into '. $data['planname'] .'.';
        }
      $body .= '<p>Confirmation #' . str_pad($conf, 6, '0', STR_PAD_LEFT) . '</p>';

      if ($email != '' && $email != NULL) {
        $mailManager = \Drupal::service('plugin.manager.mail');
        $module = 'clearstone';
        $key = 'submission_confirmation';
        $to = $email;
        $params['message'] = $body;
        $langcode = \Drupal::currentUser()->getPreferredLangcode();
        $send = TRUE;
        // Send Html mail using PhpMail.
        $send_mail = new \Drupal\Core\Mail\Plugin\Mail\PhpMail();
        $from = \Drupal::config('system.site')->get('mail');
        $message['headers'] = [
          'content-type' => 'text/html',
          'MIME-Version' => '1.0',
          'reply-to' => $from,
          'from' => \Drupal::config('system.site')->get('name') . '<' . $from . '>'
        ];
        $message['to'] = $to;
        $message['subject'] = t('Confirmation Message');

        $message['body'] = $body;

        //$result = $send_mail->mail($message);
        $result = $mailManager->mail($module, $key, $to, $langcode, $params, $reply = NULL, $send);

        // if ($result['result'] !== TRUE || $result = '') {
        if (!$result) {
          $response = [
            'status' => 400,
            'message' => 'A confirmation email not sent to your email.',
          ];
        }
        else {
          $response = [
            'status' => 200,
            'message' => 'A confirmation email has been sent to your email.',
          ];
        }
      }
      else {
        $response['status'] = 400;
        $response['message'] = 'Sorry, please enter a email address.';
      }
    }
    else {
      $response = [
        'status' => 400,
        'message' => 'A confirmation email not sent to your email.',
      ];
    }

    $element = [
      '#markup' => $response,
    ];
    
    return new JsonResponse($response);
    
  }

}

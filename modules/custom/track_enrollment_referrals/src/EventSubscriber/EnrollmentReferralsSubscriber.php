<?php

namespace Drupal\track_enrollment_referrals\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class EnrollmentReferralsSubscriber.
 */
class EnrollmentReferralsSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public function onRequest(GetResponseEvent $event) {
    if (isset($_GET['npn'])) {
      $npn = $_GET['npn'];
      $request = \Drupal::request();
      $session = $request->getSession();
      $session->set('url_npn', $npn);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['onRequest', 100];
    return $events;
  }

}

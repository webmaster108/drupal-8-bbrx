<?php

namespace Drupal\state_content\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class StateContentSubscriber.
 */
class StateContentSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public function onRequest(GetResponseEvent $event) {
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
    $valid_states = array_keys($states);
    foreach ($valid_states as $key => $value) {
      $valid_states[$key] = strtoupper($value);
    }

    $request = \Drupal::request();
    if (!empty($request->get('state'))) {
      $selected_state = strtoupper($request->get('state'));
      if (in_array($selected_state, $valid_states)) {
        $session = $request->getSession();
        $session->set('selected_state', $selected_state);
      }
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

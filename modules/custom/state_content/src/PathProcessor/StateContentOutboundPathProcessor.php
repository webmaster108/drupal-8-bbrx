<?php

namespace Drupal\state_content\PathProcessor;

use Drupal\Core\PathProcessor\OutboundPathProcessorInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Render\BubbleableMetadata;

/**
 * Class StateContentOutboundPathProcessor.
 */
class StateContentOutboundPathProcessor implements OutboundPathProcessorInterface {

  /**
   * {@inheritdoc}
   */
  public function processOutbound($path, &$options = [], Request $request = NULL, BubbleableMetadata $bubbleable_metadata = NULL) {
    $request = \Drupal::request();
    $session = $request->getSession();
    if (isset($session) && !empty($session->get('selected_state'))) {
      $options['query']['state'] = $session->get('selected_state');
    }
    if ($bubbleable_metadata) {
      $bubbleable_metadata->addCacheContexts(['url.query_args:state']);
    }
    return $path;
  }

}

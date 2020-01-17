<?php

namespace Drupal\track_enrollment_referrals\PathProcessor;

use Drupal\Core\PathProcessor\OutboundPathProcessorInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Render\BubbleableMetadata;

/**
 * Class EnrollmentReferralsOutboundPathProcessor.
 */
class EnrollmentReferralsOutboundPathProcessor implements OutboundPathProcessorInterface {

  /**
   * {@inheritdoc}
   */
  public function processOutbound($path, &$options = [], Request $request = NULL, BubbleableMetadata $bubbleable_metadata = NULL) {
    if (!empty($_SESSION['url_npn'])) {
      $options['query']['npn'] = $_SESSION['url_npn'];
    }
    if ($bubbleable_metadata) {
      $bubbleable_metadata->addCacheContexts(['url.query_args:npn']);
    }
    return $path;
  }

}

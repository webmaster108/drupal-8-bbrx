<?php

namespace Drupal\clearstone\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'custom' block.
 *
 * @Block(
 *   id = "last_updated_block",
 *   admin_label = @Translation("Last Updated Block"),
 *   category = @Translation("Custom updated block")
 * )
 */
class LastUpdatedBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $lastUpdated = strtotime('now');
    if ($node = \Drupal::routeMatch()->getParameter('node')) {
      if (!empty($node)) {
      $lastUpdated = $node->get('changed')->getString();
      $blocks = \Drupal::entityManager()
      ->getStorage('block_content');        
      $blocks = $blocks->loadMultiple();
        foreach($blocks as $k => $block){
            if($block->get('changed')->getString() > $lastUpdated){
                $lastUpdated = $block->get('changed')->getString();
            }
        }

      }
    }
    $lastUpdated = date('F j, Y', $lastUpdated);
    return [
      '#type' => 'markup',
      '#markup' => t('Last Updated: @time', ['@time' => $lastUpdated]),
    ];
  }

}

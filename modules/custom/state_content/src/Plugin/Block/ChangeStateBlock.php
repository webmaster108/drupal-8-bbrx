<?php

namespace Drupal\state_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'State Content' block.
 *
 * @Block(
 *   id = "state_content",
 *   admin_label = @Translation("Change State block"),
 *   category = @Translation("Custom State Content Module")
 * )
 */
class ChangeStateBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\state_content\Form\ChangestateForm');
    return $form;
  }

}

<?php
/**
 * @file
 * Contains \Drupal\agent_validation\Plugin\Block\AgentValidationBlock.
 */
namespace Drupal\agent_validation\Plugin\Block;
use Drupal\Core\Block\BlockBase;
/**
 * Provides a 'State Content' block.
 *
 * @Block(
 *   id = "agent_validation",
 *   admin_label = @Translation("Agent Validation Form Block"),
 *   category = @Translation("Agent Validation Form Block")
 * )
 */
class AgentValidationBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\agent_validation\Form\NpaSearchForm');
    return $form;
  }
  
}
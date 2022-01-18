<?php
namespace Drupal\custom_module\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'CustomBlock' block.
 *
 * @Block(
 *  id = "custom_block",
 *  admin_label = @Translation("custom block"),
 * )
 */
class CustomBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    ////$build = [];
    //$build['custom_block']['#markup'] = 'Implement CustomBlock.';

    $form = \Drupal::formBuilder()->getForm('Drupal\custom_module\Form\CustomForm');
    return $form;
  }
}
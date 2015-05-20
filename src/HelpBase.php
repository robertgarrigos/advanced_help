<?php
/**
 * @file
 * Provides Drupal\advanced_help\FlavorBase.
 */

namespace Drupal\advanced_help;

use Drupal\Component\Plugin\PluginBase;

class HelpBase extends PluginBase implements HelpInterface {

  public function getName() {
    return $this->pluginDefinition['name'];
  }

  /**
   * {@inheritdoc}
   */
  public function getIndex() {
    return [
      'filename-without-extension' => [
        'title' => 'Filename',
        'weight' => -11
      ]
    ];
  }
}

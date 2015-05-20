<?php
/**
 * @file
 * Contains \Drupal\advancedhelp\Plugin\Help\AdvancedHelp.
 */

namespace Drupal\advanced_help\Plugin\Help;

use Drupal\advanced_help\HelpBase;

/**
 * Provides the help for Advanced Help Module.
 *
 * @Help(
 *   id = "advanced_help",
 *   name = "Advanced Help",
 * )
 */
class AdvancedHelp extends HelpBase {

  /**
   * {@inheritdoc}
   */
  public function getIndex() {
    return [
      'readme' => [
        'title' => 'README',
        'weight' => -11
      ],
      'using-advanced-help' => [
        'title' => 'Using advanced help',
        'weight' => '-10'
      ],
      'translation' => [
        'title' => 'Translating advanced help',
      ],
      'ini-file' => [
        'title' => 'Advanced help .ini file format',
        'line break' => false,
      ],
      'why-advanced-help' => [
        'title' => 'Why advanced help?',
        'line break = true'
      ]
    ];
  }
}

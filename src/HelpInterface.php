<?php
/**
 * @file
 * Provides Drupal\advanced_help\HelpInterface
 */

namespace Drupal\advanced_help;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for ice cream flavor plugins.
 */
interface HelpInterface extends PluginInspectionInterface {

  /**
   * Return the name of the module.
   *
   * @return string
   */
  public function getName();

  /**
   * Get Index.
   *
   * Returns an associative array with the order of the documentation.
   *  <code>
   *    return [
   *      'readme' => [
   *        'title' => 'README',
   *        'weight' => -11
   *      ],
   *      'using-advanced-help' => [
   *        'title' => 'Using advanced help',
   *        'weight' => '-10'
   *      ]
   *    ];
   *  </code>
   * @todo Replace this function for a YML file.
   * @return array
   */
  public function getIndex();
}
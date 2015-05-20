<?php
/**
 * @file
 * Contains \Drupal\advancedhelp\Annotation\Help.
 */

namespace Drupal\advanced_help\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a help item annotation object.
 *
 * Plugin Namespace: Plugin\advanced_help\help
 *
 * @see \Drupal\advanced_help\Plugin\AdvancedHelpManager
 * @see plugin_api
 *
 * @Annotation
 */
class Help extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The Plugin Name.
   */
  public $name;

}

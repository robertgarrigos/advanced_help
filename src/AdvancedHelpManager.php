<?php
/**
 * @file
 * Contains AdvancedHelpManager
 */

namespace Drupal\advanced_help;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * AdvancedHelp plugin manager.
 */
class AdvancedHelpManager extends DefaultPluginManager {

  /**
   * Constructs an AdvancedHelpManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations,
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/Help', $namespaces, $module_handler, 'Drupal\advanced_help\HelpInterface', 'Drupal\advanced_help\Annotation\Help');
    $this->alterInfo('advancedhelp_help_info');
    $this->setCacheBackend($cache_backend, 'advancedhelp_help');
  }
}
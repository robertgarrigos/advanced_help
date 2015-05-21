<?php
/**
 * @file
 * Contains AdvancedHelpManager
 */

namespace Drupal\advanced_help;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Component\Discovery\YamlDiscovery;
use Drupal\Core\Plugin\Factory\ContainerFactory;

/**
 * AdvancedHelp plugin manager.
 */
class AdvancedHelpManager {

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
    $this->discovery = new  YamlDiscovery('advanced_help', $module_handler->getModuleDirectories());
    $this->factory = new ContainerFactory($this, 'Drupal\advanced_help\HelpInterface');
    $this->moduleHandler = $module_handler;

  }

  public function getDefinitions() {
      return $this->discovery->findAll();
  }

  public function getModuleIndex($module_name) {
    $modules = $this->discovery->findAll();

    foreach ($modules as $module => $data) {
      if ($module_name == $module) {
        return $data;
      }
    }

    return false;
  }
}
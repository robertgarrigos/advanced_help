<?php
/**
 * @file
 * Contains AdvancedHelpManager
 */

namespace Drupal\advanced_help;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Component\Discovery\YamlDiscovery;
use Drupal\Core\Plugin\Factory\ContainerFactory;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * AdvancedHelp plugin manager.
 */
class AdvancedHelpManager extends DefaultPluginManager {
  use StringTranslationTrait;

  /**
   * Constructs an AdvancedHelpManager instance.
   *
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   Theme handler.
   * @param \Drupal\Core\StringTranslation\TranslationInterface $string_translation
   *   The string translation service.
   */
  public function __construct(ModuleHandlerInterface $module_handler, ThemeHandlerInterface $theme_handler, CacheBackendInterface $cache_backend, TranslationInterface $string_translation) {
    $directories = $module_handler->getModuleDirectories() + $theme_handler->getThemeDirectories();
    // the YML file is in the /{$module}/help folder, we need change the path.
    array_walk($directories, function(&$item) {
      $item = $item . "/help";
    });

    $this->discovery = new YamlDiscovery('help', $directories);
    $this->factory = new ContainerFactory($this, 'Drupal\advanced_help\HelpInterface');
    $this->moduleHandler = $module_handler;

    $this->setStringTranslation($string_translation);
    $this->alterInfo('advanced_help');
    $this->setCacheBackend($cache_backend, 'advanced_help', ['advanced_help']);
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

<?php

/**
 * @file
 * Contains Drupal\advanced_help\Controller\AdvancedHelpController.
 */

namespace Drupal\advanced_help\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

/**
 * Class AdvancedHelpController.
 *
 * @package Drupal\advanced_help\Controller\AdvancedHelpController.
 */
class AdvancedHelpController extends ControllerBase {

  /**
   * Content.
   *
   * @return array
   *   Returns module index.
   */
  public function main() {

    $manager = \Drupal::service('plugin.manager.advanced_help');
    $plugins = $manager->getDefinitions();
    $list = [];

    foreach ($plugins as $module_name => $plugin) {
      $list[] = $this->l($plugin['name'], new Url('advanced_help.module_index', ['module' => $module_name]));
    }

    return [
      'help_modules' => [
        '#theme' => 'item_list',
        '#items' => $list,
        '#title' => t('Module help index'),
      ]
    ];
  }

  public function moduleIndex($module) {
    $module_help = \Drupal::service('plugin.manager.advanced_help')->getModuleIndex($module);
    $list = [];

    foreach ($module_help['index'] as $file_name => $attributes) {
      $list[] = $this->l($attributes['title'], new Url('advanced_help.help', ['module' => $module, 'topic' => $file_name]));
    }

    return [
      'index' => [
        '#theme' => 'item_list',
        '#items' => $list,
      ]
    ];
  }

  public function moduleIndexTitle($module) {
    $module_help = \Drupal::service('plugin.manager.advanced_help')->getModuleIndex($module);
    return "{$module_help['name']} help index";
  }

  public function topicPage($module, $topic) {
    $path = drupal_get_path('module', $module);
    $path = "{$path}/help/{$topic}.html";

    if (file_exists($path)) {
      $content = file_get_contents($path);
    }

    return [
      '#type' => 'markup',
      '#markup' => $content,
    ];
  }

  public function topicPageTitle($module, $topic) {
    $module_help = \Drupal::service('plugin.manager.advanced_help')->getModuleIndex($module);
    return $module_help['index'][$topic]['title'];
  }
}
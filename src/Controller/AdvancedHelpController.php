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

    foreach ($plugins as $key => $plugin) {
      $list[] = $this->l($plugin['name'], new Url('advanced_help.module_index', ['module' => $plugin['id']]));
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
    $manager = \Drupal::service('plugin.manager.advanced_help');
    $plugin = $manager->createInstance($module);
    $index = $plugin->getIndex();
    $list = [];

    foreach ($index as $file_name => $attributes) {
      $list[] = $this->l($attributes['title'], new Url('advanced_help.help', ['module' => $module, 'topic' => $file_name]));
    }

    return [
      'index' => [
        '#theme' => 'item_list',
        '#items' => $list,
        '#title' => $plugin->getName()
      ]
    ];
  }

  public function moduleIndexTitle($module) {
    $plugin = \Drupal::service('plugin.manager.advanced_help')->createInstance($module);
    return "{$plugin->getName()} help index";
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
    $plugin = \Drupal::service('plugin.manager.advanced_help')->createInstance($module);
    return $plugin->getIndex()[$topic]['title'];
  }
}
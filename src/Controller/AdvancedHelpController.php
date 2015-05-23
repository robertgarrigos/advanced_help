<?php

/**
 * @file
 * Contains Drupal\advanced_help\Controller\AdvancedHelpController.
 */

namespace Drupal\advanced_help\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AdvancedHelpController.
 *
 * @package Drupal\advanced_help\Controller\AdvancedHelpController.
 */
class AdvancedHelpController extends ControllerBase {

  /**
   * @var THe advanced help plugin.
   */
  private $advanced_help;


  public function __construct() {
    $this->advanced_help = \Drupal::service('plugin.manager.advanced_help');
  }

  /**
   * Content.
   *
   * @todo Implement search integration.
   * @return array
   *   Returns module index.
   */
  public function main() {
    $topics = $this->advanced_help->getTopics();
    $settings = $this->advanced_help->getSettings();

    // Print a module index.
    $modules = $this->advanced_help->getModuleList();
    asort($modules);

    $items = [];
    foreach ($modules as $module => $module_name) {
      if (!empty($topics[$module]) && empty($settings[$module]['hide'])) {
        if (isset($settings[$module]['index name'])) {
          $name = $settings[$module]['index name'];
        }
        elseif (isset($settings[$module]['name'])) {
          $name = $settings[$module]['name'];
        }
        else {
          $name = $this->t($module_name);
        }
        $items[] = $this->l($name, new Url('advanced_help.module_index', ['module' => $module]));
      }
    }

    return [
      'help_modules' => [
        '#theme' => 'item_list',
        '#items' => $items,
        '#title' => t('Module help index'),
      ]
    ];
  }

  /**
   * Build a hierarchy for a single module's topics.
   *
   * @param $topics array.
   * @return array.
   */
  private function getTopicHierarchy($topics) {
    foreach ($topics as $module => $module_topics) {
      foreach ($module_topics as $topic => $info) {
        $parent_module = $module;
        // We have a blank topic that we don't want parented to itself.
        if (!$topic) {
          continue;
        }

        if (empty($info['parent'])) {
          $parent = '';
        }
        elseif (strpos($info['parent'], '%')) {
          list($parent_module, $parent) = explode('%', $info['parent']);
          if (empty($topics[$parent_module][$parent])) {
            // If it doesn't exist, top level.
            $parent = '';
          }
        }
        else {
          $parent = $info['parent'];
          if (empty($module_topics[$parent])) {
            // If it doesn't exist, top level.
            $parent = '';
          }
        }

        if (!isset($topics[$parent_module][$parent]['children'])) {
          $topics[$parent_module][$parent]['children'] = [];
        }
        $topics[$parent_module][$parent]['children'][] = [$module, $topic];
        $topics[$module][$topic]['_parent'] = [$parent_module, $parent];
      }
    }
    return $topics;
  }

  /**
   * Helper function to sort topics.
   */
  private function helpUasort($id_a, $id_b) {
    $topics = $this->advanced_help->getTopics();
    list($module_a, $topic_a) = $id_a;
    $a = $topics[$module_a][$topic_a];
    list($module_b, $topic_b) = $id_b;
    $b = $topics[$module_b][$topic_b];

    $a_weight = isset($a['weight']) ? $a['weight'] : 0;
    $b_weight = isset($b['weight']) ? $b['weight'] : 0;
    if ($a_weight != $b_weight) {
      return ($a_weight < $b_weight) ? -1 : 1;
    }

    if ($a['title'] != $b['title']) {
      return ($a['title'] < $b['title']) ? -1 : 1;
    }
    return 0;
  }

  /**
   * Build a tree of advanced help topics.
   *
   * @param array $topics
   *   Topics.
   * @param array $topic_ids
   *   Topic Ids.
   * @param int $max_depth
   *   Maximum depth for subtopics.
   * @param int $depth
   *   Default depth for subtopics.
   *
   * @return array
   *   Returns list of topics/subtopics.
   */
  private function getTree($topics, $topic_ids, $max_depth = -1, $depth = 0) {
    uasort($topic_ids, [$this, 'helpUasort']);
    $items = [];
    foreach ($topic_ids as $info) {
      list($module, $topic) = $info;
      $item = $this->l($topics[$module][$topic]['title'], new Url('advanced_help.help', ['module' => $module, 'topic' => $topic]));
      if (!empty($topics[$module][$topic]['children']) && ($max_depth == -1 || $depth < $max_depth)) {
        $link = [
          '#theme' => 'item_list',
          '#items' => advanced_help_get_tree($topics, $topics[$module][$topic]['children'], $max_depth, $depth + 1),
        ];
        $item .= \Drupal::service('renderer')->render($link, FALSE);
      }
      $items[] = $item;
    }

    return $items;
  }


  public function moduleIndex($module) {
    $topics = $this->advanced_help->getTopics();

    if (empty($topics[$module])) {
      throw new NotFoundHttpException();
    }

    $topics = $this->getTopicHierarchy($topics);
    $items = $this->getTree($topics, $topics[$module]['']['children']);

    return [
      'index' => [
        '#theme' => 'item_list',
        '#items' => $items,
      ]
    ];
  }

  public function moduleIndexTitle($module) {
    return $module;
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
    return $topic;
  }


}
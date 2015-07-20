<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Main_cell extends Cell_Controller {

  /* render_cell ('main_cell', 'banner', array ()); */
  // public function _cache_banner () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function banner () {
    $pictures = GoalPicture::find ('all', array ('limit' => 10));
    $tags = GoalTag::find ('all');

    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view (array (
                    'pictures' => $pictures,
                    'tags' => $tags
                  ));
  }

  /* render_cell ('main_cell', 'boxs', array ()); */
  // public function _cache_keyword () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function boxs () {
    $comments = GoalComment::find ('all', array ('limit' => 4, 'order' => 'id DESC'));
    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view (array (
                    'comments' => $comments
                  ));
  }

  /* render_cell ('main_cell', 'unit', array ()); */
  // public function _cache_keyword () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function unit () {
    $goals = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 6));
    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view (array (
                    'goals' => $goals
                  ));
  }

  /* render_cell ('main_cell', 'details', array ()); */
  // public function _cache_keyword () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function details () {
    $goals = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 3));
    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view (array (
                    'goals' => $goals
                  ));
  }

  /* render_cell ('main_cell', 'tabview', array ()); */
  // public function _cache_tagview () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function tabview () {
    $data = array ();
    $data['本週人氣'] = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 4));
    $data['熱門關鍵'] = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 4));
    $data['大排長龍'] = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 4));
    $data['連假特輯'] = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 4));
    $data['甜死人美食'] = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 4));
    $data['超難吃推薦'] = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 4));

    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view (array (
                    'data' => $data
                  ));
  }

  /* render_cell ('main_cell', 'search', array ()); */
  // public function _cache_search () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function search ($is_search = false) {
    $limit = 15;
    $d4 = array (array (231, 109, 102), array (244, 177, 60), array (242, 224, 68), array (183, 232, 94), array (110, 192, 166), array (122, 174, 218), array (56, 121, 217), array (103, 58, 183), array (156, 39, 176), array (163, 145, 199), array (255, 192, 203), array (210, 129, 167), array (0, 0, 0), array (128, 128, 128), array (255, 255, 255), array (255, 255, 255));

    $colors = array_slice (array_merge (array_map (function ($color) {
                  return array ($color->color_red += $color->color_red - 128, $color->color_green += $color->color_green - 128, $color->color_blue += $color->color_blue - 128);
                }, GoalPicture::find ('all', array ('select' => 'color_red, color_green, color_blue, COUNT(id) AS count', 'limit' => $limit / 3 * 2, 'order' => 'count DESC', 'group' => 'ROUND(color_red / 30), ROUND(color_green / 30), ROUND(color_blue / 30)'))), $d4), 0, $limit);

    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view (array (
                    'colors' => $colors,
                    'is_search' => $is_search
                  ));
  }
}
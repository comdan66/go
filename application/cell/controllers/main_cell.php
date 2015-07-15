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

  /* render_cell ('main_cell', 'keyword', array ()); */
  // public function _cache_keyword () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function keyword () {
    return $this->load_view ();
  }

  /* render_cell ('main_cell', 'tagview', array ()); */
  // public function _cache_tagview () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function tagview () {
    $data = array ();
    $data['本週人氣'] = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 4));
    $data['熱門關鍵'] = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 4));
    $data['大排長龍'] = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 4));
    $data['連假特輯'] = Goal::find ('all', array ('order' => 'RAND()', 'limit' => 4));

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
  public function search () {
    return $this->setUseCssList (true)
                ->load_view ();
  }
}
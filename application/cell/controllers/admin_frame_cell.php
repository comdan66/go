<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Admin_frame_cell extends Cell_Controller {

  /* render_cell ('admin_frame_cell', 'header', array ()); */
  // public function _cache_header () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function header () {
    $left_links = array (
        array ('name' => '首頁', 'href' => base_url (), 'is_login' => false),
        array ('name' => '會員管理', 'href' => base_url ('admin', 'users', 'index'), 'is_login' => true),
        array ('name' => '標籤管理', 'href' => base_url ('admin', 'goal_tags', 'index'), 'is_login' => true),
        array ('name' => '景點管理', 'href' => base_url ('admin', 'goals', 'index'), 'is_login' => true),
        array ('name' => '首頁管理', 'href' => base_url ('admin', 'index', 'index'), 'is_login' => true),
      );
    $right_links = array (
        array ('name' => '登出', 'href' => base_url ('platform', 'sign_out'), 'is_login' => true),
      );

    return $this->setUseCssList (true)
                ->load_view (array (
                    'left_links' => $left_links,
                    'right_links' => $right_links
                  ));
  }

  /* render_cell ('admin_frame_cell', 'footer', array ()); */
  // public function _cache_footer () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function footer () {
    return $this->setUseCssList (true)
                ->load_view ();
  }

  /* render_cell ('admin_frame_cell', 'sides', array ()); */
  // public function _cache_sides () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function sides ($sides_list) {
    return $this->setUseCssList (true)
                ->load_view (array (
                    'sides_list' => $sides_list
                  ));
  }

  /* render_cell ('admin_frame_cell', 'pagination', array ()); */
  // public function _cache_pagination () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function pagination () {
    return $this->load_view ();
  }
}
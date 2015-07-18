<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Site_frame_cell extends Cell_Controller {

  /* render_cell ('site_frame_cell', 'header', array ()); */
  // public function _cache_header () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function header () {

    $left_links = array (
        array ('name' => '首頁', 'href' => base_url (), 'show' => true),
        array ('name' => '搜尋', 'href' => base_url ('search'), 'show' => true),
        array ('name' => '地圖', 'href' => base_url ('maps'), 'show' => true),
        array ('name' => '氣象', 'href' => base_url ('weather'), 'show' => true),
      );
    $right_links = array (
        array ('name' => '登出', 'href' => base_url ('platform', 'sign_out'), 'show' => identity ()->user () ? true : false),
        array ('name' => '登入', 'href' => facebook ()->login_url ('platform', 'fb_sign_in'), 'show' => identity ()->user () ? false : true),
        array ('name' => '後台', 'href' => base_url ('admin'), 'show' => identity ()->user () && in_array (identity ()->user ()->uid, Cfg::setting ('site', 'admin', 'uids'))),
        array ('name' => '關於', 'href' => '', 'show' => true),
      );

    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view (array (
                    'left_links' => $left_links,
                    'right_links' => $right_links
                  ));
  }

  /* render_cell ('site_frame_cell', 'footer', array ()); */
  // public function _cache_footer () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function footer () {
    return $this->setUseCssList (true)
                ->load_view ();
  }
}
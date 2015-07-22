<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Admin_controller extends Oa_controller {
  private $sides = array ();

  public function __construct () {
    parent::__construct ();
    $this->load->helper ('identity');
    $this->load->helper ('facebook');

    if (!(identity ()->user () && in_array (identity ()->user ()->uid, Cfg::setting ('site', 'admin', 'uids'))))
      return redirect ();

    $this
         ->set_componemt_path ('component', 'admin')
         ->set_frame_path ('frame', 'admin')
         ->set_content_path ('content', 'admin')
         ->set_public_path ('public')

         ->set_title ("後台管理系統 - Go! Taiwan")

         ->add_hidden (array ('id' => 'get_goals_url', 'value' => base_url ('admin', 'pub_method', 'get_goals')))
         ->add_hidden (array ('id' => 'get_towns_url', 'value' => base_url ('admin', 'pub_method', 'get_towns')))
         ->add_hidden (array ('id' => 'update_goal_position_url', 'value' => base_url ('admin', 'pub_method', 'update_goal_position')))
         ->add_hidden (array ('id' => 'update_town_position_url', 'value' => base_url ('admin', 'pub_method', 'update_town_position')))
         ->add_hidden (array ('id' => 'update_view_position_url', 'value' => base_url ('admin', 'pub_method', 'update_view_position')))

         ->_add_meta ()
         ->_add_css ()
         ->_add_js ()
         ;
  }

  protected function set_sides ($sides = array ()) {
    $this->sides = $sides;
    return $this;
  }
  protected function load_view ($data = array (), $return = false, $cache_time = 0) {
    return parent::load_view (array_merge (array ('frame_sides' => $this->sides), $data ? $data : array ()), $return, $cache_time);
  }
  private function _add_meta () {
    return $this;
  }

  private function _add_css () {
    return $this->add_css ('http://fonts.googleapis.com/css?family=Gafata', false)
                ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox.css'))
                ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.css'))
                ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.css'))
                ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'my.css'));
  }

  private function _add_js () {
    return $this->add_js (Cfg::setting ('google', 'client_js_url'), false)
                ->add_js (base_url ('resource', 'javascript', 'markerwithlabel_d2015_06_28', 'markerwithlabel.js'))
                ->add_js (base_url ('resource', 'javascript', 'jquery_v1.10.2', 'jquery-1.10.2.min.js'))
                ->add_js (base_url ('resource', 'javascript', 'imgLiquid_v0.9.944', 'imgLiquid-min.js'))
                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox.js'))
                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.js'))
                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.js'))
                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-media.js'));
  }
}

class Admin_index_controller extends Admin_controller {

  public function __construct () {
    parent::__construct ();

    $this->set_sides (array (
          '頁籤' => array (
              array ('name' => '列表', 'href' => base_url ('admin', 'index_tabs', 'index')),
              array ('name' => '新增', 'href' => base_url ('admin', 'index_tabs', 'add')),
            ),
          '評分' => array (
              array ('name' => '列表', 'href' => base_url ()),
              array ('name' => '新增', 'href' => base_url ()),
            ),
          'Banner' => array (
              array ('name' => '列表', 'href' => base_url ()),
              array ('name' => '新增', 'href' => base_url ()),
            ),
          '關鍵字' => array (
              array ('name' => '列表', 'href' => base_url ()),
              array ('name' => '新增', 'href' => base_url ()),
            ),
          '熱門回應' => array (
              array ('name' => '列表', 'href' => base_url ()),
              array ('name' => '新增', 'href' => base_url ()),
            ),
          '下方推薦' => array (
              array ('name' => '列表', 'href' => base_url ()),
              array ('name' => '新增', 'href' => base_url ()),
            )
          ));
  }
}
class Admin_town_controller extends Admin_controller {

  public function __construct () {
    parent::__construct ();

    $this->set_sides (array (
          '縣市' => array (
              array ('name' => '縣市列表', 'href' => base_url ('admin', 'towns', 'cate_index')),
              array ('name' => '新增縣市', 'href' => base_url ('admin', 'towns', 'cate_add')),
            ),
          '鄉鎮' => array (
              array ('name' => '鄉鎮列表', 'href' => base_url ('admin', 'towns', 'index')),
              array ('name' => '新增鄉鎮', 'href' => base_url ('admin', 'towns', 'add')),
            ))
          );
  }
}


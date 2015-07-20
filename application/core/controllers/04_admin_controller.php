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
         ->add_hidden (array ('id' => 'update_goal_position_url', 'value' => base_url ('admin', 'pub_method', 'update_goal_position')))
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
    return $this->add_css ('http://fonts.googleapis.com/css?family=Gafata', false);
  }

  private function _add_js () {
    return $this->add_js (Cfg::setting ('google', 'client_js_url'), false)
                ->add_js (base_url ('resource', 'javascript', 'markerwithlabel_d2015_06_28', 'markerwithlabel.js'))
                ->add_js (base_url ('resource', 'javascript', 'jquery_v1.10.2', 'jquery-1.10.2.min.js'))
                ->add_js (base_url ('resource', 'javascript', 'imgLiquid_v0.9.944', 'imgLiquid-min.js'))
                ;
  }
}
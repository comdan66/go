<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Main extends Site_controller {

  public function __construct () {
    parent::__construct ();
  }

  public function index () {
    $this->add_js (base_url ('resource', 'javascript', 'jquery_mobile_v1.3.0', 'swipe.js'))
         ->load_view (null);
  }
}

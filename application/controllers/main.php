<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Main extends Site_controller {

  public function __construct () {
    parent::__construct ();
  }

  public function test () {
    // http://maps.googleapis.com/maps/api/staticmap?center=25.050573970589,121.62981710733&zoom=11&size=170x170&markers=size:normal%7Ccolor:red%7C25.050573970589,121.62981710733
    download_web_file ('http://maps.googleapis.com/maps/api/staticmap?center=24.985809080589,121.48855784033&zoom=11&size=60x60&markers=size:mid|color:red|24.985809080589,121.48855784033&key=AIzaSyCdQh9XRRHqEXt4NoiwuKCkUoiA9JOF-8M', FCPATH . 'temp/a.png');
  }
  public function index () {
    $this->add_js (base_url ('resource', 'javascript', 'imgLiquid_v0.9.944', 'imgLiquid-min.js'))
         ->add_js (base_url ('resource', 'javascript', 'jquery-timeago_v1.3.1', 'jquery.timeago.js'))
         ->add_js (base_url ('resource', 'javascript', 'jquery-timeago_v1.3.1', 'locales', 'jquery.timeago.zh-TW.js'))
         ->load_view (null);
  }
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Index extends Admin_index_controller {

  public function __construct () {
    parent::__construct ();

  }

  public function index () {
    $this->load_view (null);
  }
}

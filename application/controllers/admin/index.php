<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Index extends Admin_controller {

  public function __construct () {
    parent::__construct ();

    $this->set_sides (array (
          '' => array (
              array ('name' => '編輯', 'href' => base_url ()),
              array ('name' => '編輯', 'href' => base_url ()),
              array ('name' => '編輯', 'href' => base_url ()),
            )
          ));
  }

  public function index () {
    $this->load_view (null);
  }
}

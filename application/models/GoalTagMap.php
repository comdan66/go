<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class GoalTagMap extends OaModel {

  static $table_name = 'goal_tag_maps';

  static $has_one = array (
  );

  static $has_many = array (
  );

  static $belongs_to = array (
    array ('goal', 'class_name' => 'Goal'),
    array ('tag', 'class_name' => 'GoalTag')
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
  public function destroy () {
    return $this->delete ();
  }
}
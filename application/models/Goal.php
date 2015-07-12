<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Goal extends OaModel {

  static $table_name = 'goals';

  static $has_one = array (
  );

  static $has_many = array (
    array ('tag_goal_maps', 'class_name' => 'GoalTagMap'),

    array ('tags', 'class_name' => 'GoalTag', 'through' => 'tag_goal_maps'),
    array ('comments', 'class_name' => 'GoalComment'),
    array ('pictures', 'class_name' => 'GoalPicture'),
    array ('scores', 'class_name' => 'GoalScore')
  );

  static $belongs_to = array (
    array ('user', 'class_name' => 'User')
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class GoalTagCategory extends OaModel {

  static $table_name = 'goal_tag_categories';

  static $has_one = array (
  );

  static $has_many = array (
    array ('tags', 'class_name' => 'GoalTag')
  );

  static $belongs_to = array (
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);

  }
  public function destroy () {
    GoalTag::update_all (array ('set' => 'goal_tag_category_id = 0', 'conditions' => array ('goal_tag_category_id = ?', $this->id)));

    return $this->delete ();
  }
  public static function detail_tags () {
    $return = array ();
    foreach (GoalTagCategory::all (array ('include' => array ('tags'))) as $category)
      if ($category->tags)
        $return = array_merge ($return, array ($category->name => $category->tags));

    return array_merge ($return, array ($return ? '未分類' : '' => GoalTag::all (array ('conditions' => array ('goal_tag_category_id = ?', 0)))));
  }
}
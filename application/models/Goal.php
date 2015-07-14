<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Goal extends OaModel {

  static $table_name = 'goals';

  static $has_one = array (
    array ('view', 'class_name' => 'GoalView')
  );

  static $has_many = array (
    array ('tag_goal_maps', 'class_name' => 'GoalTagMap'),

    array ('tags', 'class_name' => 'GoalTag', 'through' => 'tag_goal_maps'),
    array ('comments', 'class_name' => 'GoalComment'),
    array ('pictures', 'class_name' => 'GoalPicture'),
    array ('scores', 'class_name' => 'GoalScore'),
    array ('links', 'class_name' => 'GoalLink')
  );

  static $belongs_to = array (
    array ('user', 'class_name' => 'User')
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
  public function picture ($size = '60x60', $zoom = 11, $marker_size = '') {
    $marker_size = in_array ($marker_size, array ('normal', 'tiny', 'mid', 'small')) ? $marker_size : 'normal';
    return "http://maps.googleapis.com/maps/api/staticmap?center=" . $this->latitude . "," . $this->longitude . "&zoom=" . $zoom . "&size=" . $size . "&markers=size:" . $marker_size . "%7Ccolor:red%7C" . $this->latitude . "," . $this->longitude . "";
  }
  public function destroy () {
    GoalTagMap::delete_all (array ('conditions' => array ('goal_id = ?', $this->id)));
    GoalComment::delete_all (array ('conditions' => array ('goal_id = ?', $this->id)));
    GoalScore::delete_all (array ('conditions' => array ('goal_id = ?', $this->id)));
    GoalLink::delete_all (array ('conditions' => array ('goal_id = ?', $this->id)));

    foreach (GoalPicture::find ('all', array ('conditions' => array ('goal_id = ?', $this->id))) as $picture)
      $picture->destroy ();

    return $this->delete ();
  }
  public function score_star ($star_count = 5) {
    $score = $this->score * 20;

    $unit_score = 100 / $star_count;
    $count = floor ($score / $unit_score);
    $detail = ($score / $unit_score) - floor ($score / $unit_score);

    if ($detail < 0.25) { $detail = 0; }
    else if ($detail < 0.75) { $detail = 1; }
    else { $detail = 0; $count++; }

    $array = array (); for ($i = 0; $i < $star_count; $i++) array_push ($array, $count-- > 0 ? 2 : ($detail-- > 0 ? 1 : 0));

    return $array;
  }
}
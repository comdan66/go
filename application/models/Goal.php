<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Goal extends OaModel {
  
  static $table_name = 'goals';

  private $covers = null;

  static $has_one = array (
    array ('view', 'class_name' => 'GoalView'),
    array ('picture', 'class_name' => 'GoalPicture', 'order' => 'RAND()'),
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

    OrmImageUploader::bind ('pic', 'GoalPicImageUploader');
  }
  
  public function covers ($key = '') {
    return $this->covers === null ? $this->covers = array_filter (array_merge (array ($this->view ? $this->view->pic->url ($key) : null, $this->pic->url ($key)), array_map (function ($picture) use ($key) {
          return $picture->name->url ($key);
        }, $this->pictures))) : $this->covers;
  }
  public function cover ($key = '') {
    if ($this->pictures)
      return $this->picture->name->url ($key);
    else if ($this->view)
      return $this->view->pic->url ($key);
    else
      return $this->pic->url ($key);
  }

  public function put_pic () {
    return $this->pic->put_url ($this->picture ('300x300', 'server_key'));
  }
  public function picture ($size = '60x60', $type = 'client_key', $zoom = 13, $marker_size = 'normal') {
    $marker_size = in_array ($marker_size, array ('normal', 'tiny', 'mid', 'small')) ? $marker_size : 'normal';
    return "http://maps.googleapis.com/maps/api/staticmap?center=" . $this->latitude . "," . $this->longitude . "&zoom=" . $zoom . "&size=" . $size . "&markers=size:" . $marker_size . "|color:red|" . $this->latitude . "," . $this->longitude . "&key=" . Cfg::setting ('google', ENVIRONMENT, $type);
  }

  public function destroy () {
    GoalTagMap::delete_all (array ('conditions' => array ('goal_id = ?', $this->id)));
    GoalComment::delete_all (array ('conditions' => array ('goal_id = ?', $this->id)));
    GoalScore::delete_all (array ('conditions' => array ('goal_id = ?', $this->id)));
    GoalLink::delete_all (array ('conditions' => array ('goal_id = ?', $this->id)));

    foreach (GoalPicture::find ('all', array ('conditions' => array ('goal_id = ?', $this->id))) as $picture)
      $picture->destroy ();

    return $this->pic->cleanAllFiles () && $this->delete ();
  }
  public function add_score ($user_id, $value) {
    if ($value && verifyCreateOrm (GoalScore::create (array ('user_id' => $user_id, 'goal_id' => $this->id, 'value' => $value)))) {
      if ($score = GoalScore::find ('one', array ('select' => 'SUM(value) AS sum, COUNT(id) as count', 'conditions' => array ('goal_id = ?', $this->id)))) {
        $this->score = round ($score->sum / $score->count, 2);
        return $this->save ();
      }
    }
    return false;
  }

  public function score_star ($star_count = 5) {
    $score = $this->score;

    $unit_score = 100 / $star_count;
    $count = floor ($score / $unit_score);
    $detail = ($score / $unit_score) - floor ($score / $unit_score);
    $detail = $detail >= 0.25 ? $detail >= 0.75 ? $count++ ? 0 : 0 : 1 : 0;

    $array = array ();

    for ($i = 0; $i < $star_count; $i++)
      array_push ($array, $count-- > 0 ? 2 : ($detail-- > 0 ? 1 : 0));

    return $array;
  }
  
  public function star_details ($star_count = 5) {
    $count = GoalScore::count (array ('conditions' => array ('goal_id = ?', $this->id)));
    $unit_score = floor (100 / $star_count);
    $scores = GoalScore::find ('all', array ('select' => 'COUNT(*) AS count, CEIL(value / ' . $unit_score . ') AS star', 'order' => 'value DESC', 'group' => 'CEIL(value / ' . $unit_score . ')', 'conditions' => array ('goal_id = ?', $this->id)));

    $return = array ();

    foreach ($scores as $score)
      $return[$score->star] = array (
          'count' => $score->count,
          'percent' => $score->count / $count
        );

    foreach (range (1, $star_count) as $key)
      if (!isset ($return[$key]))
        $return[$key] = array (
          'count' => 0,
          'percent' => 0
        );

    krsort ($return);
    unset ($return[0]);
    return array ('details' => $return, 'count' => $count);
  }
}
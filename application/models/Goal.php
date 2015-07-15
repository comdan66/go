<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Goal extends OaModel {

  static $table_name = 'goals';

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
    array ('links', 'class_name' => 'GoalLink'),
    array ('star_details', 'select' => 'COUNT(*) AS count, value', 'class_name' => 'GoalScore', 'order' => 'value DESC', 'group' => 'value')
  );

  static $belongs_to = array (
    array ('user', 'class_name' => 'User')
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);

    OrmImageUploader::bind ('pic', 'GoalPicImageUploader');
  }
  public function cover () {
    if ($this->pictures)
      return $this->picture->name->url ();
    else if ($this->view)
      return $this->view->picture ('170x170');
    else
      return $this->picture ('170x170');
  }

  public function get_static () {
    return $this->pic->put_url ($this->picture ('1024x1024', 'server_key'));
  }
  public function picture ($size = '60x60', $type = 'client_key', $zoom = 12, $marker_size = 'normal') {
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
    if (verifyCreateOrm (GoalScore::create (array ('user_id' => $user_id, 'goal_id' => $this->id, 'value' => $value)))) {
      if ($score = GoalScore::find ('one', array ('select' => 'SUM(value) AS sum, COUNT(id) as count', 'conditions' => array ('goal_id = ?', $this->id)))) {
        $this->score = round ($score->sum / $score->count, 2);
        $this->save ();
      }
    }
  }

  public function score_star ($star_count = 5) {
    $score = $this->score;

    $unit_score = 100 / $star_count;
    $count = floor ($score / $unit_score);
    $detail = ($score / $unit_score) - floor ($score / $unit_score);

    if ($detail < 0.25) { $detail = 0; }
    else if ($detail < 0.75) { $detail = 1; }
    else { $detail = 0; $count++; }

    $array = array ();

    for ($i = 0; $i < $star_count; $i++)
      array_push ($array, $count-- > 0 ? 2 : ($detail-- > 0 ? 1 : 0));

    return $array;
  }
  
  // public function star_details () {
  //   $max = 0;
  //   $array = array (5, 4, 3, 2, 1);
  //   $unit_scores = $this->star_details;

  //   $unit_scores = array_map (function ($unit_score) use (&$max, &$array) { $max = $unit_score->count > $max ? $unit_score->count : $max; if ($array && (($key = array_search ($unit_score->value, $array))) !== false) unset ($array[$key]); return array ('score' => $unit_score->value, 'count' => $unit_score->count); }, $unit_scores);
  //   $unit_scores = array_map (function ($unit_score) use ($max) { return array ('score' => $unit_score['score'], 'count' => $unit_score['count'], 'percent' => $unit_score['count'] / $max); }, $unit_scores);
  //   $unit_scores = array_merge ($unit_scores, array_map (function ($item) { return array ('score' => $item, 'count' => 0, 'percent' => 0); }, $array));

  //   usort ($unit_scores, function ($a, $b) { return $a['score'] < $b['score']; });
  //   return $unit_scores;
  // }
}
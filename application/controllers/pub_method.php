<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Pub_method extends Site_controller {

  public function __construct () {
    parent::__construct ();
  }

  public function get_goals () {
    if (!$this->is_ajax (false))
      return show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    $north_east = $this->input_post ('NorthEast');
    $south_west = $this->input_post ('SouthWest');
    $goal_id = ($goal_id = $this->input_post ('goal_id')) ? $goal_id : 0;

    if (!(isset ($north_east['latitude']) && isset ($south_west['latitude']) && isset ($north_east['longitude']) && isset ($south_west['longitude'])))
      return $this->output_json (array ('status' => true, 'goals' => array ()));

    $goals = array_map (function ($goal) {
      return array (
          'id' => $goal->id,
          'lat' => $goal->latitude,
          'lng' => $goal->longitude,
          'title' => $goal->title,
        );
    }, Goal::find ('all', array ('conditions' => array ('id != ? AND (latitude BETWEEN ? AND ?) AND (longitude BETWEEN ? AND ?)', $goal_id, $south_west['latitude'], $north_east['latitude'], $south_west['longitude'], $north_east['longitude']))));

    return $this->output_json (array ('status' => true, 'goals' => $goals));
  }
}

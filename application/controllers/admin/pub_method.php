<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Pub_method extends Admin_controller {

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
    }, Goal::find ('all', array ('conditions' => array ('latitude < ? AND latitude > ? AND longitude < ? AND longitude > ? AND id != ?', $north_east['latitude'], $south_west['latitude'], $north_east['longitude'], $south_west['longitude'], $goal_id))));

    return $this->output_json (array ('status' => true, 'goals' => $goals));
  }
  public function map ($id = 0) {
    if (!($goal = Goal::find ('one', array ('conditions' => array ('id = ?', $id)))))
      return redirect (array ('admin', 'goals'));

    $this->add_js ('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=zh-TW', false)
         ->add_js (base_url ('resource', 'javascript', 'markerwithlabel_d2015_06_28', 'markerwithlabel.js'))
         ->add_hidden (array ('id' => 'update_goal_position_url', 'value' => base_url ('admin', 'pub_method', 'update_goal_position')))
         ->load_view (array (
            'goal' => $goal
          ));
  }
  public function update_goal_position ($id = 0) {
    if (!$this->is_ajax (false))
      return show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    $id = $this->input_post ('id');
    $lat = $this->input_post ('lat');
    $lng = $this->input_post ('lng');
    $address = $this->input_post ('addr');

    if (!($id && $lat && $lng && ($goal = Goal::find_by_id ($id))))
      return $this->output_json (array ('status' => false));

    $goal->latitude = $lat;
    $goal->longitude = $lng;
    
    if ($address)
      $goal->address = $address;

    if (!$goal->save ())
      return $this->output_json (array ('status' => false));

    return $this->output_json (array ('status' => true));
  }
}

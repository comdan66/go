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
  public function view ($id = 0) {
    if (!($goal = Goal::find ('one', array ('conditions' => array ('id = ?', $id)))))
      return show_404();

    $this->add_js (Cfg::setting ('google', 'client_js_url'), false)
         ->add_js (base_url ('resource', 'javascript', 'markerwithlabel_d2015_06_28', 'markerwithlabel.js'))
         ->load_view (array (
            'goal' => $goal
          ));
  }
  public function goal ($id = 0) {
    if (!($goal = Goal::find ('one', array ('conditions' => array ('id = ?', $id)))))
      return show_404();

    $this->add_js (Cfg::setting ('google', 'client_js_url'), false)
         ->add_js (base_url ('resource', 'javascript', 'markerwithlabel_d2015_06_28', 'markerwithlabel.js'))
         ->load_view (array (
            'goal' => $goal
          ));
  }
  public function update_view_position ($id = 0) {
    if (!$this->is_ajax (false))
      return show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    $id = trim ($this->input_post ('id'));
    $lat = trim ($this->input_post ('lat'));
    $lng = trim ($this->input_post ('lng'));
    $heading = trim ($this->input_post ('heading'));
    $pitch = trim ($this->input_post ('pitch'));
    $zoom = trim ($this->input_post ('zoom'));

    if (!($id && $lat && $lng && is_numeric ($heading) && is_numeric ($pitch) && is_numeric ($zoom) && ($goal = Goal::find_by_id ($id))))
      return $this->output_json (array ('status' => false));


    if ($goal->view) {
    
      if (($goal->view->latitude == $lat) && ($goal->view->longitude == $lng) && ($goal->view->heading == $heading) && ($goal->view->pitch == $pitch) && ($goal->view->zoom == $zoom))
        $is_update_pic = false;
      else
        $is_update_pic = true;

      $goal->view->latitude = $lat;
      $goal->view->longitude = $lng;
      $goal->view->heading = $heading;
      $goal->view->pitch = $pitch;
      $goal->view->zoom = $zoom;

      if (!$goal->view->save ())
        return $this->output_json (array ('status' => false));

      if($is_update_pic)
        $goal->view->put_pic ();

    } else {
      $params = array (
          'goal_id' => $goal->id,
          'latitude' => $lat,
          'longitude' => $lng,
          'heading' => $heading,
          'pitch' => $pitch,
          'zoom' => $zoom,
        );
      if (!verifyCreateOrm ($view = GoalView::create ($params)))
        return $this->output_json (array ('status' => false));

      if (!$view->put_pic () && ($view->destroy () || true))
        return $this->output_json (array ('status' => false));
    }
    return $this->output_json (array ('status' => true));
  }
  public function update_goal_position ($id = 0) {
    if (!$this->is_ajax (false))
      return show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    $id = trim ($this->input_post ('id'));
    $lat = trim ($this->input_post ('lat'));
    $lng = trim ($this->input_post ('lng'));
    $address = trim ($this->input_post ('addr'));

    if (!($id && $lat && $lng && ($goal = Goal::find_by_id ($id))))
      return $this->output_json (array ('status' => false));
    
    if (($goal->latitude == $lat) && ($goal->longitude == $lng))
      $is_update_pic = false;
    else
      $is_update_pic = true;

    $goal->latitude = $lat;
    $goal->longitude = $lng;
    
    if ($address)
      $goal->address = $address;

    if (!$goal->save ())
      return $this->output_json (array ('status' => false));

    if ($is_update_pic)
      $goal->put_pic ();

    return $this->output_json (array ('status' => true));
  }
}

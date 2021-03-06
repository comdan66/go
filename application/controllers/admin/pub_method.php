<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Pub_method extends Admin_controller {

  public function __construct () {
    parent::__construct ();
  }

  public function town ($id = 0) {
    if (!($town = Town::find ('one', array ('conditions' => array ('id = ?', $id)))))
      return show_404();

    if ($town->bound)
      $this->add_hidden (array ('id' => 'bound', 'data-northeast_latitude' => $town->bound->northeast_latitude, 'data-northeast_longitude' => $town->bound->northeast_longitude, 'data-southwest_latitude' => $town->bound->southwest_latitude, 'data-southwest_longitude' => $town->bound->southwest_longitude, 'value' => $town->bound->id));

    $this->add_hidden (array ('id' => 'marker', 'data-lat' => $town->latitude, 'data-lng' => $town->longitude, 'value' => $town->id))
         ->load_view (array (
            'town' => $town
          ));
  }
  public function get_towns () {
    if (!$this->is_ajax (false))
      return show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    
    $is_use_bound = false;

    $north_east = $this->input_post ('NorthEast');
    $south_west = $this->input_post ('SouthWest');
    $town_id = ($town_id = $this->input_post ('town_id')) ? $town_id : 0;

    if (!(isset ($north_east['latitude']) && isset ($south_west['latitude']) && isset ($north_east['longitude']) && isset ($south_west['longitude'])))
      return $this->output_json (array ('status' => true, 'towns' => array ()));

    $towns = array_map (function ($town) use ($is_use_bound) {
      return array (
          'id' => $town->id,
          'lat' => $town->latitude,
          'lng' => $town->longitude,
          'name' => $town->name,
          'bound' => $is_use_bound && $town->bound ? array (
              'northeast' => array (
                'lat' => $town->bound->northeast_latitude,
                'lng' => $town->bound->northeast_longitude,
                ),
              'southwest' => array (
                'lat' => $town->bound->southwest_latitude,
                'lng' => $town->bound->southwest_longitude,
                )
            ) : null
        );
    }, Town::find ('all', array ('conditions' => array ('id != ? AND (latitude BETWEEN ? AND ?) AND (longitude BETWEEN ? AND ?)', $town_id, $south_west['latitude'], $north_east['latitude'], $south_west['longitude'], $north_east['longitude']))));

    return $this->output_json (array ('status' => true, 'towns' => $towns));
  }
  public function update_town_position ($id = 0) {
    if (!$this->is_ajax (false))
      return show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    $id = trim ($this->input_post ('id'));
    $lat = trim ($this->input_post ('lat'));
    $lng = trim ($this->input_post ('lng'));
    $name = trim ($this->input_post ('name'));
    $postal_code = trim ($this->input_post ('postal_code'));

    if (!($id && $lat && $lng && ($town = Town::find_by_id ($id))))
      return $this->output_json (array ('status' => false));
    
    if (Town::find ('one', array ('select' => 'id', 'conditions' => array ('id != ? AND postal_code = ?', $town->id, $postal_code))))
      return $this->output_json (array ('status' => false));

    if (($town->latitude == $lat) && ($town->longitude == $lng))
      $is_update_pic = false;
    else
      $is_update_pic = true;

    $town->latitude = $lat;
    $town->longitude = $lng;
    
    if ($name)
      $town->name = $name;

    if ($postal_code)
      $town->postal_code = $postal_code;

    if (!$town->save ())
      return $this->output_json (array ('status' => false));

    if ($is_update_pic)
      $town->put_pic ();

    return $this->output_json (array ('status' => true));
  }

  public function goal ($id = 0) {
    if (!($goal = Goal::find ('one', array ('conditions' => array ('id = ?', $id)))))
      return show_404();

    $this->load_view (array (
            'goal' => $goal
          ));
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

  public function view ($id = 0) {
    if (!($goal = Goal::find ('one', array ('conditions' => array ('id = ?', $id)))))
      return show_404();

    $this->load_view (array (
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
}

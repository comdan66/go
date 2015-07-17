<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Goals extends Site_controller {

  public function __construct () {
    parent::__construct ();
  }

  public function index ($id = 0) {
    if (!($goal = Goal::find_by_id ($id)))
      return redirect ();

    if ($goal->view)
      $this->add_hidden (array ('id' => 'panorama', 'value' => $goal->view->id, 'data-lat' => $goal->view->latitude, 'data-lng' => $goal->view->longitude, 'data-heading' => $goal->view->heading, 'data-pitch' => $goal->view->pitch, 'data-zoom' => $goal->view->zoom));
         
    $this->add_hidden (array ('id' => 'marker', 'value' => $goal->id, 'data-lat' => $goal->latitude, 'data-lng' => $goal->longitude))
         ->load_view (array (
        'goal' => $goal
      ));
  }
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Goals extends Site_controller {

  public function __construct () {
    parent::__construct ();
  }

  public function load_maylike ($id = 0) {
    if (!$this->is_ajax (false))
      return show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    $limit = 6;
    $id = $this->input_post ('id');
    $next_id = $this->input_post ('next_id');

    $conditions = $next_id ? array ('id <= ? AND id != ?', $next_id, $id) : array ('id != ?', $id);
    $maylikes = Goal::find ('all', array ('order' => 'created_at DESC, id DESC', 'limit' => $limit + 1, 'conditions' => $conditions));

    $next_id = ($next_id = ($next_id = array_slice ($maylikes, $limit, 1)) ? $next_id[0] : null) ? $next_id->id : -1;

    $that = $this;
    $maylikes = array_map (function ($goal) use ($that) {
      return $that->set_method ('maylike')->load_content (array ('goal' => $goal), true);
    }, array_slice ($maylikes, 0, $limit));

    return $this->output_json (array ('status' => true, 'maylikes' => $maylikes, 'next_id' => $next_id));
  }
  public function index ($id = 0) {
    if (!($goal = Goal::find_by_id ($id)))
      return redirect ();

    if ($goal->view)
      $this->add_hidden (array ('id' => 'panorama', 'value' => $goal->view->id, 'data-lat' => $goal->view->latitude, 'data-lng' => $goal->view->longitude, 'data-heading' => $goal->view->heading, 'data-pitch' => $goal->view->pitch, 'data-zoom' => $goal->view->zoom));
         
    $this->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'my.css'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-media.js'))
         ->add_hidden (array ('id' => 'marker', 'value' => $goal->id, 'data-lat' => $goal->latitude, 'data-lng' => $goal->longitude))
         ->add_hidden (array ('id' => 'load_maylike_url', 'value' => base_url ($this->get_class (), 'load_maylike')))
         ->load_view (array (
        'goal' => $goal
      ));
  }
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Search extends Site_controller {

  public function __construct () {
    parent::__construct ();
  }

  public function load_goals ($key = '') {
    if (!$this->is_ajax (false))
      return show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    $limit = 5;
    $next_id = $this->input_post ('next_id');

    $conditions = $next_id ? array ('id <= ?', $next_id) : array ();
    $goals = Goal::find ('all', array ('order' => 'id DESC', 'limit' => $limit + 1, 'include' => array ('user'), 'conditions' => $conditions));

    $next_id = ($next_id = ($next_id = array_slice ($goals, $limit, 1)) ? $next_id[0] : null) ? $next_id->id : -1;

    $that = $this;
    $goals = array_map (function ($goal) use ($that) {
      return $that->set_method ('goal')->load_content (array ('goal' => $goal), true);
    }, array_slice ($goals, 0, $limit));

    return $this->output_json (array ('status' => true, 'goals' => $goals, 'next_id' => $next_id));
  }
  public function index ($key = '') {
    // $tag_ids = array_map (function ($tag) {return $tag->name; }, GoalTag::find ('all', array ('select' => 'id', 'conditions' => array ('name LIKE CONCAT("%", ? ,"%")', $key))));
    // Goal::find ()
    $this->add_hidden (array ('id' => 'search_key', 'value' => $key))
         ->add_hidden (array ('id' => 'load_goals_url', 'value' => base_url ($this->get_class (), 'load_goals')))
         ->add_js (base_url ('resource', 'javascript', 'masonry_v3.1.2', 'masonry.pkgd.min.js'))
         ->add_js (base_url ('resource', 'javascript', 'imagesloaded_v3.1.8', 'imagesloaded.pkgd.min.js'))
         ->load_view (null);
  }
}

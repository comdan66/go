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

    $key = trim ($this->input_post ('key'));
    $colors = array_filter (($colors = $this->input_post ('colors')) && is_array ($colors) && (count ($colors) === 3) && ($colors = array_map ('trim', $colors)) ? $colors : array (), function ($t) { return is_numeric ($t); });

    if (!($key || $colors))
      return $this->output_json (array ('status' => true, 'goals' => array (), 'next_id' => -1));

    $limit = 5;
    $next_id = trim ($this->input_post ('next_id'));

    if ($colors) {
      $colors = array_map (function ($color) {
        return array (
            ($min = $color - 30) < 0 ? 0 : $min,
            ($max = $color + 30) > 255 ? 255 : $max
          );
      }, $colors);

      $conditions = $next_id ? array ('(color_red between ? AND ?) AND (color_green between ? AND ?) AND (color_blue between ? AND ?) AND (id <= ?)', $colors[0][0], $colors[0][1], $colors[1][0], $colors[1][1], $colors[2][0], $colors[2][1], $next_id) : array ('(color_red between ? AND ?) AND (color_green between ? AND ?) AND (color_blue between ? AND ?)', $colors[0][0], $colors[0][1], $colors[1][0], $colors[1][1], $colors[2][0], $colors[2][1]);
      
      $pictures = GoalPicture::find ('all', array ('include' => array ('goal'), 'order' => 'goal_id DESC', 'group' => 'goal_id', 'conditions' => $conditions));
      
      $users = array ();
      if ($user_ids = column_array (column_array ($pictures, 'goal'), 'user_id'))
        foreach (User::find ('all', array ('conditions' => array ('id IN (?)', $user_ids))) as $user)
          $users[$user->id] = $user;

      $next_id = ($next_id = ($next_id = array_slice ($pictures, $limit, 1)) ? $next_id[0] : null) ? $next_id->id : -1;
      
      $that = $this;
      $goals = array_map (function ($picture) use ($that, $users) {
        return $that->set_method ('goal')->load_content (array ('goal' => $picture->goal, 'users' => $users, 'picture' => $picture), true);
      }, array_slice ($pictures, 0, $limit));
      return $this->output_json (array ('status' => true, 'goals' => $goals, 'next_id' => $next_id));
    }

    if ($tag_ids = array_map (function ($tag) {return $tag->id; }, GoalTag::find ('all', array ('select' => 'id', 'conditions' => array ('name LIKE CONCAT("%", ? ,"%")', $key))))) {
      $conditions = $next_id ? array ('goal_tag_id IN (?) AND (id <= ?)', $tag_ids,  $next_id) : array ('goal_tag_id IN (?)', $tag_ids);
      $maps = GoalTagMap::find ('all', array ('select' => 'id, goal_id', 'order' => 'goal_id DESC', 'group' => 'goal_id', 'conditions' => $conditions));
      $next_id = ($next_id = ($next_id = array_slice ($maps, $limit, 1)) ? $next_id[0] : null) ? $next_id->id : -1;

      $goals = ($ids = column_array ($maps, 'goal_id')) ? Goal::find ('all', array ('include' => array ('user', 'picture', 'view'), 'order' => 'id DESC', 'conditions' => array ('id IN (?)', $ids))) : array ();

      $that = $this;
      $goals = array_map (function ($goal) use ($that) {
        return $that->set_method ('goal')->load_content (array ('goal' => $goal), true);
      }, array_slice ($goals, 0, $limit));        
      return $this->output_json (array ('status' => true, 'goals' => $goals, 'next_id' => $next_id));
    }

    $conditions = $next_id ? array ('title LIKE CONCAT("%", ? ,"%") AND (id <= ?)', $key,  $next_id) : array ('title LIKE CONCAT("%", ? ,"%")', $key);
    $goals = Goal::find ('all', array ('include' => array ('user', 'picture', 'view'), 'order' => 'id DESC', 'limit' => $limit + 1, 'conditions' => $conditions));
    $next_id = ($next_id = ($next_id = array_slice ($goals, $limit, 1)) ? $next_id[0] : null) ? $next_id->id : -1;

    $that = $this;
    $goals = array_map (function ($goal) use ($that) {
      return $that->set_method ('goal')->load_content (array ('goal' => $goal), true);
    }, array_slice ($goals, 0, $limit));        
    return $this->output_json (array ('status' => true, 'goals' => $goals, 'next_id' => $next_id));
  }
  public function index ($key1 = '', $key2 = '', $key3 = '') {
    // $tag_ids = array_map (function ($tag) {return $tag->name; }, GoalTag::find ('all', array ('select' => 'id', 'conditions' => array ('name LIKE CONCAT("%", ? ,"%")', $key))));
    // Goal::find ()

    $q = trim ($this->input_get ('q'));
    $rgb = array_filter (($rgb = $this->input_get ('rgb')) && is_array ($rgb) && (count ($rgb) === 3) && ($rgb = array_map ('trim', $rgb)) ? $rgb : array (), function ($t) { return is_numeric ($t); });

    if ($rgb) $this->add_hidden (array ('id' => 'search_color', 'value' => 'rgb(' . implode (', ', $rgb) . ')'));

    $this->add_hidden (array ('id' => 'search_key', 'value' => $q))
         ->add_hidden (array ('id' => 'load_goals_url', 'value' => base_url ($this->get_class (), 'load_goals')))
         ->add_js (base_url ('resource', 'javascript', 'masonry_v3.1.2', 'masonry.pkgd.min.js'))
         ->add_js (base_url ('resource', 'javascript', 'imagesloaded_v3.1.8', 'imagesloaded.pkgd.min.js'))
         ->load_view (null);
  }
}

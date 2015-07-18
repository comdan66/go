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
    $maylikes = Goal::find ('all', array ('order' => 'id DESC', 'limit' => $limit + 1, 'conditions' => $conditions));

    $next_id = ($next_id = ($next_id = array_slice ($maylikes, $limit, 1)) ? $next_id[0] : null) ? $next_id->id : -1;

    $that = $this;
    $maylikes = array_map (function ($goal) use ($that) {
      return $that->set_method ('maylike')->load_content (array ('goal' => $goal), true);
    }, array_slice ($maylikes, 0, $limit));

    return $this->output_json (array ('status' => true, 'maylikes' => $maylikes, 'next_id' => $next_id));
  }
  public function post_comment () {
    if (!$this->is_ajax (false))
      return show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    if (!identity ()->user ())
      return $this->output_json (array ('status' => false, 'message' => '尚未登入！'));

    $id = trim ($this->input_post ('id'));
    $content = trim ($this->input_post ('content'));

    if (!($id && $content && ($goal = Goal::find ('one', array ('select' => 'id', 'conditions' => array ('id = ?' , $id))))))
      return $this->output_json (array ('status' => false, 'message' => '填寫資訊有少！'));

    $params = array (
        'user_id' => identity ()->user ()->id,
        'goal_id' => $goal->id,
        'content' => $content
      );

    if (!verifyCreateOrm ($comment = GoalComment::create ($params)))
      return $this->output_json (array ('status' => false, 'message' => '新增失敗！'));

    return $this->output_json (array ('status' => true, 'comment' => $this->set_method ('comment')->load_content (array ('comment' => $comment), true), 'next_id' => $comment->id - 1));
  }
  public function load_comment ($id = 0) {
    if (!$this->is_ajax (false))
      return show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    $limit = 3;
    $id = $this->input_post ('id');
    $next_id = $this->input_post ('next_id');

    $conditions = $next_id ? array ('id <= ? AND goal_id = ?', $next_id, $id) : array ('goal_id = ?', $id);
    $comments = GoalComment::find ('all', array ('order' => 'id DESC', 'limit' => $limit + 1, 'conditions' => $conditions));

    $next_id = ($next_id = ($next_id = array_slice ($comments, $limit, 1)) ? $next_id[0] : null) ? $next_id->id : -1;

    $that = $this;
    $comments = array_map (function ($comment) use ($that) {
      return $that->set_method ('comment')->load_content (array ('comment' => $comment), true);
    }, array_slice ($comments, 0, $limit));

    return $this->output_json (array ('status' => true, 'comments' => $comments, 'next_id' => $next_id));
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
         ->add_js (base_url ('resource', 'javascript', 'autosize_v3.0.8', 'autosize.min.js'))
         ->add_hidden (array ('id' => 'marker', 'value' => $goal->id, 'data-lat' => $goal->latitude, 'data-lng' => $goal->longitude))
         ->add_hidden (array ('id' => 'load_maylike_url', 'value' => base_url ($this->get_class (), 'load_maylike')))
         ->add_hidden (array ('id' => 'post_comment_url', 'value' => base_url ($this->get_class (), 'post_comment')))
         ->add_hidden (array ('id' => 'load_comment_url', 'value' => base_url ($this->get_class (), 'load_comment')))
         ->load_view (array (
        'goal' => $goal
      ));
  }
}

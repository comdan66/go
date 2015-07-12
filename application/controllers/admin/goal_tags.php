<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Goal_tags extends Admin_controller {

  public function __construct () {
    parent::__construct ();
  }

  public function destroy ($id = 0) {
    if (!($goal_tag = GoalTag::find_by_id ($id)))
      return redirect (array ('admin', 'goal_tags'));

    $message = $goal_tag->destroy () ? '刪除成功！' : '刪除失敗！';

    return identity ()->set_session ('_flash_message', $message, true)
                    && redirect (array ('admin', 'goal_tags'), 'refresh');
  }

  public function edit ($id = 0) {
    if (!($goal_tag = GoalTag::find_by_id ($id)))
      return redirect (array ('admin', 'goal_tags'));

    $message  = identity ()->get_session ('_flash_message', true);
    $name = identity ()->get_session ('name', true);

    $this->load_view (array (
        'goal_tag' => $goal_tag,
        'message' => $message,
        'name' => $name
      ));
  }

  public function update ($id = 0) {
    if (!($goal_tag = GoalTag::find_by_id ($id)))
      return redirect (array ('admin', 'goal_tags'));

    if (!$this->has_post ())
      return redirect (array ('admin', 'goal_tags', 'edit', $goal_tag->id));

    $name = trim ($this->input_post ('name'));

    if (!$name)
      return identity ()->set_session ('_flash_message', '填寫資訊有少！', true)
                        ->set_session ('name', $name, true)
                        && redirect (array ('admin', 'goal_tags', 'edit', $goal_tag->id), 'refresh');

    $goal_tag->name = $name;

    if (!$goal_tag->save ())
      return identity ()->set_session ('_flash_message', '修改失敗！', true)
                        ->set_session ('name', $name, true)
                        && redirect (array ('admin', 'goal_tags', 'edit', $goal_tag->id), 'refresh');

    return identity ()->set_session ('_flash_message', '修改成功！', true)
                      && redirect (array ('admin', 'goal_tags'), 'refresh');
  }

  public function add () {
    $message  = identity ()->get_session ('_flash_message', true);
    
    $name = identity ()->get_session ('name', true);

    $this->load_view (array (
        'message' => $message,
        'name' => $name
      ));
  }

  public function create () {
    if (!$this->has_post ())
      return redirect (array ('admin', 'goal_tags', 'add'));

    $name = trim ($this->input_post ('name'));

    if (!$name)
      return identity ()->set_session ('_flash_message', '填寫資訊有少！', true)
                        ->set_session ('name', $name, true)
                        && redirect (array ('admin', 'goal_tags', 'add'), 'refresh');

    $params = array (
        'name' => $name
      );

    if (!verifyCreateOrm ($goal_tag = GoalTag::create ($params)))
      return identity ()->set_session ('_flash_message', '新增失敗！', true)
                        ->set_session ('name', $name, true)
                        && redirect (array ('admin', 'goal_tags', 'add'), 'refresh');

    return identity ()->set_session ('_flash_message', '新增成功！', true)
                      && redirect (array ('admin', 'goal_tags'), 'refresh');
  }

  public function index ($offset = 0) {
    $columns = array ('id' => 'int', 'name' => 'string');
    $configs = array ('admin', 'goal_tags', '%s');

    $conditions = conditions (
                    $columns,
                    $configs,
                    'GoalTag',
                    $this->input_gets ()
                  );

    $conditions = array (implode (' AND ', $conditions));

    $limit = 25;
    $total = GoalTag::count (array ('conditions' => $conditions));
    $offset = $offset < $total ? $offset : 0;

    $this->load->library ('pagination');
    $configs = array_merge (array ('total_rows' => $total, 'num_links' => 5, 'per_page' => $limit, 'uri_segment' => 0, 'base_url' => '', 'page_query_string' => false, 'first_link' => '第一頁', 'last_link' => '最後頁', 'prev_link' => '上一頁', 'next_link' => '下一頁', 'full_tag_open' => '<ul class="pagination">', 'full_tag_close' => '</ul>', 'first_tag_open' => '<li>', 'first_tag_close' => '</li>', 'prev_tag_open' => '<li>', 'prev_tag_close' => '</li>', 'num_tag_open' => '<li>', 'num_tag_close' => '</li>', 'cur_tag_open' => '<li class="active"><a href="#">', 'cur_tag_close' => '</a></li>', 'next_tag_open' => '<li>', 'next_tag_close' => '</li>', 'last_tag_open' => '<li>', 'last_tag_close' => '</li>'), $configs);
    $this->pagination->initialize ($configs);
    $pagination = $this->pagination->create_links ();

    $goal_tags = GoalTag::find ('all', array ('offset' => $offset, 'limit' => $limit, 'order' => 'id DESC', 'conditions' => $conditions));

    $message = identity ()->get_session ('_flash_message', true);

    $this->load_view (array (
        'message' => $message,
        'pagination' => $pagination,
        'goal_tags' => $goal_tags,
        'columns' => $columns
      ));
  }
}

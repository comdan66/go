<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Goal_tags extends Admin_controller {

  public function __construct () {
    parent::__construct ();

    $this->set_sides (array (
          '標簽分類' => array (
              array ('name' => '列表', 'href' => base_url ('admin', 'goal_tags', 'cate_index')),
              array ('name' => '新增', 'href' => base_url ('admin', 'goal_tags', 'cate_add')),
            ),
          '標簽' => array (
              array ('name' => '列表', 'href' => base_url ('admin', 'goal_tags', 'index')),
              array ('name' => '新增', 'href' => base_url ('admin', 'goal_tags', 'add')),
            )
          ));
  }
  public function cate_destroy ($id = 0) {
    if (!($goal_tag_category = GoalTagCategory::find_by_id ($id)))
      return redirect (array ('admin', 'goal_tags', 'cate_index'));

    $message = $goal_tag_category->destroy () ? '刪除成功！' : '刪除失敗！';

    return identity ()->set_session ('_flash_message', $message, true)
                    && redirect (array ('admin', 'goal_tags', 'cate_index'), 'refresh');
  }
  public function cate_edit ($id = 0) {
    if (!($goal_tag_category = GoalTagCategory::find_by_id ($id)))
      return redirect (array ('admin', 'goal_tags', 'cate_index'));

    $message  = identity ()->get_session ('_flash_message', true);
    $name = identity ()->get_session ('name', true);
    $tag_ids = identity ()->get_session ('tag_ids', true);

    $this->load_view (array (
        'goal_tag_category' => $goal_tag_category,
        'message' => $message,
        'name' => $name,
        'tag_ids' => $tag_ids
      ));
  }

  public function cate_update ($id = 0) {
    if (!($goal_tag_category = GoalTagCategory::find_by_id ($id)))
      return redirect (array ('admin', 'goal_tags', 'cate_index'));

    if (!$this->has_post ())
      return redirect (array ('admin', 'goal_tags', 'cate_edit', $goal_tag_category->id));

    $name = trim ($this->input_post ('name'));
    $tag_ids = ($tag_ids = $this->input_post ('tag_ids')) ? $tag_ids : array ();

    if (!$name)
      return identity ()->set_session ('_flash_message', '填寫資訊有少！', true)
                        ->set_session ('name', $name, true)
                        ->set_session ('tag_ids', $tag_ids, true)
                        && redirect (array ('admin', 'goal_tags', 'cate_edit', $goal_tag_category->id), 'refresh');

    if (($cate = GoalTagCategory::find_by_name ($name)) && ($cate->id != $goal_tag_category->id))
      return identity ()->set_session ('_flash_message', '名稱不能重複！', true)
                        ->set_session ('name', $name, true)
                        ->set_session ('tag_ids', $tag_ids, true)
                        && redirect (array ('admin', 'goal_tags', 'cate_edit', $goal_tag_category->id), 'refresh');

    $goal_tag_category->name = $name;

    if (!$goal_tag_category->save ())
      return identity ()->set_session ('_flash_message', '修改失敗！', true)
                        ->set_session ('name', $name, true)
                        ->set_session ('tag_ids', $tag_ids, true)
                        && redirect (array ('admin', 'goal_tags', 'cate_edit', $goal_tag_category->id), 'refresh');
    
    $old_ids = column_array ($goal_tag_category->tags, 'id');
    if ($del_ids = array_diff ($old_ids, $tag_ids))
      GoalTag::update_all (array ('set' => 'goal_tag_category_id = 0', 'conditions' => array ('id IN (?)', $del_ids)));

    if ($add_ids = array_diff ($tag_ids, $old_ids))
      GoalTag::update_all (array ('set' => 'goal_tag_category_id = ' . $goal_tag_category->id, 'conditions' => array ('id IN (?)', $add_ids)));

    return identity ()->set_session ('_flash_message', '修改成功！', true)
                      && redirect (array ('admin', 'goal_tags', 'cate_index'), 'refresh');
  }
  public function cate_add () {
    $message  = identity ()->get_session ('_flash_message', true);
    
    $name = identity ()->get_session ('name', true);
    $tag_ids = identity ()->get_session ('tag_ids', true);

    $this->load_view (array (
        'message' => $message,
        'name' => $name,
        'tag_ids' => $tag_ids
      ));
  }
  public function cate_create () {
    if (!$this->has_post ())
      return redirect (array ('admin', 'goal_tags', 'cate_add'));

    $name = trim ($this->input_post ('name'));
    $tag_ids = ($tag_ids = $this->input_post ('tag_ids')) ? $tag_ids : array ();

    if (!$name)
      return identity ()->set_session ('_flash_message', '填寫資訊有少！', true)
                        ->set_session ('name', $name, true)
                        ->set_session ('tag_ids', $tag_ids, true)
                        && redirect (array ('admin', 'goal_tags', 'cate_add'), 'refresh');

    if (GoalTagCategory::find_by_name ($name))
      return identity ()->set_session ('_flash_message', '名稱不能重複！', true)
                        ->set_session ('name', $name, true)
                        ->set_session ('tag_ids', $tag_ids, true)
                        && redirect (array ('admin', 'goal_tags', 'cate_add'), 'refresh');

    $params = array (
        'name' => $name
      );

    if (!verifyCreateOrm ($goal_tag_category = GoalTagCategory::create ($params)))
      return identity ()->set_session ('_flash_message', '新增失敗！', true)
                        ->set_session ('name', $name, true)
                        ->set_session ('tag_ids', $tag_ids, true)
                        && redirect (array ('admin', 'goal_tags', 'cate_add'), 'refresh');
    
    if ($tag_ids)
      GoalTag::update_all (array ('set' => 'goal_tag_category_id = ' . $goal_tag_category->id, 'conditions' => array ('id IN (?)', $tag_ids)));

    return identity ()->set_session ('_flash_message', '新增成功！', true)
                      && redirect (array ('admin', 'goal_tags', 'cate_index'), 'refresh');
  }
  public function cate_index ($offset = 0) {
    $columns = array ('id' => 'int', 'name' => 'string');
    $configs = array ('admin', 'goal_tag_categories', '%s');

    $conditions = conditions (
                    $columns,
                    $configs,
                    'GoalTagCategory',
                    $this->input_gets ()
                  );

    $conditions = array (implode (' AND ', $conditions));

    $limit = 25;
    $total = GoalTagCategory::count (array ('conditions' => $conditions));
    $offset = $offset < $total ? $offset : 0;

    $this->load->library ('pagination');
    $configs = array_merge (array ('total_rows' => $total, 'num_links' => 5, 'per_page' => $limit, 'uri_segment' => 0, 'base_url' => '', 'page_query_string' => false, 'first_link' => '第一頁', 'last_link' => '最後頁', 'prev_link' => '上一頁', 'next_link' => '下一頁', 'full_tag_open' => '<ul class="pagination">', 'full_tag_close' => '</ul>', 'first_tag_open' => '<li>', 'first_tag_close' => '</li>', 'prev_tag_open' => '<li>', 'prev_tag_close' => '</li>', 'num_tag_open' => '<li>', 'num_tag_close' => '</li>', 'cur_tag_open' => '<li class="active"><a href="#">', 'cur_tag_close' => '</a></li>', 'next_tag_open' => '<li>', 'next_tag_close' => '</li>', 'last_tag_open' => '<li>', 'last_tag_close' => '</li>'), $configs);
    $this->pagination->initialize ($configs);
    $pagination = $this->pagination->create_links ();

    $goal_tag_categories = GoalTagCategory::find ('all', array ('include' => array ('tags'), 'offset' => $offset, 'limit' => $limit, 'order' => 'id DESC', 'conditions' => $conditions));

    $message = identity ()->get_session ('_flash_message', true);

    $this->load_view (array (
        'message' => $message,
        'pagination' => $pagination,
        'goal_tag_categories' => $goal_tag_categories,
        'columns' => $columns
      ));
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
    $goal_tag_category_id = identity ()->get_session ('goal_tag_category_id', true);
    $name = identity ()->get_session ('name', true);

    $this->load_view (array (
        'goal_tag' => $goal_tag,
        'message' => $message,
        'goal_tag_category_id' => $goal_tag_category_id,
        'name' => $name
      ));
  }

  public function update ($id = 0) {
    if (!($goal_tag = GoalTag::find_by_id ($id)))
      return redirect (array ('admin', 'goal_tags'));

    if (!$this->has_post ())
      return redirect (array ('admin', 'goal_tags', 'edit', $goal_tag->id));

    $goal_tag_category_id = trim ($this->input_post ('goal_tag_category_id'));
    $name = trim ($this->input_post ('name'));

    if (!$name)
      return identity ()->set_session ('_flash_message', '填寫資訊有少！', true)
                        ->set_session ('goal_tag_category_id', $goal_tag_category_id, true)
                        ->set_session ('name', $name, true)
                        && redirect (array ('admin', 'goal_tags', 'edit', $goal_tag->id), 'refresh');
    $goal_tag->goal_tag_category_id = $goal_tag_category_id;
    $goal_tag->name = $name;

    if (!$goal_tag->save ())
      return identity ()->set_session ('_flash_message', '修改失敗！', true)
                        ->set_session ('goal_tag_category_id', $goal_tag_category_id, true)
                        ->set_session ('name', $name, true)
                        && redirect (array ('admin', 'goal_tags', 'edit', $goal_tag->id), 'refresh');

    return identity ()->set_session ('_flash_message', '修改成功！', true)
                      && redirect (array ('admin', 'goal_tags'), 'refresh');
  }

  public function add () {
    $message  = identity ()->get_session ('_flash_message', true);
    
    $goal_tag_category_id = identity ()->get_session ('goal_tag_category_id', true);
    $name = trim (identity ()->get_session ('name', true));

    $this->load_view (array (
        'message' => $message,
        'goal_tag_category_id' => $goal_tag_category_id,
        'name' => $name
      ));
  }

  public function create () {
    if (!$this->has_post ())
      return redirect (array ('admin', 'goal_tags', 'add'));

    $name = trim ($this->input_post ('name'));
    $goal_tag_category_id = trim ($this->input_post ('goal_tag_category_id'));

    if (!($name && is_numeric ($goal_tag_category_id)))
      return identity ()->set_session ('_flash_message', '填寫資訊有少！', true)
                        ->set_session ('goal_tag_category_id', $goal_tag_category_id, true)
                        ->set_session ('name', $name, true)
                        && redirect (array ('admin', 'goal_tags', 'add'), 'refresh');

    $params = array (
        'goal_tag_category_id' => $goal_tag_category_id,
        'name' => $name
      );

    if (!verifyCreateOrm ($goal_tag = GoalTag::create ($params)))
      return identity ()->set_session ('_flash_message', '新增失敗！', true)
                        ->set_session ('goal_tag_category_id', $goal_tag_category_id, true)
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

    $goal_tags = GoalTag::find ('all', array ('include' => array ('category'), 'offset' => $offset, 'limit' => $limit, 'order' => 'id DESC', 'conditions' => $conditions));

    $message = identity ()->get_session ('_flash_message', true);

    $this->load_view (array (
        'message' => $message,
        'pagination' => $pagination,
        'goal_tags' => $goal_tags,
        'columns' => $columns
      ));
  }
}

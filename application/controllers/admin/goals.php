<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Goals extends Admin_controller {

  public function __construct () {
    parent::__construct ();
  }

  public function destroy ($id = 0) {
    if (!($goal = Goal::find_by_id ($id)))
      return redirect (array ('admin', 'goals'));

    $message = $goal->destroy () ? '刪除成功！' : '刪除失敗！';

    return identity ()->set_session ('_flash_message', $message, true)
                    && redirect (array ('admin', 'goals'), 'refresh');
  }

  public function edit ($id = 0) {
    if (!($goal = Goal::find_by_id ($id)))
      return redirect (array ('admin', 'goals'));

    $message = identity ()->get_session ('_flash_message', true);
    $title = identity ()->get_session ('title', true);
    $latitude = identity ()->get_session ('latitude', true);
    $longitude = identity ()->get_session ('longitude', true);
    $address = identity ()->get_session ('address', true);
    $introduction = identity ()->get_session ('introduction', true);
    $tag_ids = identity ()->get_session ('tag_ids', true);
    $links = identity ()->get_session ('links', true);
    $picture_links = identity ()->get_session ('picture_links', true);

    $this->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'my.css'))
         ->add_js ('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=zh-TW', false)
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-media.js'))
         ->add_js (base_url ('resource', 'javascript', 'markerwithlabel_d2015_06_28', 'markerwithlabel.js'))
         ->add_js (base_url ('resource', 'javascript', 'imgLiquid_v0.9.944', 'imgLiquid-min.js'))
         ->load_view (array (
        'goal' => $goal,
        'message' => $message,
        'title' => $title,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'address' => $address,
        'introduction' => $introduction,
        'tag_ids' => $tag_ids,
        'links' => $links,
        'picture_links' => $picture_links,
      ));
  }

  public function update ($id = 0) {
    if (!($goal = Goal::find_by_id ($id)))
      return redirect (array ('admin', 'goals'));

    if (!$this->has_post ())
      return redirect (array ('admin', 'goals', 'edit', $goal->id));

    $title = trim ($this->input_post ('title'));
    $latitude = trim ($this->input_post ('latitude'));
    $longitude = trim ($this->input_post ('longitude'));
    $address = trim ($this->input_post ('address'));
    $introduction = trim ($this->input_post ('introduction'));

    $tag_ids = ($tag_ids = $this->input_post ('tag_ids')) ? $tag_ids : array ();

    $old_links = ($old_links = $this->input_post ('old_links')) ? array_filter ($old_links, function ($t) { return trim ($t['value']); }) : array ();
    $links = ($links = $this->input_post ('links')) ? array_filter ($links) : array ();
    $picture_links = ($picture_links = $this->input_post ('picture_links')) ? array_filter ($picture_links) : array ();

    $pic_ids = ($pic_ids = $this->input_post ('pic_ids')) ? array_filter ($pic_ids) : array ();
    $pictures = $this->input_post ('pictures[]', true);

    if (!($title && $latitude && $longitude))
      return identity ()->set_session ('_flash_message', '填寫資訊有少！', true)
                        ->set_session ('title', $title, true)
                        ->set_session ('latitude', $latitude, true)
                        ->set_session ('longitude', $longitude, true)
                        ->set_session ('address', $address, true)
                        ->set_session ('introduction', $introduction, true)
                        ->set_session ('tag_ids', $tag_ids, true)
                        ->set_session ('links', $links, true)
                        ->set_session ('picture_links', $picture_links, true)
                        && redirect (array ('admin', 'goals', 'edit', $goal->id), 'refresh');

    $goal->title = $title;
    $goal->latitude = $latitude;
    $goal->longitude = $longitude;

    if ($address)
      $goal->address = $address;
    if ($introduction)
      $goal->introduction = $introduction;

    if (!$goal->save ())
      return identity ()->set_session ('_flash_message', '修改失敗！', true)
                        ->set_session ('title', $title, true)
                        ->set_session ('latitude', $latitude, true)
                        ->set_session ('longitude', $longitude, true)
                        ->set_session ('address', $address, true)
                        ->set_session ('introduction', $introduction, true)
                        ->set_session ('tag_ids', $tag_ids, true)
                        ->set_session ('links', $links, true)
                        ->set_session ('picture_links', $picture_links, true)
                        && redirect (array ('admin', 'goals', 'edit', $goal->id), 'refresh');

    $old_ids = column_array ($goal->tag_goal_maps, 'goal_tag_id');
    if ($del_ids = array_diff ($old_ids, $tag_ids))
      GoalTagMap::delete_all (array ('conditions' => array ('goal_tag_id IN (?)', $del_ids)));

    if ($add_ids = array_diff ($tag_ids, $old_ids))
      foreach (GoalTag::find ('all', array ('select' => 'id', 'conditions' => array ('id IN (?)', $add_ids))) as $tag)
        GoalTagMap::create (array ('goal_id' => $goal->id, 'goal_tag_id' => $tag->id));
    
    $old_ids = column_array ($goal->links, 'id');
    $link_ids = column_array ($old_links, 'id');

    if ($del_ids = array_diff ($old_ids, $link_ids))
      GoalLink::delete_all (array ('conditions' => array ('id IN (?)', $del_ids)));
    
    array_map (function ($link) {
      return GoalLink::table ()->update ($set = array ('value' => trim ($link['value'])), array ('id' => $link['id']));
    }, $old_links);

    if ($links)
      foreach ($links as $link)
        GoalLink::create (array ('goal_id' => $goal->id, 'value' => $link));

    $old_ids = column_array ($goal->pictures, 'id');
    if ($del_ids = array_diff ($old_ids, $pic_ids))
      array_map (function ($picture) {
        return $picture->destroy ();
      }, GoalPicture::find ('all', array ('conditions' => array ('id IN (?)', $del_ids))));

    if ($pictures)
      foreach ($pictures as $picture)
        if (verifyCreateOrm ($pic = GoalPicture::create (array ('goal_id' => $goal->id, 'name' => '', 'gradient' => 1, 'color_red' => '', 'color_green' => '', 'color_blue' => '', 'ori_url' => ''))))
          if (!$pic->name->put ($picture))
            $pic->destroy ();
          else
            delay_job ('main', 'picture', array ('id' => $pic->id));

    if ($picture_links)
      foreach ($picture_links as $picture_link)
        if (verifyCreateOrm ($pic = GoalPicture::create (array ('goal_id' => $goal->id, 'name' => '', 'gradient' => 1, 'color_red' => '', 'color_green' => '', 'color_blue' => '', 'ori_url' => $picture_link))))
          if (!$pic->name->put_url ($picture_link))
            $pic->destroy ();
          else
            delay_job ('main', 'picture', array ('id' => $pic->id));

    return identity ()->set_session ('_flash_message', '修改成功！', true)
                      && redirect (array ('admin', 'goals'), 'refresh');
  }

  public function add () {
    $message  = identity ()->get_session ('_flash_message', true);
    
    $title = identity ()->get_session ('title', true);
    $latitude = identity ()->get_session ('latitude', true);
    $longitude = identity ()->get_session ('longitude', true);
    $address = identity ()->get_session ('address', true);
    $introduction = identity ()->get_session ('introduction', true);
    $tag_ids = identity ()->get_session ('tag_ids', true);
    $links = identity ()->get_session ('links', true);
    $picture_links = identity ()->get_session ('picture_links', true);

    $this->add_js ('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=zh-TW', false)
         ->add_js (base_url ('resource', 'javascript', 'markerwithlabel_d2015_06_28', 'markerwithlabel.js'))
         ->load_view (array (
        'message' => $message,
        'title' => $title,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'address' => $address,
        'introduction' => $introduction,
        'tag_ids' => $tag_ids,
        'links' => $links,
        'picture_links' => $picture_links,
      ));
  }

  public function create () {
    if (!$this->has_post ())
      return redirect (array ('admin', 'goals', 'add'));

    $title = trim ($this->input_post ('title'));
    $latitude = trim ($this->input_post ('latitude'));
    $longitude = trim ($this->input_post ('longitude'));
    $address = trim ($this->input_post ('address'));
    $introduction = trim ($this->input_post ('introduction'));

    $tag_ids = $this->input_post ('tag_ids');
    $links = ($links = $this->input_post ('links')) ? array_filter ($links) : array ();
    $picture_links = ($picture_links = $this->input_post ('picture_links')) ? array_filter ($picture_links) : array ();
    $pictures = $this->input_post ('pictures[]', true);

    if (!($title && $latitude && $longitude))
      return identity ()->set_session ('_flash_message', '填寫資訊有少！', true)
                        ->set_session ('title', $title, true)
                        ->set_session ('latitude', $latitude, true)
                        ->set_session ('longitude', $longitude, true)
                        ->set_session ('address', $address, true)
                        ->set_session ('introduction', $introduction, true)
                        ->set_session ('tag_ids', $tag_ids, true)
                        ->set_session ('links', $links, true)
                        ->set_session ('picture_links', $picture_links, true)
                        && redirect (array ('admin', 'goals', 'add'), 'refresh');

    $params = array (
        'user_id' => identity ()->user ()->id,
        'title' => $title,
        'address' => $address,
        'introduction' => $introduction,
        'score' => 0,
        'pageview' => 0,
        'latitude' => $latitude,
        'longitude' => $longitude
      );

    if (!verifyCreateOrm ($goal = Goal::create ($params)))
      return identity ()->set_session ('_flash_message', '新增失敗！', true)
                        ->set_session ('title', $title, true)
                        ->set_session ('latitude', $latitude, true)
                        ->set_session ('longitude', $longitude, true)
                        ->set_session ('address', $address, true)
                        ->set_session ('introduction', $introduction, true)
                        ->set_session ('tag_ids', $tag_ids, true)
                        ->set_session ('links', $links, true)
                        ->set_session ('picture_links', $picture_links, true)
                        && redirect (array ('admin', 'goals', 'add'), 'refresh');

    if ($tag_ids)
      foreach (GoalTag::find ('all', array ('select' => 'id', 'conditions' => array ('id IN (?)', $tag_ids))) as $tag)
        GoalTagMap::create (array ('goal_id' => $goal->id, 'goal_tag_id' => $tag->id));
    
    if ($links)
      foreach ($links as $link)
        GoalLink::create (array ('goal_id' => $goal->id, 'value' => $link));

    if ($pictures)
      foreach ($pictures as $picture)
        if (verifyCreateOrm ($pic = GoalPicture::create (array ('goal_id' => $goal->id, 'name' => '', 'gradient' => 1, 'color_red' => '', 'color_green' => '', 'color_blue' => '', 'ori_url' => ''))))
          if (!$pic->name->put ($picture))
            $pic->destroy ();
          else
            delay_job ('main', 'picture', array ('id' => $pic->id));

    if ($picture_links)
      foreach ($picture_links as $picture_link)
        if (verifyCreateOrm ($pic = GoalPicture::create (array ('goal_id' => $goal->id, 'name' => '', 'gradient' => 1, 'color_red' => '', 'color_green' => '', 'color_blue' => '', 'ori_url' => $picture_link))))
          if (!$pic->name->put_url ($picture_link))
            $pic->destroy ();
          else
            delay_job ('main', 'picture', array ('id' => $pic->id));

    return identity ()->set_session ('_flash_message', '新增成功！', true)
                      && redirect (array ('admin', 'goals'), 'refresh');
  }

  public function index ($offset = 0) {
    $columns = array ('id' => 'int', 'title' => 'string', 'address' => 'string');
    $configs = array ('admin', 'goals', '%s');

    $conditions = conditions (
                    $columns,
                    $configs,
                    'Goal',
                    $this->input_gets ()
                  );

    $conditions = array (implode (' AND ', $conditions));

    $limit = 25;
    $total = Goal::count (array ('conditions' => $conditions));
    $offset = $offset < $total ? $offset : 0;

    $this->load->library ('pagination');
    $configs = array_merge (array ('total_rows' => $total, 'num_links' => 5, 'per_page' => $limit, 'uri_segment' => 0, 'base_url' => '', 'page_query_string' => false, 'first_link' => '第一頁', 'last_link' => '最後頁', 'prev_link' => '上一頁', 'next_link' => '下一頁', 'full_tag_open' => '<ul class="pagination">', 'full_tag_close' => '</ul>', 'first_tag_open' => '<li>', 'first_tag_close' => '</li>', 'prev_tag_open' => '<li>', 'prev_tag_close' => '</li>', 'num_tag_open' => '<li>', 'num_tag_close' => '</li>', 'cur_tag_open' => '<li class="active"><a href="#">', 'cur_tag_close' => '</a></li>', 'next_tag_open' => '<li>', 'next_tag_close' => '</li>', 'last_tag_open' => '<li>', 'last_tag_close' => '</li>'), $configs);
    $this->pagination->initialize ($configs);
    $pagination = $this->pagination->create_links ();

    $goals = Goal::find ('all', array ('include' => array ('pictures', 'view'), 'offset' => $offset, 'limit' => $limit, 'order' => 'id DESC', 'conditions' => $conditions));

    $message = identity ()->get_session ('_flash_message', true);

    $this->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'my.css'))
         ->add_js ('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=zh-TW', false)
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-media.js'))
         ->add_js (base_url ('resource', 'javascript', 'imgLiquid_v0.9.944', 'imgLiquid-min.js'))
         ->load_view (array (
        'message' => $message,
        'pagination' => $pagination,
        'goals' => $goals,
        'columns' => $columns
      ));
  }
  public function panorama ($id = 0) {
    if (!($goal = Goal::find_by_id ($id)))
      return redirect (array ('admin', 'goals'));

    if (!$this->has_post ())
      return redirect (array ('admin', 'goals', 'view', $goal->id));

    $latitude = trim ($this->input_post ('latitude'));
    $longitude = trim ($this->input_post ('longitude'));
    $heading = trim ($this->input_post ('heading'));
    $pitch = trim ($this->input_post ('pitch'));
    $zoom = trim ($this->input_post ('zoom'));
  
    if (!($latitude && $longitude && is_numeric ($heading) && is_numeric ($pitch) && is_numeric ($zoom)))
      return identity ()->set_session ('_flash_message', '填寫資訊有少！', true)
                        ->set_session ('latitude', $latitude, true)
                        ->set_session ('longitude', $longitude, true)
                        ->set_session ('heading', $heading, true)
                        ->set_session ('pitch', $pitch, true)
                        ->set_session ('zoom', $zoom, true)
                        && redirect (array ('admin', 'goals', 'view', $goal->id), 'refresh');
    
    if ($goal->view) {
      $goal->view->latitude = $latitude;
      $goal->view->longitude = $longitude;
      $goal->view->heading = $heading;
      $goal->view->pitch = $pitch;
      $goal->view->zoom = $zoom;

      if (!$goal->view->save ())
        return identity ()->set_session ('_flash_message', '設定失敗！', true)
                        ->set_session ('latitude', $latitude, true)
                        ->set_session ('longitude', $longitude, true)
                        ->set_session ('heading', $heading, true)
                        ->set_session ('pitch', $pitch, true)
                        ->set_session ('zoom', $zoom, true)
                        && redirect (array ('admin', 'goals', 'view', $goal->id), 'refresh');
    } else {
      $params = array (
          'goal_id' => $goal->id,
          'latitude' => $latitude,
          'longitude' => $longitude,
          'heading' => $heading,
          'pitch' => $pitch,
          'zoom' => $zoom,
        );
      if (!verifyCreateOrm ($goal = GoalView::create ($params)))
        return identity ()->set_session ('_flash_message', '設定失敗！', true)
                        ->set_session ('latitude', $latitude, true)
                        ->set_session ('longitude', $longitude, true)
                        ->set_session ('heading', $heading, true)
                        ->set_session ('pitch', $pitch, true)
                        ->set_session ('zoom', $zoom, true)
                        && redirect (array ('admin', 'goals', 'view', $goal->id), 'refresh');
    }

    return identity ()->set_session ('_flash_message', '設定成功！', true)
                      && redirect (array ('admin', 'goals'), 'refresh');
  }
  public function view ($id = 0) {
    if (!($goal = Goal::find_by_id ($id)))
      return redirect (array ('admin', 'goals'));
    $message  = identity ()->get_session ('_flash_message', true);
    
    $latitude = identity ()->get_session ('latitude', true);
    $longitude = identity ()->get_session ('longitude', true);
    $heading = identity ()->get_session ('heading', true);
    $pitch = identity ()->get_session ('pitch', true);
    $zoom = identity ()->get_session ('zoom', true);

    $this->add_js ('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=zh-TW', false)
         ->add_js (base_url ('resource', 'javascript', 'markerwithlabel_d2015_06_28', 'markerwithlabel.js'))
         ->load_view (array (
        'goal' => $goal,
        'message' => $message,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'heading' => $heading,
        'pitch' => $pitch,
        'zoom' => $zoom,
      ));
  }
  public function show ($id = 0) {
    if (!($goal = Goal::find_by_id ($id)))
      return redirect (array ('admin', 'goals'));

    $this->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.css'))
         ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'my.css'))
         ->add_js ('https://maps.googleapis.com/maps/api/js?key=AIzaSyBpKWfHYDJV9iJ4HE8jKBI_sPA-4xHY0Zs&v=3.exp&sensor=false&language=zh-TW', false)
         ->add_js (base_url ('resource', 'javascript', 'markerwithlabel_d2015_06_28', 'markerwithlabel.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.js'))
         ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-media.js'))
         ->add_js (base_url ('resource', 'javascript', 'imgLiquid_v0.9.944', 'imgLiquid-min.js'))
         ->load_view (array (
        'goal' => $goal
      ));
  }
}

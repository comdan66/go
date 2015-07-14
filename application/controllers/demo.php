<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Demo extends Site_controller {

  public function __construct () {
    parent::__construct ();
  }

  public function test () {
    $user_count = User::count ();

    foreach (Goal::all () as $goal) {
      $goal->pageview = rand (0, 500);

      foreach (User::find ('all', array ('select' => 'id', 'order' => 'RAND()', 'limit' => rand (0, $user_count / 2), 'conditions' => array ())) as $user)
        $goal->add_score ($user->id, rand (0, 100));
    }
  }
  public function create () {
    $lat = 25.03684951358938;
    $lng = 121.54878616333008;

    $this->load->library ('CreateDemo');

    $times = range (3, rand (3, 10));
    echo "\n 新增 " . count ($times) . "筆 User\n==========================================\n";
    foreach ($times as $time)
      if (verifyCreateOrm ($user = User::create (array ('uid' => uniqid (), 'name' => CreateDemo::text (4, 10)))))
        echo " Create a User, id: " . $user->id . "\n";

    $times = range (3, rand (3, 10));
    echo "\n 新增 " . count ($times) . "筆 GoalTagCategory\n==========================================\n";
    foreach ($times as $time)
      if (verifyCreateOrm ($cate = GoalTagCategory::create (array ('name' => CreateDemo::text (2, 6)))))
        echo " Create a GoalTagCategory, id: " . $cate->id . "\n";

    $cate_count = GoalTagCategory::count ();

    $times = range (10, rand (10, 30));
    echo "\n 新增 " . count ($times) . "筆 GoalTag\n==========================================\n";
    foreach ($times as $time) {
      if (!rand (0, $cate_count))
        $cate = GoalTagCategory::find ('one', array ('select' => 'id', 'order' => 'RAND()', 'conditions' => array ()));
      else
        $cate = null;

      if (verifyCreateOrm ($tag = GoalTag::create (array ('goal_tag_category_id' => $cate ? $cate->id : 0, 'name' => CreateDemo::text (2, 6)))))
        echo " Create a GoalTag, id: " . $tag->id . "\n";
    }

    $tag_count = GoalTag::count ();

    $times = range (1, rand (50, 100));
    echo "\n 新增 " . count ($times) . "筆 Goal\n==========================================\n";
    foreach ($times as $time) {
      $user = User::find ('one', array ('select' => 'id', 'order' => 'RAND()', 'conditions' => array ()));
      $params = array (
          'user_id' => $user->id,
          'title' => CreateDemo::text (10, 50),
          'address' => CreateDemo::text (30, 80),
          'introduction' => CreateDemo::text (100, 500),
          'score' => 0,
          'pageview' => 0,
          'latitude' => $lat + (rand (-99999999, 99999999) * 0.000000001),
          'longitude' => $lng + (rand (-99999999, 99999999) * 0.000000001),
        );
      if (verifyCreateOrm ($goal = Goal::create ($params))) {
        echo " Create a Goal, id: " . $goal->id . "\n";

        $limit = rand (0, $tag_count / 2);
        echo "\n   新增 " . $limit . "筆 GoalTag\n   ---------------------------------------\n";
        if ($limit)
          foreach (GoalTag::find ('all', array ('select' => 'id', 'order' => 'RAND()', 'limit' => $limit, 'conditions' => array ())) as $tag)
            if (verifyCreateOrm ($goal_tag_map = GoalTagMap::create (array ('goal_id' => $goal->id, 'goal_tag_id' => $tag->id)))) 
              echo "   Create a GoalTagMap, id: " . $goal_tag_map->id . "\n";

        $pics = CreateDemo::pics (0, 5, $tags = array ('貓咪', '貓', '貓星人', '柴犬', '可愛', '狗', '寵物', '台灣', '名人'));
        echo "\n   新增 " . count ($pics) . "筆 GoalPicture\n   ---------------------------------------\n";
        foreach ($pics as $pic)
          if (verifyCreateOrm ($picture = GoalPicture::create (array ('goal_id' => $goal->id, 'name' => '', 'gradient' => 1, 'color_red' => '', 'color_green' => '', 'color_blue' => '', 'ori_url' => $pic['url']))))
            if (!$picture->name->put_url ($pic['url']))
              $picture->destroy ();
            else {
              $picture->update_gradient_and_color ();
              echo "   Create a GoalPicture, id: " . $picture->id . "\n";
            }

        $links = range (1, rand (1, 5));
        echo "\n   新增 " . $limit . "筆 GoalLink\n   ---------------------------------------\n";
        foreach ($links as $link)
          if (verifyCreateOrm ($link = GoalLink::create (array ('goal_id' => $goal->id, 'value' => CreateDemo::password (50)))))
            echo " Create a GoalLink, id: " . $link->id . "\n";


        echo "\n";
      }
    }
  }
}

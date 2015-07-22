<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Migration_Add_goal_tag_categories extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `goal_tag_categories` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '分類名稱',
        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        PRIMARY KEY (`id`),
        UNIQUE KEY `name_unique` (`name`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `goal_tag_categories`;"
    );
  }
}
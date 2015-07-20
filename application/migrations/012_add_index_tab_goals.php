<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Migration_Add_index_tab_goals extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `index_tab_goals` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `goal_id` int(11) NOT NULL COMMENT 'Goal ID',
        `index_tab_id` int(11) NOT NULL COMMENT 'Index Tab ID',
        `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '標題',
        `introduction` text  COMMENT '介紹',
        `pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '圖檔',
        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        PRIMARY KEY (`id`),
        KEY `goal_id_index` (`goal_id`),
        KEY `index_tab_id_index` (`index_tab_id`),
        FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`index_tab_id`) REFERENCES `index_tabs` (`id`) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `index_tab_goals`;"
    );
  }
}
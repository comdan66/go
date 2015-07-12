<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Migration_Add_goal_pictures extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `goal_pictures` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `goal_id` int(11) NOT NULL,

        `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '檔案名稱',

        `gradient` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '斜率，height/width',
        `color_red` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT 'RGB 紅',
        `color_green` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT 'RGB 綠',
        `color_blue` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT 'RGB 藍',

        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        PRIMARY KEY (`id`),
        KEY `goal_id_index` (`goal_id`),
        FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `goal_pictures`;"
    );
  }
}
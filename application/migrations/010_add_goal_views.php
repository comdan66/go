<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Migration_Add_goal_views extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `goal_views` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `goal_id` int(11) NOT NULL,

        `latitude` DOUBLE NOT NULL COMMENT '緯度',
        `longitude` DOUBLE NOT NULL COMMENT '經度',
        `pic` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '靜態圖檔',
        
        `heading` int(5) NOT NULL COMMENT '水平角度',
        `pitch` int(5) NOT NULL COMMENT '垂直角度',
        `zoom` int(5) NOT NULL COMMENT '放大度',


        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        PRIMARY KEY (`id`),
        KEY `goal_id_index` (`goal_id`),
        UNIQUE KEY `goal_id_unique` (`goal_id`),
        FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `goal_views`;"
    );
  }
}
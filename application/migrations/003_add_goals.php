<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Migration_Add_goals extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `goals` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,

        `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '標題',
        `introduction` text  COMMENT '介紹',
        `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '標題',

        `score` float NOT NULL COMMENT '分數',
        `pageview` int(11) NOT NULL DEFAULT '0' COMMENT 'PV',

        `latitude` float NOT NULL COMMENT '緯度',
        `longitude` float NOT NULL COMMENT '經度',

        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        PRIMARY KEY (`id`),
        KEY `user_id_index` (`user_id`),
        KEY `latitude_longitude_index` (`latitude`, `longitude`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `goals`;"
    );
  }
}
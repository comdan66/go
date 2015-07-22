<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Migration_Add_town_bounds extends CI_Migration {
  public function up () {
    /*  ______________. northeast - latitude
        |             |           - longitude
        |             |
        |             |
        .--------------
southwest - latitude
          - longitude
    */
    $this->db->query (
      "CREATE TABLE `town_bounds` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `town_id` int(11) NOT NULL,

        `northeast_latitude` DOUBLE NOT NULL COMMENT '東北緯度',
        `northeast_longitude` DOUBLE NOT NULL COMMENT '東北經度',
        `southwest_latitude` DOUBLE NOT NULL COMMENT '西南緯度',
        `southwest_longitude` DOUBLE NOT NULL COMMENT '西南經度',

        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        PRIMARY KEY (`id`),
        KEY `town_id_index` (`town_id`),
        FOREIGN KEY (`town_id`) REFERENCES `towns` (`id`) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `town_bounds`;"
    );
  }
}
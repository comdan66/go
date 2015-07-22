<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Migration_Add_towns extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `towns` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `town_category_id` int(11) NOT NULL,

        `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '名稱',
        `postal_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '郵遞區號',
        `latitude` DOUBLE NOT NULL COMMENT '緯度',
        `longitude` DOUBLE NOT NULL COMMENT '經度',

        `pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '靜態圖檔',
        `cwb_town_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '中央氣象局資料ID',

        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        PRIMARY KEY (`id`),
        KEY `town_category_id_index` (`town_category_id`),
        FOREIGN KEY (`town_category_id`) REFERENCES `town_categories` (`id`) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `towns`;"
    );
  }
}
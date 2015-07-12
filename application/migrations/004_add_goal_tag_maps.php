<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Migration_Add_goal_tag_maps extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `goal_tag_maps` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `goal_tag_id` int(11) NOT NULL COMMENT 'Tag ID',
        `goal_id` int(11) NOT NULL COMMENT 'Goal ID',
        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        PRIMARY KEY (`id`),
        KEY `goal_tag_id_index` (`goal_tag_id`),
        KEY `goal_id_index` (`goal_id`),
        UNIQUE KEY `goal_tag_id_goal_id_unique` (`goal_tag_id`, `goal_id`),
        FOREIGN KEY (`goal_tag_id`) REFERENCES `goal_tags` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `goal_tag_maps`;"
    );
  }
}
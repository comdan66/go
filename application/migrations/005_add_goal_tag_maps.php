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
        `goal_id` int(11) NOT NULL COMMENT 'Goal ID',
        `goal_tag_id` int(11) NOT NULL COMMENT 'Tag ID',
        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        PRIMARY KEY (`id`),
        KEY `goal_id_index` (`goal_id`),
        KEY `goal_tag_id_index` (`goal_tag_id`),
        UNIQUE KEY `goal_id_goal_tag_id_unique` (`goal_id`, `goal_tag_id`),
        FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`goal_tag_id`) REFERENCES `goal_tags` (`id`) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `goal_tag_maps`;"
    );
  }
}
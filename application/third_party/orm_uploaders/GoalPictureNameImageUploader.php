<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class GoalPictureNameImageUploader extends OrmImageUploader {

  public function getVersions () {
    return array (
        '' => array (),
        '50x50c' => array ('adaptiveResizeQuadrant', 50, 50, 'c'),
      );
  }
}
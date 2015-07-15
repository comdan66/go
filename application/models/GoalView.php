<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class GoalView extends OaModel {

  static $table_name = 'goal_views';

  static $has_one = array (
  );

  static $has_many = array (
  );

  static $belongs_to = array (
    array ('goal', 'class_name' => 'Goal')
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
   
    OrmImageUploader::bind ('pic', 'GoalViewPicImageUploader');
  }
  public function picture ($size = '50x50', $fov = 90) {
    return "http://maps.googleapis.com/maps/api/streetview?size=" . strtolower ($size) . "&location=" . $this->latitude . "," . $this->longitude . "&heading=" . $this->heading . "&pitch=" . $this->pitch . "&fov=" . $fov . "&sensor=false";
  }
  public function destroy () {
    return $this->pic->cleanAllFiles () && $this->delete ();
  }
}
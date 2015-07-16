<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class User extends OaModel {

  static $table_name = 'users';

  static $has_one = array (
  );

  static $has_many = array (
    array ('goals', 'class_name' => 'Goal'),
    array ('comments', 'class_name' => 'GoalComment')
  );

  static $belongs_to = array (
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
  public function avatar () {
    return 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpa1/v/t1.0-1/p160x160/11048657_1080777421935599_5837445915403701082_n.jpg?oh=db4264849241f5fc4d855b9e3aee3b5d&oe=561CA297&__gda__=1447967125_d25173da139343c19aca5a7de924febe';
  }
  public function destroy () {
    return $this->delete ();
  }
}
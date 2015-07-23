<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class TownWeather extends OaModel {
  static $file_name_encode = true;

  static $table_name = 'town_weathers';

  static $has_one = array (
  );

  static $has_many = array (
  );

  static $belongs_to = array (
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
  public function icon () {
    return base_url ('resource', 'image', 'weather', $this->icon);
  }
  public function special_icon () {
    return base_url ('resource', 'image', 'weather', $this->special_icon);
  }
  public function has_special () {
    return $this->special_icon && $this->special_status && $this->special_describe;
  }
  public function to_array () {
    return array (
          'icon' => $this->icon (),
          'describe' => $this->describe,
          'temperature' => $this->temperature,
          'humidity' => $this->humidity,
          'rainfall' => $this->rainfall,
          'sunrise' => $this->sunrise,
          'sunset' => $this->sunset,
          'special' => $this->has_special () ? array (
              'icon' => $this->special_icon (),
              'status' => $this->special_status,
              'describe' => $this->special_describe,
              'at' => $this->special_at->format ('Y-m-d H:m:i')
            ) : array ()
        );
  }
  public function destroy () {
    return $this->delete ();
  }
}
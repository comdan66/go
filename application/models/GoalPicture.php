<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class GoalPicture extends OaModel {

  static $table_name = 'goal_pictures';

  static $has_one = array (
  );

  static $has_many = array (
  );

  static $belongs_to = array (
    array ('goal', 'class_name' => 'Goal')
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);

    OrmImageUploader::bind ('name', 'GoalPictureNameImageUploader');
  }
  public function destroy () {
    return $this->name->cleanAllFiles () && $this->delete ();
  }
  public function update_gradient () {
    $image_utility = ImageUtility::create (FCPATH . implode('/', $this->name->path ()));
    if (ImageUtility::verifyDimension ($dimension = $image_utility->getDimension ())) {
      $this->gradient = gradient ($dimension['height'] / $dimension['width']);
      $this->save ();
    }
  }

  public function update_color ($image_utility = null) {
    if (!$image_utility)
      $image_utility = ImageUtility::create (FCPATH . implode('/', $this->name->path ()));
    
    if (($analysis_datas = $image_utility->resize (10, 10, 'w')->getAnalysisDatas (1)) && isset ($analysis_datas[0]['color']) && ($analysis_datas = $analysis_datas[0]['color']) && (isset ($analysis_datas['r']) && isset ($analysis_datas['g']) && isset ($analysis_datas['b']))) {
      $average = 128;

      $color_red = round ($analysis_datas['r'] / 10) * 10;
      $color_green = round ($analysis_datas['g'] / 10) * 10;
      $color_blue = round ($analysis_datas['b'] / 10) * 10;

      $color_red += (round (($color_red - $average) / 10) * 1.125) * 10;
      $color_green += (round (($color_green - $average) / 10) * 1.125) * 10;
      $color_blue += (round (($color_blue - $average) / 10) * 1.125) * 10;

      $this->color_red = round ($color_red > 0 ? $color_red < 256 ? $color_red : 255 : 0);
      $this->color_green = round ($color_green > 0 ? $color_green < 256 ? $color_green : 255 : 0);
      $this->color_blue = round ($color_blue > 0 ? $color_blue < 256 ? $color_blue : 255 : 0);

      return $this->save ();
    }
  }

  public function update_gradient_and_color () {
    $image_utility = ImageUtility::create (FCPATH . implode('/', $this->name->path ()));
    
    if (ImageUtility::verifyDimension ($dimension = $image_utility->getDimension ()))
      $this->gradient = gradient ($dimension['height'] / $dimension['width']);
    return $this->update_color ($image_utility);
  }
}
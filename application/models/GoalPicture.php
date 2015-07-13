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

  public function update_color () {
    $image_utility = ImageUtility::create (FCPATH . implode('/', $this->name->path ()));
    
    if (($analysis_datas = $image_utility->resize (10, 10, 'w')->getAnalysisDatas (1)) && isset ($analysis_datas[0]['color']) && ($analysis_datas = $analysis_datas[0]['color']) && (isset ($analysis_datas['r']) && isset ($analysis_datas['g']) && isset ($analysis_datas['b']))) {
      $this->color_red   = $analysis_datas['r'];
      $this->color_green = $analysis_datas['g'];
      $this->color_blue  = $analysis_datas['b'];
      $this->save ();
    }
  }

  public function update_gradient_and_color () {
    $image_utility = ImageUtility::create (FCPATH . implode('/', $this->name->path ()));
    
    if (ImageUtility::verifyDimension ($dimension = $image_utility->getDimension ())) {
      $this->gradient = gradient ($dimension['height'] / $dimension['width']);
    }
    if (($analysis_datas = $image_utility->resize (10, 10, 'w')->getAnalysisDatas (1)) && isset ($analysis_datas[0]['color']) && ($analysis_datas = $analysis_datas[0]['color']) && (isset ($analysis_datas['r']) && isset ($analysis_datas['g']) && isset ($analysis_datas['b']))) {
      $this->color_red   = $analysis_datas['r'];
      $this->color_green = $analysis_datas['g'];
      $this->color_blue  = $analysis_datas['b'];
    }
    $this->save ();
  }
}
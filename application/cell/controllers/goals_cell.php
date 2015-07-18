<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Goals_cell extends Cell_Controller {

  /* render_cell ('goals_cell', 'banner', array ()); */
  // public function _cache_banner () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function banner ($goal) {
    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view (array (
                    'goal' => $goal
                  ));
  }

  /* render_cell ('goals_cell', 'user', array ()); */
  // public function _cache_temp () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function user ($goal) {
    return $this->setUseCssList (true)
                ->load_view (array (
                    'goal' => $goal
                  ));
  }

  /* render_cell ('goals_cell', 'introduction', array ()); */
  // public function _cache_temp () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function introduction ($goal) {
    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view (array (
                    'goal' => $goal
                  ));
  }

  /* render_cell ('goals_cell', 'comments', array ()); */
  // public function _cache_temp () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function comments () {
    return $this->setUseCssList (true)
                ->load_view ();
  }

  /* render_cell ('goals_cell', 'images', array ()); */
  // public function _cache_temp () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function images ($goal) {
    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view (array (
                    'goal' => $goal
                  ));
  }

  /* render_cell ('goals_cell', 'maps', array ()); */
  // public function _cache_temp () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function maps ($goal) {
    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view (array (
                    'goal' => $goal
                  ));
  }

  /* render_cell ('goals_cell', 'maylike', array ()); */
  // public function _cache_temp () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function maylike () {
    return $this->setUseJsList (true)
                ->setUseCssList (true)
                ->load_view ();
  }

  /* render_cell ('goals_cell', 'temp', array ()); */
  // public function _cache_temp () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function temp () {
    return $this->load_view ();
  }
}
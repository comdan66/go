/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  function goLeft () {
    $('.banner').last ().clone ().insertBefore ($('.banner').first ());
    $('.banner').last ().remove ();
  }
  function goRight () {
    $('.banner').first ().clone ().insertAfter ($('.banner').last ());
    $('.banner').first ().remove ();
  }

  var $banner = $('#banner');
  var $banners = $('#banner').find ('.banners');
  var $leftArrow = $banner.find ('.arrow.left');
  var $rightArrow = $banner.find ('.arrow.right');

  $leftArrow.click (goLeft);
  $rightArrow.click (goRight);
  
  $banners.swiperight (goLeft);
  $banners.swipeleft (goRight);
});
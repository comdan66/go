/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  function goLeft () {
    $('.banner').last ().clone ().insertBefore ($('.banner').first ());
    $('.banner').last ().remove ();
    $bottom.text ($('.banner').eq (firstIndex).data ('title'));
  }
  function goRight () {
    $('.banner').first ().clone ().insertAfter ($('.banner').last ());
    $('.banner').first ().remove ();
    $bottom.text ($('.banner').eq (firstIndex).data ('title'));
  }

  var firstIndex = 2;
  var $banner = $('#banner');
  var $banners = $('#banner').find ('.banners');
  var $leftArrow = $banners.find ('.arrow.left');
  var $rightArrow = $banners.find ('.arrow.right');
  var $bottom = $banners.find ('.bottom');

  $leftArrow.click (goLeft);
  $rightArrow.click (goRight).click ();
  
  $banners.swiperight (goLeft);
  $banners.swipeleft (goRight);
});
/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $tabview = $('#tabview');
  var $item = $tabview.find ('.item');
  var $content = $tabview.find ('.content');
  
  $item.mouseenter (function () {
    var index = $item.index ($(this));
    $(this).addClass ('active').siblings ().removeClass ('active');
    $content.attr ('class', 'content').map (function (i) {
      $(this).addClass ('c' + (i - index)).addClass (i == index ? 'show' : '');
    });
  }).first ().mouseenter ();
});
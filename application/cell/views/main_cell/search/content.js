/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $bg_cover = $('#bg_cover');
  var $search = $('#search');
  var $color_picker = $search.find ('.color_picker');
  var $icon = $color_picker.find ('.icon-eyedropper');
  var $colors = $color_picker.find ('.colors');
  var $color = $colors.find ('> div');
  var $key = $('#search_key');
  var $input = $('#search').find ('.search');

  function goSearch () {
    var input = $input.val ().trim ();
    if (!input) return;

    var colors = input.match (/^rgb\s*\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)$/i);
    if (colors)
      window.location.assign ('/search?rgb[0]=' + colors[1] + '&rgb[1]=' + colors[2] + '&rgb[2]=' + colors[3]);
    else
      window.location.assign ('/search?q=' + $input.val ().trim ());
  }
  $input.keyup (function (e) {
    if (e.keyCode == 13)
      goSearch ();
  });

  $search.find ('.go_search').click (goSearch);

  $icon.click (function () {
    $colors.addClass ('show');
    $bg_cover.addClass ('show');
  });
  $bg_cover.click (function () {
    $colors.removeClass ('show');
    $bg_cover.removeClass ('show');
  });
  $color.click (function () {
    if ($color.index ($(this)) == ($color.length - 1))
      $icon.removeClass ('choice');
    else
      $icon.addClass ('choice');
    
    $colors.removeClass ('show');
    $bg_cover.removeClass ('show');

    $icon.css ({
      'background-color': $(this).css ('background-color')
    });

    if ($color.index ($(this)) == ($color.length - 1))
      $input.val ('');
    else
      $input.val ($(this).css ('background-color'));
  });
});
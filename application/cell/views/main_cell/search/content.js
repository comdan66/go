/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $search = $('#search');
  var $key = $('#search_key');
  var $input = $('#search').find ('.search');

  $search.find ('.go_search').click (function () {
    if ($input.val ().trim ().length)
      window.location.assign ('/search/' + $input.val ().trim ());
  });
});
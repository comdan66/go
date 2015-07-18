/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $detail = $('#details .detail');

  $(window).scroll (function () {
    var $that = $(this);
    $detail.each (function () {
      if ($(this).data ('has_loaded') || ($that.scrollTop () + $that.height () < $(this).offset ().top))
        return;
      $(this).data ('has_loaded', true);

      setTimeout (function () {
        $(this).find ('.row div[data-width]').each (function () {
          $(this).css ({'width': $(this).data ('width')});
        });
      }.bind ($(this)), 500);
    });
  }).scroll ();

});
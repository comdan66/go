/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $detail = $('#introduction .detail');
  var $stars = $('#introduction .stars.can');
  var $star = $stars.find ('i');

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

  $star.mouseenter (function () {
    $star.attr ('class', 'icon-star-0');
    $(this).prevAll ().andSelf ().addClass ('icon-star-2');
  });
  $stars.mouseleave (function () {
    $star.each (function () {
      $(this).attr ('class', 'icon-star-' + $(this).data ('ori'));
    });
  });
});
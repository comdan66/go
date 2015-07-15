/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var firstIndex = 2;
  var $banner = $('#banner');
  var $banners = $('#banner').find ('.banners');
  var $leftArrow = $banners.find ('.arrow.left');
  var $rightArrow = $banners.find ('.arrow.right');
  var $bottom = $banners.find ('.bottom');

  $leftArrow.click (function () {
    $('.banner').last ().clone ().insertBefore ($('.banner').first ());
    $('.banner').last ().remove ();
    $bottom.text ($('.banner').eq (firstIndex).data ('title'));
  });
  $rightArrow.click (function () {
    $('.banner').first ().clone ().insertAfter ($('.banner').last ());
    $('.banner').first ().remove ();
    $bottom.text ($('.banner').eq (firstIndex).data ('title'));
  }).click ();

  $('.banner').imgLiquid ({verticalAlign: 'top'});
  // var timer = null, index = 0;

  // $(window).resize (function () {
  //   var move = function (i) {
  //     // var w = $(window).width ();
  //     // if (w < 990)
  //     //   w = 990;
  //     // $('#banners').css ({'width': w + 'px'});
      
  //     // var h = (w * 800) / 1200;

  //     // $('#banners .banners').css ({'width': w * $('#banners .banners .banner').length + 'px', 'height': h + 'px'});
  //     // $('#banners .banners .banner').map (function (j, t) {
  //     //     $(this).css ({'left': (j - i) * w + 'px', 'width': w + 'px'});
  //     // });
  //   };
  //   // $('#banners .point').click (function () {
  //   //   $(this).addClass ('now').siblings ().removeClass ('now');
  //   //   var i = $('#banners .points_c .point').index ($(this));
  //   //   move (i);
  //   // });

  //   // var loop = function () {
  //   //   clearTimeout (timer);
  //   //   $('#banners .points_c .point').eq (index).click ();
  //   //   index = ++index < $('#banners .banners .banner').length ? index : 0;
  //   //   timer = setTimeout (loop, 3000);
  //   // };
  //   // loop ();
  // }).resize ();
});
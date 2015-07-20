/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {

  // setTimeout (function () {
  //   setTimeout (function () {
  //     $('.tags .tag').slice (0, 5).addClass ('stop');
  //     $('.tags .tag').slice (5, 10).addClass ('start');

  //   }, 3000);
  // }, 1000);

  function x (i) {
    var $tags = $('.tags .tag').slice (i, i + 5).removeClass ('back').addClass ('start');
    setTimeout (function () {
      $tags.addClass ('end');

      setTimeout (x.bind (this, (i + 5) % 10), 100);

      setTimeout (function () {
        $tags.addClass ('back').removeClass ('start end');
      }, 1500);

    }, 5000);
  }

  setTimeout (x.bind (this, 0), 100);
});
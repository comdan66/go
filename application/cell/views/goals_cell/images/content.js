/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  $('.fancybox').fancybox ({
                    padding: 0,
                    helpers: {
                      overlay: { locked: false },
                      title: { type: 'over' },
                      thumbs: { width: 50, height: 50 }
                    }
                 });
});
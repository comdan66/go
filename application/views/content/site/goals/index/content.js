/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var now = new Date ().getTime ();
  var ids = getStorage ('goal_site_viewed');
  if (!ids) ids = [];
  ids = ids.filter (function (t) { return now - t.t < 1 * 86400 * 1000; });

  var obj = [{id: $('#marker').val (), t: now}];
  ids = ids.diff (obj);
  var add = obj.diff (ids);
  ids = ids.concat (add);

  setStorage ('goal_site_viewed', ids);
});
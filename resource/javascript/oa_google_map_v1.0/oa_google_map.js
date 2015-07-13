/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

Array.prototype.diff = function (a) {
  return this.filter (function (i) { return a.map (function (t) { return t.id; }).indexOf (i.id) < 0; });
};

function getUnit (will, now) {
  var addLat = will.lat () - now.lat ();
  var addLng = will.lng () - now.lng ();
  var aveAdd = ((Math.abs (addLat) + Math.abs (addLng)) / 2);
  var unit = aveAdd < 10 ? aveAdd < 1 ? aveAdd < 0.1 ? aveAdd < 0.01 ? aveAdd < 0.001 ? aveAdd < 0.0001 ? 3 : 6 : 9 : 12 : 15 : 24 : 21;
  var lat = addLat / unit;
  var lng = addLng / unit;

  if (!((Math.abs (lat) > 0) || (Math.abs (lng) > 0)))
    return null;

  return {
    unit: unit,
    lat: lat,
    lng: lng
  };
}

function mapMove (map, unitLat, unitLng, unitCount, unit, callback) {
  if (unit > unitCount) {
    map.setCenter (new google.maps.LatLng (map.getCenter ().lat () + unitLat, map.getCenter ().lng () + unitLng));
    setTimeout (function () {
      mapMove (map, unitLat, unitLng, unitCount + 1, unit, callback);
    }, 50);
  } else {
    if (callback)
      callback ();
  }
}

function mapGo (map, will, callback) {
  var now = map.getCenter ();

  var Unit = getUnit (will, now);
  if (!Unit)
    return false;

  mapMove (map, Unit.lat, Unit.lng, 0, Unit.unit, callback);
}
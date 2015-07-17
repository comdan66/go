/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

function getGoals (map, goal_id, $loadingData, notSaveLast) {
  clearTimeout (map.getGoalsTimer);

  map.getGoalsTimer = setTimeout (function () {
    if (map.isGetGoals)
      return;
    
    if(!map.markers)
      map.markers = [];
    
    if(!map.markerCluster)
      map.markerCluster = new MarkerClusterer(_map, [], {
        styles: [{url: '/resource/image/map/pictures_1.png', height: 74, width: 75, textSize: 20, textColor: '#ffffff', backgroundPosition: "0 -4px"},
                 {url: '/resource/image/map/pictures_2.png', height: 74, width: 75, textSize: 20, textColor: '#ffffff', backgroundPosition: "0 -4px"},
                 {url: '/resource/image/map/pictures_3.png', height: 74, width: 75, textSize: 20, textColor: '#ffffff', backgroundPosition: "0 -4px"},
                 {url: '/resource/image/map/pictures_4.png', height: 74, width: 75, textSize: 20, textColor: '#ffffff', backgroundPosition: "0 -4px"},
                 {url: '/resource/image/map/pictures_5.png', height: 74, width: 75, textSize: 20, textColor: '#ffffff', backgroundPosition: "0 -4px"}]
      });

    if ($loadingData)
      $loadingData.addClass ('show');
    map.isGetGoals = true;

    var northEast = map.getBounds().getNorthEast ();
    var southWest = map.getBounds().getSouthWest ();

    $.ajax ({
      url: $('#get_goals_url').val (),
      data: { NorthEast: {latitude: northEast.lat (), longitude: northEast.lng ()},
              SouthWest: {latitude: southWest.lat (), longitude: southWest.lng ()},
              goal_id: goal_id ? goal_id : 0
            },
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {}
    })
    .done (function (result) {
      if (result.status) {
        var markers = result.goals.map (function (t) {
          var markerWithLabel = new MarkerWithLabel ({
              position: new google.maps.LatLng (t.lat, t.lng),
              draggable: false,
              raiseOnDrag: false,
              clickable: true,
              labelContent: t.title,
              labelAnchor: new google.maps.Point (50, 0),
              labelClass: "marker_label",
              icon: '/resource/image/map/spotlight-poi-blue.png'
            });
          return {
            id: t.id,
            markerWithLabel: markerWithLabel
          };
        });

        var deletes = map.markers.diff (markers);
        var adds = markers.diff (map.markers);
        var delete_ids = deletes.map (function (t) { return t.id; });
        var add_ids = adds.map (function (t) { return t.id; });

        map.markerCluster.removeMarkers (deletes.map (function (t) { return t.markerWithLabel; }));
        map.markerCluster.addMarkers (adds.map (function (t) { return t.markerWithLabel; }));
        
        map.markers = map.markers.filter (function (t) { return $.inArray (t.id, delete_ids) == -1; }).concat (markers.filter (function (t) { return $.inArray (t.id, add_ids) != -1; }));

        if ($loadingData)
          $loadingData.removeClass ('show');
        map.isGetGoals = false;
      }
    })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) {});
  }, 100);

  if (!notSaveLast)
    setStorage.apply (this, ['goal_site_map', {
      lat: map.center.lat (),
      lng: map.center.lng (),
      zoom: map.zoom
    }]);
}
$(function () {
  $('.created_at').timeago ();
  $('.imgLiquid_top').imgLiquid ({verticalAlign: 'top'});
  $('.imgLiquid_center').imgLiquid ({verticalAlign: 'center'});
});
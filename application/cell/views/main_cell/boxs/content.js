/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $boxs = $('#boxs');
  var $map = $boxs.find ('#map');
  var $loadingData = $boxs.find ('.loading_data');
  var _markers = [];
  var _isGetGoals = false;
  var _getGoalsTimer = null;
  var _markerCluster = null;

  function getGoals () {
    clearTimeout (_getGoalsTimer);

    _getGoalsTimer = setTimeout (function () {
      if (_isGetGoals)
        return;
      
      $loadingData.addClass ('show');
      _isGetGoals = true;

      var northEast = _map.getBounds().getNorthEast ();
      var southWest = _map.getBounds().getSouthWest ();

      $.ajax ({
        url: $('#get_goals_url').val (),
        data: { NorthEast: {latitude: northEast.lat (), longitude: northEast.lng ()},
                SouthWest: {latitude: southWest.lat (), longitude: southWest.lng ()},
                goal_id: 0
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

          var deletes = _markers.diff (markers);
          var adds = markers.diff (_markers);
          var delete_ids = deletes.map (function (t) { return t.id; });
          var add_ids = adds.map (function (t) { return t.id; });

          // deletes.map (function (t) { t.markerWithLabel.setMap (null); });
          // adds.map (function (t) { t.markerWithLabel.setMap (_map); });

          _markerCluster.removeMarkers (deletes.map (function (t) { return t.markerWithLabel; }));
          _markerCluster.addMarkers (adds.map (function (t) { return t.markerWithLabel; }));
          
          _markers = _markers.filter (function (t) { return $.inArray (t.id, delete_ids) == -1; }).concat (markers.filter (function (t) { return $.inArray (t.id, add_ids) != -1; }));

          $loadingData.removeClass ('show');
          _isGetGoals = false;
        }
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) {});
    }, 500);

    setStorage.apply (this, ['goal_site_map', {
      lat: _map.center.lat (),
      lng: _map.center.lng (),
      zoom: _map.zoom
    }]);
  }
  function initialize () {
    var styledMapType = new google.maps.StyledMapType ([
      { featureType: 'transit.station.bus',
        stylers: [{ visibility: 'off' }]
      }, {
        featureType: 'poi',
        stylers: [{ visibility: 'off' }]
      }, {
        featureType: 'poi.attraction',
        stylers: [{ visibility: 'on' }]
      }, {
        featureType: 'poi.school',
        stylers: [{ visibility: 'on' }]
      }
    ]);
    _map = new google.maps.Map ($map.get (0), {
        zoom: 14,
        zoomControl: true,
        scrollwheel: true,
        scaleControl: true,
        mapTypeControl: false,
        navigationControl: true,
        streetViewControl: false,
        disableDoubleClickZoom: true,
        center: new google.maps.LatLng (25.04, 121.55),
      });
    _map.mapTypes.set ('map_style', styledMapType);
    _map.setMapTypeId ('map_style');

    var last = getStorage ('goal_site_map');

    if (last) {
      _map.setCenter (new google.maps.LatLng (last.lat, last.lng));
      _map.setZoom (last.zoom);
    } else {
      navigator.geolocation.getCurrentPosition (function (position) {
        _map.setZoom (14);
        mapGo (_map, new google.maps.LatLng (position.coords.latitude, position.coords.longitude), function (map) {
          setStorage.apply (this, ['goal_site_map', {
            lat: map.center.lat (),
            lng: map.center.lng (),
            zoom: map.zoom
          }]);
        });
      });
    }

    _markerCluster = new MarkerClusterer(_map, [], {
      styles: [{
            url: 'resource/image/map/pictures_1.png',
            height: 74,
            width: 75,
            textSize: 20,
            textColor: '#ffffff',
            backgroundPosition: "0 -4px"
        },
        {
            url: 'resource/image/map/pictures_2.png',
            height: 74,
            width: 75,
            textSize: 20,
            textColor: '#ffffff',
            backgroundPosition: "0 -4px"
        },
        {
            url: 'resource/image/map/pictures_3.png',
            height: 74,
            width: 75,
            textSize: 20,
            textColor: '#ffffff',
            backgroundPosition: "0 -4px"
        },
        {
            url: 'resource/image/map/pictures_4.png',
            height: 74,
            width: 75,
            textSize: 20,
            textColor: '#ffffff',
            backgroundPosition: "0 -4px"
        },
        {
            url: 'resource/image/map/pictures_5.png',
            height: 74,
            width: 75,
            textSize: 20,
            textColor: '#ffffff',
            backgroundPosition: "0 -4px"
        }]
    });
    google.maps.event.addListener(_map, 'zoom_changed', getGoals);
    google.maps.event.addListener(_map, 'idle', getGoals);
  }

  google.maps.event.addDomListener (window, 'load', initialize);
});
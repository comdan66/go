/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $map = $('#map');
  var $view = $('#view');
  var $alert = $('#alert');
  var $error = $('#error');
  var $marker = $('#marker');
  var $latitude = $('#latitude');
  var $longitude = $('#longitude');
  var $heading = $('#heading');
  var $pitch = $('#pitch');
  var $zoom = $('#zoom');
  var $loading = $('<div />').attr ('id', 'loading')
                             .append ($('<div />'))
                             .appendTo ('#container');
  var _map = null;
  var _panorama = null;
  var _update = false;
  var _povChangedTimer = null;
  var _hasView = false;

  function updateGoal (id, position) {
    if (_update)
      return;

    _update = true;

    new google.maps.Geocoder ().geocode ({'latLng': position}, function (result, status) {
      var address = ((status == google.maps.GeocoderStatus.OK) && result.length) ? result[0].formatted_address : '';

      $.ajax ({
        url: $('#update_goal_position_url').val (),
        data: { id: id, lat: position.lat (), lng: position.lng (), addr: address },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () { }
      })
      .done (function (result) {})
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) {
        _update = false;
      });
    });
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

    var marker = new google.maps.Marker ({
        draggable: true,
        position: new google.maps.LatLng ($marker.data ('lat'), $marker.data ('lng')),
      });

    _panorama = new google.maps.StreetViewPanorama ($view.get (0), {
      linksControl: true,
      addressControl: false,
      pov: {
        heading: parseInt ($heading.val (), 10),
        pitch: parseInt ($pitch.val (), 10),
        zoom: parseInt ($zoom.val (), 10)
      }
    });

    _map = new google.maps.Map ($map.get (0), {
        zoom: 17,
        zoomControl: true,
        scrollwheel: true,
        scaleControl: true,
        streetView: _panorama,
        mapTypeControl: false,
        navigationControl: true,
        center: marker.position,
        streetViewControl: true,
        disableDoubleClickZoom: true,
      });
    _map.mapTypes.set ('map_style', styledMapType);
    _map.setMapTypeId ('map_style');
    
    google.maps.event.addListener (_panorama, 'visible_changed', function () {
      if (!this.getVisible ()) {
        _hasView = false;
        $alert.text ('此處沒有任何街景！').attr ('class', 'show');
      } else {
        _hasView = true;
        $alert.text ('').attr ('class', '');
      }

      mapGo (_map, this.getPosition ());
    });

    _panorama.setPosition (new google.maps.LatLng ($latitude.val (), $longitude.val ()));

    new google.maps.StreetViewService ().getPanoramaByLocation (marker.position, 10, function (data, status) {
      if (status != google.maps.StreetViewStatus.OK) {
        _hasView = false;
        $alert.text ('此處沒有任何街景！').attr ('class', 'show');
      } else {
        _hasView = true;
        $alert.text ('').attr ('class', '');
      }
    });

    marker.setMap (_map);

    google.maps.event.addListener (marker, 'dragend', function () {
      updateGoal ($marker.val (), marker.position);
    });

    google.maps.event.addListener(_map, 'zoom_changed', getGoals.bind (this, _map, $marker.val (), $('#loading_data'), true));
    google.maps.event.addListener(_map, 'idle', getGoals.bind (this, _map, $marker.val (), $('#loading_data'), true));

    google.maps.event.addListener (_panorama, 'position_changed', function () {
      $latitude.val (_panorama.getPosition ().lat ());
      $longitude.val (_panorama.getPosition ().lng ());
    });

    google.maps.event.addListener (_panorama, 'pov_changed', function () {
      clearTimeout (_povChangedTimer);
      _povChangedTimer = setTimeout (function () {
        $heading.val (_panorama.getPov().heading);
        $pitch.val (_panorama.getPov().pitch);
        $zoom.val (_panorama.getPov().zoom);
      }, 500);
    });
    
    $('#control').submit (function () {

      if (!_hasView) {
        $error.text ('此處沒有任何街景，請選擇有街景的地區！').addClass ('show');
        return false;
      }

      if (!($latitude.val () && $longitude.val ())) {
        $error.text ('錯誤，未取得到經緯度！').addClass ('show');
        return false;
      }

      if (!($heading.val () && $pitch.val () && $zoom.val ())) {
        $error.text ('錯誤，未取得到街景角度！').addClass ('show');
        return false;
      }

      return true;
    });
    
    $loading.fadeOut (function () {
      $(this).hide (function () {
        $(this).remove ();
        getGoals (_map, $marker.val (), $('#loading_data'), true);
      });
    });
  }

  google.maps.event.addDomListener (window, 'load', initialize);
});
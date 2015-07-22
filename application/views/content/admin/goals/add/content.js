/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  var $map = $('#map');
  var $options = $('#options');
  var $title = $('#title');
  var $latitude = $('#latitude');
  var $longitude = $('#longitude');
  var $address = $('#address');
  var $pictures = $('#pictures');
  var $pictureLinks = $('#picture_links');
  var $links = $('#links');
  var $error = $('#error');
  var $loading = $('<div />').attr ('id', 'loading')
                             .append ($('<div />'))
                             .appendTo ('#container');
  
  var _map = null;
  var _marker = null;

  function updateLatLng (position) {
    $latitude.val (position.lat ());
    $longitude.val (position.lng ());

    new google.maps.Geocoder ().geocode ({'latLng': position}, function (result, status) {
      if ((status == google.maps.GeocoderStatus.OK) && result.length)
        $address.val (result[0].formatted_address);
    });
    mapGo (_map, position);
  }

  function initMarker (position) {
    updateLatLng (position);
    
    if (_marker)
      return _marker.setPosition (position);
    
    _marker = new google.maps.Marker ({
        map: _map,
        draggable: true,
        position: position
      });

    google.maps.event.addListener (_marker, 'dragend', function () {
      updateLatLng (_marker.position);
    });

    $options.addClass ('show');
  }

  function initialize () {
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

    var last = getLastPosition ('goal_admin_map');

    if (last) {
      _map.setCenter (new google.maps.LatLng (last.lat, last.lng));
      _map.setZoom (last.zoom);
    } else {
      navigator.geolocation.getCurrentPosition (function (position) {
        _map.setZoom (14);
        mapGo (_map, new google.maps.LatLng (position.coords.latitude, position.coords.longitude), function (map) {
          setStorage.apply (this, ['goal_admin_map', {
            lat: map.center.lat (),
            lng: map.center.lng (),
            zoom: map.zoom
          }]);
        });
      });
    }

    if ($latitude.val () && $longitude.val ()) {
      _map.setCenter (new google.maps.LatLng ($latitude.val (), $longitude.val ()));
      initMarker (_map.center);
    }
    google.maps.event.addListener(_map, 'click', function (e) {
      initMarker (e.latLng);
    });

    google.maps.event.addListener(_map, 'zoom_changed', getGoals.bind (this, _map, 0, $('#loading_data')));
    google.maps.event.addListener(_map, 'idle', getGoals.bind (this, _map, 0, $('#loading_data')));

    $options.submit (function () {

      if (!($latitude.val () && $longitude.val ())) {
        $error.text ('請點選地圖，選擇地點！').addClass ('show');
        return false;
      }

      if (!$title.val ()) {
        $error.text ('請輸入標題！').addClass ('show');
        return false;
      }

      return true;
    });

    $('#choice_picture').click (function () {
      $('<div />').addClass ('picture')
                  .append ($('<div />').addClass ('l').append ($('<input />').attr ('type', 'file').attr ('name', 'pictures[]').attr ('accept', 'image/gif, image/jpeg, image/png').val ('')))
                  .append ($('<div />').addClass ('r').append ($('<button />').addClass ('icon-bin')))
                  .appendTo ($pictures).find ('input').last ().click ();
    });
    $pictures.on ('click', 'button', function () {
      $(this).parents ('.picture').remove ();
    });
    
    $('#add_links').click (function () {
      var link = prompt ('請輸入參考鏈結..', '');
      $('<div />').addClass ('link')
                  .append ($('<div />').addClass ('l').append ($('<input />').attr ('type', 'text').attr ('name', 'links[]').attr ('placeholder', '請輸入參考鏈結..').val (link)))
                  .append ($('<div />').addClass ('r').append ($('<button />').addClass ('icon-bin')))
                  .appendTo ($links);
    });
    $links.on ('click', 'button', function () {
      $(this).parents ('.link').remove ();
    });

    $('#choice_picture_link').click (function () {
      var link = prompt ('請輸入照片鏈結..', '');
      $('<div />').addClass ('picture_link')
                  .append ($('<div />').addClass ('l').append ($('<input />').attr ('type', 'text').attr ('name', 'picture_links[]').attr ('placeholder', '請輸入照片鏈結..').val (link)))
                  .append ($('<div />').addClass ('r').append ($('<button />').addClass ('icon-bin')))
                  .appendTo ($pictureLinks);
    });
    $pictureLinks.on ('click', 'button', function () {
      $(this).parents ('.picture_link').remove ();
    });

    $loading.fadeOut (function () {
      $(this).hide (function () {
        $(this).remove ();
        getGoals (_map, 0, $('#loading_data'));
      });
    });
  }

  google.maps.event.addDomListener (window, 'load', initialize);
});
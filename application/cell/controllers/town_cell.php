<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Town_cell extends Cell_Controller {

  /* render_cell ('town_cell', 'update_weather', array ()); */
  // public function _cache_update_weather () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function update_weather ($town) {
    $this->CI->load->library ('phpQuery');
    $base_url = 'http://www.cwb.gov.tw';

    $url = 'http://www.cwb.gov.tw/m/f/town368/GT/' . $town->cwb_town_id . '.htm?_=' . time ();
    $get_html_str = str_replace ('&amp;', '&', urldecode (file_get_contents ($url)));
    
    if (!$get_html_str)
      return $town->weather;

    $php_query = phpQuery::newDocument ($get_html_str);
    $img = pq ('.icon img', $php_query);
    $describe = pq ('.icon-text-1', $php_query);
    $degree = pq ('.degree', $php_query);
    $humidity = pq ('.humidity', $php_query);
    $rainfall = pq ('.rainfall', $php_query);
    $sunrise = pq ('.sunrise', $php_query);
    $sunset = pq ('.sunset', $php_query);

    if (!(count ($img) && count ($describe) && count ($degree) && count ($humidity) && count ($rainfall) && count ($sunrise) && count ($sunset)))
      return $town->weather;

    $img_url = $base_url . $img->attr ('src');
    $describe_text = $describe->text ();
    $degree_text = $degree->text ();
    $humidity_text = $humidity->text ();
    $rainfall_text = $rainfall->text ();
    $sunrise_text = $sunrise->text ();
    $sunset_text = $sunset->text ();

    $params = array (
        'town_id' => $town->id,
        'icon' => $img_url,
        'describe' => $describe_text,
        'temperature' => $degree_text,
        'humidity' => $humidity_text,
        'rainfall' => $rainfall_text,
        'sunrise' => $sunrise_text,
        'sunset' => $sunset_text
      );

    if (!verifyCreateOrm ($weather = TownWeather::create ($params)))
      return $town->weather;

    if (!$weather->icon->put_url ($img_url))
      $weather->destroy ();

    return $town->weather;
  }
}
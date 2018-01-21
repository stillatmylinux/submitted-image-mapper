<?php

function sim_map_center_lat() {
    echo get_option('sim-map-center-lat');
}

function sim_map_center_lng() {
    echo get_option('sim-map-center-lng');
}

function test_geo_pics() {
    $pic = ABSPATH . '/wp-content/uploads/2018/01/155323undefined.jpg';
    $pic = ABSPATH . '/wp-content/uploads/2018/01/1603551515276235167.jpg';
    $pic = ABSPATH . '/wp-content/uploads/2018/01/1612201515276740014.jpg';
    $pic = ABSPATH . '/wp-content/uploads/2016/05/1463682443193.jpg';
    $pic = ABSPATH . '/wp-content/uploads/2018/01/2146351515469595262.jpg';
    // $pic = 'wp-content/uploads/2016/05/1463682443193.jpg';
    // $pic = 'wp-content/uploads/2016/09/1473361700-cdv_photo_004.jpg';
    // $pic = 'wp-content/uploads/2016/01/14456514951051445651495.jpg';
    // $pic = '/Users/matt/Desktop/1456561489528616719.jpg';
    

    @var_dump(get_image_location($pic));

    // @$exif = exif_read_data($pic, 'IFD0');
    // echo $exif===false ? "No header data found.<br />\n" : "Image contains headers<br />\n";
    
    // @$exif = exif_read_data($pic, 0, true);
    
    // var_dump($exif['GPS']);
    
    // echo "$pic<br />\n";
    // foreach ($exif as $key => $section) {
    //     foreach ($section as $name => $val) {
    //         echo "$key.$name: $val<br />\n";
    //     }
    // }
    
    // echo '<hr>';
    // var_dump(get_image_location($pic));

}

// test_geo_pics();
  

function get_image_location($file) {
    if (is_file($file)) {
		@$info = exif_read_data($file, "EXIF");
		
		if ($info !== false) {
            $direction = array('N', 'S', 'E', 'W');
            if (isset($info['GPSLatitude'], $info['GPSLongitude'], $info['GPSLatitudeRef'], $info['GPSLongitudeRef']) &&
                in_array($info['GPSLatitudeRef'], $direction) && in_array($info['GPSLongitudeRef'], $direction)) {

                $lat_degrees_a = explode('/',$info['GPSLatitude'][0]);
                $lat_minutes_a = explode('/',$info['GPSLatitude'][1]);
                $lat_seconds_a = explode('/',$info['GPSLatitude'][2]);
                $lng_degrees_a = explode('/',$info['GPSLongitude'][0]);
                $lng_minutes_a = explode('/',$info['GPSLongitude'][1]);
                $lng_seconds_a = explode('/',$info['GPSLongitude'][2]);

                $lat_degrees = $lat_degrees_a[0] / $lat_degrees_a[1];
                $lat_minutes = $lat_minutes_a[0] / $lat_minutes_a[1];
                $lat_seconds = $lat_seconds_a[0] / $lat_seconds_a[1];
                $lng_degrees = $lng_degrees_a[0] / $lng_degrees_a[1];
                $lng_minutes = $lng_minutes_a[0] / $lng_minutes_a[1];
                $lng_seconds = $lng_seconds_a[0] / $lng_seconds_a[1];

                $lat = (float) $lat_degrees + ((($lat_minutes * 60) + ($lat_seconds)) / 3600);
                $lng = (float) $lng_degrees + ((($lng_minutes * 60) + ($lng_seconds)) / 3600);
                $lat = number_format($lat, 7);
                $lng = number_format($lng, 7);

                //If the latitude is South, make it negative. 
                //If the longitude is west, make it negative
                $lat = $info['GPSLatitudeRef'] == 'S' ? $lat * -1 : $lat;
                $lng = $info['GPSLongitudeRef'] == 'W' ? $lng * -1 : $lng;

                return array(
                    'lat' => $lat,
                    'lng' => $lng
                );
            }
        }
    }

    return false;
}
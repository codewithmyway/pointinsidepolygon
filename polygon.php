<?php

// Get the latitude and longitude from the POST data
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Define the polygon coordinates
$polygonCoords = [
    ['lat' => 23.31481938082571, 'lng' => 83.21939773559572],
    ['lat' => 23.307173417137452, 'lng' => 83.22107143402101],
    ['lat' => 23.304887425102784, 'lng' => 83.22042770385744],
    ['lat' => 23.303744414351616, 'lng' => 83.21772403717043],
    ['lat' => 23.30342909931245, 'lng' => 83.2148916244507]

];

// Check if the point is inside the polygon
if (isPointInPolygon($latitude, $longitude, $polygonCoords)) {
    echo 'Point inside';
} else {
    echo 'Point outside';
}

// Function to check if a point is inside a polygon
function isPointInPolygon($latitude, $longitude, $polygonCoords) {
    $isInside = false;

    // Sort the polygon vertices in counter-clockwise order
    usort($polygonCoords, function($a, $b) {
        return ($a['lng'] + $b['lng']) * ($a['lat'] - $b['lat']);
    });

    $n = count($polygonCoords);
    $j = $n - 1;

    for ($i = 0; $i < $n; $i++) {
        $xi = $polygonCoords[$i]['lat'];
        $yi = $polygonCoords[$i]['lng'];
        $xj = $polygonCoords[$j]['lat'];
        $yj = $polygonCoords[$j]['lng'];

        if (($yi < $longitude && $yj >= $longitude || $yj < $longitude && $yi >= $longitude) &&
            ($xi + ($longitude - $yi) / ($yj - $yi) * ($xj - $xi) < $latitude)) {
            $isInside = !$isInside;
        }

        $j = $i;
    }

    return $isInside;
}

?>

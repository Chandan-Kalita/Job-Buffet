<?php 

function genErrorList($errors){
    $html = "<ul style='color:red'>";
    foreach ($errors as $key => $value) {
        $html .= "<li>".ucwords($key)."<ul>";
        foreach($value as $msg){
            $html .= "<li>$msg</li>";
        }
        $html .= "</ul></li>";
    }
    $html .= "</ul>";
    return $html;
}

//return distance in meter
function haversineGreatCircleDistance(
    $latitudeFrom,
    $longitudeFrom,
    $latitudeTo,
    $longitudeTo,
    $earthRadius = 6371000
) {
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
}
?>
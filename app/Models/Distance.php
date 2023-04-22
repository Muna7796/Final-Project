<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;
use NominatimLaravel\Content\Nominatim;
use App\Models\BloodBank;
use App\Models\User;

class Distance extends Model
{
    use HasFactory;

   public static function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit='Km') {

    $theta = $longitude1 - $longitude2;
    $distance = sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta));

    $distance = acos($distance); 
    $distance = rad2deg($distance); 
    $distance = $distance * 60 * 1.1515;

    switch($unit)
    { 
        case 'Mi': break;
        case 'Km' : $distance = $distance * 1.609344; 
    }

    return (round($distance,2)); 
}
public static function getUserNerestDistance($userlat, $userlng, $location){
  
    $UserCoord = array($userlat, $userlng); //stores user coord;
   
    $location = $location;
    $bloodcoord = BloodBank::select('lat', 'lng', 'name')->get();

    //find user coord
    $url = "http://nominatim.openstreetmap.org/";
    $nominatim = new Nominatim($url);

    $search = $nominatim->newSearch()
        ->country('Nepal')
        ->city($location)
        ->polygon('geojson')    //or 'kml', 'svg' and 'text'
        ->addressDetails();


    $result = $nominatim->find($search);

    if($result){
       
    array_push($UserCoord, $result[0]['lat'], $result[0]['lon']); //gather user coord
    }
    else{
        dd('Address not found');
    }


    //haversine
    function haversineDistance($lat1, $lon1, $lat2, $lon2)

    {
        
        $earthRadius = 6371; // radius of the earth in kilometers


        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);

        $a = sin($latDiff / 2) * sin($latDiff / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c; // distance in kilometers

        return $distance;

    }

    $bestDistance = INF;
    $closestLocationName = "";

    foreach ($bloodcoord as $blood) {
        $distance = haversineDistance($result[0]['lat'], $result[0]['lon'], $blood['lat'], $blood['lng']);

        if ($distance < $bestDistance) {
            $bestDistance = $distance;
            $closestLocationName = $blood['name'];
        }
    }

    return "Our location " . $location . ', Nearest blood bank ' . $closestLocationName;
}
}

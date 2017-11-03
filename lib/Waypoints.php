<?php

namespace Iupick;

class Waypoints{

    public static function getWayPointInformation($waypointId){
        $url = Iupick::getBaseUrl() . 'waypoints/' . $waypointId . '/';
        $authHeader = Iupick::generateAuthHeader('public');
        $response = Iupick::callApi($url, $authHeader, 'get');
        return \json_decode($response, true);
    }

    public static function getWaypointsLite(){
        $url = Iupick::getBaseUrl() . 'waypoints/lite/';
        $authHeader = Iupick::generateAuthHeader('public');
        $response = Iupick::callApi($url, $authHeader, 'get');
        return \json_decode($response, true);
    }

    public static function getWaypointsByPostalCode($postalCode){
        $url = Iupick::getBaseUrl() . 'waypoints/postal-ids/' . $postalCode . '/';
        $authHeader = Iupick::generateAuthHeader('public');
        $response = Iupick::callApi($url, $authHeader, 'get');
        return \json_decode($response, true);
    }
}

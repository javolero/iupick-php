<?php

namespace Iupick;

class Shipment
{
    
    public static function create(int $length, int $width, int $height, int $weight)
    {
        $url = Iupick::getBaseUrl() . 'create-shipment-token/';
        $authHeader = Iupick::generateAuthHeader('secret');
        $data = [
            'length'=> $length,
            'width'=> $width,
            'height'=> $height,
            'weight'=> $weight
        ];
        $response = Iupick::callApi($url, $authHeader, 'post', $data);
        return \json_decode($response, true);
    }

    public static function addInformation(array $information)
    {
        if (isset($information['waypointId']) || isset($information['recipientAddress'])) {
            if (!isset($information['recipientAddress'])) {
                $information['recipientAddress'] = Iupick::emptyAddress();
            }
            $url = Iupick::getBaseUrl() . 'fill-shipment-information/' . $information['shipmentToken'] . '/';
            $authHeader = Iupick::generateAuthHeader('public');
            $data = [
                'waypoint' => $information['waypointId'],
                'shipper_address' => $information['shipperAddress'],
                'shipper_contact' => $information['shipperContact'],
                'recipient_address' => $information['recipientAddress'],
                'recipient_contact' => $information['recipientContact'],
                'third_party_reference' => $information['thirdPartyReference'],
            ];
            $response = Iupick::callApi($url, $authHeader, 'post', $data);
            return \json_decode($response, true);
        }
        return false;
    }

    public static function generateWaybill($confirmationToken){
        $url = Iupick::getBaseUrl() . 'generate-waybill/' . $confirmationToken . '/';
        $authHeader = Iupick::generateAuthHeader('secret');
        $response = Iupick::callApi($url, $authHeader, 'post');
        return \json_decode($response, true);
    }

    public static function track($carrier, $trackingNumber){
        $url = Iupick::getBaseUrl() . 'track-shipment/';
        $query = http_build_query([
            'carrier' => $carrier,
            'tracking_number' => $trackingNumber,
        ]);
        $url .= '?' . $query;
        $authHeader = Iupick::generateAuthHeader('public');
        $response = Iupick::callApi($url, $authHeader, 'get');
        return \json_decode($response, true);
    }

    public static function confirmShipmentWaypoint($waypointId, $orderId){
        $url = Iupick::getBaseUrl() . 'waypoint-confirmation/';
        $data = [
            'waypoint' => $waypointId,
            'order_id' => $orderId,
        ];
        $authHeader = Iupick::generateAuthHeader('secret');
        $response = Iupick::callApi($url, $authHeader, 'post', $data);
        return \json_decode($response, true);
    }
}

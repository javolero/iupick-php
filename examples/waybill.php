<?php

require_once '../vendor/autoload.php';

Iupick\Iupick::setSecretToken('sk_sandbox_4bdcd3630417c5119029859c08a7b8d9d97dda79');
Iupick\Iupick::setPublicToken('315cdf3ca4dd588ab8e6f7fa4b7aa433c641cadd');
Iupick\Iupick::setEnviroment('sandbox');

$shipmentToken = Iupick\Shipment::create(14,12,13,2);

var_dump($shipmentToken);
$shipmentToken = $shipmentToken['shipment_token'];
$shipperAddress = Iupick\Iupick::createAddress(
    'Querétaro',
    'Epigmenio Gonzáles 500',
    96558,
    '',
    'Momma'
);


$shipperContact = Iupick\Iupick::createPerson(
    'Tony Stark',
    '555555555',
    'tony@fakemail.com',
    'CEO',
    'Stark Industries',
    '123'
);

$recipientContact = Iupick\Iupick::createPerson(
    'Steve Rogers',
    '555555555',
    'steve@fakemail.com',
    'Agent',
    'SHIELD',
    '123'
);

$addInformation = Iupick\Shipment::addInformation([
    'shipmentToken' => $shipmentToken,
    'waypointId' => 486,
    'shipperAddress' => $shipperAddress,
    'shipperContact' => $shipperContact,
    'recipientContact' => $recipientContact,
    'thirdPartyReference' => "I am a shipment"
]);

var_dump($addInformation);

$waybill = Iupick\Shipment::generateWaybill($shipmentToken);
$carrier = $waybill['carrier'];
$trackingNumber = $waybill['tracking_number'];
var_dump($waybill);

$track = Iupick\Shipment::track('Estafeta', '8055241528464720099314');
var_dump($track);


$confirmToken = Iupick\Shipment::confirmShipmentWaypoint(486, 'Order123');
var_dump($confirmToken);

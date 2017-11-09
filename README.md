# Iupick PHP

The iupick PHP Library wraps the iupick API to facilitate access from applications written in PHP.

Keep in mind that this package requires iupick secret keys, contact
info@iupick.com for more information.

## Installation

TODO

## Usage

Import the library and add your secret and public tokens.

``` php
require_once 'iupick'

Iupick\Iupick::setSecretToken('sk_sandbox_4bdcd3630417c5119029859c08a7b8d9d97dda79');
Iupick\Iupick::setPublicToken('315cdf3ca4dd588ab8e6f7fa4b7aa433c641cadd');
Iupick\Iupick::setEnviroment('sandbox');
```

Methods require either your Public or your Secret token, never expose your secret token.

Methods that require your secret_token should never be done from the front-end. Since this methods deal with sensitive information.

### Waypoints

The Waypoints resource allows you to interact with all the delivery points from
our network that are available to your account.

To pull the full information for a single waypoint. Use `getWaypointInformation`
It requires the waypoint unique id.

``` php
$waypoints = Iupick\Waypoints::getWayPointInformation(13);
```

To get a list of all the coordinates of available waypoints, use
`getWaypointsLite`.

``` php
$waypointsLite = Iupick\Waypoints::getWaypointsByPostalCode(76140)
```

You can get all the waypoints close to a Postal Code with
`getPostalCodeWaypoints`.

``` php
$waypointsCP = Iupick\Waypoints::getWayPointsLite())
```

## External Shipments

If you want to generate a shipment to one of iupick delivery points, but not through our Waybill API, you will need to create a confirmation token so our points are able to receive your package.

``` php
$confirmToken = Iupick\Shipment::confirmShipmentWaypoint(486, 'ORDER666');
var_dump($confirmToken);
```

## Shipments with iupick

The iupick API allows the generation of waybills and tracking with our available carriers.

The waybill generation occurs on three steps:


### Step 1.

Create a shipment on the iupick platform and receive a
shipment token.

``` php
$shipmentToken = Iupick\Shipment::create(14,12,13,2);
```

### Step 2.

Fill the rest of the information required to generate a waybill,
and receive a confirmation token.

You can send a shipment either to an arbitrary direction or to one
of our waypoints; just replace the waypoint_id attribute for a recipient
address.

``` php
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

```

### Step 3.

Generate your waybill with your confirmation token.

``` php
$waybill = Iupick\Shipment::generateWaybill($shipmentToken);
```

### Tracking your shipment

In order to track a shipment send the carrier and the tracking number.

``` php
$track = Iupick\Shipment::track('Estafeta', '8055241528464720099314');
```

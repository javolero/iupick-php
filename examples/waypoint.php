<?php

require_once '../vendor/autoload.php';

Iupick\Iupick::setSecretToken('sk_sandbox_4bdcd3630417c5119029859c08a7b8d9d97dda79');
Iupick\Iupick::setPublicToken('315cdf3ca4dd588ab8e6f7fa4b7aa433c641cadd');
Iupick\Iupick::setEnviroment('sandbox');

var_dump(Iupick\Waypoints::getWayPointInformation(13));
var_dump(Iupick\Waypoints::getWaypointsByPostalCode(76140));
var_dump(Iupick\Waypoints::getWayPointsLite());

<?php

$crsUrl = 'https://ifc.centralchinahotels.com/KWS_train/';

$service = [
    'SecurityService' => $crsUrl . 'SecurityService.asmx',
    'ProfileService' => $crsUrl . 'ProfileService.asmx',
    'AvailabilityService' => $crsUrl . 'AvailabilityService.asmx',
];

return $service;

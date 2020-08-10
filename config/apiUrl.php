<?php

$crsUrl = 'https://ifc.centralchinahotels.com/KWS_train/';

$service = [
    'SecurityService' => $crsUrl . 'SecurityService.asmx',
    'ProfileService' => $crsUrl . 'ProfileService.asmx',
];

return $service;

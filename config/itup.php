<?php

return [
    'domain' => 'itup.ca',
    'hosted_zone_id' => env('HOSTED_ZONE_ID', ''),
    'blocked_hostnames' => ['dev', 'www', 'mail', 'mx'],
];

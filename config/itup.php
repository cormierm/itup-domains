<?php

return [
    'domain' => env('DOMAIN', 'domain-not-set.test'),
    'hosted_zone_id' => env('HOSTED_ZONE_ID', ''),
    'blocked_hostnames' => ['dev', 'www', 'mail', 'mx'],
];

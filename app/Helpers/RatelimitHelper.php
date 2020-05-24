<?php

namespace App\Helpers;

use CQ\Middleware\RateLimit;

class RatelimitHelper extends RateLimit
{
    public function valid($request)
    {
        $this->loadConfig($request);

        $fingerprint = $this->fingerprintRequest($request);
        $validated_request = $this->validateRequest($fingerprint);

        return $validated_request['valid'];
    }
}

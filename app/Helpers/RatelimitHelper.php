<?php

namespace App\Helpers;

use CQ\Middleware\RateLimit;

class RatelimitHelper extends RateLimit
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function valid()
    {
        $this->loadConfig($this->request);

        $fingerprint = $this->getFingerprint();
        $validated_request = $this->validateRequest($fingerprint);

        return $validated_request['valid'];
    }

    public function getFingerprint()
    {
        return $this->fingerprintRequest($this->request);
    }
}

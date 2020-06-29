<?php

namespace App\Validators;

use CQ\Validators\Validator;
use Respect\Validation\Validator as v;

class LinkValidator extends Validator
{
    /**
     * Validate json submission.
     *
     * @param object $data
     */
    public static function create($data)
    {
        $v = v::attribute('long_url', v::url()->length(1, 2048))
            ->attribute('short_url', v::optional(v::alnum()->length(1, 255)))
        ;

        self::validate($v, $data);
    }

    /**
     * Validate json submission.
     *
     * @param object $data
     */
    public static function update($data)
    {
        $v = v::attribute('expires_at', v::optional(v::stringType()->length(1, 255)))
            ->attribute('password', v::optional(v::stringType()->length(1, 255)))
        ;

        self::validate($v, $data);
    }

    /**
     * Validate json submission.
     *
     * @param object $data
     */
    public static function ratelimit($data)
    {
        $v = v::attribute('state', v::alnum()->length(1, 32))
            ->attribute('fingerprint', v::alnum()->length(1, 50))
            ->attribute('original_option', v::optional(v::oneOf(v::equals('qr'), v::equals('confirm'))))
            ->attribute('h-captcha-response', v::stringType())
        ;

        self::validate($v, $data);
    }

    /**
     * Validate json submission.
     *
     * @param object $data
     */
    public static function password($data)
    {
        $v = v::attribute('state', v::alnum()->length(1, 32))
            ->attribute('password', v::stringType()->length(1, 255))
        ;

        self::validate($v, $data);
    }
}

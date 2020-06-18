<?php

namespace App\Validators;

use CQ\Validators\Validator;
use Respect\Validation\Validator as v;

class LinkValidator extends Validator
{
    /**
     * Validate json submission
     *
     * @param object $data
     *
     * @return void
     */
    public static function create($data)
    {
        $v = v::attribute('long_url', v::url()->length(1, 2048))
            ->attribute('short_url', v::optional(v::alnum()->length(1, 255)));

        self::validate($v, $data);
    }

    /**
     * Validate json submission
     *
     * @param object $data
     *
     * @return void
     */
    public static function update($data)
    {
        $v = v::attribute('long_url', v::optional(v::url()->length(1, 2048)))
            ->attribute('short_url', v::optional(v::alnum()->length(1, 255)));

        self::validate($v, $data);
    }

    /**
     * Validate json submission
     *
     * @param object $data
     *
     * @return void
     */
    public static function ratelimit($data)
    {
        $v = v::attribute('long_url', v::optional(v::url()->length(1, 2048)))
            ->attribute('short_url', v::optional(v::alnum()->length(1, 255)));

        // TODO: state,fingerprint,original_option (qr, confirm),h-captcha-response

        self::validate($v, $data);
    }

    /**
     * Validate json submission
     *
     * @param object $data
     *
     * @return void
     */
    public static function password($data)
    {
        $v = v::attribute('long_url', v::optional(v::url()->length(1, 2048)))
            ->attribute('short_url', v::optional(v::alnum()->length(1, 255)));


        // TODO: state, password

        self::validate($v, $data);
    }
}

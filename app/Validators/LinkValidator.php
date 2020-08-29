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
}

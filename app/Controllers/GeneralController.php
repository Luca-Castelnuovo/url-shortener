<?php

namespace App\Controllers;

use CQ\Controllers\General;

class GeneralController extends General
{
    /**
     * Index screen
     * 
     * @param object $request
     * 
     * @return Redirect
     */
    public function index($request)
    {
        $code = $request->getQueryParams()['code'] ?: '';

        if ($code) {
            return $this->redirect("/auth/callback?code={$code}");
        }

        return $this->redirect('https://lucacastelnuovo.nl');
    }
}

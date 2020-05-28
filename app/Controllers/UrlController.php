<?php

namespace App\Controllers;

use CQ\DB\DB;
use CQ\Config\Config;
use CQ\Captcha\hCaptcha;
use CQ\Helpers\Password;
use CQ\Controllers\Controller;
use App\Helpers\RatelimitHelper;
use App\Validators\UrlValidator;

class UrlController extends Controller
{
    /**
     * url redirect
     * 
     * @param object $request
     * @param string $short_url
     * @param string $option
     * 
     * @return Redirect|Html
     */
    public function index($request, $short_url, $option)
    {
        $url = DB::get(
            'urls',
            ['expires_at', 'password', 'long_url'],
            ['short_url' => $short_url]
        );

        if (!$url) {
            return $this->redirect('/error/404', 404);
        }

        if ($url['expires_at'] > time()) { // TODO: if expired - return 404
            return $this->redirect('/error/404', 404);
        }


        $ratelimit = new RatelimitHelper();
        if (!$ratelimit->valid($request)) {
            if (!hCaptcha::v1(
                Config::get('captcha.secret_key'),
                $request->data->{'h-captcha-response'}
            )) {
                // ask for captcha
            }
        }

        if ($url['password']) {
            if (Password::check($request->data->password, $url['password'])) {
                // ask for password
            }
        }

        if ($option === 'qr') {
            // gen qr for full link
        }

        if ($option === 'confirm') {
            // use state

            // show user short, full, screenshot of destination
            // ask for confirmation before redirect
        }

        // TODO: analytics

        return $this->redirect($url['long_url']);
    }

    /**
     * Create short url
     * 
     * @param object $request
     *
     * @return Json
     */
    public function create($request)
    {
        //validator

        // if short_url provided - check doesn't exist
        // if not provided - gen short_url
        // create: long url, short_url, expiry time, password
    }

    /**
     * Update short url
     * 
     * @param object $request
     * @param string $id
     *
     * @return Json
     */
    public function update($request, $id)
    {
        // validator

        // id is in uuid form
        // if new short_url - check doesn't exist
        // update: long url, short_url, expiry time, password
    }

    /**
     * Delete short url
     * 
     * @param object $request
     * @param string $id
     *
     * @return Json
     */
    public function delete($request, $id)
    {
        // id is in uuid form
        // delete if owned
    }
}

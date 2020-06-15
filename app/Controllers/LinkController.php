<?php

namespace App\Controllers;

use Exception;
use CQ\DB\DB;
use CQ\Config\Config;
use CQ\Captcha\hCaptcha;
use CQ\Helpers\UUID;
use CQ\Helpers\Session;
use CQ\Helpers\Password;
use CQ\Controllers\Controller;
use App\Helpers\RatelimitHelper;
use App\Validators\LinkValidator;

class LinkController extends Controller
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

        if ($url['expires_at'] > date('Y-m-d H:i:s')) { // TODO: test
            return $this->redirect('/error/404', 404);
        }


        // $ratelimit = new RatelimitHelper();
        // if (!$ratelimit->valid($request)) {
        //     if (!hCaptcha::v1(
        //         Config::get('captcha.secret_key'),
        //         $request->data->{'h-captcha-response'}
        //     )) {
        //         // ask for captcha
        //     }
        // }

        // if ($url['password']) {
        //     if (Password::check($request->data->password, $url['password'])) {
        //         // ask for password
        //     }
        // }

        if ($option === 'qr') {
            // gen qr for full link
        }

        if ($option === 'confirm') {
            // use state

            // show user short, full, screenshot of destination
            // ask for confirmation before redirect
            // confirmation should contain state
        }

        DB::update('links', [
            'clicks[+]' => 1
        ], [
            'short_url' => $short_url
        ]);

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
        try {
            LinkValidator::create($request->data);
        } catch (Exception $e) {
            return $this->respondJson(
                'Provided data was malformed',
                json_decode($e->getMessage()),
                422
            );
        }

        if (!$request->data->short_url) {
            $request->data->short_url = 'random';
        }

        // check doesn't exist
        // return error

        DB::create('projects', [
            'id' => UUID::v6(),
            'user_id' => Session::get('id'),
            'short_url' => $request->data->short_url,
            'long_url' => $request->data->long_url
        ]);

        return $this->respondJson(
            'Link Created',
            ['reload' => true]
        );
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
        try {
            LinkValidator::update($request->data);
        } catch (Exception $e) {
            return $this->respondJson(
                'Provided data was malformed',
                json_decode($e->getMessage()),
                422
            );
        }

        if (!DB::has('links', [
            'id' => $id,
            'user_id' => Session::get('id')
        ])) {
            return $this->respondJson(
                'Link not found',
                [],
                404
            );
        }

        // check id exists and is owned

        // id is in uuid form
        // if new short_url - check doesn't exist
        // update: long url, short_url, expiry time, password

        return $this->respondJson(
            'Link Updated',
            ['reload' => true]
        );
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
        if (!DB::has('links', [
            'id' => $id,
            'user_id' => Session::get('id')
        ])) {
            return $this->respondJson(
                'Link not found',
                [],
                404
            );
        }

        DB::delete('links', [
            'id' => $id,
            'user_id' => Session::get('id')
        ]);

        return $this->respondJson(
            'Link Deleted',
            ['reload' => true]
        );
    }
}

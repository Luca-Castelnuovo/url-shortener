<?php

namespace App\Controllers;

use Exception;
use CQ\DB\DB;
use CQ\Config\Config;
use CQ\Captcha\hCaptcha;
use CQ\Helpers\Str;
use CQ\Helpers\UUID;
use CQ\Helpers\State;
use CQ\Helpers\Session;
use CQ\Helpers\Password;
use CQ\Controllers\Controller;
use App\Helpers\RatelimitHelper;
use App\Validators\LinkValidator;

class LinkController extends Controller
{
    /**
     * Link screen
     * 
     * @param object $request
     * 
     * @return Html
     */
    public function view($request)
    {
        $state = $request->getQueryParams()['s'] ?: '';
        $error = $request->getQueryParams()['e'] ?: '';
        $short_url = $request->getQueryParams()['k'] ?: '';
        $long_url = $request->getQueryParams()['l'] ?: '';
        $option = $request->getQueryParams()['o'] ?: '';
        $original_option = $request->getQueryParams()['oo'] ?: '';
        $fingerprint = $request->getQueryParams()['f'] ?: '';

        if (!State::valid($state)) {
            return $this->redirect('/');
        }

        switch ($error) {
            case 'not_found':
                $error = 'The requested link could not be found!';
                break;

            case 'expired':
                $error = 'The requested link has expired!';
                break;

            default:
                $error = '';
                break;
        }

        return $this->respond('link.twig', [
            'state' => State::set(),
            'error' => $error,
            'short_url' => Config::get('app.url') . "/{$short_url}",
            'long_url' => $long_url,
            'option' => $option,
            'original_option' => $original_option,
            'fingerprint' => $fingerprint,
            'site_key' => Config::get('captcha.site_key')
        ]);
    }

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
        $link = DB::get(
            'links',
            ['expires_at', 'password', 'long_url'],
            ['short_url' => $short_url]
        );

        if (!$link) {
            $state = State::set();

            return $this->redirect("/l?s={$state}&k={$short_url}&e=not_found", 404);
        }

        if ($link['expires_at'] && $link['expires_at'] > date('Y-m-d H:i:s')) {
            $state = State::set();

            return $this->redirect("/l?s={$state}&k={$short_url}&e=expired", 404);
        }

        if ($option === 'ratelimit') {
            if (!State::valid($request->data->state)) {
                return $this->respondJson(
                    'Incorrect State',
                    ['redirect' => Config::get('app.url') . "/{$short_url}"]
                );
            }

            if (!hCaptcha::v1(
                Config::get('captcha.secret_key'),
                $request->data->{'h-captcha-response'}
            )) {
                return $this->respondJson(
                    'Captcha Failed',
                    ['redirect' => Config::get('app.url') . "/{$short_url}"]
                );
            }

            DB::delete('cq_ratelimit', [
                'fingerprint' => $request->data->fingerprint
            ]);

            return $this->respondJson(
                'Captcha Completed',
                ['redirect' => Config::get('app.url') . "/{$short_url}/{$request->data->original_option}"]
            );
        }

        $ratelimit = new RatelimitHelper($request);
        if (!$ratelimit->valid()) {
            $state = State::set();
            $fingerprint = $ratelimit->getFingerprint();

            return $this->redirect("/l?s={$state}&k={$short_url}&o=ratelimit&oo={$option}&f={$fingerprint}", 429);
        }

        if ($option === 'password') {
            if (!State::valid($request->data->state)) {
                return $this->respondJson(
                    'Incorrect State',
                    ['redirect' => Config::get('app.url') . "/{$short_url}"]
                );
            }

            if (!Password::check($request->data->password, $link['password'])) {
                return $this->respondJson(
                    'Password Incorrect',
                    ['redirect' => Config::get('app.url') . "/{$short_url}"]
                );
            }

            return $this->respondJson(
                'Password Correct',
                ['redirect' => $link['long_url']]
            );
        }

        if ($link['password']) {
            $state = State::set();

            return $this->redirect("/l?s={$state}&k={$short_url}&o=password", 401);
        }


        DB::update('links', [
            'clicks[+]' => 1
        ], [
            'short_url' => $short_url
        ]);

        if ($option === 'qr') {
            $state = State::set();

            return $this->redirect("/l?s={$state}&k={$short_url}&o=qr&l={$link['long_url']}", 200);
        }

        if ($option === 'confirm') {
            $state = State::set();

            return $this->redirect("/l?s={$state}&k={$short_url}&o=confirm&l={$link['long_url']}", 200);
        }

        return $this->redirect($link['long_url']);
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
            $request->data->short_url = Str::random(6);
        }

        if (DB::has('links', [
            'short_url' => $request->data->short_url
        ])) {
            return $this->respondJson(
                'Short URL is already used',
                [],
                400
            );
        }

        // TODO: validate variant rank

        DB::create('links', [
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

        // TODO: build function

        DB::update('links', [
            'password' => '',
            'expires_at' => ''
        ], ['id' => $id]);

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
    public function delete($id)
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

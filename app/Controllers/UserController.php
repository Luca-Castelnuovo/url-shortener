<?php

namespace App\Controllers;

use CQ\DB\DB;
use CQ\Config\Config;
use CQ\Helpers\Session;
use CQ\Helpers\Variant;
use CQ\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Dashboard screen
     * 
     * @return Html
     */
    public function dashboard()
    {
        $links = DB::select(
            'links',
            [
                'id',
                'clicks',
                'short_url',
                'long_url',
                'password',
                'expires_at',
                'created_at'
            ],
            [
                'user_id' => Session::get('id'),
                'ORDER' => ['created_at' => 'DESC']
            ]
        );

        $variant_provider = new Variant([
            'user' => Session::get('variant'),
            'type' => 'can_edit'
        ]);

        return $this->respond('dashboard.twig', [
            'app' => Config::get('app'),
            'links' => $links,
            'can_edit' => $variant_provider->configuredValue(),
            'admin' => Session::get('variant') === 'Admin'
        ]);
    }

    /**
     * Admin screen
     * 
     * @return Html
     */
    public function admin()
    {
        $links = DB::select(
            'links',
            [
                'id',
                'clicks',
                'short_url',
                'long_url',
                'created_at'
            ],
            [
                'ORDER' => ['created_at' => 'DESC']
            ]
        );

        return $this->respond('admin.twig', [
            'app' => Config::get('app'),
            'links' => $links,
            'can_edit' => false,
            'admin' => Session::get('variant') === 'Admin'
        ]);
    }
}

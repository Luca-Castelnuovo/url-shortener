<?php

namespace App\Controllers;

use CQ\Config\Config;
use CQ\Controllers\Controller;
use CQ\DB\DB;
use CQ\Helpers\Session;
use CQ\Helpers\Roles;

class UserController extends Controller
{
    /**
     * Dashboard screen.
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
                'created_at',
            ],
            [
                'user_id' => Session::get('id'),
                'ORDER' => ['created_at' => 'DESC'],
            ]
        );

        return $this->respond('dashboard.twig', [
            'app' => Config::get('app'),
            'admin' => Roles::has('admin'),
            'links' => $links,
        ]);
    }

    /**
     * Admin screen.
     *
     * @return Html
     */
    public function admin()
    {
        if (!Roles::has('admin')) {
            return $this->redirect('/dashboard', 403);
        }

        $links = DB::select(
            'links',
            [
                'id',
                'clicks',
                'short_url',
                'long_url',
                'created_at',
            ],
            [
                'ORDER' => ['created_at' => 'DESC'],
            ]
        );

        return $this->respond('admin.twig', [
            'app' => Config::get('app'),
            'admin' => true,
            'links' => $links,
        ]);
    }
}

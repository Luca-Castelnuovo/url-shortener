<?php

namespace App\Controllers;

use CQ\Config\Config;
use CQ\Controllers\Controller;
use CQ\DB\DB;
use CQ\Helpers\User;

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
                'user_id' => User::getId(),
                'ORDER' => ['created_at' => 'DESC'],
            ]
        );

        return $this->respond('dashboard.twig', [
            'app' => Config::get('app'),
            'admin' => User::hasRole('admin'),
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
        if (!User::hasRole('admin')) {
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

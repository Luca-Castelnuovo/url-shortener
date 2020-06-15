<?php

namespace App\Controllers;

use CQ\DB\DB;
use CQ\Config\Config;
use CQ\Helpers\Session;
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
                'expires_at'
            ],
            [
                'user_id' => Session::get('id'),
                'ORDER' => ['created_at' => 'DESC']
            ]
        );

        return $this->respond('dashboard.twig', [
            'app' => Config::get('app'),
            'links' => $links
        ]);
    }
}

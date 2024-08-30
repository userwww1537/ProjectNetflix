<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function getWallet($id = 0)
    {
        if($id == 0) {
            return \App\Models\wallet_users::where('parent_id', Auth::user()->id)->first();
        }
        return \App\Models\wallet_users::where('parent_id', $id)->first();
    }

    public static function checkRole($id = 0)
    {
        if($id == 0) {
            return \App\Models\role_users::where('id', Auth::user()->role_id)->first();
        }
        return \App\Models\role_users::where('id', \App\Models\users::where('id', $id)->first()->role_id)->first();
    }

    public static function countMission()
    {
        $missions = (Auth::check() && Auth::user()->role_id <=2) ? \App\Models\missions::orderBy('id', 'desc')->get() : \App\Models\missions::where('status', 1)->orderBy('id', 'desc')->get();
        foreach($missions as $key => $mission) {
            if(Auth::check() && \App\Models\mission_users::where('user_id', Auth::user()->id)->where('parent_id', $mission->id)->first()) {
                unset($missions[$key]);
            }
        }
        return count($missions);
    }

    public static function convertTime($time)
    {
        $time = strtotime($time);
        $now = time();
        $time = $now - $time;
        if($time < 60) {
            return 'Vừa xong';
        } elseif($time < 3600) {
            return floor($time / 60) . ' phút trước';
        } elseif($time < 86400) {
            return floor($time / 3600) . ' giờ trước';
        } elseif($time < 604800) {
            return floor($time / 86400) . ' ngày trước';
        } elseif($time < 2592000) {
            return floor($time / 604800) . ' tuần trước';
        } elseif($time < 31536000) {
            return floor($time / 2592000) . ' tháng trước';
        }
        return floor($time / 31536000) . ' năm trước';
    }

    public static function checkCookie($cookie)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://www.netflix.com/tv2', [
            'headers' => [
                'Cookie' => $cookie
            ]
        ]);

        $body = $response->getBody()->getContents();

        if(stripos($body, 'tvsignup-username') !== false) {
            preg_match('/<input type="hidden" name="authURL" value="([^"]+)"/', $body, $matches);

            return [
                'status' => 200,
                'message' => 'Cookie live',
                'authUrl' => $matches[1]
            ];
        }

        return [
            'status' => 401,
            'message' => 'Cookie die',
            'authUrl' => null
        ];
    }
}

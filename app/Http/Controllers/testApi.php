<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class testApi extends Controller
{

    public function index()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://www.netflix.com/tv2');

        $body = $response->getBody()->getContents();

        echo $body;
    }
}

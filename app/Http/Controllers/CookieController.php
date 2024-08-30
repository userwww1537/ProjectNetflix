<?php

namespace App\Http\Controllers;

use App\Models\stock_products;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CookieController extends Controller
{
    public function resetCookie()
    {
        $day = date('Y-m-d H:i:s', time() - 7 * 60 * 60);
        $list_cookie = stock_products::select('stock_products.info')
            ->join('products', 'stock_products.parent_id', '=', 'products.id')
            ->join('sub_categories', 'products.parent_id', '=', 'sub_categories.id')
            ->where('stock_products.created_at', '>', $day)
            ->whereIn('stock_products.parent_id', [5, 14])
            ->orderBy('stock_products.id', 'asc')
            ->get();
        $url = "https://www.netflix.com/api/shakti/mre/account/devices";
        foreach ($list_cookie as $cookie) {
            $response = Controller::checkCookie($cookie->info);
            if ($response['status'] == 200) {
                $client = new Client();
                $client->request('POST', $url, [
                    'headers' => [
                        'Cookie' => $cookie->info
                    ],
                    'query' => [
                        "deactivate" => "all",
                        "authURL" => $response['authUrl']
                    ]
                ]);

            }
            stock_products::where('info', $cookie->info)->update(['status' => 0, 'quantity' => 0]);
        }
        return redirect()->back()->with('success','Reset cookie thành công');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\log_users;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\stock_products;
use App\Models\sub_categories;
use Illuminate\Pagination\LengthAwarePaginator;
use Jenssegers\Agent\Agent;
use App\Models\orders;
use App\Models\mission_users;
use App\Models\notify;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $controller = new Controller();
        $products = products::select('products.*', 'sub_categories.name as category_name', 'sub_categories.image as category_image')
            ->join('sub_categories', 'products.parent_id', '=', 'sub_categories.id')
            ->where('products.status', 1)
            ->orderBy('products.id', 'desc')
            ->get();

        $products = $products->groupBy('category_name');
        foreach ($products as $product) {
            foreach ($product as $item) {
                $item->stock = stock_products::where('parent_id', $item->id)->where('status', 1)->sum('quantity');
                $item->des = explode(",", $item->description);
            }
        }

        $popular = products::select('products.*', 'sub_categories.name as category_name', 'sub_categories.image as category_image')
        ->join('sub_categories', 'products.parent_id', '=', 'sub_categories.id')
        ->where('products.sold', '>', 0)
        ->where('products.status', 1)
        ->orderBy('products.sold', 'desc')
        ->limit(9)
        ->get();
        foreach ($popular as $product) {
            $product->stock = stock_products::where('parent_id', $product->id)->where('status', 1)->sum('quantity');
            $product->des = explode(",", $product->description);
        }

        $categories = sub_categories::orderBy('updated_at', 'desc')->get();
        $orderNearest = orders::select('orders.*', 'users.fullName', 'products.title')
            ->join('users', 'orders.parent_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->orderBy('orders.id', 'desc')
            ->limit(15)
            ->get();

        $cayxuNearest = mission_users::select('mission_users.*', 'users.fullName', 'missions.title', 'missions.reward', 'missions.type_reward')
            ->join('users', 'mission_users.user_id', '=', 'users.id')
            ->join('missions', 'mission_users.parent_id', '=', 'missions.id')
            ->orderBy('mission_users.id', 'desc')
            ->limit(15)
            ->get();

        $is_notify = notify::where('status', 1)->orderBy('id', 'desc')->first();

        if($is_notify && Auth::check()) {
            if(log_users::where('content', 'like', '%' . $is_notify->title . '%')->where('parent_id', Auth::user()->id)->where('content', '!=', 'Thêm thông báo mới có tiêu đề ' . $is_notify->title)->first()) {
                $is_notify = null;
            }
        }

        return view('index', compact('controller', 'products', 'popular', 'categories', 'orderNearest', 'cayxuNearest', 'is_notify'));
    }

    public function auth()
    {
        return view('Systems.auth');
    }
}

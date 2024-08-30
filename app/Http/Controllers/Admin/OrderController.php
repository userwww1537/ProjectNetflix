<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request) {
        $orders = orders::orderBy('created_at', 'desc')->get();
        return view('admin.order', compact('orders'));
    }
}

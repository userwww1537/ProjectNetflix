<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Models\log_users;
use App\Models\products;
use App\Models\stock_products;
use App\Models\sub_categories;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ProductController extends Controller
{
    public function index()
    {
        $products = products::all();

        return view("admin.products.index", compact('products'));
    }

    public function add()
    {
        $sub_categories = sub_categories::all();
        return view('admin.products.create', compact('sub_categories'));
    }

    public function create(AddProductRequest $request)
    {
        $product = new products();
        $product->title = $request->title;
        $product->price = str_replace(',', '', $request->price);
        $product->coin = str_replace(',', '', $request->coin);
        $product->country = $request->country;
        $product->description = $request->description;
        $product->parent_id = $request->parent_id;
        $product->user_id = auth()->user()->id;

        $product->save();

        $agent = new Agent();
        log_users::create([
            'parent_id' => auth()->user()->id,
            'content' => 'Tạo sản phẩm' . $product->title,
            'ip_address' => $request->ip(),
            'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
        ]);
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    public function edit(string $id)
    {
        $product = products::find($id);
        $sub_categories = sub_categories::all();
        return view('admin.products.edit', compact('product', 'sub_categories'));
    }

    public function update(AddProductRequest $request, string $id)
    {
        $product = products::find($id);
        $product->title = $request->title;
        $product->price = str_replace(',', '', $request->price);
        $product->coin = str_replace(',', '', $request->coin);
        $product->country = $request->country;
        $product->description = $request->description;
        $product->parent_id = $request->parent_id;
        $product->user_id = auth()->user()->id;
        if ($request->status) {
            $product->status = $request->status;
        }
        $product->save();
        $agent = new Agent();
        log_users::create([
            'parent_id' => auth()->user()->id,
            'content' => 'Cập nhật sản phẩm' . $product->title,
            'ip_address' => $request->ip(),
            'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
        ]);
        return to_route('admin.products')->with('success', 'Cập nhật thành công');
    }

    public function delete(Request $request, string $id)
    {
        $product = products::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['success' => 'Sản phẩm đã được xóa thành công!']);
        }

        $agent = new Agent();
        log_users::create([
            'parent_id' => auth()->user()->id,
            'content' => 'Xóa sản phẩm',
            'ip_address' => $request->ip(),
            'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
        ]);

        return response()->json(['error' => 'Không tìm thấy sản phẩm.'], 404);
    }

    public function detail(string $id){
        $product = products::find($id);
        $stock_product = stock_products::where('parent_id', $id)->get();

        return view('admin.products.detail-product', compact('product', 'stock_product'));
    }
}

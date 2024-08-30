<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\missions;
use App\Models\mission_users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\products;
use App\Models\stock_products;
use Illuminate\Pagination\LengthAwarePaginator;
use Jenssegers\Agent\Agent;
use App\Models\sub_categories;
use App\Models\users;
use App\Models\log_users;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountEmail;
use App\Models\deposit_history;
use App\Models\orders;
use App\Models\wallet_users;
use App\Models\notify;

class StaffController extends Controller
{
    public function addMission(Request $request)
    {

        if(Auth::check() && Auth::user()->role > 2) {
            return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập');
        }

        $code = rand(100000, 999999);
        $mission = new missions();
        $mission->title = $request->title;
        $mission->reward = intval($request->reward);
        $mission->type_reward = ($request->type_reward == '1') ? 1 : 2;
        $mission->type = ($request->type == 1) ? 1 : 2;
        $mission->code = $code;

        $url = route('mission') . '?code=' . $code;
        if($request->type_link == '8Link') {
            $res = Http::get('https://partner.8link.io/api/public/gen-shorten-link?apikey=ee2daf8990a18ed78c0408f3fb91bf20250b099bd86fecaaf5d26da66b45ebc6&url='. $url .'&target_domain=https://8link.vip');
            $data = $res->json();
            $link = $data['shortened_url'];
        } else {
            $res = Http::get('https://yeumoney.com/QL_api.php?token=756859ee73eee48762b8a95131a56fc4f1e8d9c3511fd1d4139038ab61283487&format=json&url='. $url .'');
            $data = $res->json();
            $link = $data['shortenedUrl'];
        }
        $mission->link = $link;
        $mission->parent_id = Auth::user()->id;

        $users = users::where('is_mission', 1)->get();
        $emails = [];

        foreach($users as $user) {
            $emails[] = $user->email;
        }

        mail::to($emails)->send(new AccountEmail('Nhiệm vụ mới từ Cửa hàng MMO có giá trị ' . number_format($request->reward) . ' ' . (($request->type_reward == '1') ? 'Tiền' : 'Xu'), 'Bạn ơi, Cửa hàng MMO có nhiệm vụ mới rồi đó', 'bạn', 'mail-template.mission-mail', route('mission'), 'Link nhiệm vụ'));

        $mission->save();

        return redirect()->route('mission')->with('success', 'Thêm nhiệm vụ thành công');
    }

    public function index(Request $request)
    {
        $controller = new Controller;
        $products = products::select('products.*', 'sub_categories.name as category_name')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.parent_id')
            ->orderBy('products.id', 'desc')
            ->paginate(30);

        $sub_categories = sub_categories::orderBy('id', 'desc')->get();

        foreach($products as $key => $product) {
            $stock = stock_products::where('parent_id', $product->id)->sum('quantity');
            $products[$key]->stock = $stock;
            $products[$key]->user_name = users::where('id', $product->user_id)->first()->fullName;
        }

        return view('Products.add-product', compact('controller', 'products', 'sub_categories'));
    }

    public function notify(Request $request)
    {
        $controller = new Controller;
        $notify = notify::orderBy('updated_at', 'desc')->paginate(10);

        foreach($notify as $key => $noti) {
            $notify[$key]->traffic = log_users::where('content', 'like', '%' . $noti->title . '%')->where('content', '!=', 'Thêm thông báo mới có tiêu đề ' . $noti->title)->count();
            $notify[$key]->user_name = users::where('id', $noti->parent_id)->first()->fullName;
        }

        return view('Products.notify', compact('controller', 'notify'));
    }

    public function changeStatusNotify(Request $request)
    {
        $notify = notify::where('id', $request->id)->first();

        if(!$notify) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy thông báo'
            ]);
        }

        if($notify->status == 0) {
            $notify->status = 1;
            foreach(notify::all() as $noti) {
                $noti->status = 0;
                $noti->save();
            }
            $notify->save();
            return response()->json([
                'status' => 1,
                'message' => 'Trạng thái đã được bật'
            ]);
        }

        $notify->status = 0;
        $notify->save();

        return response()->json([
            'status' => 0,
            'message' => 'Trạng thái đã được tắt'
        ]);
    }

    public function processNotify(Request $request)
    {

        if(Auth::check() && Auth::user()->role_id > 1) {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập!');
        }

        $notify = new notify();
        $notify->title = $request->title;
        $notify->body = $request->body; 
        $notify->parent_id = Auth::user()->id;
        foreach(notify::all() as $noti) {
            $noti->status = 0;
            $noti->save();
        }
        $notify->save();

        $agent = new Agent();
        log_users::create([
            'parent_id' => Auth::user()->id,
            'content' => 'Thêm thông báo mới có tiêu đề ' . $request->title, 
            'ip_address' => $request->ip(),
            'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
        ]);

        return redirect()->back()->with('success', 'Thêm thông báo thành công');
    }

    public function getNotify(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Không tìm thấy thông báo'
        ];

        $notify = notify::where('id', $request->id)->first();
        if($notify) {
            $response = [
                'status' => true,
                'message' => 'Lấy thông báo thành công',
                'title' => $notify->title,
                'body' => $notify->body
            ];
            return response()->json($response);
        }
        return response()->json($response);
    }

    public function addGianHang(Request $request)
    {
        $price = str_replace(',', '', $request->price);
        $product = new products();
        $product->title	 = $request->title;
        $product->price	 = $price;
        $product->coin = $request->coin;
        $product->description = $request->description;
        $product->parent_id  = $request->category_id;
        $product->country = $request->country;
        $product->user_id = Auth::user()->id;
        $product->save();

        return redirect()->back()->with('success', 'Thêm gian hàng thành công');
    }

    public function fetchGianHang(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Không tìm thấy sản phẩm'
        ];

        $product = products::where('id', $request->id)->first();
        if($product) {
            if($request->has('detail')) {
                $details = stock_products::where('parent_id', $product->id)->where('quantity', '>', 0)->orderBy('updated_at', 'desc')->get();
                if(!$details) {
                    $response = [
                        'status' => false,
                        'message' => 'Không tìm thấy thông tin sản phẩm'
                    ];
                    return response()->json($response);
                }

                $html = '';

                foreach($details as $detail) {
                    $html .= '<tr>
                                <td class="text-center"><b style="color: #6666FF;">'. $product['title'] .'</b></td>
                                <td class="text-center"><b style="color: #6666FF;">'. $detail['quantity'] .'</b></td>
                                <td class="text-center"><span class="">';
                                    if(stripos($detail['info'], '|') !== false) {
                                        $html .= $detail['info'];
                                    } else {
                                        $html .= '<span class="coppy-cookie btn btn-outline-secondary" data-text="'. $detail['info'] .'">Coppy cookie</span>';
                                    }
                                $html .= '</span></td>
                                <td class="text-center">
                                    ';
                                        if($detail['status'] == 1 && $detail['quantity'] > 0) {
                                            $html .= '<span class="badge text-bg-success">Còn hàng</span>';
                                        } else {
                                            $html .= '<span class="badge text-bg-danger">Hết hàng</span>';
                                        }
                                    $html .= '
                                </td>
                                <td class="text-center">'. users::where('id', $detail['user_id'])->first()->fullName .'</td>
                                <td class="text-center">'. Controller::convertTime($detail['updated_at']) .'</td>
                                <td class="text-center">
                                    <a class="cookieDie-Btn" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="Chi tiết hoá đơn"
                                        data-id="'. $detail['id'] .'"
                                        href="">
                                        Cookie die or Account Error
                                    </a>
                                </td>
                            </tr>';
                }

                $response = [
                    'status' => true,
                    'message' => 'Lấy thông tin sản phẩm thành công',
                    'title' => $product['title'],
                    'html' => $html
                ];

                return response()->json($response);
            }
            $response = [
                'status' => true,
                'message' => 'Lấy thông tin sản phẩm thành công',
                'title' => $product['title']
            ];
            return response()->json($response);
        }
        return response()->json($response);
    }

    public function processCookieDie(Request $request)
    {
        $stock = stock_products::where('id', $request->id)->first();
        if($stock) {
            $stock->status = 0;
            $stock->quantity = 0;
            $stock->save();
            $agent = new Agent();
            log_users::create([
                'parent_id' => Auth::user()->id,
                'content' => 'Đánh dấu sản phẩm ' . $stock->info . ' đã die',
                'ip_address' => $request->ip(),
                'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Đánh dấu sản phẩm đã die thành công'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy sản phẩm'
        ]);
    }
    
    public function addSanPham(Request $request)
    {
        $product = products::where('id', $request->product_id)->first();
        if($product) {
            $stock = new stock_products();
            $stock->info = $request->info;
            $stock->quantity = $request->quantity;
            $stock->parent_id = $product->id;
            $stock->user_id = Auth::user()->id;
            if($request->info_more) {
                $stock->info_more = $request->info_more;
            }
            $stock->save();
            $agent = new Agent();
            log_users::create([
                'parent_id' => Auth::user()->id,
                'content' => 'Thêm sản phẩm ' . $product->title . ' vào kho',
                'ip_address' => $request->ip(),
                'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
            ]);

            return redirect()->back()->with('success', 'Thêm sản phẩm thành công');
        }
        return redirect()->back()->with('error', 'Không tìm thấy sản phẩm');
    }

    public function processGianHang(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Không tìm thấy sản phẩm'
        ];
        $product = products::where('id', $request->id)->first();
        if($product) {
            if($request->has('title')) {
                $product->title = $request->title;
            }

            if($request->has('category_id')) {
                $product->parent_id = $request->category_id;
            }

            $product->save();

            $response = [
                'status' => true,
                'message' => 'Cập nhật sản phẩm thành công'
            ];
            return response()->json($response);
        }
        return response()->json($response);
    }

    public function scan(Request $request)
    {
        if(Auth::check() && Auth::user()->role > 2) {
            return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập');
        }
        if(!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
        }

        $order = orders::where('id', $request->id)->first();

        if(!$order) {
            return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng');
        }

        if($order->status == 'Đang chờ duyệt') {
            orders::where('id', $request->id)->update([
                'status' => ($request->status == 1) ? 'Hoàn thành' : 'Đã hoàn'
            ]);
        } else {
            return redirect()->route('home')->with('error', 'Đơn hàng đã được xử lý');
        }

        $agent = new Agent();
        log_users::create([
            'parent_id' => Auth::user()->id,
            'content' => Auth::user()->fullName . ' đã quét mã cho đơn hàng có id: ' . $order->id . ' với trạng thái ' . ((intval($request->status) == 1) ? 'Đã nhận' : 'Đã hủy'), 
            'ip_address' => $request->ip(),
            'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
        ]);
        if(intval($request->status) == 2) {
            log_users::create([
                'parent_id' => Auth::user()->id,
                'content' => Auth::user()->fullName . ' đã hoàn cho người mua ' . ($order->payment_method == 'price') ? number_format($order->price) : $order->coin . ' ' . (($order->payment_method == 'price') ? 'Tiền' : 'Xu'), 
                'ip_address' => $request->ip(),
                'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
            ]);
            if($order->payment_method == 'price') {
                $user = wallet_users::where('parent_id', $order->parent_id)->first();
                $user->money += $order->price;
                $user->save();
            } else {
                $user = wallet_users::where('parent_id', $order->parent_id)->first();
                $user->coin += $order->coin;
                $user->save();
            }

            return redirect()->route('home')->with('success', 'Quét mã thất bại, đơn hàng đã được hoàn');
        }
        
        return redirect()->route('home')->with('success', 'Quét mã thành công');
    }

    protected function bankingCheck(Request $request)
    {
        if(Auth::check() && Auth::user()->role > 2) {
            return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập');
        }
        if(!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
        }

        $deposit = deposit_history::where('id', $request->id)->first();

        if(!$deposit) {
            return redirect()->route('home')->with('error', 'Không tìm thấy thông tin chuyển khoản');
        }

        if($deposit->status == 'Chờ xác nhận') {
            deposit_history::where('id', $request->id)->update([
                'status' => ($request->status == 1) ? 'Thành công' : 'Hủy bỏ'
            ]);

            if($request->status == 1) {
                $user = wallet_users::where('parent_id', $deposit->parent_id)->first();
                $user->money = $deposit->actually_received + $user->money;
                $user->total = $deposit->actually_received + $user->total;
                $user->save();

                $agent = new Agent();
                log_users::create([
                    'parent_id' => Auth::user()->id,
                    'content' => Auth::user()->fullName . ' đã xác nhận chuyển khoản cho ' . users::where('id', $deposit->parent_id)->first()->fullName . ' với số tiền là ' . number_format($deposit->actually_received) . ' Tiền', 
                    'ip_address' => $request->ip(),
                    'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
                ]);

                Mail::to(users::where('id', $deposit->parent_id)->first()->email)->send(new AccountEmail('Chuyển khoản của bạn đã được xác nhận', 'Chuyển khoản thành công', users::where('id', $deposit->parent_id)->first()->fullName, 'mail-template.forgot-mail', route('home'), 'Trang chủ'));
            } else {
                Mail::to(users::where('id', $deposit->parent_id)->first()->email)->send(new AccountEmail('Chuyển khoản của bạn đã bị hủy', 'Chuyển khoản thất bại', users::where('id', $deposit->parent_id)->first()->fullName, 'mail-template.forgot-mail', route('home'), 'Trang chủ'));
            }

            return redirect()->route('home')->with('success', 'Xác nhận chuyển khoản thành công');
        }

        return redirect()->route('home')->with('error', 'Chuyển khoản đã được xử lý');
    }
}

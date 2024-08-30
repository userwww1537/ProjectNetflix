<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\ip_info;
use App\Models\log_users;
use App\Models\missions;
use App\Models\mission_users;
use App\Models\stock_products;
use Illuminate\Support\Facades\Auth;
use App\Models\wallet_users;
use Illuminate\Pagination\LengthAwarePaginator;
use Jenssegers\Agent\Agent;
use App\Models\orders;
use App\Mail\AccountEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\users;
use App\Models\notify;

class ProductController extends Controller
{
    public function mission(request $request)
    {
        if($request->has('code')) {
            if(!Auth::check()) {
                return redirect()->route('login');
            }
            $mission = missions::where('code', $request->code)->first();
            if($mission) {

                $check = users::where('id', Auth::user()->id)->where('mission_code', $mission->code)->first();

                if(!$check) {
                    return redirect()->route('mission')->with('error', 'Làm nhiệm vụ thất bại');
                }

                if(mission_users::where('user_id', Auth::user()->id)->where('parent_id', $mission->id)->first()) {
                    return redirect()->route('mission')->with('error', 'Bạn đã làm nhiệm vụ này rồi');
                }

                $check->mission_code = null;
                $check->save();

                $mission_user = new mission_users;
                $mission_user->user_id = Auth::user()->id;
                $mission_user->parent_id = $mission->id;
                $mission_user->save();

                $mission->view = $mission->view + 1;
                $mission->save();

                $wallet_users = wallet_users::where('parent_id', Auth::user()->id)->first();
                if($mission->type_reward == 'Xu') {
                    $wallet_users->coin = $wallet_users->coin + $mission->reward;
                } else {
                    $wallet_users->money = $wallet_users->money + $mission->reward;
                }
                $wallet_users->save();
                $agent = new Agent();
                log_users::create([
                    'parent_id' => Auth::user()->id,
                    'content' => 'Nhận được ' . $mission->reward . ' ' . $mission->type_reward . ' từ nhiệm vụ ' . $mission->title,
                    'ip_address' => $request->ip(),
                    'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
                ]);

                return redirect()->route('mission')->with('success', 'Hoàn thành nhiệm vụ bạn nhận được ' . $mission->reward . ' ' . $mission->type_reward);
            }
        }
        $controller = new Controller;
        $missions = (Auth::check() && Auth::user()->role_id <=2) ? missions::orderBy('id', 'desc')->get() : missions::where('status', 1)->orderBy('id', 'desc')->get();

        if($missions) {
            foreach($missions as $mission) {
                if($mission['created_at']->diffInDays() >= 1) {
                    $mission->status = 0;
                    $mission->save();
                }
            }
        }

        $filteredMissions = $missions->filter(function ($mission) {
            return !(Auth::check() && mission_users::where('user_id', Auth::user()->id)->where('parent_id', $mission->id)->first());
        });
        $currentPage = $request->get('page', 1);
        $perPage = 10;
        $missions = new LengthAwarePaginator(
            $filteredMissions->slice(($currentPage - 1) * $perPage, $perPage),
            $filteredMissions->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url()]
        );

        return view('Products.mission', compact('controller', 'missions'));
    }

    protected function fetchBuy(request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Có lỗi xảy ra, vui lòng thử lại sau',
            'total' => '0'
        ];
        $product = products::where('id', $request->id)->where('status', 1)->first();

        if($product) {
            if($request->qty > 0 && stock_products::where('parent_id', $product->id)->sum('quantity') >= $request->qty) {
                $response['status'] = true;
                $response['message'] = 'Đã thêm sản phẩm vào giỏ hàng';
                $response['total'] = number_format($request->qty * $product->price) . 'đ - ' . $request->qty * $product->coin . 'xu';
            } else {
                $response['message'] = 'Số lượng sản phẩm không đủ';
            }
        }

        return response()->json($response);
    }

    protected function checkout(request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Có lỗi xảy ra, vui lòng thử lại sau'
        ];

        $request['qty'] = 1;

        if(!Auth::check()) {
            $response['message'] = 'Vui lòng đăng nhập để mua hàng';
            return response()->json($response);
        }

        if(Auth::user()->email_verified == 0) {
            $response['message'] = 'Vui lòng xác nhận email trước khi mua hàng';
            return response()->json($response);
        }

        $product = products::where('id', $request->id)->where('status', 1)->first();

        if($product) {
            $request['qty'] = (int) $request->qty;
            $qty_product = stock_products::where('parent_id', $product->id)->where('status', 1)->sum('quantity');
            if($qty_product >= $request->qty) {
                $payment = $request->paymentMethod;
                if($payment == 1) {
                    $price = $request->qty * $product->price;

                    if(wallet_users::where('parent_id', Auth::user()->id)->where('money', '<', $price)->first()) {
                        $response['message'] = 'Số dư không đủ';
                        return response()->json($response);
                    }
                } else {
                    $price = $request->qty * $product->coin;

                    if(wallet_users::where('parent_id', Auth::user()->id)->where('coin', '<', $price)->first()) {
                        $response['message'] = 'Số dư không đủ';
                        return response()->json($response);
                    }
                }
                $stock = stock_products::where('parent_id', $product->id)->orderBy('id', 'asc')->where('quantity', '>', 0)->where('status', 1)->get();
                if($stock) {
                    $fail = true;
                    if(stripos($product->title, 'cookie') !== false && stripos($product->title, 'gói') === false) {
                        foreach($stock as $key => $value) {
                            $check = controller::checkCookie($value->info);

                            if($check['status'] == 200) {
                                orders::create([
                                    'parent_id' => Auth::user()->id,
                                    'product_id' => $product->id,
                                    'payment_method' => ($payment == 1) ? 1 : 2,
                                    'information' => $value->info,
                                    'info_more' => $value->info_more,
                                    'status' => ($request->scan != '') ? 1 : 2,
                                    'price' => $product->price,
                                    'coin' => $product->coin
                                ]);
                                stock_products::where('id', $value->id)->update([
                                    'quantity' => $value->quantity - 1
                                ]);
                                $fail = false;
                                break;
                            }

                            $value->status = 0;
                            $value->quantity = 0;
                            $value->save();
                            $fail = true;
                        }
                    } else if(stripos($product->title, 'quét mã') !== false) {
                        foreach($stock as $key => $value) {
                            orders::create([
                                'parent_id' => Auth::user()->id,
                                'product_id' => $product->id,
                                'payment_method' => ($payment == 1) ? 1 : 2,
                                'information' => $value->info,
                                'info_more' => $value->info_more,
                                'status' => ($request->scan != '') ? 1 : 2,
                                'price' => $product->price,
                                'coin' => $product->coin
                            ]);
                            stock_products::where('id', $value->id)->update([
                                'quantity' => $value->quantity - 1
                            ]);
                            $fail = false;
                            break;
                        }
                    } else {
                        foreach($stock as $key => $value) {
                            orders::create([
                                'parent_id' => Auth::user()->id,
                                'product_id' => $product->id,
                                'payment_method' => ($payment == 1) ? 1 : 2,
                                'information' => $value->info,
                                'info_more' => $value->info_more,
                                'status' => ($request->scan != '') ? 1 : 2,
                                'price' => $product->price,
                                'coin' => $product->coin
                            ]);
                            stock_products::where('id', $value->id)->update([
                                'quantity' => $value->quantity - 1
                            ]);
                            $fail = false;
                            break;
                        }
                    }

                    if($fail) {
                        $message = 'Khách hàng ' . Auth::user()->fullName . ' đã mua sản phẩm ' . $product->title . ' vào lúc ' . date('d/m/Y H:i:s') . ' nhưng không thể mua được sản phẩm này';
                        $subject = 'Thông báo trường hợp hàng die - Cửa hàng MMO';
                        Mail::to('cuahangmmovn@gmail.com')->send(new AccountEmail($message, $subject, Auth::user()->fullName, 'mail-template.order-mail', route('staff.index')));
                        $wallet = wallet_users::where('parent_id', Auth::user()->id)->first();
                        if($payment == 1) {
                            $wallet->money = $wallet->money + $price;
                        } else {
                            $wallet->coin = $wallet->coin + $price;
                        }
                        $wallet->save();
                        $response['message'] = 'Không thể mua sản phẩm này';
                        return response()->json($response);
                    }

                    $wallet = wallet_users::where('parent_id', Auth::user()->id)->first();
                    if($payment == 1) {
                        $wallet->money = $wallet->money - $price;
                    } else {
                        $wallet->coin = $wallet->coin - $price;
                    }
                    $wallet->save();

                    $agent = new Agent();
                    log_users::create([
                        'parent_id' => Auth::user()->id,
                        'content' => 'Mua sản phẩm ' . $product->title . ' với số lượng ' . $request->qty . ' bằng ' . (($payment == 1) ? 'tiền mặt' : 'xu'),
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
                    ]);

                    $subject = 'Đơn hàng mới của bạn';
                    $message = 'Cảm ơn bạn đã ủng hộ cửa hàng chúng tôi, đơn hàng của bạn đã được xác nhận và đã được gửi vào kho hàng của chúng tôi. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận đơn hàng của bạn. Cảm ơn bạn đã mua hàng tại cửa hàng chúng tôi.';
                    Mail::to(Auth::user()->email)->send(new AccountEmail($message, $subject, Auth::user()->fullName, 'mail-template.order-mail', route('orders'), 'Xem đơn hàng'));
                    if($request->scan != '') {
                        $message = 'Khách hàng ' . Auth::user()->fullName . ' đã mua sản phẩm <b>' . $product->title . '</b> vào lúc ' . date('d/m/Y H:i:s');
                        $order = orders::where('parent_id', Auth::user()->id)->orderBy('id', 'desc')->first();
                        $message .= ' <b>- mã là: <h3>' . $request->scan . '</h3></b>';
                        if(stripos($product->title, 'riêng tư') !== false) {
                            $message .= ' - Thông tin thêm: <b> ' . $order->info_more . '</b>';
                        }
                        $subject = '⚜️Đơn hàng quét mã mới thể loại ' . $product->title . '⚜️';
                        Mail::to('cuahangmmovn@gmail.com')->send(new AccountEmail($message, $subject, Auth::user()->fullName, 'mail-template.scan-mail', route('staff.status-order-scan') . '?id=' . $order['id'] . '&status=1', 'Đã quét', route('staff.status-order-scan') . '?id=' . $order['id'] . '&status=2', 'Hoàn tiền'));
                    }


                    $response['status'] = true;
                    $response['message'] = 'Mua hàng thành công';
                    return response()->json($response);
                }
            } else {
                $response['message'] = 'Số lượng sản phẩm không đủ';
            }
        }

        return response()->json($response);
    }

    protected function daXem($id)
    {

        if(!Auth::check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để xem thông báo');
        }

        $notify = notify::where('id', $id)->where('status', 1)->first();
        if($notify) {
            if(log_users::where('content', 'like', '%' . $notify->title . '%')->where('parent_id', Auth::user()->id)->where('content', '!=', 'Thêm thông báo mới có tiêu đề ' . $notify->title)->first()) {
                return redirect()->back()->with('error', 'Bạn đã xem thông báo này');
            }
            $agent = new Agent();
            log_users::create([
                'parent_id' => Auth::user()->id,
                'content' => 'Đã xem thông báo ' . $notify->title,
                'ip_address' => request()->ip(),
                'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
            ]);
        }
        return redirect()->back();
    }

    public function faq()
    {
        $controller = new Controller;
        return view('Systems.faq', compact('controller'));
    }

    public function talkingMission(request $request)
    {
        $response = [
            'status' => false
        ];
        $mission = missions::where('link', $request->link)->where('status', 1)->first();

        if($mission) {
            users::where('id', Auth::user()->id)->update([
                'mission_code' => $mission->code
            ]);

            $response['status'] = true;
            return response()->json($response);
        }

        return response()->json($response);
    }
}

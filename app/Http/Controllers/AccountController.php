<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountEmail;
use App\Models\deposit_history;
use App\Models\log_affilate;
use App\Models\log_users;
use App\Models\mission_users;
use Jenssegers\Agent\Agent;
use App\Models\wallet_users;
use App\Models\orders;
use App\Models\withdraw_affilate_history;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\stock_products;

class AccountController extends Controller
{

    public function index(request $request)
    {
        if(Auth::user()->email_verified == 0) {
            if($request->has('code')) {
                if(Auth::user()->email_code == $request->code) {
                    $agent = new Agent();
                    log_users::create([
                        'content' => 'Xác thực email thành công',
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform(),
                        'parent_id' => Auth::user()->id,
                    ]);
                    users::where('id', Auth::user()->id)->update([
                        'email_verified' => 1,
                        'email_code' => null,
                    ]);
                    echo "<script>alert('Xác thực email thành công');</script>";
                    echo "<script>window.location = '/account/profile';</script>";
                } else {
                    echo "<script>alert('Mã xác thực không chính xác');</script>";
                    echo "<script>window.location = '/account/profile';</script>";
                }
            }
        }
        $controller = new Controller();
        $amount = $controller->getWallet();
        $mission_count = mission_users::where('user_id', Auth::user()->id)->count();
        return view('Account.index', compact('controller', 'amount', 'mission_count'));
    }

    public function login(request $request)
    {
        if($request->has('code') && $request->has('security')) {
            $user = users::where('email_code', $request->code)->first();
            if($user) {
                users::where('id', $user->id)->update(['email_verified' => 1, 'email_code' => null, 'password' => $request->security]);
                echo "<script>alert('Mật khẩu đã được cập nhật');</script>";
                echo "<script>window.location = '/account/login';</script>";
            } else {
                echo "<script>window.location = '/account/login';</script>";
            }
        }
        $controller = new Controller();
        return view('Account.login', compact('controller'));
    }

    public function affilate(request $request)
    {
        $agent = new Agent();
        $controller = new Controller();
        $users = users::where('affilate', Auth::user()->id)->orderBy('updated_at', 'desc')->get();
        $count['countUser'] = count($users);
        $countSesRecharge = 0;
        $history = log_affilate::select('log_affilate.*', 'users.username', 'users.fullName')
            ->join('users', 'users.id', '=', 'log_affilate.referrer_id')
            ->where('log_affilate.parent_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();

        foreach($users as $key => $value) {

            $ses = deposit_history::where('parent_id', $value->id)->where('status', 2)->get();

            if($ses) {
                foreach($ses as $k => $v) {
                    $log = log_affilate::where('parent_id', Auth::user()->id)->where('referrer_id', $value->id)->where('des', 'like', '%' . $v->description . '%')->first();

                    if(!$log) {
                        log_affilate::create([
                            'content' => 'Nhận hoa hồng từ ' . $value->username . ' đã nạp ' . number_format($v->amount) . 'đ',
                            'des' => $v->description,
                            'money_before' => wallet_users::where('parent_id', Auth::user()->id)->first()->money,
                            'money_change' => wallet_users::where('parent_id', Auth::user()->id)->first()->money + ($v->amount * 0.1),
                            'amount' => $v->amount * 0.1,
                            'referrer_id' => $value->id,
                            'parent_id' => Auth::user()->id,
                        ]);

                        wallet_users::where('parent_id', Auth::user()->id)->update([
                            'money' => wallet_users::where('parent_id', Auth::user()->id)->first()->money + ($v->amount * 0.1),
                        ]);

                        log_users::create([
                            'content' => 'Nhận hoa hồng từ ' . $value->username . ' đã nạp ' . number_format($v->amount) . 'đ',
                            'ip_address' => $request->ip(),
                            'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform(),
                            'parent_id' => Auth::user()->id,
                        ]);
                    }
                }
            }

            $countSesRecharge += deposit_history::where('parent_id', $value->id)->where('status', 2)->sum('amount') * 0.1;
            $mission_count = mission_users::where('user_id', $value->id)->count();

            $users[$key]['hoa_hong'] = deposit_history::where('parent_id', $value->id)->where('status', 2)->sum('amount') * 0.1;

            if($mission_count > 5) {
                $users[$key]['hoa_hong'] += 1000;
                $log_mission = log_affilate::where('parent_id', Auth::user()->id)->where('referrer_id', $value->id)->where('des', 'like', '%mission%')->first();

                if(!$log_mission) {
                    log_affilate::create([
                        'content' => 'Nhận hoa hồng từ ' . $value->username . ' đã hoàn thành nhiệm vụ 5 lần',
                        'des' => 'mission',
                        'money_before' => wallet_users::where('parent_id', Auth::user()->id)->first()->money,
                        'money_change' => wallet_users::where('parent_id', Auth::user()->id)->first()->money + 1000,
                        'amount' => 1000,
                        'referrer_id' => $value->id,
                        'parent_id' => Auth::user()->id,
                    ]);

                    wallet_users::where('parent_id', Auth::user()->id)->update([
                        'money' => wallet_users::where('parent_id', Auth::user()->id)->first()->money + 1000,
                    ]);

                    log_users::create([
                        'content' => 'Nhận hoa hồng từ ' . $value->username . ' đã hoàn thành nhiệm vụ',
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform(),
                        'parent_id' => Auth::user()->id,
                    ]);
                }
            }
        }

        $count['countRecharge'] = $countSesRecharge;
        $count['countMoney'] = wallet_users::where('parent_id', Auth::user()->id)->first()->money;

        return view('Account.affilate', compact('controller', 'count', 'users', 'history'));
    }

    public function processLogin(request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Đăng nhập thất bại',
        ];

        $user = users::where('username', $request->username)->first();
        if ($user) {
            $agent = new Agent();
            if(Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

                if($user->status == 0) {
                    $response = [
                        'status' => false,
                        'message' => 'Tài khoản đã bị khóa',
                    ];
                    return response()->json($response);
                }

                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
                log_users::create([
                    'content' => 'Đăng nhập thành công',
                    'ip_address' => $request->ip(),
                    'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform(),
                    'parent_id' => $user->id,
                ]);
                $log = log_users::where('parent_id', $user->id)->orderBy('id', 'desc')->first();
                if($log) {
                    if($log->ip_address != $request->ip()) {
                        $content = 'Đăng nhập từ một thiết bị mới';
                        $log = new log_users();
                        $log->content = $content;
                        $log->ip_address = $request->ip();
                        $log->browser = $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform();
                        $log->parent_id = $user->id;
                        $log->save();

                        $subject = 'Phát hiện đăng nhập từ thiết bị mới';
                        $message = 'Chúng tôi phát hiện bạn vừa đăng nhập từ một thiết bị mới. Nếu đây không phải là bạn, hãy đổi mật khẩu ngay lập tức.';
                        Mail::to($user->email)->send(new AccountEmail($message, $subject, $user->fullName, 'mail-template.warn-mail'));
                    }
                }
                $response = [
                    'status' => true,
                    'message' => 'Đăng nhập thành công',
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Mật khẩu không chính xác',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Tài khoản không tồn tại',
            ];
        }

        return response()->json($response);
    }

    public function register()
    {
        $controller = new Controller();
        return view('Account.register', compact('controller'));
    }

    public function processReg(request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Đăng ký thất bại',
        ];

        if (users::where('username', $request->username)->exists()) {
            $response = [
                'status' => false,
                'message' => 'Tên đăng nhập đã tồn tại',
            ];
            return response()->json($response);
        }

        if (users::where('email', $request->email)->exists()) {
            $response = [
                'status' => false,
                'message' => 'Email đã tồn tại',
            ];
            return response()->json($response);
        }

        $aff = users::where('phone', $request->aff)->first();

        if(!$aff) {
            $aff = 13;
        } else {
            $aff = $aff->id;
        }

        $user = new users();
        $user->fullName = $request->fullName;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->affilate = $aff;
        $user->password = bcrypt($request->password);
        $user->last_login = date('Y-m-d H:i:s');
        if ($user->save()) {
            $response = [
                'status' => true,
                'message' => 'Đăng ký thành công',
            ];
        }

        $wallet = new wallet_users();
        $wallet->parent_id = $user->id;
        $wallet->save();

        $agent = new Agent();
        $content = "Đăng ký tài khoản thành công";
        $log = new log_users();
        $log->content = $content;
        $log->ip_address = $request->ip();
        $log->browser = $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform();
        $log->parent_id = $user->id;
        $log->save();

        $message = "Chúc mừng bạn đã đăng ký tài khoản trên CuaHangMMO của chúng tôi. Hãy đăng nhập và trải nghiệm ngay nhé!";
        $subject = "Đăng ký tài khoản thành công trên CuaHangMMO";
        Mail::to($request->email)->send(new AccountEmail($message, $subject, $request->fullName));

        return response()->json($response);
    }

    public function forgot()
    {
        $controller = new Controller();
        return view('Account.forgot-password', compact('controller'));
    }

    public function forgotPass(request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Khôi phục mật khẩu thất bại',
        ];

        $user = users::where('email', $request->email)->first();
        if($user) {
            $agent = new Agent();
            $newPass = 'CuaHangMMO@' . rand(100000, 999999);
            $code = rand(100000, 999999);
            users::where('id', $user->id)->update(['email_code' => $code]);
            $content = "Gửi mã link khôi phục mật khẩu thành công";
            $log = new log_users();
            $log->content = $content;
            $log->ip_address = $request->ip();
            $log->browser = $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform();
            $log->parent_id = $user->id;
            $log->save();

            $message = "Chúng tôi đã khôi phục mật khẩu của bạn. Mật khẩu mới của bạn là: " . $newPass . " - Hãy ấn tiếp tục để chấp nhận mật khẩu mới.";
            $subject = "Có yêu cầu khôi phục mật khẩu từ email: " . $request->email . " trên CuaHangMMO";
            Mail::to($request->email)->send(new AccountEmail($message, $subject, $user->fullName, 'mail-template.forgot-mail', route('login') . '?security='. bcrypt($newPass) .'&code=' . $code, 'Tiếp tục'));

            $response = [
                'status' => true,
                'message' => 'Đã gửi mail khôi phục'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Email không tồn tại',
            ];
        }

        return response()->json($response);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function verifyMail()
    {
        $response = [
            'status' => false,
            'message' => 'Xác thực thất bại',
        ];
        if(Auth::user()->email_verified == 1) {
            $response = [
                'status' => false,
                'message' => 'Email đã được xác thực',
            ];
            return response()->json($response);
        }

        $agent = new Agent();
        log_users::create([
            'content' => 'Yêu cầu xác thực email',
            'ip_address' => request()->ip(),
            'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform(),
            'parent_id' => Auth::user()->id,
        ]);

        $subject = 'Xác thực email ' . Auth::user()->email . ' trên CuaHangMMO';
        $message = 'Chúng tôi rất vui thông báo rằng bạn đã đăng ký tài khoản thành công trên CuaHangMMO. Hãy xác thực email của bạn để bảo vệ tài khoản của mình.';
        $code = rand(100000, 999999);
        users::where('id', Auth::user()->id)->update(['email_code' => $code]);
        Mail::to(Auth::user()->email)->send(new AccountEmail($message, $subject, Auth::user()->fullName, 'mail-template.verify-mail', route('profile') . '?code=' . $code, 'Xác thực ngay'));

        $response = [
            'status' => true,
            'message' => 'Xác thực thành công',
        ];

        return response()->json($response);
    }

    public function updateProfile(request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Cập nhật thất bại',
        ];

        if(users::where('email', $request->email)->where('id', '!=', Auth::user()->id)->exists()) {
            $response = [
                'status' => false,
                'message' => 'Email đã tồn tại',
            ];
            return response()->json($response);
        }

        if(users::where('phone', $request->phone)->where('id', '!=', Auth::user()->id)->exists()) {
            $response = [
                'status' => false,
                'message' => 'Số điện thoại đã tồn tại',
            ];
            return response()->json($response);
        }   

        $user = users::where('id', Auth::user()->id)->first();
        if($user) {
            $user->fullName = $request->fullname;
            $user->email = $request->email;
            if($request->email != Auth::user()->email) {
                $user->email_verified = 0;
            }
            $user->phone = $request->phone;
            $user->is_mission = $request->is_mission;
            $user->save();
            $response = [
                'status' => true,
                'message' => 'Cập nhật thành công',
            ];
        }
        $agent = new Agent();
        log_users::create([
            'content' => 'Cập nhật thông tin cá nhân thành công',
            'ip_address' => $request->ip(),
            'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform(),
            'parent_id' => Auth::user()->id,
        ]);

        return response()->json($response);
    }

    public function updatePass(request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Cập nhật thất bại',
        ];

        $user = users::where('id', Auth::user()->id)->first();
        $agent = new Agent();
        if($user) {
            if(password_verify($request->password, $user->password)) {
                $user->password = bcrypt($request->newpassword);
                $user->save();
                $response = [
                    'status' => true,
                    'message' => 'Cập nhật thành công',
                ];
                log_users::create([
                    'content' => 'Cập nhật mật khẩu thành công',
                    'ip_address' => $request->ip(),
                    'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform(),
                    'parent_id' => Auth::user()->id,
                ]);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Mật khẩu cũ không chính xác',
                ];
            }
        }

        return response()->json($response);
    }

    public function orders()
    {
        $controller = new Controller();
        $orders = orders::select('orders.*', 'products.title')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->where('orders.parent_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('Account.order', compact('controller', 'orders'));
    }

    public function history()
    {
        $controller = new Controller();
        $history = deposit_history::where('parent_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        return view('Account.history', compact('controller', 'history'));
    }

    protected function processBank(request $request)
    {
        if(intval($request->amount) < 10000) {
            return redirect()->back()->with('error', 'Số tiền nạp tối thiểu là 10.000đ');
        }

        $bankInfo = deposit_history::create([
            'parent_id' => Auth::user()->id,
            'amount' => $request->amount,
            'actually_received' => $request->amount
        ]);

        $description = 'naptiencuahangmmo' . 'bank' . $bankInfo->id;
        $bankInfo->update(['description' => $description]);

        $subject = Auth::user()->username . ' gửi yêu cầu nạp ' . number_format($request->amount) . 'đ vào tài khoản CuaHangMMO';
        $message = 'Yêu cầu nạp tiền của ' . Auth::user()->fullName . ' được khởi tạo. Số tiền: ' . number_format($request->amount) . 'đ - Nội dung: ' . $bankInfo->description;
        $template = 'mail-template.banking-mail';
        $link1 = route('staff.banking-status') . '?id=' . $bankInfo->id . '&status=1';
        $link2 = route('staff.banking-status') . '?id=' . $bankInfo->id . '&status=2';

        Mail::to('nguyentany.tricker@gmail.com')->send(new AccountEmail($message, $subject, Auth::user()->fullName, $template, $link1, 'Đã nhận', $link2, 'Chưa nhận'));

        return redirect()->route('bank-info', ['id' => $bankInfo->id])->with('success', 'Đã tạo hóa đơn chuyển khoản thành công');
    }

    public function bankInfo(request $request)
    {
        $deposit = deposit_history::where('id', $request->id)->where('parent_id', Auth::user()->id)->first();

        if(!$deposit) {
            return redirect()->route('history')->with('error', 'Không tìm thấy hóa đơn');
        }

        return view('Account.payment', compact('deposit'));
    }

    protected function supportOrder($id)
    {
        $order = orders::where('id', $id)->where('parent_id', Auth::user()->id)->first();

        if(!$order) {
            return redirect()->route('orders')->with('error', 'Không tìm thấy đơn hàng');
        }

        $order->product_id == 5 ? $time = date('Y-m-d H:i:s', strtotime('-3 hours')) : $time = date('Y-m-d H:i:s', strtotime('-12 hours'));

        if($order->created_at < $time) {
            return redirect()->route('orders')->with('error', 'Không thể hỗ trợ đơn hàng này vì đã quá thời gian bảo hành');
        }

        $check = controller::checkCookie($order->information);

        if($check['status'] == 200) {
            return redirect()->route('orders')->with('error', 'Đơn hàng không bị lỗi');
        }

        $order->product_id == 5 ? $cookies = stock_products::where('parent_id', 5)->where('status', 1)->where('quantity', '>', 0)->get() : $cookies = stock_products::where('parent_id', 14)->where('status', 1)->where('quantity', '>', 0)->get();

        foreach($cookies as $key => $value) {
            $response = controller::checkCookie($value->info);

            if($response['status'] == 200) {
                $value->quantity -= 1;
                $value->save();

                $order->information = $value->info;
                if($value->info_more) {
                    $order->info_more = $value->info_more;
                }
                $order->save();

                return redirect()->route('orders')->with('success', 'Đã hỗ trợ đơn hàng thành công, vui lòng kiểm tra lại');
            }
            $value->quantity = 0;
            $value->status = 0;
            $value->save();
        }

        $message = 'Đơn hàng ' . $order->id . ' bị lỗi, kiểm tra lại ngay kho hàng';
        $subject = 'Thông báo trường hợp hàng die - Cửa hàng MMO';
        Mail::to('cuahangmmovn@gmail.com')->send(new AccountEmail($message, $subject, Auth::user()->fullName, 'mail-template.order-mail', route('staff.index')));
        return redirect()->route('orders')->with('error', 'Vui lòng thử lại sau');
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\RevenueExpenditure;
use App\Models\Treasury;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountEmail;

class AuthPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()) {

            if(Auth::user()->status == 0) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa');
            }

            $mission_now = \App\Models\missions::select('id')->where('status', 1)->where('parent_id', Auth::user()->id)->get();

            if($mission_now) {
                foreach($mission_now as $key => $m) {
                    $mission_users = \App\Models\mission_users::where('parent_id', $m['id'])->where('user_id', Auth::user()->id)->count();

                    if($mission_users > 1) {
                        \App\Models\user::where('id', Auth::user()->id)->update(['status' => 0]);
                        Auth::logout();
                        return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa do spam xu nhiệm vụ');
                    }
                }
            }

            $pay = \App\Models\deposit_history::where('status', 1)->where('parent_id', Auth::user()->id)->get();
            $current_time = time();

            foreach($pay as $key => $value) {
                $convert = strtotime($value['created_at']);
                $elapsed_time = $current_time - $convert;

                if($elapsed_time > (15 * 60)) {
                    $value->status = 'Hủy bỏ';
                    $value->save();
                } else {
                    $url = 'https://my.sepay.vn/userapi/transactions/list?amount_in=' . $value['amount'] . '&transaction_date_min=' . $value['created_at'] . '&transaction_date_max=' . date('Y-m-d H:i:s', $convert + (15 * 60));

                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer QZWFRKAIZ8TDNJGKFS51MPP9UPWILGYURTVWGOQSV96NLJ73Y5XIOQ3NDKBCHODM'
                    ])->get($url);

                    $result = json_decode($response->body(), true);
                    $result = (isset($result['transactions'])) ? $result['transactions'] : [];

                    if($result != []) {
                        foreach($result as $key => $trans) {
                            if(stripos($trans['transaction_content'], $value['description']) !== false) {
                                $value->status = 'Thành công';
                                $value->save();

                                \App\Models\wallet_users::where('parent_id', $value['parent_id'])->increment('money', $value['amount']);
                                \App\Models\wallet_users::where('parent_id', $value['parent_id'])->increment('total', $value['amount']);

                                $agent = new Agent();
                                \App\Models\log_users::create([
                                    'parent_id' => Auth::user()->id,
                                    'content' => Auth::user()->name . ' đã nạp ' . number_format($value['amount']) . ' VNĐ vào tài khoản',
                                    'ip_address' => $request->ip(),
                                    'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
                                ]);
                                Mail::to(Auth::user()->email)->send(new AccountEmail('Chuyển khoản của bạn đã được xác nhận', 'Chuyển khoản thành công', Auth::user()->fullName, 'mail-template.forgot-mail', route('home'), 'Trang chủ'));

                                $model = new RevenueExpenditure();
                                $model->type = 'collect';
                                $model->money = $value['amount'];
                                $model->content = 'Nạp tiền';
                                $model->people = 'Của hàng MMO';
                                $model->parent_id = 1;
                                $model->user_id = auth()->user()->id;
                                $model->date = Carbon::now()->format('d-m-Y');
                                $model->save();

                                if($model->id){
                                    $treasury = Treasury::find(1);
                                    $treasury->total_money += $value['amount'];
                                    $treasury->save();
                                }
                                echo '
                                    <script>
                                        alert("Xác thực thanh toán thành công, bạn đã được cộng '. number_format($value['amount']) .'đ vào tài khoản");
                                    </script>
                                ';
                            }
                        }
                    }
                }
            }
        }

        return $next($request);
    }
}

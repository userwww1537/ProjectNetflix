<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\missions;
use Illuminate\Support\Facades\Http;
use App\Models\users;
use App\Mail\AccountEmail;
use Illuminate\Support\Facades\Mail;

class AutoCreatedMission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-created-mission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tự động tạo nhiệm vụ theo khung giờ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $code = rand(100000, 999999);
        $url = route('mission') . '?code=' . $code;

        $mission = new missions();
        $mission->code = $code;
        $mission->title = '	Vượt link rút gọn khung giờ ' . date('H:i');
        $mission->reward = 1;
        $mission->type_reward = 1;
        $mission->code = $code;
        $mission_check = missions::where('link', 'like', '%8link%')->orWhere('link', 'like', '%yeumoney%')->orderBy('id', 'desc')->first();
        if(stripos($mission_check->link, '8link') !== false) {
            $res = Http::get('https://yeumoney.com/QL_api.php?token=756859ee73eee48762b8a95131a56fc4f1e8d9c3511fd1d4139038ab61283487&format=json&url='. $url .'');
            $data = $res->json();
            $mission->link = $data['shortenedUrl'];
        } else {
            $res = Http::get('https://partner.8link.io/api/public/gen-shorten-link?apikey=ee2daf8990a18ed78c0408f3fb91bf20250b099bd86fecaaf5d26da66b45ebc6&url='. $url .'&target_domain=https://8link.vip');
            $data = $res->json();
            $mission->link = $data['shortened_url'];
        }
        $mission->parent_id = 13;

        $users = users::where('is_mission', 1)->get();
        $emails = [];

        foreach ($users as $user) {
            $emails[] = $user->email;
        }

        mail::to($emails)->send(new AccountEmail('Nhiệm vụ mới từ Cửa hàng MMO có giá trị 1 xu', 'Bạn ơi, Cửa hàng MMO có nhiệm vụ mới rồi đó', 'bạn', 'mail-template.mission-mail', route('mission'), 'Link nhiệm vụ'));
        $mission->save();
    }
}

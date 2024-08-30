<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\log_users;
use App\Models\role_users;
use App\Models\users;
use App\Models\wallet_users;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = users::all();
        return view('admin.users.index', compact('users'));
    }

    public function updateWaller(Request $request, string $id)
    {
        request()->validate([
            'price' => 'required',
            'coin' => 'required',
        ]);
        $wallet = wallet_users::where('parent_id', $id)->first();
        $wallet->money = str_replace(',','', $request->price);
        $wallet->coin = str_replace(',','', $request->coin);
        $wallet->save();

        $agent = new Agent();
                log_users::create([
                    'parent_id' => auth()->user()->id,
                    'content' => 'Thay đổi số xu trong tài khoản',
                    'ip_address' => $request->ip(),
                    'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
                ]);
        return back()->with('success','Cập nhật thành công');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = role_users::all();
        $user = users::find($id);

        return view('admin.users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = users::find($id);
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        $user->save();

        $agent = new Agent();
        log_users::create([
            'parent_id' => auth()->user()->id,
            'content' => 'Thay đổi thông tin tài khoản',
            'ip_address' => $request->ip(),
            'browser' => $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' - ' . $agent->platform()
        ]);
        return redirect()->back()->with('success','Cập nhật thành công');
    }
}

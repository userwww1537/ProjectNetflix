<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RevenueExpenditure;
use App\Models\Treasury;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RevenueExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = RevenueExpenditure::with('user')->get();
        $treasury = Treasury::find(1);

        return view('admin.treasuries.index', compact('items', 'treasury'));
    }

    /**m
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $treasuries = Treasury::all();
        return view('admin.treasuries.create', compact('treasuries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $imageName = null;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }
        $money = str_replace(',', '', $request->money);
        $model = new RevenueExpenditure();
        $model->type = $request->type;
        $model->money =$money;
        $model->content = $request->content;
        $model->people = $request->people;
        $model->number_phone = $request->number_phone;
        $model->parent_id = $request->parent_id;
        $model->user_id = auth()->user()->id;
        $model->image = $imageName;
        $model->date = Carbon::parse($request->date)->format('d-m-Y');
        $model->save();

        if($model->id){
            $treasury = Treasury::find($request->parent_id);
            if($request->type == 'collect'){
                $treasury->total_money = $treasury->total_money + $money;
            } elseif($request->type == 'spend'){
                $treasury->total_money = $treasury->total_money - $money;
            }
            $treasury->save();
        }
        return redirect()->route('admin.treasury.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\deposit_history;
use App\Models\mission_users;
use App\Models\orders;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalUser = User::count();
        $totalAmount = deposit_history::where('status', 'Thành công')->sum('amount');
        $totalOrder = orders::where('status', 'Hoàn thành')->count();
        $countMission = mission_users::count();
        $totalAmountMission = $countMission * 500;

        if (!empty($request->month_order)) {
            $month = $request->month_order;
        } else {
            $month = Carbon::now()->month;
        }
        if (!empty($request->year_order)) {
            $year = $request->year_order;
        } else {
            $year = Carbon::now()->year;
        }

        $deposits = deposit_history::where('status', 2)->latest();
        if ($request->ajax()) {
            if ($request->month_order && $request->year_order) {
                return $this->getOrderData($request->month_order, $request->year_order);
            }

            // $deposits = deposit_history::latest();

            if ($request->date_start_deposit || $request->date_end_deposit) {
                $deposits = $deposits->where(function ($query) use ($request) {
                    if ($request->date_start_deposit) {
                        $query->where('created_at', '>=', Carbon::parse($request->date_start_deposit)->startOfDay());
                    }

                    if ($request->date_end_deposit) {
                        $query->where('created_at', '<=', Carbon::parse($request->date_end_deposit)->endOfDay());
                    }
                });
            }

            $deposits = $deposits->get();
            $totalAmount = $deposits->sum('amount');
            return response()->json([
                'deposits' => $deposits,
                'totalAmount' => number_format($totalAmount, 0, ',', '.') . ' ₫',
                'html' => view('admin.layout.table-amount', compact('deposits', 'totalAmount'))->render()
            ]);
        }
        $deposits = $deposits->get();

        // data chart order
        $ordersPerDay = orders::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        $day = [];
        $dayDeposit = [];
        $countOrder = [];
        foreach ($ordersPerDay as $item) {
            $day[] = $item->date;
            $countOrder[] = $item->total;
        }

        // data chart deposit
        $depositPerDay = deposit_history::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status',2)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalAmountDeposit = [];
        foreach ($depositPerDay as $item) {
            $totalAmountDeposit[] = $item->total;
            $dayDeposit[] = $item->date;
        }
        return view('admin.dashboard', compact(
            'totalUser',
            'totalAmount',
            'deposits',
            'totalOrder',
            'totalAmountMission',
            'countMission',
            'month',
            'year',
            'day',
            'countOrder',
            'totalAmountDeposit',
            'dayDeposit'
        )
        );
    }

    private function getOrderData($month, $year)
    {
        // data order chart
        $ordersPerDay = orders::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('date')
            ->orderBy('date')
            ->limit(31)
            ->get();

        $day = [];
        $dayDeposit = [];
        $countOrder = [];
        foreach ($ordersPerDay as $item) {
            $day[] = $item->date;
            $countOrder[] = $item->total;
        }

        // data deposit
        $depositPerDay = deposit_history::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('date')
            ->orderBy('date')
            ->where('status', 2)
            ->limit(31)
            ->get();
        $totalAmountDeposit = [];
        foreach ($depositPerDay as $item) {
            $totalAmountDeposit[] = $item->total;
            $dayDeposit[] = $item->date;
        }

        return response()->json([
            'labels' => $day,
            'label2' => $dayDeposit,
            'order' => $countOrder,
            'deposit' => $totalAmountDeposit
        ]);
    }
}



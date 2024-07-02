<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IncomeController extends Controller
{
    //
    public function getIncome(Request $request)
    {
        $filter = $request->filter;
        Log::info("request : " . json_encode($request));
        Log::info("filter : " . $filter);
        try {
            $totals = [];
            if ($filter == "today") {
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                $totalIncome = Transaction::whereBetween('settlement_time', [$start, $end])
                    ->sum('gross_amount');
                $totalTransaction = Transaction::whereBetween('settlement_time', [$start, $end])
                    ->count('transaction_id');
                $totals[] = ['income' => $totalIncome, 'totalTransaction' => $totalTransaction, "date" => Carbon::today()->toDateString()];
            } else if ($filter == "weekly") {
                $dates = $this->getDatesForCurrentWeek();
                foreach ($dates as $date) {
                    $start = Carbon::parse($date)->startOfDay();
                    Log::info("start : " . $start);
                    $end = Carbon::parse($date)->endOfDay();
                    Log::info("end : " . $end);
                    $totalIncome = Transaction::whereBetween('settlement_time', [$start, $end])
                        ->sum('gross_amount');
                    $totalTransaction = Transaction::whereBetween('settlement_time', [$start, $end])
                        ->count('transaction_id');
                    array_push($totals, ['income' => $totalIncome, 'totalTransaction' => $totalTransaction, "date" => $date]);
                }
            } else if ($filter == "monthly") {
                $dates = $this->getDatesFromStartOfMonthToToday();
                foreach ($dates as $date) {
                    $start = Carbon::parse($date)->startOfDay();
                    Log::info("start : " . $start);
                    $end = Carbon::parse($date)->endOfDay();
                    Log::info("end : " . $end);
                    $totalIncome = Transaction::whereBetween('settlement_time', [$start, $end])
                        ->sum('gross_amount');
                    $totalTransaction = Transaction::whereBetween('settlement_time', [$start, $end])
                        ->count('transaction_id');
                    array_push($totals, ['income' => $totalIncome, 'totalTransaction' => $totalTransaction, "date" => $date]);
                }
            }
            Log::info("totals : " . json_encode($totals));
            return response()->json(['isSuccess' => true, 'errorMessage' => null, "data" => $totals]);
        } catch (Exception $e) {
            return response()->json(['isSuccess' => false, 'errorMessage' => $e->getMessage(), "data" => null]);
        }
    }

    public function getDatesForCurrentWeek()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        Log::info("start of week : " . $startOfWeek);
        $endOfWeek = Carbon::now();
        Log::info("end of week : " . $endOfWeek);

        $dates = [];
        $currentDate = $startOfWeek->copy();

        while ($currentDate->lte($endOfWeek)) {
            $dates[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        return $dates;
    }

    public function getDatesFromStartOfMonthToToday()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        Log::info("start of month : " . $startOfMonth);
        $today = Carbon::now();
        Log::info("start of today : " . $today);

        $dates = [];
        $currentDate = $startOfMonth->copy();

        while ($currentDate->lte($today)) {
            $dates[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        return $dates;
    }
}

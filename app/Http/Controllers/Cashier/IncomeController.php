<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    //
    public function getIncome(Request $request)
    {
        $filter = $request->filter;
        try {
            if ($filter == "today") {
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                $totalIncome = Transaction::whereBetween('settlement_time', [$start, $end])
                    ->sum('gross_amount');
                $totalTransaction = Transaction::whereBetween('settlement_time', [$start, $end])
                    ->count('transaction_id');
                $totals = [['income' => $totalIncome, 'totalTransaction' => $totalTransaction, "date" => Carbon::today()->toDateString()]];
            } else if ($filter == "weekly") {
                $dates = $this->getDatesForCurrentWeek();
                $totals = [];
                foreach ($dates as $date) {
                    $start = Carbon::parse($date)->startOfDay();
                    $end = Carbon::parse($date)->endOfDay();
                    $totalIncome = Transaction::whereBetween('settlement_time', [$start, $end])
                        ->sum('gross_amount');
                    $totalTransaction = Transaction::whereBetween('settlement_time', [$start, $end])
                        ->count('transaction_id');
                    $totals[] = ['income' => $totalIncome, 'totalTransaction' => $totalTransaction, "date" => Carbon::today()->toDateString()];
                }
            } else if ($filter == "monthly") {
                $dates = $this->getDatesForCurrentWeek();
                $totals = [];
                foreach ($dates as $date) {
                    $start = Carbon::parse($date)->startOfDay();
                    $end = Carbon::parse($date)->endOfDay();
                    $totalIncome = Transaction::whereBetween('settlement_time', [$start, $end])
                        ->sum('gross_amount');
                    $totalTransaction = Transaction::whereBetween('settlement_time', [$start, $end])
                        ->count('transaction_id');
                    $totals[] = ['income' => $totalIncome, 'totalTransaction' => $totalTransaction, "date" => Carbon::today()->toDateString()];
                }
            }
            return response()->json(['isSuccess' => true, 'errorMessage' => null, "data" => $totals]);
        } catch (Exception $e) {
            return response()->json(['isSuccess' => false, 'errorMessage' => $e->getMessage(), "data" => null]);
        }
    }

    public function getDatesForCurrentWeek()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now();

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
        $today = Carbon::now();

        $dates = [];
        $currentDate = $startOfMonth->copy();

        while ($currentDate->lte($today)) {
            $dates[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        return $dates;
    }
}

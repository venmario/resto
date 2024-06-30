<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Exception;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function getOpenCloseHour()
    {
        try {
            $stores = Store::all();
            if (count($stores) > 0) {
                return response()->json(['isSuccess' => true, 'errorMessage' => null, 'data' => $stores[0]]);
            }
            return response()->json(['isSuccess' => true, 'errorMessage' => null, 'data' => null]);
        } catch (Exception $e) {
            return response()->json(['isSuccess' => false, 'errorMessage' => $e->getMessage(), 'data' => null]);
        }
    }

    public function setOpenCloseHour(Request $request, Store $store)
    {
        $open = $request->open;
        $close = $request->close;

        try {
            if ($store == null) {
                $store->create(['open' => $open, 'close' => $close]);
            } else {
                $store->update(['open' => $open, 'close' => $close]);
            }
            return response()->json(['isSuccess' => true, 'errorMessage' => null, 'data' => $store]);
        } catch (Exception $e) {
            return response()->json(['isSuccess' => false, 'errorMessage' => $e->getMessage(), 'data' => null]);
        }
    }
}

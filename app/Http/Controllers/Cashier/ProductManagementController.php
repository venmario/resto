<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductManagementController extends Controller
{
    //

    public function getCategories()
    {
        $categories = Category::where('name', '!=', 'Makanan')->where('name', '!=', 'Minuman')->orderBy('sequence')->get();
        return response()->json(['isSuccess' => true, "errorMessage" => null, "data" => $categories]);
    }

    public function getAllProduct()
    {
        $categories = Category::with('product')->where('name', '!=', 'Makanan')->where('name', '!=', 'Minuman')->orderBy('sequence')->get();
        return response()->json(['isSuccess' => true, "errorMessage" => null, "data" => $categories]);
    }

    public function getProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json(['isSuccess' => true, "errorMessage" => null, "data" => $product]);
        } catch (Exception $e) {
            return response()->json(['isSuccess' => false, "errorMessage" => $e->getMessage(), "data" => null]);
        }
    }

    public function createProduct(Request $request)
    {
        $product = $request->all();
        try {
            $product = Product::create($product);
            return response()->json(['isSuccess' => true, "errorMessage" => null, "data" => $product]);
        } catch (Exception $e) {
            Log::error("error : " . $e->getMessage());
            return response()->json(['isSuccess' => false, "errorMessage" => $e->getMessage(), "data" => null]);
        }
    }
    public function updateProduct($id, Request $request)
    {
        $productData = $request->all();
        try {
            $product = Product::where('id', $id)->first();
            $result = $product->update($productData);
            $updatedProduct = $product->refresh();
            if ($result == 1) {
                return response()->json(['isSuccess' => true, "errorMessage" => null, "data" => $updatedProduct]);
            }
            return response()->json(['isSuccess' => false, "errorMessage" => "failed updating product", "data" => null]);
        } catch (Exception $e) {
            Log::error("error : " . $e->getMessage());
            return response()->json(['isSuccess' => false, "errorMessage" => $e->getMessage(), "data" => null]);
        }
    }
    public function deleteProduct($id)
    {
        try {
            Product::find($id)->delete();
            return response()->json(['isSuccess' => true, "errorMessage" => null, "data" => null]);
        } catch (Exception $e) {
            Log::error("error : " . $e->getMessage());
            return response()->json(['isSuccess' => false, "errorMessage" => $e->getMessage(), "data" => null]);
        }
    }
}

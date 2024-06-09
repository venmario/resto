<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    //
    public function getProductByCategory()
    {
        Log::info("get products");
        $categories = Category::with('product')->where('name', '!=', 'Makanan')->where('name', '!=', 'Minuman')->orderBy('sequence')->get();
        return response()->json($categories, Response::HTTP_OK);
    }

    public function getProductById(Product $product)
    {
        return response()->json($product, Response::HTTP_OK);
    }
}

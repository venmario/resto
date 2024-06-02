<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    //
    public function getProductByCategory()
    {
        $categories = Category::with('product')->where('name', '!=', 'Makanan')->where('name', '!=', 'Minuman')->get();
        return response()->json($categories, Response::HTTP_OK);
    }

    public function getProductById(Product $product)
    {
        return response()->json($product, Response::HTTP_OK);
    }
}

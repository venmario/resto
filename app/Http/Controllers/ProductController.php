<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    //
    public function getProductByCategory($categoryId)
    {
        $products = Product::with(['category' => function ($query) use ($categoryId) {
            $query->where('id', $categoryId);
        }])->get();

        return response()->json($products, Response::HTTP_OK);
    }

    public function getProductById(Product $product)
    {
        return response()->json($product, Response::HTTP_OK);
    }
}

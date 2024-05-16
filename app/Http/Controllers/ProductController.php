<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    //
    public function getProductByCategory(Category $category)
    {
        $products = Product::where('category_id', $category->id);

        return response()->json($products, Response::HTTP_OK);
    }
}

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

    public function addCategory()
    {
        Category::create([
            'id' => 23,
            'name' => 'Makanan Kering',
            'parent_id' => 1,
            'sequence' => 21
        ]);
    }

    public function updateCategory()
    {
        $cat = Category::find(23);
        $cat->update([
            'name' => 'Baksos'
        ]);
    }

    public function deleteCategory()
    {
        $cat = Category::destroy(23);
    }

    public function addProduct()
    {
        Product::create([
            'id' => 106,
            'name' => 'Mie Gacoan',
            'description' => 'Mie Pedas',
            'image' => 'https://plus.unsplash.com/premium_photo-1666978195894-b2e3a3f14d9b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'available' => false,
            'category_id'  => 22,
            'price' => 100000,
            'poin' => 100
        ]);
    }

    public function updateProduct()
    {
        $prod = Product::find(106);
        $prod->update([
            'name' => 'Internet'
        ]);
    }

    public function deleteProduct()
    {
        Product::destroy(106);
    }
}

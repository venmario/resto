<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function order()
    {
        return $this->belongsToMany(Order::class, 'order_details')->withPivot('price', 'poin', 'quantity', 'note');
    }
}

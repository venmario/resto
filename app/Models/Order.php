<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_id', 'id')->withPivot('price', 'poin', 'quantity', 'note')->withTimestamps();
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'order_id', 'id');
    }
}

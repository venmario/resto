<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $keyType = "string";
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'order_details')->withPivot('price', 'poin', 'quantity', 'note');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'order_id', 'id');
    }

    public static function generate_unique_6_digit()
    {
        $unique_id = uniqid('', true);
        $hashed_id = hash('sha256', $unique_id);
        return intval(substr($hashed_id, 0, 6), 16) % 900000 + 100000;
    }

    public static function generateOrderId()
    {
        $digits = Order::generate_unique_6_digit();
        return date('Ym') . $digits;
    }
}

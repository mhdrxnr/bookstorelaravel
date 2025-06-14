<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id'; 
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['userID','totalPrice','status'];

    public function user()
    {
        return $this->belongsTo(User::class,'userID','user_id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class,'order_details','orderID','bookID');
                    // ->withPivot('quantity','unitPrice');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'book_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['title', 'author', 'price', 'description', 'categoryID', 'image'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID', 'category_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details', 'orderID', 'bookID');
        // ->withPivot('quantity','unitPrice');
    }

    public function favoriteByUser()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }
}

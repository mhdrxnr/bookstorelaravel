<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'category_id'; 
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable =['name'];

    public function books(){
        return $this->hasMany(Book::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable =['image','firstName','lastName','number','wilaya','address','userID'];
    protected $visible = ['client_id', 'firstName', 'lastName', 'number', 'wilaya', 'address', 'image', 'userID'];

    public function user(){
        return $this->belongsTo(User::class, 'userID', 'user_id');
    }

   
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable =['firstName','lastName','number','wilaya','address','userID'];

    public function user(){
        return $this->hasOne(Client::class);
    }

   
}

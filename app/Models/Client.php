<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['user_id','image','accepted' ,'full_name', 'mobile_number', 'file_path'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

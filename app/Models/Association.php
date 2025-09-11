<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    protected $fillable = ['user_id', 'image','accepted','rating','full_name', 'mobile_number', 'file_path','lisence'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

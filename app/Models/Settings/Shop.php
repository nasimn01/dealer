<?php

namespace App\Models\Settings;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    public function dsr(){
        return $this->belongsTo(User::class,'dsr_id','id');
    }
}

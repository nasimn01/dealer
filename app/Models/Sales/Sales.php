<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\Shop;
use App\Models\User;
use App\Models\Sales\SalesPayment;

class Sales extends Model
{
    use HasFactory;
    public function shop(){
        return $this->belongsTo(Shop::class,'shop_id','id');
    }
    public function dsr(){
        return $this->belongsTo(User::class,'dsr_id','id');
    }
    public function sales_payment(){
        return $this->hasMany(SalesPayment::class,'sales_id','id');
    }

    public function sales_details(){
    return $this->hasMany(SalesDetails::class,'sales_id','id');
    }
}

<?php

namespace App\Models\Do;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;
use App\Models\Do\D_o;

class DoReceiveHistory extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function do(){
        return $this->belongsTo(D_o::class,'do_id','id');
    }
}

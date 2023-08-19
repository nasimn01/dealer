<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Settings\Unit;
use App\Models\Settings\Supplier;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    public function group(){
     return $this->belongsTo(Group::class,'group_id','id');
    }

    public function category(){
     return $this->belongsTo(Category::class,'category_id','id');
    }

    public function unit(){
     return $this->belongsTo(Unit::class,'base_unit','id');
    }

    public function distributor(){
        return $this->belongsTo(Supplier::class,'distributor_id','id');
    }
}

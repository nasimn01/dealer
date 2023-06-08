<?php

namespace App\Models\Do;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Settings\Supplier;

class D_o extends Model
{
    use HasFactory,SoftDeletes;
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
}

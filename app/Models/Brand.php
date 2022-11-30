<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\QueryBuilderTrait;

class Brand extends Model
{
    use HasFactory, SoftDeletes, QueryBuilderTrait;
    public $timestamps = true;
    protected $fillable = [
        'name',
        'logo',
        'banner',
        'description'
    ];

    protected $hidden = ['deleted_at'];

    public function outlets()
    {
        return $this->hasMany('App\Models\Outlet','brand_id','id');
    }

    public function products(){
        return $this->hasMany('App\Models\Product','brand_id','id');
    }
}

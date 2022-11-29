<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\QueryBuilderTrait;

class Product extends Model
{
    use HasFactory, SoftDeletes, QueryBuilderTrait;
    public $timestamps = true;
    protected $fillable = [
        'name',
        'picture',
        'price',
        'brand_id',
        'description'
    ];
    protected $hidden = ['deleted_at'];

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand','brand_id','id')->select('id','name');
    }
}

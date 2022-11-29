<?php
namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface{
    protected $product;

    public function __construct(){
        $this->product = new Product();
    }

    public function fetch($request){
        $query = $this->product->with('brand');

        if($request->brand_id){
            $query->where('brand_id', $request->brand_id);
        }

        return $query->getOrPaginate($request->paginate, $request->per_page);
    }


    public function show($id){
        return $this->product->with('brand')->where('id',$id)->first();
    }

    public function store(array $data){
        return $this->product->create($data);
    }

    public function update($id, array $data){
        return $this->product->where('id',$id)->update($data);
    }

    public function destroy($id){
        return $this->product->where('id',$id)->delete();
    }
}

<?php
namespace App\Repositories;

use App\Interfaces\BrandRepositoryInterface;
use App\Models\Brand;

class BrandRepository implements BrandRepositoryInterface{
    protected $brand;

    public function __construct(){
        $this->brand = new Brand();
    }

    public function fetch($request){
        return $this->brand->withCount('outlets','products')->getOrPaginate($request->paginate, $request->per_page);
    }

    public function show($id){
        return $this->brand->with('outlets','products')->where('id',$id)->first();
    }

    public function store(array $data){
        return $this->brand->create($data);
    }

    public function update($id, array $data){
        return $this->brand->where('id',$id)->update($data);
    }

    public function destroy($id){
        return $this->brand->where('id',$id)->delete();
    }
}

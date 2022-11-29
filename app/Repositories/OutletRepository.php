<?php
namespace App\Repositories;

use App\Interfaces\OutletRepositoryInterface;
use App\Models\Outlet;

class OutletRepository implements OutletRepositoryInterface{
    protected $outlet;

    public function __construct(){
        $this->outlet = new Outlet();
    }

    public function fetch($request){
        $query = $this->outlet->with('brand');

        if($request->brand_id){
            $query->where('brand_id', $request->brand_id);
        }

        return $query->getOrPaginate($request->paginate, $request->per_page);
    }

    public function show($id){
        return $this->outlet->with('brand')->where('id',$id)->first();
    }

    public function store(array $data){
        return $this->outlet->create($data);
    }

    public function update($id, array $data){
        return $this->outlet->where('id',$id)->update($data);
    }

    public function destroy($id){
        return $this->outlet->where('id',$id)->delete();
    }
}

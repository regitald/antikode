<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Interfaces\ProductRepositoryInterface;

class ProductService
{
    protected $product_repo;
    public function __construct(ProductRepositoryInterface $product_repo)
    {
        $this->product_repo = $product_repo;
    }

    public function fetch($request)
    {
        $data = $this->product_repo->fetch($request);

        return $this->appendData($request, $data);
    }
    public function show($id)
    {
        $data = $this->product_repo->show($id);
        if($data)
            $data['picture_url']  = url("/images/products/".$data['picture']);

        return $data;
    }

    public function store($request)
    {

        $picture = uploadFile($request->picture,"products");

        $data = [
            'name'      => $request['name'],
            'picture'   => $picture,
            'price'     => $request['price'],
            'brand_id'  => $request['brand_id'],
            'description'  => $request['description'],
        ];

        return $this->product_repo->store($data);
    }


    public function update($request, $id)
    {
        $data = [
            'name'      => $request['name'],
            'price'     => $request['price'],
            'brand_id'  => $request['brand_id'],
            'description'  => $request['description']
        ];

        if ($request['picture']) {
            $data['picture'] = uploadFile($request['picture'],"products");
        }
        return $this->product_repo->update($id, $data);
    }

    public function destroy($id)
    {
        $data = $this->show($id);
        if($data){
            deleteFile($data->picture,"products");
        }
        return $this->product_repo->destroy($id);
    }

    private function appendData($request, $data){
        if($request['paginate']== 'true'){
            $data->getCollection()->transform(function ($value) {
                $value['picture_url']  = url("/images/products/".$value['picture']);
                return $value;
            });
        }else{
            $data = collect($data)->map(function($key){
                $key['picture_url']  = url("/images/products/".$key['picture']);
                return $key;
            });
        }
        return $data;
    }

}

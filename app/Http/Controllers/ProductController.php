<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Validator;

class ProductController extends Controller
{
    protected $product_service;
    use GeneralTrait;
    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }

    public function index(Request $request)
    {
        $data = $this->product_service->fetch($request);

        return $this->ResponseJson(200,"Product Data",$data);
    }

    public function show($id)
    {
        $data = $this->product_service->show($id);

        if(!$data) {
            return $this->ResponseJson(404,"Product Not Found");
        }

        return $this->ResponseJson(200,"Product Detail",$data);

    }

    public function store(Request $request)
    {
        $rules = [
			'name'      => 'required',
			'picture'   => 'required',
			'price'     => 'required',
			'brand_id'  => 'required',
			'description' => 'required',
		];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ResponseJson(422,$validator->errors()->first());
        }

        $data = $this->product_service->store($request);

        return $this->ResponseJson(201,"Product Created",$data);
    }

    public function update(Request $request, $id)
    {
        $data = $this->product_service->update($request, $id);

        if(!$data){
            return $this->ResponseJson(400,"Fail update Product!");
        }

        return $this->ResponseJson(200,"Product Updated");
    }

    public function destroy($id)
    {
        $data = $this->product_service->destroy($id);

        if(!$data){
            return $this->ResponseJson(400,"Fail to delete Product!");
        }

        return $this->ResponseJson(200,"Product Deleted");
    }

}

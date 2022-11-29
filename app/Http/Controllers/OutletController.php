<?php

namespace App\Http\Controllers;

use App\Services\OutletService;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Validator;

class OutletController extends Controller
{
    protected $outlet_service;
    use GeneralTrait;
    public function __construct(OutletService $outlet_service)
    {
        $this->outlet_service = $outlet_service;
    }

    public function index(Request $request)
    {
        $data = $this->outlet_service->fetch($request);

        return $this->ResponseJson(200,"Outlet Data",$data);
    }

    public function show($id)
    {
        $data = $this->outlet_service->show($id);

        if(!$data) {
            return $this->ResponseJson(404,"Outlet Not Found");
        }

        return $this->ResponseJson(200,"Outlet Detail",$data);

    }

    public function store(Request $request)
    {
        $rules = [
			'name'      => 'required',
			'picture'   => 'required',
			'longitude' => 'required',
			'latitude'  => 'required',
			'address'   => 'required',
			'brand_id'   => 'required',
		];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ResponseJson(422,$validator->errors()->first());
        }

        $data = $this->outlet_service->store($request);

        return $this->ResponseJson(201,"Outlet Created",$data);
    }

    public function update(Request $request, $id)
    {
        $data = $this->outlet_service->update($request, $id);

        if(!$data){
            return $this->ResponseJson(400,"Fail update Outlet!");
        }

        return $this->ResponseJson(200,"Outlet Updated");
    }

    public function destroy($id)
    {
        $data = $this->outlet_service->destroy($id);

        if(!$data){
            return $this->ResponseJson(400,"Fail to delete Outlet!");
        }

        return $this->ResponseJson(200,"Outlet Deleted");
    }

}

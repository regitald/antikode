<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Validator;

class BrandController extends Controller
{
    protected $brand_service;
    use GeneralTrait;
    public function __construct(BrandService $brand_service)
    {
        $this->brand_service = $brand_service;
    }

    public function index(Request $request)
    {
        $data = $this->brand_service->fetch($request);

        return $this->ResponseJson(200,"Brand Data",$data);
    }

    public function show($id)
    {
        $data = $this->brand_service->show($id);

        if(!$data) {
            return $this->ResponseJson(404,"Brand Not Found");
        }

        return $this->ResponseJson(200,"Brand Detail",$data);

    }

    public function store(Request $request)
    {
        $rules = [
			'name'   => 'required',
			'logo'   => 'required',
			'banner' => 'required',
			'description' => 'required',
		];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ResponseJson(422,$validator->errors()->first());
        }

        $data = $this->brand_service->store($request);

        return $this->ResponseJson(201,"Brand Created",$data);
    }

    public function update(Request $request, $id)
    {
        $data = $this->brand_service->update($request, $id);

        if(!$data){
            return $this->ResponseJson(400,"Fail update brand!");
        }

        return $this->ResponseJson(200,"Brand Updated");
    }

    public function destroy($id)
    {
        $data = $this->brand_service->destroy($id);

        return $this->ResponseJson(200,"Brand Deleted");
    }

}

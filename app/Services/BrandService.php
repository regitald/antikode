<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Interfaces\BrandRepositoryInterface;

class BrandService
{
    protected $brand_repo;
    public function __construct(BrandRepositoryInterface $brand_repo)
    {
        $this->brand_repo = $brand_repo;
    }

    public function fetch($request)
    {
        $data = $this->brand_repo->fetch($request);

        return $this->appendData($request, $data);
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

    public function show($id)
    {
        $data = $this->brand_repo->show($id);
        if($data){
            $data['logo_url']  = url("/images/brands/".$data['logo']);
            $data['banner_url']  = url("/images/brands/".$data['banner']);
        }
        return $data;
    }

    public function store($request)
    {

        $logo = uploadFile($request->logo,"brands");
        $banner = uploadFile($request->banner,"brands");

        $data = [
            'name' => $request['name'],
            'logo' => $logo,
            'banner' => $banner,
            'description' => $request['description']
        ];

        return $this->brand_repo->store($data);
    }


    public function update($request, $id)
    {
        $data = [
            'name' => $request['name'],
            'description' => $request['description']
        ];

        if ($request['logo']) {
            $data['logo'] = uploadFile($request['logo'],"brands");
        }
        if ($request['banner']) {
            $data['banner'] = uploadFile($request['banner'],"brands");
        }
        return $this->brand_repo->update($id, $data);
    }

    public function destroy($id)
    {
        $data = $this->show($id);
        if($data){
            deleteFile($data->logo,"brands");
            deleteFile($data->banner,"brands");
        }
        return $this->brand_repo->destroy($id);
    }

}

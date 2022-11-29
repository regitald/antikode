<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Interfaces\OutletRepositoryInterface;

class OutletService
{
    protected $outlet_repo;
    public function __construct(OutletRepositoryInterface $outlet_repo)
    {
        $this->outlet_repo = $outlet_repo;
    }

    public function fetch($request)
    {
        $data = $this->outlet_repo->fetch($request);
        return $this->appendData($request, $data);
    }

    private function appendData($request, $data){
        $longitude = $request['longitude'];
        $latitude = $request['latitude'];
        if($request['paginate']== 'true'){
            $data->getCollection()->transform(function ($value) use($longitude, $latitude) {
                $value['picture_url']  = url("/images/outlets/".$value['picture']);
                $value['distance']  = calculate_distance($value['latitude'], $value['longitude'], $latitude, $longitude);
                return $value;
            })->sortBy('distance');
        }else{
            $data = collect($data)->map(function($key) use($longitude, $latitude) {
                $key['picture_url']  = url("/images/outlets/".$key['picture']);
                $key['distance']  = calculate_distance($key['latitude'], $key['longitude'], $latitude, $longitude);
                return $key;
            })->sortBy('distance')->values();
        }
        return $data;
    }

    public function show($id)
    {
        $data = $this->outlet_repo->show($id);
        if($data)
            $data['picture_url']  = url("/images/outlets/".$data['picture']);

        return $data;
    }

    public function store($request)
    {

        $picture = uploadFile($request->picture,"outlets");

        $data = [
            'name'      => $request['name'],
            'picture'   => $picture,
            'longitude' => $request['longitude'],
            'latitude'  => $request['latitude'],
            'address'   => $request['address'],
            'brand_id'   => $request['brand_id']
        ];

        return $this->outlet_repo->store($data);
    }


    public function update($request, $id)
    {
        $data = [
            'name'      => $request['name'],
            'longitude' => $request['longitude'],
            'latitude'  => $request['latitude'],
            'address'   => $request['address']
        ];

        if ($request['picture']) {
            $data['picture'] = uploadFile($request['picture'],"outlets");
        }
        return $this->outlet_repo->update($id, $data);
    }

    public function destroy($id)
    {
        $data = $this->show($id);
        if($data){
            deleteFile($data->picture,"outlets");
        }
        return $this->outlet_repo->destroy($id);
    }

}

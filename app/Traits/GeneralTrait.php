<?php

namespace App\Traits;

trait GeneralTrait {

    public function ResponseJson($status,$message,$data = null){
        $response = [
            'status' => $status,
            'message' => $message
        ];
        if($data){
            $response['data'] = $data;
        }
		return response()->json($response, $status);
	}

}

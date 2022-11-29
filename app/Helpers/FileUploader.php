<?php

if(!function_exists("get_file_name")){
    function getFilename($extension, $file_name){
        $file_name = Str::random(10)."_".$file_name."_".time().'.'.$extension;
        return $file_name;
    }
}

if(!function_exists("uploadFile")){
    function uploadFile($file, $folder_name, $storage_name = "images"){
        if($file){
            $file_name =  getFilename($file->getClientOriginalExtension(), "brand");
            $path = $storage_name."/".$folder_name."/".$file_name;
            $storage = Storage::disk('uploads');

            $checkDirectory = $storage->exists($storage_name.'/'.$folder_name);

            if (!$checkDirectory) {
                $storage->makeDirectory($storage_name.'/'.$folder_name);
            }

            $storage->put($path, file_get_contents($file), 'public');

            return $file_name;
        }else{
            return NULL;
        }
    }
}
if(!function_exists("deleteFile")){
    function deleteFile($file_name, $folder_name, $storage_name = "images"){
        $path = $storage_name."/".$folder_name."/".$file_name;
        $storage = Storage::disk("uploads");
        $storage->delete($path);
        return $storage;
    }
}

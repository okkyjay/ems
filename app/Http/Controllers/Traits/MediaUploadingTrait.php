<?php

namespace App\Http\Controllers\Traits;

use App\Http\Requests\Api\FileRequest;
use Illuminate\Http\Request;


trait MediaUploadingTrait
{

    public function fileUploadMethod(FileRequest $request)
    {
        $file = $request->file('file');

        $path = storage_path('tmp/uploads');

        try {
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        } catch (\Exception $e) {
        }

        if(is_array($file)){
            $files = $file;
            $response = [];
            foreach($files as $key => $file){
                $name = uniqid() . '_' . trim($file->getClientOriginalName());
                $file->move($path, $name);
                $response[$key] = ['name' => $name, 'original_name' => $file->getClientOriginalName()];
            }
            return $response;
        } else{
            $name = uniqid() . '_' . trim($file->getClientOriginalName());

            $file->move($path, $name);

            return array(
                'name'=> $name,
                'original_name' => $file->getClientOriginalName()
            );
        }
    }
}

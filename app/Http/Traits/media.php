<?php
namespace App\Http\traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait media{

    public function uploadAvatar($file)
    {
        $file->store('/', 'avatars');
        return $file->hashName();
    }
    
    public function uploadImage($file, $path)
    {
        $file->store($path);
        return $file->hashName();
    }
    
}
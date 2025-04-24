<?php
namespace App\Services;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function upload(UploadedFile $file, $directory = 'attachments')
    {
        $path = $file->store($directory, 'public');
        
        return Attachment::create([
            'name' => $file->getClientOriginalName(),
            'uri' => $path,
            'type' => $file->getClientMimeType(),
          //  'size' => $file->getSize(),
          //  'disk' => 'public'
        ]);
    }
    
    public function delete(Attachment $attachment)
    {
        Storage::disk($attachment->disk)->delete($attachment->storage_path);
        return $attachment->delete();
    }
}
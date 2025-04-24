<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentRequest;
use App\Services\FileUploadService;
use App\Models\Attachment;

class AttachmentController extends Controller
{
    protected $fileUploadService;
    
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    
    public function store(StoreAttachmentRequest $request)
    {
        $file = $request->file('file');
        $attachment = $this->fileUploadService->upload($file);
        
        return response()->json([
            'success' => true,
            'data' => $attachment
        ]);
    }
    
    public function destroy(Attachment $attachment)
    {
        $this->fileUploadService->delete($attachment);
        
        return response()->json([
            'success' => true,
            'message' => 'Attachment deleted successfully'
        ]);
    }
}
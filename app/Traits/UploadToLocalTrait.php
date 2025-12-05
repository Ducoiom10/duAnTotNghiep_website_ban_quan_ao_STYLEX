<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadToLocalTrait
{
    use LoggableTrait;

    public function uploadToLocal($file, $directory = 'uploads')
    {
        try {
            if (!$file->isValid()) {
                throw new \Exception('File không hợp lệ');
            }

            // Tạo tên file unique
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Lưu file vào storage/app/public
            $path = $file->storeAs($directory, $fileName, 'public');

            return $path;
        } catch (\Exception $e) {
            $this->logError($e);
            throw new \Exception('Có lỗi xảy ra khi upload file: ' . $e->getMessage());
        }
    }

    public function uploadMultiple($files, $directory = 'uploads')
    {
        try {
            $uploadedFiles = [];

            foreach ($files as $file) {
                if (!$file->isValid()) {
                    continue;
                }

                $filePath = Storage::put($directory, $file);

                if ($filePath) {
                    $uploadedFiles[] = $filePath;
                }
            }

            if (empty($uploadedFiles)) {
                return response()->json([
                    'message' => 'No valid files were uploaded',
                ], Response::HTTP_BAD_REQUEST);
            }

            return $uploadedFiles;
        } catch (\Exception $e) {
            $this->logError($e);

            return response()->json([
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteFromLocal($filePath, $directory = 'uploads')
    {
        try {
            // Nếu filePath là URL đầy đủ, không xóa
            if (filter_var($filePath, FILTER_VALIDATE_URL)) {
                return true;
            }

            // Xóa file từ storage/app/public
            if (Storage::disk('public')->exists($filePath)) {
                return Storage::disk('public')->delete($filePath);
            }

            return true; // File không tồn tại, coi như đã xóa thành công
        } catch (\Exception $e) {
            $this->logError($e);
            return false;
        }
    }
}

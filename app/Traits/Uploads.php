<?php

namespace App\Traits;

use App\Models\Auth\User;
use Plank\Mediable\Facades\MediaUploader;
use Plank\Mediable\Media;
use Plank\Mediable\SourceAdapters\SourceAdapterInterface;

trait Uploads
{

    public function getUploadedFilePath($file, $folder = 'settings', $company_id = null)
    {
        $path = '';

        if (!$file || !$file->isValid()) {
            return $path;
        }

        if (!$company_id) {
            $company_id = session('company_id');
        }

        $file_name = $file->getClientOriginalName();

        // Upload file
        $file->storeAs($company_id . '/' . $folder, $file_name);

        // Prepare db path
        $path = $folder . '/' . $file_name;

        return $path;
    }


    public function getMedia($file, $folder = 'settings', $company_id = null, $comment = null, $user_id = null, $date = null, $identifier = null)
    {
        $path = '';

        if (!$file || !$file->isValid()) {
            return $path;
        }

        if (!$company_id) {
            $company_id = session('company_id');
        }

        $path = $company_id . '/' . $folder;

        return MediaUploader::fromSource($file->readStream())
            ->beforeSave(function (Media $model, SourceAdapterInterface $source) use ($comment, $user_id, $date, $identifier) {
                $model->setAttribute('comments', $comment);
                $model->setAttribute('user_id', $user_id);
                $model->setAttribute('identifier', $identifier);
                $model->setAttribute('date', $date);
            })
            ->toDirectory($path)
            ->useFilename($file->getClientOriginalName())
            ->upload();
    }

    public function importMedia($file, $folder = 'settings', $company_id = null, $disk = null)
    {
        $path = '';

        if (!$disk) {
            $disk = config('mediable.default_disk');
        }

        if (!$company_id) {
            $company_id = session('company_id');
        }

        $path = $company_id . '/' . $folder . '/' . basename($file);

        return MediaUploader::importPath($disk, $path);
    }
}

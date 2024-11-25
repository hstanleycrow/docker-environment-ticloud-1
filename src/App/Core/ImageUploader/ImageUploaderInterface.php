<?php

namespace App\Core\ImageUploader;

interface ImageUploaderInterface
{
    public function upload(): string;
    public function isUploading(): bool;
}

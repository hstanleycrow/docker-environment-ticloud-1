<?php

namespace App\Core\ImageUploader;

class ImageUploader
{
    private string $targetDir;
    private array $allowedFormats = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

    public function __construct(string $targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(string $inputName): string
    {
        if (!$this->isValidFormat($_FILES[$inputName]["name"])) {
            throw new \Exception("Formato de archivo no válido");
        }
        $targetFile = $this->targetDir . basename(slug($_FILES[$inputName]["name"]));
        move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFile);
        return $targetFile;
    }

    private function isValidFormat(string $fileName): bool
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        return in_array($extension, $this->allowedFormats);
    }
}

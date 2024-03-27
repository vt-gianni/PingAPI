<?php

namespace App\Service;

use Symfony\Component\Mime\MimeTypes;

class FileService
{
    public function isBase64Image(string $base64String): bool
    {
        $parts = explode(';', $base64String);
        if (count($parts) !== 2) {
            return false;
        }

        $typeParts = explode(':', $parts[0]);
        if (count($typeParts) !== 2 || $typeParts[0] !== 'data' || !preg_match('/^image\/\w+$/', $typeParts[1])) {
            return false;
        }

        $mimeTypes = new MimeTypes();
        $extension = $mimeTypes->getExtensions($typeParts[1])[0] ?? null;

        if ($extension === null) {
            return false;
        }

        $base64Data = base64_decode(explode(',', $base64String)[1]);
        if ($base64Data === false) {
            return false;
        }

        if (!@imagecreatefromstring($base64Data)) {
            return false;
        }

        return true;
    }

    public function getFileExtension(string $base64String): ?string
    {
        $parts = explode(';', $base64String);
        if (count($parts) !== 2) {
            return null;
        }

        $typeParts = explode(':', $parts[0]);
        if (count($typeParts) !== 2 || $typeParts[0] !== 'data' || !preg_match('/^image\/\w+$/', $typeParts[1])) {
            return null;
        }

        $mimeTypes = new MimeTypes();
        return $mimeTypes->getExtensions($typeParts[1])[0] ?? null;
    }
}

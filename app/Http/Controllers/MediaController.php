<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function show($id)
    {
        $media = Media::findOrfail($id);
        if (!auth()->check()) {
            abort(403, 'No tienes permiso para acceder a este archivo.');
        }

        if (!$media->exists) {
            abort(404, 'El archivo no existe.');
        }
        $filePath = $media->getPath();

        return response(file_get_contents($filePath), 200, [
            'Content-Type' => $media->mime_type,
            'Content-Disposition' => 'inline; filename="' . $media->name .'.'.$media->extension. '"',
        ]);
    }
}

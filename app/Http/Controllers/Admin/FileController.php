<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileController extends Controller
{
    public function getDiskUsage() {
        return response()->json([
            'disk_free_space' => disk_free_space(storage_path()),
            'disk_total_space' => disk_total_space(storage_path())
        ]);
    }

    public function getCollections() {
        $collections = Media::select('collection_name as name', DB::raw('sum(size) total_size'))
                            ->groupBy('collection_name');

        return response()->json([
            'collections' => $collections->get()
        ]);
    }
}

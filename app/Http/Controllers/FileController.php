<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload (Request $request) {
        $request->validate([
            'file' => 'required|file'
        ]);

        $path = $request->file('file')->store('tmp');

        return response()->json([
            'path' => $path
        ]);
    }

    public function get() {
        // TODO: manage all media
    }
}

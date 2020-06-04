<?php

namespace App\Http\Controllers;

use App\Jobs\PutFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GoogleDriveController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimetypes:application/pdf|max:10000'
        ]);

        $fileName = $request->file('file')->getClientOriginalName();

        $request->file('file')->move(storage_path('app/public/exams'), $fileName);

        PutFile::dispatch($fileName);

        // Get the file to find the ID
        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));
        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($fileName, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($fileName, PATHINFO_EXTENSION))
            ->first(); // there can be duplicate file names!

        $service = Storage::cloud()->getAdapter()->getService();
        $permission = new \Google_Service_Drive_Permission();
        $permission->setRole('reader');
        $permission->setType('anyone');
        $permission->setAllowFileDiscovery(false);
        $permissions = $service->permissions->create($file['basename'], $permission);

        return 'https://drive.google.com/file/d/' . $file['path'] . '/view?usp=sharing';
    }
}

<?php

namespace App\Http\Controllers;

use App\Jobs\PutFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GoogleDriveController extends Controller
{
    public function store(Request $request)
    {
       /* $request->validate([
            'file' => 'required|mimetypes:application/pdf|max:10000'
        ]);*/

        $fileName = $request->file('file')->getClientOriginalName();
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

        // Change permissions
        // - https://developers.google.com/drive/v3/web/about-permissions
        // - https://developers.google.com/drive/v3/reference/permissions
        $service = Storage::cloud()->getAdapter()->getService();
        $permission = new \Google_Service_Drive_Permission();
        $permission->setRole('reader');
        $permission->setType('anyone');
        $permission->setAllowFileDiscovery(false);
        $permissions = $service->permissions->create($file['basename'], $permission);

        return 'https://drive.google.com/file/d/' . $file['path'] . '/view?usp=sharing';
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Media\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReleaseController extends Controller
{
    public function download(Request $request, $id)
    {
        $uid = $request->user()->uid;
        $release = Release::where('file_uuid', $id)
            ->when(!$request->user()->hasRole('Admin'), function ($query) use ($uid) {
                return $query->where('uid', $uid);
            })
            ->firstOrFail();
        return Storage::disk('releases')->download($release->file_uuid . $release->extension);
    }

}
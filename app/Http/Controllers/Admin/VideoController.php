<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\VideoResourceCollection;
use App\Models\Media\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class VideoController extends Controller
{
    /**
     * List videos which are ready for aproval.
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $users = Video::select('uid', DB::raw('count(`uid`) as video_count'))
            ->where('status', 2)
            ->groupBy('uid')
            ->with('user')
            ->orderBy('video_count', 'DESC')
            ->get();
        $videos = Video::with('user')->paginate();

        $result = Inertia::render('Admin/Video/Index', [
            //'videos' => Video::where('status', 2)->with('user')->paginate(),
            'videos' => new VideoResourceCollection($videos),
            'users' => $users,
        ]);
        return $result;
    }

    /**
     * Approve one or more videos
     * @param Request $request
     * @return void
     */
    public function approve(Request $request)
    {

    }

    /**
     * Reject One or more videos
     * @param Request $request
     * @return void
     */
    public function reject(Request $request)
    {

    }

    public function getFullLink(Request $request, String $id)
    {
        $result = Video::where('file_uuid', $id)->firstOrFail();
        $templink = Storage::disk('videos')->temporaryUrl("source/{$result->file_uuid}{$result->extension}", now()->addMinutes(10));
        return ['status' => 'OK', 'src' => $templink];
    }
}
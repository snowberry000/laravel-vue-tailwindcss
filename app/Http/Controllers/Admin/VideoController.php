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
        $perpage = $request->perpage ?? 20;
        $uid = $request->contributor;
        $users = Video::select('uid', DB::raw('count(`uid`) as video_count'))
            ->whereStatus(2)
            ->groupBy('uid')
            ->with('user')
            ->orderBy('video_count', 'DESC')
            ->get();
        $videos = Video::with('user')
            ->whereStatus(2)
            ->when($uid, function ($query) use ($uid) {
                return $query->where('uid', $uid);
            })
            ->paginate($perpage);

        $result = Inertia::render('Admin/Video/Index', [
            'perpage' => $perpage,
            'contributor' => $uid,
            //'videos' => Video::where('status', 2)->with('user')->paginate(),
            'videos' => new VideoResourceCollection($videos),
            'contributors' => $users,
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
        $validated = $request->validate([
            'videos' => ['required', 'array'],
        ]);
        $result = Video::whereIn('id', $validated['videos'])->update(['status' => 3]);
        return redirect()->back()->with('success', "{$result} videos successfully accepted.");
    }

    /**
     * Reject One or more videos
     * @param Request $request
     * @return void
     */
    public function reject(Request $request)
    {
        $validated = $request->validate([
            'videos' => ['required', 'array'],
        ]);
        $result = Video::whereIn('id', $validated['videos'])->update(['status' => -2]);
        return redirect()->back()->with('success', "{$result} videos successfully rejected.");
    }

    public function getFullLink(Request $request, String $id)
    {
        $result = Video::where('file_uuid', $id)->firstOrFail();
        $source = $result['4k'] ? '1080p' : 'source';
        $templink = Storage::disk('videos')->temporaryUrl("{$source}/{$result->file_uuid}{$result->extension}", now()->addMinutes(10));
        return ['status' => 'OK', 'src' => $templink];
    }
}
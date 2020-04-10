<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoCollectionResource;
use App\Models\Media\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $status = [
            -1 => 'rejected',
            0 => 'processing',
            1 => 'processed',
            2 => 'waiting fo approval',
            3 => 'approved',
        ];

        return Inertia::render('Video/Index', [
            'currentStatus' => function () use ($request) {return $request->status;},
            'videos' => function () use ($request) {
                $videos = Video::when(isset($request->status), function ($q) use ($request) {
                    return $q->where('status', $request->status);
                })->where('uid', $request->user()->uid)->paginate();
                return new VideoCollectionResource($videos);
            },
            'status' => function () use ($status) {return $status;},
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => ['integer'],
            'title' => ['required'],
            'description' => ['required'],
            'keywords' => ['required'],
        ]);
        $video = Video::where('id', $validated['id'])->where('uid', $request->user()->uid)->firstOrFail();
        $video->title = $validated['title'];
        $video->description = $validated['description'];
        $video->keywords = $validated['keywords'];
        $video->status = 2;

        if ($video->save()) {
            return redirect()->back()->with('success', "entry {$request->title} successfully saved.");
        }
        return redirect()->back()->with('error', "entry {$request->title} could not be saved. try again later");

    }
}
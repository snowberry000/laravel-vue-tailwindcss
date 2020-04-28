<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoCollectionResource;
use App\Models\Media\Video;
use App\Notifications\VideoRequestSubmittedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use stdClass;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $status = [
            -2 => 'error',
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
                })
                    ->where('uid', $request->user()->uid)
                    ->paginate();
                return new VideoCollectionResource($videos);
            },
            'releases' => function () use ($request) {
                return $request->user()->releases()->orderBy('name')->get()->transform(function ($item, $key) {
                    $result = new stdClass();
                    $result->key = $item->id;
                    $result->value = $item->name;
                    return $result;
                });
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
            'people' => ['sometimes', 'boolean'],
            'num_people' => ['sometimes', 'integer'],
            'editorial' => ['sometimes', 'boolean'],
            'nsfw' => ['sometimes', 'boolean'],
            'releases' => ['sometimes', 'array'],
        ]);
        $video = Video::where('id', $validated['id'])->where('uid', $request->user()->uid)->firstOrFail();
        $video->title = $validated['title'];
        $video->description = $validated['description'];
        $video->keywords = $validated['keywords'];
        $video->people = $validated['people'];
        $video->num_people = $validated['people'] ? $validated['num_people'] : 0;
        $video->editorial = $validated['editorial'];
        $video->nsfw = $validated['nsfw'];

        $video->status = 2;

        if ($video->save()) {
            if ($validated['releases'] || $video->releases) {
                $video->attachReleases($validated['releases']);
            }
            return redirect()->back()->with('success', "entry {$request->title} successfully saved.");
        }
        return redirect()->back()->with('error', "entry {$request->title} could not be saved. try again later");

    }

    public function docs(Request $request)
    {
        return view('static.videodocs');
    }

    public function submitrequest(Request $request)
    {
        $validated = $request->validate([
            'portfolio' => ['required'],
            'number_of_videos' => ['required'],
            'information' => ['sometimes'],
        ]);
        Notification::route('mail', env('MAIL_FROM_ADDRESS'))->notify(new VideoRequestSubmittedNotification($request->user(), $validated));
        return redirect()->back()->with('success', 'Your request was sent, we will contact you shortly.');
    }
}
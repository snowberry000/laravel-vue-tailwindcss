<?php

namespace App\Http\Controllers;

use App\Download;
use App\Http\Resources\DownloadResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DownloadController extends Controller
{

    /**
     * List downloads for an user and no one else.
     */
    public function index(Request $request, $date = null)
    {
        if (!$date) {
            $date = Carbon::now()->startOfMonth();
        } else {
            $date = new Carbon($date);
        }

        return Inertia::render('Downloads/Index', [
            'downloads' => function () use ($request, $date) {
                $downloads = Download::where('uid', $request->user()->uid)->orderBy('created_at', 'desc')->whereYear('created_at', $date)->whereMonth('created_at', $date)->where('value', '>', 0)->get();
                return DownloadResource::collection($downloads);
            },
            'date' => $date,
        ]);
    }
}
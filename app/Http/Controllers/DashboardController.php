<?php

namespace App\Http\Controllers;

use App\Download;
use App\Http\Resources\DownloadResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Dashboard/Index', [
            'total' => function () use ($request) {
                $downloads = Download::where('uid', $request->user()->uid)->where('value', '>', 0);
                return [
                    'value' => number_format((($downloads->sum('value') / 2) / 100), 2),
                    'count' => $downloads->count(),
                ];
            },
            'last30' => function () use ($request) {
                $downloads = Download::where('uid', $request->user()->uid)->where('value', '>', 0)->whereDate('created_at', '>=', Carbon::now()->subDays(30));
                return [
                    'value' => number_format((($downloads->sum('value') / 2) / 100), 2),
                    'count' => $downloads->count(),
                ];
                return number_format((($downloads / 2) / 100), 2);
            },
            'available' => function () use ($request) {
                $downloads = Download::where('uid', $request->user()->uid)->whereNull('payout_id')->where('value', '>', 0);
                return [
                    'value' => number_format((($downloads->sum('value') / 2) / 100), 2),
                    'count' => $downloads->count(),
                ];
                return number_format((($downloads / 2) / 100), 2);
            },
            'downloads' => function () use ($request) {
                $downloads = Download::where('uid', $request->user()->uid)->orderBy('created_at', 'desc')->where('value', '>', 0)->limit(5)->get();
                return DownloadResource::collection($downloads);
            },
        ]

        );

    }
}
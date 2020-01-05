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
                $promo_items = $downloads->filter(function ($item) {
                    return $item->value < 10;
                });
                $normal_items = $downloads->filter(function ($item) {
                    return $item->value >= 10;
                });

                return [
                    'promo' => number_format($promo_items->sum('value') / 2 / 100, 2),
                    'items' => DownloadResource::collection($normal_items),
                ];
            },
            'date' => $date,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Download;
use App\Http\Resources\AdminPayoutResource;
use App\Http\Resources\DownloadResource;
use App\Payout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        //dd($request->user()->hasRole('Admin'));
        if ($request->user()->hasRole('Contributor')) {
            return $this->contributorDashboard($request);
        }
        if ($request->user()->hasRole('Admin')) {
            return $this->adminDashboard($request);
        }
    }

    protected function adminDashboard($request)
    {
        return Inertia::render('Admin/Dashboard', [
            'payouts' => function () {
                $payouts = Payout::limit(10)->with('user')->orderBy('created_at', 'desc')->get();
                return AdminPayoutResource::collection($payouts);
            },
        ]);
    }

    protected function contributorDashboard(Request $request)
    {
        return Inertia::render('Dashboard/Index', [
            'total' => function () use ($request) {
                $downloads = Download::where('uid', $request->user()->uid)->where('value', '>', 0);
                return [
                    'value' => number_format((($downloads->sum('value') / 2) / 100), 2),
                    //'count' => $downloads->count(),
                ];
            },
            'last30' => function () use ($request) {
                $downloads = Download::where('uid', $request->user()->uid)->where('value', '>', 0)->whereDate('created_at', '>=', Carbon::now()->subDays(30));
                return [
                    'value' => number_format((($downloads->sum('value') / 2) / 100), 2),
                    //'count' => $downloads->count(),
                ];
                return number_format((($downloads / 2) / 100), 2);
            },
            'available' => function () use ($request) {
                $downloads = Download::where('uid', $request->user()->uid)->whereNull('payout_id')->where('value', '>', 0);
                return [
                    'value' => number_format((($downloads->sum('value') / 2) / 100), 2),
                    //'count' => $downloads->count(),
                ];
                return number_format((($downloads / 2) / 100), 2);
            },
            'downloads' => function () use ($request) {
                $downloads = Download::where('uid', $request->user()->uid)->orderBy('created_at', 'desc')->where('value', '>', 0)->limit(20)->get();
                // $promo_items = $downloads->filter(function ($item) {
                //     return $item->value < 10;
                // });
                $normal_items = $downloads->filter(function ($item) {
                    return $item->value >= 10;
                });

                return [
                    //'promo' => number_format($promo_items->sum('value') / 2 / 100, 2),
                    'items' => DownloadResource::collection($normal_items),
                ];
            },
        ]

        );

    }
}
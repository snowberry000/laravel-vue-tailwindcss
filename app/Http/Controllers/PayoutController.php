<?php

namespace App\Http\Controllers;

use App\Notifications\PayoutRequested;
use App\Notifications\PayoutRequestedClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PayoutController extends Controller
{
    public function create(Request $request)
    {
        $request->validate(['memo' => 'required']);
        $user = $request->user();
        $unpaidDownloads = $user->unpaidDownloads();
        $amount = $unpaidDownloads->sum('value') / 2;
        if ($amount == 0 || $amount < 25) {
            return redirect()->back()->with('success', 'You have not enough funds to withdraw.');
        }
        DB::beginTransaction();
        $payout = $user->payouts()->create([
            'amount' => $amount,
            'memo' => $request->memo,
        ]);
        $unpaidDownloads->each(function ($item) use ($payout) {
            $item->payout_id = $payout->id;
            $item->save();
        });
        if ($payout) {
            $user->notify(new PayoutRequestedClient($payout));
            Notification::route('mail', env('MAIL_FROM_ADDRESS'))->notify(new PayoutRequested($payout, $user));
        }
        DB::commit();
        return redirect()->back()->with('success', 'Your Payment Request was successfully sent.');
    }

}
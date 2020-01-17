<?php

namespace App\Http\Controllers;

use App\Notifications\KycFileSubmittedNotification;
use App\Notifications\KycSubmittedClientNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class KycController extends Controller
{
    /**
     *
     * @param Request $request
     * @return Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Kyc/Index'

        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Kyc/Index');
    }

    public function store(Request $request)
    {

        $user = $request->user();
        $request->validate([
            'documents' => ['required'],
            'documents.*' => ['required', 'file', 'mimes:jpg,jpeg,bmp,png,pdf'],
        ], [
            'mimes' => 'Only PDF, JPG, BMP, PNG filetypes are supported',
        ]);
        $dt = new Carbon();
        $recentKycs = $user->kycs()->whereDate('created_at', '>=', $dt->subMinutes(30))->count();
        $files = $request->file('documents');
        foreach ($request->documents as $key => $doc) {
            $path = $doc->store('kyc');
            $user->kycs()->create([
                'file' => $path,
                'original_name' => $files[$key]->getClientOriginalName(),
            ]);
        }

        $user->notify(new KycSubmittedClientNotification($user));
        if ($recentKycs == 0) {
            Notification::route('mail', env('MAIL_FROM_ADDRESS'))->notify(new KycFileSubmittedNotification($user));
        }

        return redirect()->route('home')->with('success', 'Your Documents were successfully supplied.');
    }
}
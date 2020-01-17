<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\KycContributorResource;
use App\Kyc;
use App\Notifications\KycApprovedNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class KycController extends Controller
{
    public function confirm(Request $request, User $user)
    {
        return Inertia::render('Admin/Kyc/Confirm', [
            'user' => new KycContributorResource($user),
        ]);
    }

    public function file(Request $request, Kyc $file)
    {
        return Storage::download($file->file, $file->original_name);
    }

    public function approve(Request $request, User $user)
    {
        $user->approve();
        $user->notify(new KycApprovedNotification($user));
        return redirect()->back()->with('success', "User {$user->name} was successfully verified");

    }
}
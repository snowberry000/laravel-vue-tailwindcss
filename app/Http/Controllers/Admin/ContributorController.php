<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContributorCollectionResource;
use App\Http\Resources\KycContributorResource;
use App\Notifications\ContributorVideoEnabledNotification;
use App\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContributorController extends Controller
{
    public function index(Request $request)
    {

        $perpage = $request->perpage ?? 20;
        $search = $request->search;
        $contributors = User::when(isset($request->s), function ($q) use ($request) {
            return $q
                ->where('uid', 'like', $request->s)
                ->orWhere('username', 'like', "%{$request->s}%")
                ->orWhere('email', 'like', "%{$request->s}%");
        })->paginate($perpage);
        return Inertia::render('Admin/Contributors/Index', [
            'contributors' => new ContributorCollectionResource($contributors),
            'search' => $request->s,
        ]);
    }

    public function show(Request $request, User $contributor)
    {
        return Inertia::render('Admin/Contributors/View', [
            'contributor' => new KycContributorResource($contributor),
        ]);
    }

    public function enableVideo(Request $request, User $contributor)
    {
        $contributor->video = 1;
        if ($contributor->save()) {
            $contributor->notify(new ContributorVideoEnabledNotification($contributor));
            return redirect()->back()->with('success', "Video upload for {$contributor->name} successfully enabled");
        }
    }
}
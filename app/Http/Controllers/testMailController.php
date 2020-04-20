<?php

namespace App\Http\Controllers;

use App\Notifications\ContributorVideoEnabledNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class testMailController extends Controller
{

    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $user = Auth::user();
        //$user->notify(new ContributorVideoEnabledNotification($user));
        return (new ContributorVideoEnabledNotification($user))
            ->toMail('marius@yayimages.com');

//        $user->notify(new CheckoutNotification($user, $items, $images, $total));
    }

}
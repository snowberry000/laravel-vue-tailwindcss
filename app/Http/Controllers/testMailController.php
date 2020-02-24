<?php

namespace App\Http\Controllers;

use App\Notifications\PeriodicSingleSalesNotification;
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

        return (new PeriodicSingleSalesNotification($user, 5.1233))
            ->toMail('marius@yayimages.com');

//        $user->notify(new CheckoutNotification($user, $items, $images, $total));
    }

}
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminPayoutCollectionResource;
use App\Payout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PayoutController extends Controller
{
    /**
     * Retrieve all payout requests from dashboard.
     * Could be filtered by status.
     * @param Request $request
     * @return Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Admin/Payouts', [
            'payouts' => function () {
                $payouts = Payout::with('user')->orderBy('created_at', 'desc')->paginate();
                return new AdminPayoutCollectionResource($payouts);
            },
        ]);

    }

    public function markPaid(Request $request, Payout $payout)
    {
        $payout->paid_at = Carbon::now();
        if ($payout->save()) {
            return redirect()->back()->with('success', 'Payout Successfully marked as paid.');
        }
        return redirect()->back()->with('error', 'Somehting went wrong try again later.');
    }

    public function markUnpaid(Request $request, Payout $payout)
    {
        $payout->paid_at = null;
        if ($payout->save()) {
            return redirect()->back()->with('success', 'Payout Successfully marked as unpaid.');
        }
        return redirect()->back()->with('error', 'Somehting went wrong try again later.');

    }
}
<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class KycContributorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lastItem = $this->media()->orderBy('accepted_time', 'desc')->first();
        return [
            'id' => $this->id,
            'uid' => $this->uid,
            'created_at' => $this->created_at->format('d/m/Y'),
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'kyc_verified_at' => $this->kyc_verified_at,
            'video' => $this->video,
            'downloads' => $this->downloads->count(),
            'sales' => $this->downloads->sum('value') / 2 / 100,
            'available' => $this->unpaidDownloads->sum('value') / 2 / 100,
            'paidout' => $this->payouts->sum('amount') / 100,
            'pending_payouts' => $this->pendingPayouts->sum('value') / 2 / 100,
            'last_payout' => $this->payouts->last() ? $this->payouts->last()->paid_at : null,
            'kycs' => $this->kycs,
            'monthsfromcreated' => $this->created_at->diffInMonths(Carbon::now()),
            // 'imagecount' => $this->media->count(),
            // 'lastImage' => $lastItem ? $lastItem->accepted_time : 'N/A',
        ];
        //return parent::toArray($request);
    }
}
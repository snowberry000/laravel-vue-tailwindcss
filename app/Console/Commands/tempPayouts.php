<?php

namespace App\Console\Commands;

use App\Download;
use App\Payout;
use Carbon\Traits\Timestamp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class tempPayouts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmp:payouts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $payouts = DB::table('temp_payouts')->orderBy('timestamp', 'asc')->get();
        foreach ($payouts as $payout) {

            $downloads = Download::where('uid', $payout->uid)->whereNull('payout_id')->whereDate('created_at', '<=', $payout->timestamp)->get();
            DB::beginTransaction();
            $payout = Payout::create(
                [
                    'uid' => $payout->uid,
                    'amount' => $downloads->sum('value') / 2,
                    'memo' => '1234',
                    'paid_at' => $payout->timestamp,
                    'created_at' => $payout->timestamp,
                ]
            );
            $downloads->each(function ($item) use ($payout) {
                $item->payout_id = $payout->id;
                $item->save();
            });
            DB::commit();
            $sum = round($downloads->sum('value') / 100 / 2);
            $amount = round($payout->amount * 1.1);
            $equal = $sum == $amount ? '==' : '!=';
            $this->info("uid:{$payout->uid} sum: {$sum} amount: {$amount}   equal: {$equal}");
            $this->info("-----------------------------------------------------");
        }
        //dd($payouts);
    }
}
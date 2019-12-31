<?php

namespace App\Console\Commands;

use App\Download;
use App\Payout;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportOldPayouts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payouts:import';

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

        $payouts = DB::table('old_payout')->where('status', 'COMPLETED')->where('affected_ids', '!=', '1234')->get();
        foreach ($payouts as $payout) {
            DB::beginTransaction();

            $payout_id = $this->create_payout($payout);
            $ids = explode(';', $payout->affected_ids);
            $this->assigntoPayout($payout_id, $ids);
            DB::table('old_payout')->where('id', '=', $payout->id)->delete();
            DB::commit();

        }

    }

    public function create_payout($payout)
    {
        $res = new Payout();
        $res->uid = $payout->uid;
        $res->amount = $payout->amount * 1.1 * 100;
        $res->memo = $payout->to . ' ' . $payout->external_reference;
        $res->paid_at = $payout->timestamp;
        $res->created_at = $payout->timestamp;
        $res->save();
        return $res->id;
    }

    public function assigntoPayout($payout, $ids)
    {
        return Download::whereIn('original_id', $ids)->update(['payout_id' => $payout]);
    }
}
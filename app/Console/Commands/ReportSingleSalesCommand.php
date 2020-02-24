<?php

namespace App\Console\Commands;

use App\Download;
use App\Jobs\SendSalesNotificationJob;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReportSingleSalesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reports to users who got bigger sales into their account.';

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
        $lastWeek = Carbon::now()->subWeek();
        $this->info("Report for {$lastWeek->startOfWeek()}-{$lastWeek->endOfWeek()} ");
        $downloads = Download::select(DB::raw('sum(value)/2/100 as total_sales, count(id) as sales_count, sum(value)/count(id) as avg_sale, uid'))
            ->whereDate('created_at', '>=', $lastWeek->startOfWeek())
            ->whereDate('created_at', '<=', $lastWeek->endOfWeek())
            ->where('value', '>', 0)
            ->having('total_sales', '>=', 2)
            ->having('avg_sale', '>=', '100')
            ->whereNotIn('uid', [54231, 95124])
            ->groupBy('uid')->get();
        $downloads->each(function ($item) {
            dispatch(new SendSalesNotificationJob($item));
        });

    }
}
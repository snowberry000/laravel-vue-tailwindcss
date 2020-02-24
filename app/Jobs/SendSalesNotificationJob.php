<?php

namespace App\Jobs;

use App\Download;
use App\Notifications\PeriodicSingleSalesNotification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSalesNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $uid;
    protected $count;
    protected $value;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Download $download)
    {
        $this->uid = $download->uid;
        $this->value = $download->total_sales;
        $this->count = $download->sales_count;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::where('uid', $this->uid)->firstOrFail();
        $user->notify(new PeriodicSingleSalesNotification($user, $this->value));
    }
}
<?php

namespace App\Console\Commands;

use App\Notifications\KycSubmittedClientNotification;
use App\User;
use Illuminate\Console\Command;

class TempNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:notify';

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
        $users = User::where('video', 1)->get();
        $users->each(function ($user) {
            $this->info("Notification sent to {$user->email}");
            $user->notify(new KycSubmittedClientNotification($user));
        });
    }
}
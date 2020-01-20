<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportUserPasswordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:passwords';

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

        $users = User::where('password', 'reset')->orderBy('uid')->chunk('100', function ($items) {
            foreach ($items as $item) {
                $user = DB::connection('db1')->table('users')->where('uid', $item->uid)->first();
                $item->password = $user->password;
                $item->save();
            }
        });

    }
}
<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:import';

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
        $last_imported_user = User::orderBy('uid', 'desc')->first();
        $uid = isset($last_imported_user) ? $last_imported_user->uid : 0;
        $users = DB::connection('db1')->table('users')
            ->where('uid', '>', $uid)
            ->where('roles', 3)
            ->where('email_confirmed', true)
            ->whereNull('delete_info')
            ->orderBy('uid', 'asc')
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    $import = User::firstOrNew([
                        'uid' => $user->uid,
                    ]);
                    $import->uid = $user->uid;
                    $import->name = $user->name;
                    $import->username = $user->display_name;
                    $import->email = $user->email;
                    $import->password = 'reset';
                    $import->created_at = new Carbon($user->registered_time);
                    $import->email_verified_at = $user->email_confirmed ? new Carbon($user->registered_time) : null;
                    $import->save();
                    $import->assignRole('Contributor');
                }
            });
        Log::info('Succesfully ran user import script!');
    }
}

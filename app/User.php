<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, Notifiable;

    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Verify user so he could request payouts.
     * @return bool
     */
    public function approve()
    {
        $this->kyc_verified_at = Carbon::now();
        return $this->save();
    }

    public function payouts()
    {
        return $this->hasMany('App\Payout', 'uid', 'uid');
    }

    public function downloads()
    {

        return $this->hasMany('App\Download', 'uid', 'uid');
    }

    public function unpaidDownloads()
    {
        return $this->hasMany('App\Download', 'uid', 'uid')->whereNull('payout_id');
    }

    public function kycs()
    {
        return $this->hasMany('App\Kyc', 'user_id', 'id');
    }

    public function videos()
    {
        return $this->hasMany('App\Models\Media\Video', 'uid', 'uid');
    }

    public function releases()
    {
        return $this->hasMany('App\Models\Media\Releases', 'uid', 'uid');
    }
}
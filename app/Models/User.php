<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Library\Helper;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'seondary_email',
        'password',
        'mobile',
        'seondary_number',
        'firm_name',
        'role',
        'user_ip',
        'last_login_time'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function MessageGet(){
        return $this->hasMany('App\Models\SendMessage','user_id','id');
    }


    public function getNotifaction($id){
        
        $notifaction = Helper::GetNotifaction($id);
        return $notifaction;
    }
}

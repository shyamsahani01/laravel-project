<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Library\Helper;

class Metalwisedailyfgproductioncostreport extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'erpnext';
    protected $table = 'metalwisedailyfgproductioncostreport';
    protected $fillable = [
        'createddate','updateddate','createdby','reportdate','goldworkerspresenttoday','totalgoldsalary',
        'gwamount','goldtotalamount','goldfgwt','goldfgqty','goldfgrsperpc','goldfgrspergm','silverworkersperday',
        'silversalaryperday','silvergwamount','silvertotalamount','silverfgqty','silverfgwt','directprodcostperpc',
        'directprodcostpergm','totalfggoldslivergms','manpowercost','gwcost','totalmanpoweramount','totalmanpowerpergm',
        'totalexporttilltodayusd','goldfgamount','silveramount','totalfgamount','totalexpensesonmanpower','manpowerexpensepercent',
        'totalexpensesofgold','manpowerexpensesgoldagainstfg','totalexpensesofsilver','manpowerexpensesofsilveragainstfg'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'createddate' => 'datetime',
    ];
    public $timestamps = false; //only want to used created_at column
    const UPDATED_AT = null; //and updated by default null set
    const created_at = null;

    public function MessageGet(){
        return $this->hasMany('App\Models\SendMessage','user_id','id');
    }


    public function getNotifaction($id){
        
        $notifaction = Helper::GetNotifaction($id);
        return $notifaction;
    }
}

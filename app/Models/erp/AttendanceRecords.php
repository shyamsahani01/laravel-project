<?php

namespace App\Models\erp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class AttendanceRecords extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $connection = 'erpnext';
    protected $table = 'tabAttendance';
    
    protected $guarded = [];

    public $timestamps = false; //only want to used created_at column
    const UPDATED_AT = null; //and updated by default null set
    const created_at = null;


    public function CheckinData(){
        return $this->HasMany('App\Models\erp\Attendance','employee','employee');
    }

}

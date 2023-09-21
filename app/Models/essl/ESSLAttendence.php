<?php

namespace App\Models\essl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class ESSLAttendence extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $connection = 'essl';
    protected $table = 'DeviceLogs_12_2021';
    
    protected $guarded = [];

    public $timestamps = false; //only want to used created_at column
    const UPDATED_AT = null; //and updated by default null set
    const created_at = null;

}

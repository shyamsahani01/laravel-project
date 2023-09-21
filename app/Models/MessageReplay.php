<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class MessageReplay extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message_replay';


    public function reciver(){
    	return $this->belongsTo('App\Models\User','receiver_id','id');
    }


    public function sender(){
    	return $this->belongsTo('App\Models\User','sender_id','id');
    }

    public  function getTime($created_at){
          if(!empty($created_at)){
         $time = Helper::getTime($created_at);
         return $time;
        }
    }

}

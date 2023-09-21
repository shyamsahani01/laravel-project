<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class ProductData extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */


    protected $table = 'products_data';


    public function message(){

    	return $this->belongsTo('App\Models\SendMessage','message_id','id');
    }

}

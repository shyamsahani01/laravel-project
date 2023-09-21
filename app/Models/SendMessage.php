<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class SendMessage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sendmessage';


    public function users(){

    	return $this->belongsTo('App\Models\User','user_id','id');
    }


    public function productdata(){
        return $this->hasMany('App\Models\ProductData','message_id','id');
    }

    public  function getTime($created_at){
          if(!empty($created_at)){
         $time = Helper::getTime($created_at);
         return $time;
        }
    }


    public function allProduct($data){
       
        $datas = Helper::GetProducts($data);
       // dd($datas['pdata']);
        return $datas;
    }

    public function getAllProductData($data){
        

    }

    public function ProductCategory($slug){
        $datas = Helper::ProductCategory($slug,$this->id);
        return $datas;
    }
}

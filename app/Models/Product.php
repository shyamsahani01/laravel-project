<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_type';



    public  function getTime($created_at){
          if(!empty($created_at)){
         $time = Helper::getTime($created_at);
         return $time;
     }

    }
}

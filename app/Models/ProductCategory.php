<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $fillable = ['product_id','name','sub_cat','type'];

    protected $table = 'product_category';



    public  function getTime($created_at){
          if(!empty($created_at)){
         $time = Helper::getTime($created_at);
         return $time;
     }

    }
}

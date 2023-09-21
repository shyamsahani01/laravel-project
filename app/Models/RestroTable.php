<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restro extends Model
{
    use HasFactory,SoftDeletes;
	/**
	* The database table used by the model.
	*
	* @var string
	*/
   protected $table = 'restro';
   /**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
   // Primary key
   public $primaryKey = 'id';
   public $incrementing = true;


    /**
     * (Override HasRoleAndPermission Trait)
     * User belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function restroTables()
    {
    	return $this->hasMany(FloorTable::class, 'restro_id', 'id');
    }


   
}

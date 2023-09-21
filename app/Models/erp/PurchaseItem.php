<?php

namespace App\Models\erp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class PurchaseItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $connection = 'erpnext';
    //protected $table = 'tabStock Ledger Entry';
    //protected $table = 'tabPurchase Order';
    protected $table = 'tabPurchase Order Item';
    //protected $table = 'tabSales Order';
    //protected $table = 'tabSales Order Item';
    

    

    protected $guarded = [];

}

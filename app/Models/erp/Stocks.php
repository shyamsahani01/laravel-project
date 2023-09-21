<?php

namespace App\Models\erp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;
USE App\Models\erp\PurchaseItem;

class Stocks extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $connection = 'erpnext';
    protected $table = 'tabStock Ledger Entry';
    //protected $table = 'tabPurchase Order';
    //protected $table = 'tabPurchase Order Item';
    //protected $table = 'tabSales Order';
    //protected $table = 'tabSales Order Item';
    

    protected $guarded = [];


    // public function Salesitem(){
    //     return $this->hasMany('App\Models\erp\SalesItem','item_code','item_code');
    // }

    // public function Purchaseitem(){
    //     return $this->hasMany('App\Models\erp\PurchaseItem','item_code','item_code');
    // }

    public function SalesItem($code){
        $salesStockqty = SalesItem::where('item_code',$code)->first();
        dd($salesStockqty);
        $totalqty = 0;
        foreach($salesStockqty as $qty){
            $totalqty += $qty;
        }
        return $totalqty;
    }


    public function PurchaseItem($code){
        $purchaseStockqty = PurchaseItem::where('item_code',$code)->pluck('qty');
        $totalqty = 0;
        foreach($purchaseStockqty as $qty){
            $totalqty += $qty;
        }
        return $totalqty;
    }

}

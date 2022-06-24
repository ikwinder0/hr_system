<?php
namespace App\Models;

use CodeIgniter\Model;
	
class PurchaseitemsModel extends Model {
 
    protected $table = 'ci_stock_purchase_items';

    protected $primaryKey = 'purchase_item_id';
    
	// get all fields of table
    protected $allowedFields = ['purchase_item_id','purchase_id','item_id','item_qty','item_unit_price','item_sub_total','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
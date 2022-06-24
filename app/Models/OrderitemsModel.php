<?php
namespace App\Models;

use CodeIgniter\Model;
	
class OrderitemsModel extends Model {
 
    protected $table = 'ci_stock_order_items';

    protected $primaryKey = 'order_item_id';
    
	// get all fields of table
    protected $allowedFields = ['order_item_id','order_id','item_id','item_qty','item_unit_price','item_sub_total','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
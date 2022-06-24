<?php
namespace App\Models;

use CodeIgniter\Model;
	
class OrderquoteitemsModel extends Model {
 
    protected $table = 'ci_stock_order_quote_items';

    protected $primaryKey = 'quote_item_id';
    
	// get all fields of table
    protected $allowedFields = ['quote_item_id','quote_id','item_id','item_qty','item_unit_price','item_sub_total','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
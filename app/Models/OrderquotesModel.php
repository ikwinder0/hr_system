<?php
namespace App\Models;

use CodeIgniter\Model;
	
class OrderquotesModel extends Model {
 
    protected $table = 'ci_stock_order_quotes';

    protected $primaryKey = 'quote_id';
    
	// get all fields of table
    protected $allowedFields = ['quote_id','quote_number','company_id','customer_id','quote_month','quote_date','quote_due_date','sub_total_amount','discount_type','discount_figure','total_tax','tax_type','total_discount','grand_total','quote_note','status','payment_method','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class OrdersModel extends Model {
 
    protected $table = 'ci_stock_orders';

    protected $primaryKey = 'order_id';
    
	// get all fields of table
    protected $allowedFields = ['order_id','order_number','company_id','customer_id','invoice_month','invoice_date','invoice_due_date','sub_total_amount','discount_type','discount_figure','total_tax','tax_type','total_discount','grand_total','invoice_note','status','payment_method','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class PurchasesModel extends Model {
 
    protected $table = 'ci_stock_purchases';

    protected $primaryKey = 'purchase_id';
    
	// get all fields of table
    protected $allowedFields = ['purchase_id','purchase_number','company_id','supplier_id','purchase_month','purchase_date','sub_total_amount','discount_type','discount_figure','total_tax','tax_type','total_discount','grand_total','purchase_note','status','payment_method','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
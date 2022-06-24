<?php
namespace App\Models;

use CodeIgniter\Model;
	
class InvoicesModel extends Model {
 
    protected $table = 'ci_invoices';

    protected $primaryKey = 'invoice_id';
    
	// get all fields of table
    protected $allowedFields = ['invoice_id','invoice_number','company_id','client_id','project_id','invoice_month','invoice_date','invoice_due_date','sub_total_amount','discount_type','discount_figure','total_tax','tax_type','total_discount','grand_total','invoice_note','status','payment_method','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
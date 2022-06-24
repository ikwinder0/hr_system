<?php
namespace App\Models;

use CodeIgniter\Model;
	
class InvoicepaymentsModel extends Model {
 
    protected $table = 'ci_finance_membership_invoices';

    protected $primaryKey = 'membership_invoice_id';
    
	// get all fields of table
    protected $allowedFields = ['membership_invoice_id','invoice_id','company_id','membership_id','subscription_id','membership_type','subscription','invoice_month','membership_price','payment_method','transaction_date','description','receipt_url','source_info','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
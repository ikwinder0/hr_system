<?php
namespace App\Models;

use CodeIgniter\Model;

class TransactionsModel extends Model {
 
    protected $table = 'ci_finance_transactions';

    protected $primaryKey = 'transaction_id';
    
	// get all fields of table
    protected $allowedFields = ['transaction_id','account_id','company_id','staff_id','transaction_date','transaction_type','entity_id','entity_type','entity_category_id','description','amount','dr_cr','payment_method_id','reference','attachment_file','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
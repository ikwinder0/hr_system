<?php
namespace App\Models;

use CodeIgniter\Model;

class AccountsModel extends Model {
 
    protected $table = 'ci_finance_accounts';

    protected $primaryKey = 'account_id';
    
	// get all fields of table
    protected $allowedFields = ['account_id','company_id','account_name','account_balance','account_opening_balance','account_number','branch_code','bank_branch','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
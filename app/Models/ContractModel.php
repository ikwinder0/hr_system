<?php
namespace App\Models;

use CodeIgniter\Model;
	
class ContractModel extends Model {
 
    protected $table = 'ci_contract_options';

    protected $primaryKey = 'contract_option_id';
    
	// get all fields of table
    protected $allowedFields = ['contract_option_id','user_id','salay_type','contract_tax_option','is_fixed','option_title','contract_amount'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
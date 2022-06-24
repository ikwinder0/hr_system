<?php
namespace App\Models;

use CodeIgniter\Model;
	
class PolicyModel extends Model {
 
    protected $table = 'ci_policies';

    protected $primaryKey = 'policy_id';
    
	// get all fields of table
    protected $allowedFields = ['policy_id','company_id','title','description','attachment','added_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
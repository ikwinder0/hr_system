<?php
namespace App\Models;

use CodeIgniter\Model;
	
class CompanymembershipModel extends Model {
 
    protected $table = 'ci_company_membership';

    protected $primaryKey = 'company_membership_id';
    
	// get all fields of table
    protected $allowedFields = ['company_membership_id','company_id','membership_id','subscription_type','update_at','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
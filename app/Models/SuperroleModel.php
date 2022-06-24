<?php
namespace App\Models;

use CodeIgniter\Model;
	
class SuperroleModel extends Model {
 
    protected $table = 'ci_erp_users_role';
    protected $primaryKey = 'role_id';
	
	protected $returnType = 'array';
    
	// get all fields of erp user roles table
    protected $allowedFields = ['role_id','role_name','role_access','role_resources','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
}
?>
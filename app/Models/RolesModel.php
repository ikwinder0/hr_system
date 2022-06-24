<?php
namespace App\Models;

use CodeIgniter\Model;
	
class RolesModel extends Model {
 
    protected $table = 'ci_staff_roles';

    protected $primaryKey = 'role_id';
    
	// get all fields of user roles table
    protected $allowedFields = ['role_id','company_id','role_name','role_access','role_resources','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
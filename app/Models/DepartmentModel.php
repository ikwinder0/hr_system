<?php
namespace App\Models;

use CodeIgniter\Model;

class DepartmentModel extends Model {
 
    protected $table = 'ci_departments';

    protected $primaryKey = 'department_id';
    
	// get all fields of table
    protected $allowedFields = ['department_id','company_id','department_name','department_head','added_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
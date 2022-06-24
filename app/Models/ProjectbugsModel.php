<?php
namespace App\Models;

use CodeIgniter\Model;
	
class ProjectbugsModel extends Model {
 
    protected $table = 'ci_projects_bugs';

    protected $primaryKey = 'project_bug_id';
    
	// get all fields of table
    protected $allowedFields = ['project_bug_id','company_id','project_id','employee_id','bug_note','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
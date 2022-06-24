<?php
namespace App\Models;

use CodeIgniter\Model;
	
class ProjectfilesModel extends Model {
 
    protected $table = 'ci_projects_files';

    protected $primaryKey = 'project_file_id';
    
	// get all fields of table
    protected $allowedFields = ['project_file_id','company_id','project_id','employee_id','file_title','attachment_file','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TaskfilesModel extends Model {
 
    protected $table = 'ci_tasks_files';

    protected $primaryKey = 'task_file_id';
    
	// get all fields of table
    protected $allowedFields = ['task_file_id','company_id','task_id','employee_id','file_title','attachment_file','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
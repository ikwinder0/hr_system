<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TaskdiscussionModel extends Model {
 
    protected $table = 'ci_tasks_discussion';

    protected $primaryKey = 'task_discussion_id';
    
	// get all fields of table
    protected $allowedFields = ['task_discussion_id','company_id','task_id','employee_id','discussion_text','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
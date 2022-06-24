<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TasknotesModel extends Model {
 
    protected $table = 'ci_tasks_notes';

    protected $primaryKey = 'task_note_id';
    
	// get all fields of table
    protected $allowedFields = ['task_note_id','company_id','task_id','employee_id','task_note','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TasksModel extends Model {
 
    protected $table = 'ci_tasks';

    protected $primaryKey = 'task_id';
    
	// get all fields of table
    protected $allowedFields = ['task_id','company_id','project_id','task_name','assigned_to','associated_goals','start_date','end_date','task_hour','task_progress','summary','description','task_status','task_note','created_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class ProjecttimelogsModel extends Model {
 
    protected $table = 'ci_projects_timelogs';

    protected $primaryKey = 'timelogs_id';
    
	// get all fields of table
    protected $allowedFields = ['timelogs_id','company_id','project_id','employee_id','start_time','end_time','start_date','end_date','total_hours','timelogs_memo','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
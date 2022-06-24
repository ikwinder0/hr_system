<?php
namespace App\Models;

use CodeIgniter\Model;
	
class ProjectsModel extends Model {
 
    protected $table = 'ci_projects';

    protected $primaryKey = 'project_id';
    
	// get all fields of table
    protected $allowedFields = ['project_id','company_id','client_id','title','start_date','end_date','assigned_to','priority','project_no','budget_hours','summary','description','project_progress','associated_goals','project_note','status','added_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
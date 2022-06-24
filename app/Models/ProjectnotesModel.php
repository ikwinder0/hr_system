<?php
namespace App\Models;

use CodeIgniter\Model;
	
class ProjectnotesModel extends Model {
 
    protected $table = 'ci_projects_notes';

    protected $primaryKey = 'project_note_id';
    
	// get all fields of table
    protected $allowedFields = ['project_note_id','company_id','project_id','employee_id','project_note','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
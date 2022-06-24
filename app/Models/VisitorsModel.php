<?php
namespace App\Models;

use CodeIgniter\Model;
	
class VisitorsModel extends Model {
 
    protected $table = 'ci_visitors';

    protected $primaryKey = 'visitor_id';
    
	// get all fields of table
    protected $allowedFields = ['visitor_id','company_id','department_id','visit_purpose','visitor_name','phone','email','visit_date','check_in','check_out','address','description','created_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
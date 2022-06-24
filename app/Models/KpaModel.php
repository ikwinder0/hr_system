<?php
namespace App\Models;

use CodeIgniter\Model;
	
class KpaModel extends Model {
 
    protected $table = 'ci_performance_appraisal';

    protected $primaryKey = 'performance_appraisal_id';
    
	// get all fields of table
    protected $allowedFields = ['performance_appraisal_id','company_id','employee_id','title','appraisal_year_month','remarks','added_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
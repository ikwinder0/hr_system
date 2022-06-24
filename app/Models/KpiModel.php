<?php
namespace App\Models;

use CodeIgniter\Model;
	
class KpiModel extends Model {
 
    protected $table = 'ci_performance_indicator';

    protected $primaryKey = 'performance_indicator_id';
    
	// get all fields of table
    protected $allowedFields = ['performance_indicator_id','company_id','title','designation_id','added_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
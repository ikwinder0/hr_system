<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TravelModel extends Model {
 
    protected $table = 'ci_travels';

    protected $primaryKey = 'travel_id';
    
	// get all fields of table
    protected $allowedFields = ['travel_id','company_id','employee_id','start_date','end_date','associated_goals','visit_purpose','visit_place','travel_mode','arrangement_type','expected_budget','actual_budget','description','status','added_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
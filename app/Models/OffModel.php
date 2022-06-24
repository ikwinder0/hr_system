<?php
namespace App\Models;

use CodeIgniter\Model;
	
class OffModel extends Model {
 
    protected $table = 'ci_employee_exit';

    protected $primaryKey = 'exit_id';
    
	// get all fields of table
    protected $allowedFields = ['exit_id','company_id','employee_id','exit_date','exit_type_id','exit_interview','is_inactivate_account','reason','added_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
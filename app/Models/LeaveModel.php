<?php
namespace App\Models;

use CodeIgniter\Model;

class LeaveModel extends Model {
 
    protected $table = 'ci_leave_applications';

    protected $primaryKey = 'leave_id';
    
	// get all fields of table
    protected $allowedFields = ['leave_id','company_id','employee_id','leave_type_id','from_date','to_date','reason','remarks','status','is_half_day','leave_attachment','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
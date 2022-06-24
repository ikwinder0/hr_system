<?php
namespace App\Models;

use CodeIgniter\Model;
	
class OvertimerequestModel extends Model {
 
    protected $table = 'ci_timesheet_request';

    protected $primaryKey = 'time_request_id';
    
	// get all fields of table
    protected $allowedFields = ['time_request_id','company_id','staff_id','request_date','request_month','clock_in','clock_out','total_hours','request_reason','is_approved','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
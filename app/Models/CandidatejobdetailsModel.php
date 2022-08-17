<?php
namespace App\Models;

use CodeIgniter\Model;

class CandidatejobdetailsModel extends Model {
 
    protected $table = 'candidate_job_details'; 

    protected $primaryKey = 'id';
    
	// get all fields of employees details table
    protected $allowedFields = ['project_code','staff_number','line_manager','duty_timing','division_name','stadium_allocation','joining_date','last_working_day','employment_type','qid_number','qid_expiry_date','cc_email_address','local_contact_number','local_address','person_type','person_type','reject_code','reject_message','acc_local_address','building_no','zone_no','street_no','floor_no','flat_no','room_no'];
	
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
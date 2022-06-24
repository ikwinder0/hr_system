<?php
namespace App\Models;

use CodeIgniter\Model;

class JobcandidatesModel extends Model {
 
    protected $table = 'ci_rec_candidates';

    protected $primaryKey = 'candidate_id';
    
	// get all fields of table
    protected $allowedFields = ['candidate_id','company_id','job_id','designation_id','staff_id','message','job_resume','application_status','application_remarks','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
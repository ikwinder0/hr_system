<?php
namespace App\Models;

use CodeIgniter\Model;

class JobinterviewsModel extends Model {
 
    protected $table = 'ci_rec_interviews';

    protected $primaryKey = 'job_interview_id';
    
	// get all fields of table
    protected $allowedFields = ['job_interview_id','company_id','job_id','designation_id','staff_id','interview_place','interview_date','interview_time','interviewer_id','description','interview_remarks','status','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
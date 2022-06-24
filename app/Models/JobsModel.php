<?php
namespace App\Models;

use CodeIgniter\Model;

class JobsModel extends Model {
 
    protected $table = 'ci_rec_jobs';

    protected $primaryKey = 'job_id';
    
	// get all fields of table
    protected $allowedFields = ['job_id','company_id','job_title','designation_id','job_type','job_vacancy','gender','minimum_experience','date_of_closing','short_description','long_description','status','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class ComplaintsModel extends Model {
 
    protected $table = 'ci_complaints';

    protected $primaryKey = 'complaint_id';
    
	// get all fields of table
    protected $allowedFields = ['complaint_id','company_id','complaint_from','title','complaint_date','complaint_against','description','status','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
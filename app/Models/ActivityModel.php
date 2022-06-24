<?php
namespace App\Models;

use CodeIgniter\Model;
	
class ActivityModel extends Model {
 
    protected $table = 'ci_recent_activity';

    protected $primaryKey = 'activity_id';
    
	// get all fields of table
    protected $allowedFields = ['activity_id','company_id','staff_id','module_id','module_type','is_read','added_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
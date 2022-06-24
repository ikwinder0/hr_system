<?php
namespace App\Models;

use CodeIgniter\Model;
	
class WarningModel extends Model {
 
    protected $table = 'ci_warnings';

    protected $primaryKey = 'warning_id';
    
	// get all fields of table
    protected $allowedFields = ['warning_id','company_id','warning_to','warning_by','warning_date','warning_type_id','attachment','subject','description','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
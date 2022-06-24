<?php
namespace App\Models;

use CodeIgniter\Model;
	
class SmstemplatesModel extends Model {
 
    protected $table = 'ci_sms_template';

    protected $primaryKey = 'template_id';
    
	// get all fields of table
    protected $allowedFields = ['template_id','message','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
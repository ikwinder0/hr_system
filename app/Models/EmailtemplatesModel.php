<?php
namespace App\Models;

use CodeIgniter\Model;
	
class EmailtemplatesModel extends Model {
 
    protected $table = 'ci_email_template';

    protected $primaryKey = 'template_id';
    
	// get all fields of table
    protected $allowedFields = ['template_id','template_code','name','subject','message','status'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class Moduleattributes extends Model {
 
    protected $table = 'ci_module_attributes';

    protected $primaryKey = 'custom_field_id';
    
	// get all fields of table
    protected $allowedFields = ['custom_field_id','company_id','module_id','attribute','attribute_label','attribute_type','col_width','validation','priority','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
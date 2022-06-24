<?php
namespace App\Models;

use CodeIgniter\Model;
	
class Moduleattributesvalsel extends Model {
 
    protected $table = 'ci_module_attributes_select_value';

    protected $primaryKey = 'attributes_select_value_id';
    
	// get all fields of table
    protected $allowedFields = ['attributes_select_value_id','company_id','custom_field_id','select_label'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class Moduleattributesval extends Model {
 
    protected $table = 'ci_module_attributes_values';

    protected $primaryKey = 'attributes_value_id';
    
	// get all fields of table
    protected $allowedFields = ['attributes_value_id','company_id','user_id','module_attributes_id','attribute_value','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
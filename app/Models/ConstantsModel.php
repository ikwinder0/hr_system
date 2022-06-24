<?php
namespace App\Models;

use CodeIgniter\Model;

class ConstantsModel extends Model {
 
    protected $table = 'ci_erp_constants';

    protected $primaryKey = 'constants_id';
    
	// get all fields of table
    protected $allowedFields = ['constants_id','company_id','type','category_name','field_one','field_two','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
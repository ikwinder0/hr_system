<?php
namespace App\Models;

use CodeIgniter\Model;

class PayeesModel extends Model {
 
    protected $table = 'ci_finance_entity';

    protected $primaryKey = 'entity_id';
    
	// get all fields of table
    protected $allowedFields = ['entity_id','company_id','name','contact_number','type','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
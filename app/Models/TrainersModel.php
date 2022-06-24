<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TrainersModel extends Model {
 
    protected $table = 'ci_trainers';

    protected $primaryKey = 'trainer_id';
    
	// get all fields of table
    protected $allowedFields = ['trainer_id','company_id','first_name','last_name','contact_number','email','expertise','address','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
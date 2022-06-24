<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TrainingModel extends Model {
 
    protected $table = 'ci_training';

    protected $primaryKey = 'training_id';
    
	// get all fields of table
    protected $allowedFields = ['training_id','company_id','employee_id','training_type_id','associated_goals','trainer_id','start_date','finish_date','training_cost','training_status','description','performance','remarks','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
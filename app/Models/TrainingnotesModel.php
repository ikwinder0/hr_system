<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TrainingnotesModel extends Model {
 
    protected $table = 'ci_training_notes';

    protected $primaryKey = 'training_note_id';
    
	// get all fields of table
    protected $allowedFields = ['training_note_id','company_id','training_id','employee_id','training_note','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class KpaoptionsModel extends Model {
 
    protected $table = 'ci_performance_appraisal_options';

    protected $primaryKey = 'performance_appraisal_options_id';
    
	// get all fields of table
    protected $allowedFields = ['performance_appraisal_options_id','company_id','appraisal_id','appraisal_type','appraisal_option_id','appraisal_option_value'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
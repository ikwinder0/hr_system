<?php
namespace App\Models;

use CodeIgniter\Model;
	
class LanguageModel extends Model {
 
    protected $table = 'ci_languages';

    protected $primaryKey = 'language_id';
    
	// get all fields of table
    protected $allowedFields = ['language_id','language_name','language_code','language_flag','is_active','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class UsersModel extends Model {
 
    protected $table = 'ci_visa_details';

    protected $primaryKey = 'user_id';
    
	// get all fields of user roles table
    protected $allowedFields = ['user_id','document_type','passport_type','passport_number','passport_expiry','passport_issue_country','visa_image'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
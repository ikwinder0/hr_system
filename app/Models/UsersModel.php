<?php
namespace App\Models;

use CodeIgniter\Model;
	
class UsersModel extends Model {
 
    protected $table = 'ci_erp_users';

    protected $primaryKey = 'user_id';
    
	// get all fields of user roles table
    protected $allowedFields = ['user_id','user_role_id','user_type','company_id','first_name','last_name','email','username','password','company_name','trading_name','registration_no','government_tax','company_type_id','profile_photo','contact_number','gender','address_1','address_2','city','state','zipcode','country','last_login_date','last_logout_date','last_login_ip','is_logged_in','is_active','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class UsersModel extends Model {
 
    protected $table = 'ci_erp_users';

    protected $primaryKey = 'user_id';
    
	// get all fields of user roles table
    protected $allowedFields = ['user_id','user_role_id','user_type','company_id','first_name','last_name','email','username','password','company_name','trading_name','registration_no','government_tax','company_type_id','profile_photo','contact_number','gender','address_1','address_2','city','state','zipcode','country','last_login_date','last_logout_date','last_login_ip','is_logged_in','is_active','created_at','website','cr_tax_card','bank_account','bank_account_with_seal','bank_certificate','contact_person','contact_person_phone','first_given_name','second_given_name','family_name','third_given_name','fourth_given_name','given_name_arabic','father_name_arabic','grandfather_name_arabic','greatfather_name_arabic','preferred_family_name','preferred_given_name'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
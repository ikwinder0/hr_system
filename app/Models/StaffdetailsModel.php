<?php
namespace App\Models;

use CodeIgniter\Model;

class StaffdetailsModel extends Model {
 
    protected $table = 'ci_erp_users_details';

    protected $primaryKey = 'staff_details_id';
    
	// get all fields of employees details table
    protected $allowedFields = ['staff_details_id','user_id','employee_id','department_id','designation_id','office_shift_id','basic_salary','hourly_rate','salay_type','leave_categories','role_description','date_of_joining','date_of_leaving','date_of_birth','marital_status','religion_id','blood_group','citizenship_id','bio','experience','fb_profile','twitter_profile','gplus_profile','linkedin_profile','account_title','account_number','bank_name','iban','swift_code','bank_branch','contact_full_name','contact_phone_no','contact_email','contact_address','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
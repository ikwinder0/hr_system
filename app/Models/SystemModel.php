<?php
namespace App\Models;

use CodeIgniter\Model;
	
class SystemModel extends Model {
 
    protected $table = 'ci_erp_settings';

    protected $primaryKey = 'setting_id';
    
	// get all fields of system table
    protected $allowedFields = ['setting_id','application_name','company_name','trading_name','registration_no','government_tax','company_type_id','default_currency','currency_converter','notification_position','notification_close_btn','notification_bar','date_format_xi','enable_email_notification','email_type','logo','favicon','frontend_logo','other_logo','animation_effect','footer_text','default_language','system_timezone','is_ssl_available','contact_number','country','paypal_email','paypal_sandbox','paypal_active','stripe_secret_key','stripe_publishable_key','stripe_active','online_payment_account','invoice_terms_condition','enable_sms_notification','sms_from','sms_service_plan_id','sms_bearer_token','auth_background','address_1','address_2','city','zipcode','state','email','hr_version','hr_release_date','updated_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
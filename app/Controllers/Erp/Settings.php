<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the TimeHRM License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.timehrm.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to timehrm.official@gmail.com so we can send you a copy immediately.
 *
 * @author   TimeHRM
 * @author-email  timehrm.official@gmail.com
 * @copyright  Copyright © timehrm.com All Rights Reserved
 */
namespace App\Controllers\Erp;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\IncomingRequest; 
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ConstantsModel;
use App\Models\CurrenciesModel;
use App\Models\SmstemplatesModel;
use App\Models\DatabasebackupModel;
use App\Models\EmailtemplatesModel;

require_once('Backup_erp.php');
class Settings extends BaseController {

	public function index()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$RolesModel = new RolesModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('settings1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.left_settings').' | '.$xin_system['application_name'];
		$data['path_url'] = 'settings';
		$data['breadcrumbs'] = lang('Main.left_settings');

		$data['subview'] = view('erp/settings/settings', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function constants()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$RolesModel = new RolesModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('settings2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.left_constants').' | '.$xin_system['application_name'];
		$data['path_url'] = 'constants';
		$data['breadcrumbs'] = lang('Main.left_constants');

		$data['subview'] = view('erp/settings/constants', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function database_backup()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('settings5',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.header_db_log').' | '.$xin_system['application_name'];
		$data['path_url'] = 'database_backup';
		$data['breadcrumbs'] = lang('Main.header_db_log');

		$data['subview'] = view('erp/settings/database_backup', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function email_templates()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('settings3',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.left_email_templates').' | '.$xin_system['application_name'];
		$data['path_url'] = 'email_template';
		$data['breadcrumbs'] = lang('Main.left_email_templates');

		$data['subview'] = view('erp/settings/email_templates', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function sms_templates()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('settings3',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_sms_templates').' | '.$xin_system['application_name'];
		$data['path_url'] = 'sms_template';
		$data['breadcrumbs'] = lang('Main.xin_sms_templates');

		$data['subview'] = view('erp/settings/sms_templates', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function currency_converter()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('settings6',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_currency_converter').' | '.$xin_system['application_name'];
		$data['path_url'] = 'currency_converter';
		$data['breadcrumbs'] = lang('Main.xin_currency_converter');

		$data['subview'] = view('erp/settings/currency_converter', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	
	// Validate and update info in database
	public function system_info() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$SystemModel = new SystemModel();
	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'application_name' => 'required',
					'company_name' => 'required',
				],
				[   // Errors
					'application_name' => [
						'required' => lang('Main.xin_error_application_name_field'),
					],
					'company_name' => [
						'required' => lang('Company.xin_error_name_field'),
					],
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('application_name')) {
				$Return['error'] = $validation->getError('application_name');
			} else if($validation->hasError('company_name')) {
				$Return['error'] = $validation->getError('company_name');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
		$application_name = $this->request->getPost('application_name',FILTER_SANITIZE_STRING);
		$company_name = $this->request->getPost('company_name',FILTER_SANITIZE_STRING);
		$auth_background = $this->request->getPost('auth_background',FILTER_SANITIZE_STRING);
		$is_ssl_available = $this->request->getPost('is_ssl_available',FILTER_SANITIZE_STRING);
		if($is_ssl_available == ''){
			$is_ssl_available = 0;
		}
		$id = 1;
		$data = [
            'application_name' => $application_name,
			'company_name' => $company_name,
			'auth_background'  => $auth_background,
			'is_ssl_available'  => $is_ssl_available,
        ];
        $result = $SystemModel->update($id, $data);	
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Main.xin_success_system_configuration_updated');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	} 
	// set logo
	public function add_logo() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'logo_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validated = $this->validate([
				'logo_file' => [
					'uploaded[logo_file]',
					'mime_in[logo_file,image/jpg,image/jpeg,image/gif,image/png,image/svg]',
					'max_size[logo_file,4096]',
				],
			]);
			if (!$validated) {
				$Return['error'] = lang('Main.xin_error_select_first_logo');
			} else {
				$avatar = $this->request->getFile('logo_file');
				$file_name = $avatar->getName();
				$avatar->move('public/uploads/logo/');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = 1;
			$data = [
				'logo' => $file_name
			];
			$SystemModel = new SystemModel();
			$result = $SystemModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_success_system_logo_updated');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	} 
	// set favicon
	public function add_favicon() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'favicon') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validated = $this->validate([
				'favicon' => [
					'uploaded[favicon]',
					'mime_in[favicon,image/jpg,image/jpeg,image/gif,image/png,image/svg]',
					'max_size[favicon,4096]',
				],
			]);
			if (!$validated) {
				$Return['error'] = lang('Main.xin_error_select_favicon');
			} else {
				$avatar = $this->request->getFile('favicon');
				$file_name = $avatar->getName();
				$avatar->move('public/uploads/logo/favicon/');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = 1;
			$data = [
				'favicon' => $file_name
			];
			$SystemModel = new SystemModel();
			$result = $SystemModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_success_system_favicon_updated');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	} 
	// set sign in page logo
	public function add_frontend_logo() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'frontend_logo') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validated = $this->validate([
				'frontend_logo' => [
					'uploaded[frontend_logo]',
					'mime_in[frontend_logo,image/jpg,image/jpeg,image/gif,image/png,image/svg]',
					'max_size[frontend_logo,4096]',
				],
			]);
			if (!$validated) {
				$Return['error'] = lang('Main.xin_error_select_field_logo');
			} else {
				$avatar = $this->request->getFile('frontend_logo');
				$file_name = $avatar->getName();
				$avatar->move('public/uploads/logo/frontend/');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = 1;
			$data = [
				'frontend_logo' => $file_name
			];
			$SystemModel = new SystemModel();
			$result = $SystemModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_success_signin_page_logo_updated');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	} 
	// set invoice/payslip logo
	public function add_other_logo() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'other_logo') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validated = $this->validate([
				'other_logo' => [
					'uploaded[other_logo]',
					'mime_in[other_logo,image/jpg,image/jpeg,image/gif,image/png,image/svg]',
					'max_size[other_logo,4096]',
				],
			]);
			if (!$validated) {
				$Return['error'] = lang('Main.xin_error_select_field_logo');
			} else {
				$avatar = $this->request->getFile('other_logo');
				$file_name = $avatar->getName();
				$avatar->move('public/uploads/logo/other/');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = 1;
			$data = [
				'other_logo' => $file_name
			];
			$SystemModel = new SystemModel();
			$result = $SystemModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_success_invoice_payslip_logo_updated');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	} 
	
	// Validate and update info in database
	public function update_payment_gateway() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		$SystemModel = new SystemModel();
	
		if ($this->request->getPost('type') === 'payment_gateway') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'paypal_email' => 'required',
					'stripe_secret_key' => 'required',
					'stripe_publishable_key' => 'required'
				],
				[   // Errors
					'paypal_email' => [
						'required' => lang('Main.xin_error_paypal_email_field'),
					],
					'stripe_secret_key' => [
						'required' => lang('Main.xin_error_stripe_secret_key_field'),
					],
					'stripe_publishable_key' => [
						'required' => lang('Main.xin_error_stripe_publishable_key_field'),
					]
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('paypal_email')) {
				$Return['error'] = $validation->getError('paypal_email');
			} elseif($validation->hasError('stripe_secret_key')){
				$Return['error'] = $validation->getError('stripe_secret_key');
			} elseif($validation->hasError('stripe_publishable_key')){
				$Return['error'] = $validation->getError('stripe_publishable_key');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
		$paypal_email = $this->request->getPost('paypal_email',FILTER_SANITIZE_STRING);
		$paypal_sandbox = $this->request->getPost('paypal_sandbox',FILTER_SANITIZE_STRING);
		$paypal_active = $this->request->getPost('paypal_active',FILTER_SANITIZE_STRING);
		$stripe_secret_key = $this->request->getPost('stripe_secret_key',FILTER_SANITIZE_STRING);
		$stripe_publishable_key = $this->request->getPost('stripe_publishable_key',FILTER_SANITIZE_STRING);
		$stripe_active = $this->request->getPost('stripe_active',FILTER_SANITIZE_STRING);
		$id = 1;
		$data = [
            'paypal_email' => $paypal_email,
            'paypal_sandbox'  => $paypal_sandbox,
			'paypal_active'  => $paypal_active,
			'stripe_secret_key'  => $stripe_secret_key,
			'stripe_publishable_key'  => $stripe_publishable_key,
			'stripe_active'  => $stripe_active
        ];
        $result = $SystemModel->update($id, $data);	
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Main.xin_acc_payment_gateway_info_updated');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	}
	// Validate and update info in database
	public function email_info() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$SystemModel = new SystemModel();
	
		if ($this->request->getPost('type') === 'email_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'email_type' => 'required'
				],
				[   // Errors
					'email_type' => [
						'required' => lang('Main.xin_email_type_error_field'),
					]
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('email_type')) {
				$Return['error'] = $validation->getError('email_type');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
		$email_type = $this->request->getPost('email_type',FILTER_SANITIZE_STRING);
		$email_notification = $this->request->getPost('email_notification',FILTER_SANITIZE_STRING);
		if($email_notification == ''): $email_notification = 0; endif;
		$id = 1;
		$data = [
            'enable_email_notification' => $email_notification,
            'email_type'  => $email_type,
        ];
        $result = $SystemModel->update($id, $data);	
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Main.xin_success_email_notify_updated');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	}
	// Validate and update info in database
	public function sms_info() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$SystemModel = new SystemModel();
	
		if ($this->request->getPost('type') === 'sms_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'service_plan_id' => 'required',
					'bearer_token' => 'required',
					'sms_from' => 'required'
				],
				[   // Errors
					'service_plan_id' => [
						'required' => lang('Main.xin_service_plan_id_error_field'),
					],
					'bearer_token' => [
						'required' => lang('Main.xin_api_token_error_field'),
					],
					'sms_from' => [
						'required' => lang('Main.xin_api_token_error_field'),
					]
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('service_plan_id')) {
				$Return['error'] = $validation->getError('service_plan_id');
			} elseif ($validation->hasError('bearer_token')) {
				$Return['error'] = $validation->getError('bearer_token');
			} elseif ($validation->hasError('sms_from')) {
				$Return['error'] = $validation->getError('sms_from');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
		$service_plan_id = $this->request->getPost('service_plan_id',FILTER_SANITIZE_STRING);
		$bearer_token = $this->request->getPost('bearer_token',FILTER_SANITIZE_STRING);
		$sms_from = $this->request->getPost('sms_from',FILTER_SANITIZE_STRING);
		$sms_notification = $this->request->getPost('sms_notification',FILTER_SANITIZE_STRING);
		if($sms_notification == ''): $sms_notification = 0; endif;
		$id = 1;
		$data = [
            'enable_sms_notification' => $sms_notification,
            'sms_from'  => $sms_from,
			'sms_service_plan_id'  => $service_plan_id,
			'sms_bearer_token'  => $bearer_token,
        ];
        $result = $SystemModel->update($id, $data);	
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Main.xin_sms_settings_updated');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	}
	// Validate and update info in database
	public function update_currency() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$SystemModel = new SystemModel();
	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
		
			$currency_val = $this->request->getPost('currency_val',FILTER_SANITIZE_STRING);
			$currency_val = serialize($currency_val);
			$id = 1;
			$data = [
				'currency_converter' => $currency_val,
			];
			$result = $SystemModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_updated_system_currency_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// Validate and update info in database
	public function notification_position_info() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$SystemModel = new SystemModel();
	
		if ($this->request->getPost('type') === 'notification') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'notification_position' => 'required'
				],
				[   // Errors
					'notification_position' => [
						'required' => lang('Main.xin_error_notify_position'),
					]
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('notification_position')) {
				$Return['error'] = $validation->getError('notification_position');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
		$notification_position = $this->request->getPost('notification_position',FILTER_SANITIZE_STRING);
		$notification_close = $this->request->getPost('notification_close',FILTER_SANITIZE_STRING);
		$notification_bar = $this->request->getPost('notification_bar',FILTER_SANITIZE_STRING);
		if($notification_close == ''): $notification_close = 0; endif;
		if($notification_bar == ''): $notification_bar = 0; endif;
		$id = 1;
		$data = [
            'notification_position' => $notification_position,
            'notification_close_btn'  => $notification_close,
			 'notification_bar'  => $notification_bar
        ];
        $result = $SystemModel->update($id, $data);	
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Main.xin_success_notify_position_config_updated');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	}
	
	// Constants///
	// list
	public function currency_type_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$ConstantsModel = new ConstantsModel();
		$currency = $ConstantsModel->where('type','currency_type')->orderBy('constants_id', 'ASC')->findAll();
		
		$data = array();
		
          foreach($currency as $r) {						
		  	
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_type="currency_type" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '" data-token_type="currency_type"><i class="feather icon-trash-2"></i></button></span>';

			$combhr = $edit.$delete;
			$links = '
				'.$r['category_name'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';						 			  				
			$data[] = array(
				$links,
				$r['field_one'],
				$r['field_two']
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	// list
	public function company_type_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$ConstantsModel = new ConstantsModel();
		$ctype = $ConstantsModel->where('type','company_type')->orderBy('constants_id', 'ASC')->findAll();
		
		$data = array();
		
          foreach($ctype as $r) {						
		  	
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_type="company_type" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '" data-token_type="company_type"><i class="feather icon-trash-2"></i></button></span>';

			$combhr = $edit.$delete;
			$links = '
				'.$r['category_name'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';			  				
			$data[] = array($links,
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	// list
	public function religion_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$ConstantsModel = new ConstantsModel();
		$ctype = $ConstantsModel->where('type','religion')->orderBy('constants_id', 'ASC')->findAll();
		
		$data = array();
		
          foreach($ctype as $r) {						
		  	
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_type="religion" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '" data-token_type="religion"><i class="feather icon-trash-2"></i></button></span>';

			$combhr = $edit.$delete;
			$links = '
				'.$r['category_name'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';			  				
			$data[] = array($links,
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 // list
	public function currency_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$CurrenciesModel = new CurrenciesModel();
		$ctype = $CurrenciesModel->orderBy('currency_id', 'ASC')->findAll();
		
		$data = array();
		
          foreach($ctype as $r) {						
		  	
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_type="currency_type" data-field_id="'. uencode($r['currency_id']) . '"><i class="feather icon-edit"></i></button></span>';
				//$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['currency_id']) . '" data-token_type="religion"><i class="feather icon-trash-2"></i></button></span>';

			$combhr = $edit;
			$links = '
				'.$r['country_name'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';			  				
			$data[] = array(
				$links,
				$r['currency_name'],
				$r['currency_code']
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 // add record
	 public function currency_type_info() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
	
		if ($this->request->getPost('type') === 'currency_type_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'country' => 'required',
					'currency_name' => 'required',
					'currency_code' => 'required'
				],
				[   // Errors
					'country' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'currency_name' => [
						'required' => lang('Main.xin_error_currency_name_field'),
					],
					'currency_code' => [
						'required' => lang('Main.xin_error_currency_code_field'),
					],
					
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('country')) {
				$Return['error'] = $validation->getError('country');
			} elseif ($validation->hasError('currency_name')) {
				$Return['error'] = $validation->getError('currency_name');
			} elseif ($validation->hasError('currency_code')) {
				$Return['error'] = $validation->getError('currency_code');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
		$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);
		$currency_name = $this->request->getPost('currency_name',FILTER_SANITIZE_STRING);
		$currency_code = $this->request->getPost('currency_code',FILTER_SANITIZE_STRING);
		$data = [
			'country_name' => $country,
            'currency_name'  => $currency_name,
			'currency_code'  => $currency_code,
        ];
		$CurrenciesModel = new CurrenciesModel();
        $result = $CurrenciesModel->insert($data);	
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Main.xin_success_currency_type_added');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	}
	// update record
	 public function update_currency_type() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$CurrenciesModel = new CurrenciesModel();
	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'country' => 'required',
					'currency_name' => 'required',
					'currency_code' => 'required'
				],
				[   // Errors
					'country' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'currency_name' => [
						'required' => lang('Main.xin_error_currency_name_field'),
					],
					'currency_code' => [
						'required' => lang('Main.xin_error_currency_code_field'),
					],
					
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('country')) {
				$Return['error'] = $validation->getError('country');
			} elseif ($validation->hasError('currency_name')) {
				$Return['error'] = $validation->getError('currency_name');
			} elseif ($validation->hasError('currency_code')) {
				$Return['error'] = $validation->getError('currency_code');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
		$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);
		$currency_name = $this->request->getPost('currency_name',FILTER_SANITIZE_STRING);
		$currency_code = $this->request->getPost('currency_code',FILTER_SANITIZE_STRING);
		$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
		$data = [
			'country_name' => $country,
            'currency_name'  => $currency_name,
			'currency_code'  => $currency_code,
        ];
        $result = $CurrenciesModel->update($id,$data);	
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Main.xin_success_currency_type_updated');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	}
	// add record
	 public function company_type_info() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		$ConstantsModel = new ConstantsModel();
	
		if ($request->getPost('type') === 'company_type_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'company_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_ctype_field')
					]
				]
			];
			if(!$this->validate($rules)){
				
				/*$ruleErrors = \Config\Services::validation()->listErrors();
				//foreach($ruleErrors as $err){
					$Return['error'] = $ruleErrors;
					if($Return['error']!=''){
						$this->output($Return);
					}*/
				//}
				$ruleErrors = [
                    "company_type" => $validation->getError('company_type')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$company_type = $this->request->getPost('company_type',FILTER_SANITIZE_STRING);
				$data = [
					'category_name' => $company_type,
					'company_id'  => $usession['sup_user_id'],
					'type'  => 'company_type',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Main.xin_company_type_added');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
			
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// add record
	 public function add_religion_info() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		$ConstantsModel = new ConstantsModel();
	
		if ($request->getPost('type') === 'religion_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'religion' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				
				/*$ruleErrors = \Config\Services::validation()->listErrors();
				//foreach($ruleErrors as $err){
					$Return['error'] = $ruleErrors;
					if($Return['error']!=''){
						$this->output($Return);
					}*/
				//}
				$ruleErrors = [
                    "religion" => $validation->getError('religion')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$religion = $this->request->getPost('religion',FILTER_SANITIZE_STRING);
				$data = [
					'category_name' => $religion,
					'company_id'  => $usession['sup_user_id'],
					'type'  => 'religion',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Employees.xin_ethnicity_type_success_added');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
			
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// update record
	 public function update_company_type() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$ConstantsModel = new ConstantsModel();
	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_ctype_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$Return['error'] = $validation->getError('name');
				if($Return['error']!=''){
					$this->output($Return);
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'category_name' => $name
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Main.xin_company_type_updated');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		}
		
	}
	// update record
	 public function update_religion() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$ConstantsModel = new ConstantsModel();
	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'religion' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$Return['error'] = $validation->getError('religion');
				if($Return['error']!=''){
					$this->output($Return);
				}
			} else {
				$religion = $this->request->getPost('religion',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'category_name' => $religion
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Employees.xin_ethnicity_type_success_updated');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		}
		
	}
	// read and view all constants data > modal form
	public function constants_read()
	{
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$id = $request->getGet('field_id');
		//$result = $this->Membership_model->read_membership_info($id);
		$data = [
				'field_id' => $id,
			];
		if($session->has('sup_username')){
			return view('erp/settings/dialog_constants', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_currency_type() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ConstantsModel = new ConstantsModel();
			$result = $ConstantsModel->where('constants_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_success_currency_type_deleted');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_company_type() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ConstantsModel = new ConstantsModel();
			$result = $ConstantsModel->where('constants_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_company_type_deleted');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_religion() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ConstantsModel = new ConstantsModel();
			$result = $ConstantsModel->where('constants_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Employees.xin_ethnicity_type_success_deleted');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// list
	public function database_backup_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$DatabasebackupModel = new DatabasebackupModel();
		$backup = $DatabasebackupModel->orderBy('backup_id', 'ASC')->findAll();
		$data = array();
		
          foreach($backup as $r) {						
		  					
				$download = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_download').'"><a href="'.site_url().'download?type=dbbackup&filename='.uencode($r['backup_file']).'"><button type="button" class="btn icon-btn btn-sm btn-light-success waves-effect waves-light"><i class="feather icon-download"></i></button></a></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light deletedb" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['backup_id']) . '"><i class="feather icon-trash-2"></i></button></span>';

			$combhr = $download.$delete;
									 			  				
			$data[] = array($combhr,
				$r['backup_file'],
				$r['created_at']
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 public function create_database_backup()
     {
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		if ($this->request->getMethod() === 'post') {
			
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			
			$db = \Config\Database::connect();
			// get db credentials			
			$hostname = $db->hostname;
			$username = $db->username;
			$password = $db->password;
			$database = $db->database;
				
			$dir  = base_url().'/public/uploads/dbbackup/'; // directory files
			$name = 'timehrm_backup_'.date('d-m-Y').'_'.time(); // name sql backup
			
			$newImport = new Backup_erp($hostname,$database,$username,$password);
			$newImport->backup();					
					
			$fname = $name.'.sql';
					
			$data = array(
			'backup_file' => $fname,
			'created_at' => date('d-m-Y H:i:s')
			);
			$DatabasebackupModel = new DatabasebackupModel();
			$result = $DatabasebackupModel->insert($data);	
			
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_database_backup_generated');
				
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
     }
	  public function delete_db_backup()
     {
		if($this->request->getPost('type')=='delete_old_backup') {
			
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			
			/*Delete backup*/
			$DatabasebackupModel = new DatabasebackupModel();
			$result = $DatabasebackupModel->emptyTable();
						
			if ($result) {
				delete_files('./public/uploads/dbbackup/');
				$Return['result'] = lang('Main.xin_success_database_old_backup_deleted');
				
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
     }
	 // delete single record
	public function delete_dbsingle_backup() {
		
		if($this->request->getPost('is_ajax')==2) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$DatabasebackupModel = new DatabasebackupModel();
			$row = $DatabasebackupModel->where('backup_id', $id)->first();
			unlink('./public/uploads/dbbackup/'.$row['backup_file']);
			$result = $DatabasebackupModel->where('backup_id', $id)->delete($id);
			if($result) {
				
				$Return['result'] = lang('Main.xin_success_database_backup_deleted');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	/// Email Templates
	  public function email_template_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$EmailtemplatesModel = new EmailtemplatesModel();
		$emailtemplates = $EmailtemplatesModel->where('template_type', 'super_admin')->orderBy('template_id', 'ASC')->findAll();
		
		$data = array();

        foreach($emailtemplates as $r) {
			
		if($r['status']==1){
			$status = '<span class="badge badge-pill badge-success">'.lang('Main.xin_employees_active').'</span>';
		} else {
			$status = '<span class="badge badge-pill badge-danger">'.lang('Main.xin_employees_inactive').'</span>';
		}
		$links = '
			'.$r['name'].'
			<div class="overlay-edit">
				<button type="button" class="btn btn-sm btn-icon btn-light-primary" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['template_id']) . '"><i class="feather icon-edit"></i></button>
			</div>
		';			  				
		$data[] = array(
			$links,
			$r['subject'],
			$status
		);
      }

	  $output = array(
		   //"draw" => $draw,
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     } 
	 /// Email Templates
	  public function sms_template_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$SmstemplatesModel = new SmstemplatesModel();
		$smstemplates = $SmstemplatesModel->orderBy('template_id', 'ASC')->findAll();
		
		$data = array();

        foreach($smstemplates as $r) {
			
		$links = '
			'.$r['subject'].'
			<div class="overlay-edit">
				<button type="button" class="btn btn-sm btn-icon btn-light-primary" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['template_id']) . '"><i class="feather icon-edit"></i></button>
			</div>
		';			  				
		$data[] = array(
			$links
		);
      }

	  $output = array(
		   //"draw" => $draw,
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     } 
	 public function read_tempalte()
	{
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$id = $request->getGet('field_id');
		$data = [
				'field_id' => $id,
			];
		if($session->has('sup_username')){
			return view('erp/settings/dialog_email_template', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	} 
	public function read_sms_tempalte()
	{
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$id = $request->getGet('field_id');
		$data = [
				'field_id' => $id,
			];
		if($session->has('sup_username')){
			return view('erp/settings/dialog_sms_template', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	} 
	
	// update record
	 public function update_template() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$EmailtemplatesModel = new EmailtemplatesModel();
	
		if ($this->request->getPost('type') === 'edit_template') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'name' => 'required',
					'subject' => 'required',
					'status' => 'required',
					'message' => 'required'
				],
				[   // Errors
					'name' => [
						'required' => lang('Main.xin_error_template_name_field'),
					],
					'subject' => [
						'required' => lang('Main.xin_employee_error_subject'),
					],
					'status' => [
						'required' => lang('Main.xin_error_template_status'),
					],
					'message' => [
						'required' => lang('Main.xin_error_template_message'),
					]
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('name')) {
				$Return['error'] = $validation->getError('name');
			} elseif ($validation->hasError('subject')) {
				$Return['error'] = $validation->getError('subject');
			} elseif ($validation->hasError('status')) {
				$Return['error'] = $validation->getError('status');
			} elseif ($validation->hasError('message')) {
				$Return['error'] = $validation->getError('message');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
		$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
		$subject = $this->request->getPost('subject',FILTER_SANITIZE_STRING);
		$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
		$message = $this->request->getPost('message',FILTER_SANITIZE_STRING);
		$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
		$data = [
            'name' => $name,
			'subject' => $subject,
			'message' => $message,
			'status' => $status
        ];
        $result = $EmailtemplatesModel->update($id,$data);	
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Main.xin_success_email_template_updated');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	}
	// update record
	 public function update_sms_template() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$SmstemplatesModel = new SmstemplatesModel();
	
		if ($this->request->getPost('type') === 'edit_template') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'subject' => 'required',
					'message' => 'required'
				],
				[   // Errors
					'subject' => [
						'required' => lang('Main.xin_employee_error_subject'),
					],
					'message' => [
						'required' => lang('Main.xin_error_template_message'),
					]
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('subject')) {
				$Return['error'] = $validation->getError('subject');
			} elseif ($validation->hasError('message')) {
				$Return['error'] = $validation->getError('message');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
		$subject = $this->request->getPost('subject',FILTER_SANITIZE_STRING);
		$message = $this->request->getPost('message',FILTER_SANITIZE_STRING);
		$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
		$data = [
			'subject' => $subject,
			'message' => $message
        ];
        $result = $SmstemplatesModel->update($id,$data);	
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Main.xin_sms_template_updated');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	}
}

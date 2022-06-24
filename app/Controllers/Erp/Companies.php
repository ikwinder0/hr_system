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

use CodeIgniter\I18n\Time;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Files\UploadedFile;

use App\Models\MainModel;
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\CompanyModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;
use App\Models\MembershipModel;
use App\Models\SuperroleModel;
use App\Models\EmailtemplatesModel;
use App\Models\CompanysettingsModel;
use App\Models\CompanymembershipModel;

class Companies extends BaseController {
	
	public function index()
	{		
		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Company.xin_companies').' | '.$xin_system['application_name'];
		$data['path_url'] = 'companies';
		$data['breadcrumbs'] = lang('Company.xin_companies');
		$data['subview'] = view('erp/companies/company_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function company_details()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$UsersModel = new UsersModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $UsersModel->where('user_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_company_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'company_details';
		$data['breadcrumbs'] = lang('Main..xin_company_details');

		$data['subview'] = view('erp/companies/company_detail', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	 // list
	public function companies_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$ConstantsModel = new ConstantsModel();
		$CountryModel = new CountryModel();
		$MembershipModel = new MembershipModel();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$CompanymembershipModel = new CompanymembershipModel();
		$company = $UsersModel->where('user_type', 'company')->orderBy('user_id', 'ASC')->findAll();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data = array();
		
          foreach($company as $r) {						
		  			
				$view = '<a href="'.site_url('erp/company-detail/'). uencode($r['user_id']) . '"><span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></span></a>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['user_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			$company_types = $ConstantsModel->where('constants_id', $r['company_type_id'])->first();
			$all_countries = $CountryModel->where('country_id', $r['country'])->first();
			// membership
			$company_membership = $CompanymembershipModel->where('company_id', $r['user_id'])->first();
			$membership = $MembershipModel->where('membership_id', $company_membership['membership_id'])->first();
			if($membership['plan_duration'] == '1'){
				$subscription = '<span class="text-success">'.lang('Membership.xin_subscription_monthly').'</span>';
				$iprice = number_to_currency($membership['price'], $xin_system['default_currency'],null,2);
			
			} elseif($membership['plan_duration'] == '2') {
				$subscription = '<span class="text-info">'.lang('Membership.xin_subscription_yearly').'</span>';
				$iprice = number_to_currency($membership['price'], $xin_system['default_currency'],null,2);
			} elseif($membership['plan_duration'] == '3') {
				$subscription = '<span class="text-info">'.lang('Membership.xin_subscription_unlimit').'</span>';
				$iprice = number_to_currency($membership['price'], $xin_system['default_currency'],null,2);
			}
			$mp_subs = $membership['membership_type'].'<br><div class="small">'.$iprice.'/'.$subscription.'</div>';
			$combhr = $edit.$view.$delete;
			if($r['profile_photo']=='no'){
				$profile_picture = base_url().'/public/uploads/default_profile.jpg';
			} else {
				$profile_picture = base_url().'/public/uploads/users/thumb/'.$r['profile_photo'];
			}
			$cname = '<div class="d-inline-block align-middle">
				<img src="'.staff_profile_photo($r['user_id']).'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$r['company_name'].'</h6>
					<p class="m-b-0">'.$r['email'].'</p>
				</div>
			</div>'; 
			//status
			if($r['is_active']==1){
				$status = '<span class="badge badge-light-success">'.lang('Main.xin_employees_active').'</span>';
			} else {
				$status = '<span class="badge badge-light-danger">'.lang('Main.xin_employees_inactive').'</span>';
			}
			$links = '
				'.$cname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';						 			  				
			$data[] = array(
				$links,
				$company_types['category_name'],
				$mp_subs,
				$all_countries['country_name'],
				$status,
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	public function add_company() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'company_name' => 'required',
					'company_type' => 'required',
					'first_name' => 'required',
					'last_name' => 'required',
					'contact_number' => 'required',
					'email' => 'required|valid_email|is_unique[ci_app_users.email]',
					'membership_type' => 'required',
					'country' => 'required',
					'username' => 'required|min_length[6]|is_unique[ci_app_users.username]',
					'password' => 'required|min_length[6]',
					//'logo' => 'required'
				],
				[   // Errors
					'company_name' => [
						'required' => lang('Company.xin_error_name_field'),
					],
					'company_type' => [
						'required' => lang('Company.xin_error_ctype_field'),
					],
					'first_name' => [
						'required' => lang('Main.xin_contact_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_contact_error_last_name'),
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_contact_field'),
					],
					'email' => [
						'required' => lang('Main.xin_error_cemail_field'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email'),
						'is_unique' => lang('Main.xin_already_exist_error_email'),
					],
					'membership_type' => [
						'required' => lang('Company.xin_error_membership_type_field'),
					],
					'country' => [
						'required' => lang('Main.xin_error_country_field'),
					],
					'username' => [
						'required' => lang('Main.xin_employee_error_username'),
						'min_length' => lang('Main.xin_min_error_username'),
						'is_unique' => lang('Main.xin_already_exist_error_username')
					],
					'password' => [
						'required' => lang('Main.xin_employee_error_password'),
						'min_length' => lang('Login.xin_min_error_password')
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('company_name')) {
				$Return['error'] = $validation->getError('company_name');
			} elseif($validation->hasError('company_type')){
				$Return['error'] = $validation->getError('company_type');
			} elseif($validation->hasError('first_name')) {
				$Return['error'] = $validation->getError('first_name');
			} elseif($validation->hasError('last_name')){
				$Return['error'] = $validation->getError('last_name');
			} elseif($validation->hasError('country')){
				$Return['error'] = $validation->getError('country');
			} elseif($validation->hasError('membership_type')){
				$Return['error'] = $validation->getError('membership_type');
			} elseif($validation->hasError('email')){
				$Return['error'] = $validation->getError('email');
			} elseif($validation->hasError('username')){
				$Return['error'] = $validation->getError('username');
			} elseif($validation->hasError('password')){
				$Return['error'] = $validation->getError('password');
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$image = service('image');
			$validated = $this->validate([
				'file' => [
					'uploaded[file]',
					'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
					'max_size[file,4096]',
				],
			]);
			if (!$validated) {
				$Return['error'] = lang('Company.xin_logo_company_error_field');
			} else {
				$avatar = $this->request->getFile('file');
				$avatar->move('public/uploads/users/');
				$file_name = $avatar->getName();
				$image->withFile(filesrc($file_name))
				->fit(100, 100, 'center')
				->save('public/uploads/users/thumb/'.$file_name);

			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$company_name = $this->request->getPost('company_name',FILTER_SANITIZE_STRING);
			$company_type = $this->request->getPost('company_type',FILTER_SANITIZE_STRING);
			$trading_name = '';
			$registration_no = '';
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$xin_gtax = '';
			$membership_type = $this->request->getPost('membership_type',FILTER_SANITIZE_STRING);
			//$subscription = $this->request->getPost('subscription',FILTER_SANITIZE_STRING);
			$address_1 = '';
			$address_2 = '';
			$city = '';
			$state = '';
			$zipcode = '';
			$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);		
			$username = $this->request->getPost('username',FILTER_SANITIZE_STRING);
			$password = $this->request->getPost('password',FILTER_SANITIZE_STRING);
							
			$options = array('cost' => 12);
			$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
			$data = [
				'company_id' => 0,
				'company_name' => $company_name,
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'company_type_id'  => $company_type,
				'trading_name'  => $trading_name,
				'user_type'  => 'company',
				'registration_no'  => $registration_no,
				'contact_number'  => $contact_number,
				'email'  => $email,
				'government_tax' => $xin_gtax,
				'address_1'  => $address_1,
				'address_2'  => $address_2,
				'city'  => $city,
				'profile_photo'  => $file_name,
				'state'  => $state,
				'zipcode' => $zipcode,
				'country'  => $country,
				'username'  => $username,
				'password'  => $password_hash,
				'user_role_id' => 0,
				'gender' => 1,
				'last_login_date' => '0',
				'last_logout_date' => '0',
				'last_login_ip' => '0',
				'is_logged_in' => '0',
				'is_active'  => 1,
				'added_by'  => $usession['sup_user_id'],
				'created_at' => date('d-m-Y h:i:s')
			];
			
			$UsersModel = new UsersModel();
			$result = $UsersModel->insert($data);	
			$user_id = $UsersModel->insertID();
			$SystemModel = new SystemModel();
			$MembershipModel = new MembershipModel();
			$EmailtemplatesModel = new EmailtemplatesModel();
			$CompanysettingsModel = new CompanysettingsModel();
			$CompanymembershipModel = new CompanymembershipModel();
			$membership_info = $MembershipModel->where('membership_id', $membership_type)->first();
			$xin_system = $SystemModel->where('setting_id', 1)->first();
			
			$data2 = array(
				'company_id'  => $user_id,
				'membership_id'  => $membership_type,
				'subscription_type'  => $membership_info['plan_duration'],
				'update_at'  => date('d-m-Y h:i:s'),
				'created_at'  => date('d-m-Y h:i:s')
			);
			$CompanymembershipModel->insert($data2);
			$data3 = array(
				'company_id'  => $user_id,
				'default_currency'  => 'USD',
				'default_currency_symbol'  => 'USD',
				'notification_position'  => 'toast-top-center',
				'notification_close_btn'  => 'true',
				'notification_bar'  => 'true',
				'date_format_xi'  => 'Y-m-d',
				'default_language'  => 'en',
				'system_timezone'  => 'Asia/Riyadh',
				'paypal_email'  => 'paypal@example.com',
				'paypal_sandbox'  => 'yes',
				'paypal_active'  => 'yes',
				'stripe_secret_key'  => 'stripe_secret_key',
				'stripe_publishable_key'  => 'stripe_publishable_key',
				'stripe_active'  => 'yes',
				'invoice_terms_condition'  => 'invoice terms condition..',
				'updated_at'  => date('d-m-Y h:i:s')
			);
			$CompanysettingsModel->insert($data3);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				if($xin_system['enable_email_notification'] == 1){
					$full_name = $first_name.' '.$last_name;
					// Send mail start
					$itemplate = $EmailtemplatesModel->where('template_id', 3)->first();
					$isubject = $itemplate['subject'];
					$ibody = html_entity_decode($itemplate['message']);
					$fbody = str_replace(array("{user_name}","{site_name}","{user_password}","{user_username}","{plan_title}","{site_url}"),array($full_name,$xin_system['company_name'],$password,$username,$membership_info['membership_type'],site_url()),$ibody);
					timehrm_mail_data($xin_system['email'],$xin_system['company_name'],$email,$isubject,$fbody);
					// Send mail end
				}
				$Return['result'] = lang('Company.xin_success_add_company');
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
	// update record
	public function update_company() {
		
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'company_name' => 'required',
					'company_type' => 'required',
					'first_name' => 'required',
					'last_name' => 'required',
					'contact_number' => 'required',
					'email' => 'required|valid_email',
					'membership_type' => 'required',
					'subscription' => 'required',
					'country' => 'required',
					'username' => 'required|min_length[6]'
					//'logo' => 'required'
				],
				[   // Errors
					'company_name' => [
						'required' => lang('Company.xin_error_name_field'),
					],
					'company_type' => [
						'required' => lang('Company.xin_error_ctype_field'),
					],
					'first_name' => [
						'required' => lang('Main.xin_contact_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_contact_error_last_name'),
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_contact_field'),
					],
					'email' => [
						'required' => lang('Main.xin_error_cemail_field'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email'),
					],
					'membership_type' => [
						'required' => lang('Company.xin_error_membership_type_field'),
					],
					'subscription' => [
						'required' => lang('Company.xin_error_subscription_field'),
					],
					'country' => [
						'required' => lang('Main.xin_error_country_field'),
					],
					'username' => [
						'required' => lang('Main.xin_employee_error_username'),
						'min_length' => lang('Main.xin_min_error_username'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('company_name')) {
				$Return['error'] = $validation->getError('company_name');
			} elseif($validation->hasError('company_type')){
				$Return['error'] = $validation->getError('company_type');
			} elseif($validation->hasError('membership_type')){
				$Return['error'] = $validation->getError('membership_type');
			} elseif($validation->hasError('subscription')){
				$Return['error'] = $validation->getError('subscription');
			} elseif($validation->hasError('first_name')) {
				$Return['error'] = $validation->getError('first_name');
			} elseif($validation->hasError('last_name')){
				$Return['error'] = $validation->getError('last_name');
			}  elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			} elseif($validation->hasError('email')){
				$Return['error'] = $validation->getError('email');
			} elseif($validation->hasError('username')){
				$Return['error'] = $validation->getError('username');
			} elseif($validation->hasError('country')){
				$Return['error'] = $validation->getError('country');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$image = service('image');
			$validated = $this->validate([
				'file' => [
					'uploaded[file]',
					'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
					'max_size[file,4096]',
				],
			]);
			if ($validated) {
				$avatar = $this->request->getFile('file');
				$avatar->move('public/uploads/users/');
				$file_name = $avatar->getName();
				$image->withFile(filesrc($file_name))
				->fit(100, 100, 'center')
				->save('public/uploads/users/thumb/'.$file_name);
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$company_name = $this->request->getPost('company_name',FILTER_SANITIZE_STRING);
			$company_type = $this->request->getPost('company_type',FILTER_SANITIZE_STRING);
			$trading_name = $this->request->getPost('trading_name',FILTER_SANITIZE_STRING);
			$registration_no = $this->request->getPost('registration_no',FILTER_SANITIZE_STRING);
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$xin_gtax = $this->request->getPost('xin_gtax',FILTER_SANITIZE_STRING);
			$membership_type = $this->request->getPost('membership_type',FILTER_SANITIZE_STRING);
			$subscription = $this->request->getPost('subscription',FILTER_SANITIZE_STRING);
			$address_1 = $this->request->getPost('address_1',FILTER_SANITIZE_STRING);
			$address_2 = $this->request->getPost('address_2',FILTER_SANITIZE_STRING);
			$city = $this->request->getPost('city',FILTER_SANITIZE_STRING);
			$state = $this->request->getPost('state',FILTER_SANITIZE_STRING);
			$zipcode = $this->request->getPost('zipcode',FILTER_SANITIZE_STRING);
			$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);		
			$username = $this->request->getPost('username',FILTER_SANITIZE_STRING);
			
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			if ($validated) {
			$data = [
				'company_name' => $company_name,
				'company_type_id'  => $company_type,
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'trading_name'  => $trading_name,
				'registration_no'  => $registration_no,
				'contact_number'  => $contact_number,
				'email'  => $email,
				'government_tax' => $xin_gtax,
				'address_1'  => $address_1,
				'address_2'  => $address_2,
				'city'  => $city,
				'profile_photo'  => $file_name,
				'state'  => $state,
				'zipcode' => $zipcode,
				'country'  => $country,
				'username'  => $username
				];
			} else {
				$data = [
					'company_name' => $company_name,
					'company_type_id'  => $company_type,
					'first_name' => $first_name,
					'last_name'  => $last_name,
					'trading_name'  => $trading_name,
					'registration_no'  => $registration_no,
					'contact_number'  => $contact_number,
					'email'  => $email,
					'government_tax' => $xin_gtax,
					'address_1'  => $address_1,
					'address_2'  => $address_2,
					'city'  => $city,
					'state'  => $state,
					'zipcode' => $zipcode,
					'country'  => $country,
					'username'  => $username
				];
			}
			$UsersModel = new UsersModel();
			$CompanymembershipModel = new CompanymembershipModel();
			$result = $UsersModel->update($id, $data);			
			
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$data2 = array(
					'membership_id'  => $membership_type
				);
				$MainModel = new MainModel();
				$MainModel->update_company_membership($data2,$id);
				$Return['result'] = lang('Company.xin_success_update_company');
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
	// update record
	public function update_basic_info() {
		
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'company_name' => 'required',
					'company_type' => 'required',
					'first_name' => 'required',
					'last_name' => 'required',
					'country' => 'required',
					'contact_number' => 'required',
					'email' => 'required|valid_email',
					'username' => 'required|min_length[6]'
				],
				[   // Errors
					'company_name' => [
						'required' => lang('Company.xin_error_name_field'),
					],
					'company_type' => [
						'required' => lang('Company.xin_error_ctype_field'),
					],
					'first_name' => [
						'required' => lang('Main.xin_contact_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_contact_error_last_name'),
					],
					'country' => [
						'required' => lang('Main.xin_error_country_field'),
					],
					// Errors
					'contact_number' => [
						'required' => lang('Main.xin_error_contact_field'),
					],
					'email' => [
						'required' => lang('Main.xin_error_cemail_field'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email'),
					],
					'username' => [
						'required' => lang('Main.xin_employee_error_username'),
						'min_length' => lang('Main.xin_min_error_username'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('company_name')) {
				$Return['error'] = $validation->getError('company_name');
			} elseif($validation->hasError('company_type')){
				$Return['error'] = $validation->getError('company_type');
			} elseif($validation->hasError('first_name')) {
				$Return['error'] = $validation->getError('first_name');
			} elseif($validation->hasError('last_name')){
				$Return['error'] = $validation->getError('last_name');
			} elseif($validation->hasError('country')){
				$Return['error'] = $validation->getError('country');
			} elseif($validation->hasError('username')){
				$Return['error'] = $validation->getError('username');
			} elseif($validation->hasError('email')){
				$Return['error'] = $validation->getError('email');
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$company_name = $this->request->getPost('company_name',FILTER_SANITIZE_STRING);
			$company_type = $this->request->getPost('company_type',FILTER_SANITIZE_STRING);
			$trading_name = $this->request->getPost('trading_name',FILTER_SANITIZE_STRING);
			$registration_no = $this->request->getPost('registration_no',FILTER_SANITIZE_STRING);
			$xin_gtax = $this->request->getPost('xin_gtax',FILTER_SANITIZE_STRING);
			$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);	
			$username = $this->request->getPost('username',FILTER_SANITIZE_STRING);
			$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
			
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$data = [
				'company_name' => $company_name,
				'company_type_id'  => $company_type,
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'trading_name'  => $trading_name,
				'registration_no'  => $registration_no,
				'government_tax' => $xin_gtax,
				'country'  => $country,
				'contact_number'  => $contact_number,
				'email'  => $email,
				'username'  => $username,
				'is_active'  => $status,
				];
			$UsersModel = new UsersModel();
			$result = $UsersModel->update($id, $data);			
			
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Company.xin_success_update_company');
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
	// update record
	public function update_plan() {
		
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'membership_type' => 'required'
				],
				[   // Errors
					'membership_type' => [
						'required' => lang('Company.xin_error_membership_type_field'),
					],
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if($validation->hasError('membership_type')){
				$Return['error'] = $validation->getError('membership_type');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$membership_type = $this->request->getPost('membership_type',FILTER_SANITIZE_STRING);		
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$MembershipModel = new MembershipModel();
			$membership_info = $MembershipModel->where('membership_id', $membership_type)->first();
			$data2 = array(
				'membership_id'  => $membership_type,
				'subscription_type'  => $membership_info['plan_duration'],
				'update_at'  => date('d-m-Y h:i:s')
			);
			$MainModel = new MainModel();
			$result = $MainModel->update_company_membership($data2,$id);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				
				$Return['result'] = lang('Company.xin_success_update_company_subscription');
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
	// update record
	public function update_company_photo() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			//$image = service('image');
			// set rules
			$image = service('image');
			$validated = $this->validate([
				'cifile' => [
					'rules'  => 'uploaded[cifile]|mime_in[cifile,image/jpg,image/jpeg,image/gif,image/png]|max_size[cifile,3072]',
					'errors' => [
						'uploaded' => lang('Asset.xin_error_asset_image_field'),
						'mime_in' => 'wrong size'
					]
				]
			]);
			if (!$validated) {
				$Return['error'] = lang('Main.xin_error_profile_picture_field');
			} else {
				$avatar = $this->request->getFile('cifile');
				$file_name = $avatar->getName();
				$avatar->move('public/uploads/users/');
				$image->withFile(filesrc($file_name))
				->fit(100, 100, 'center')
				->save('public/uploads/users/thumb/'.$file_name);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				
				$UsersModel = new UsersModel();
				$Return['result'] = lang('Main.xin_profile_picture_success_updated');
				$data = [
					'profile_photo'  => $file_name
				];
				$result = $UsersModel->update($id, $data);
				$Return['csrf_hash'] = csrf_hash();
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// update record
	public function update_company_info() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'company_name' => 'required',
					'company_type' => 'required',
				],
				[   // Errors
					'company_name' => [
						'required' => lang('Company.xin_error_name_field'),
					],
					'company_type' => [
						'required' => lang('Company.xin_error_ctype_field'),
					]
				]
			);
			$UsersModel = new UsersModel();
			$validation->withRequest($this->request)->run();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			//check error
			if ($validation->hasError('company_name')) {
				$Return['error'] = $validation->getError('company_name');
			} elseif($validation->hasError('company_type')){
				$Return['error'] = $validation->getError('company_type');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$company_name = $this->request->getPost('company_name',FILTER_SANITIZE_STRING);
			$company_type = $this->request->getPost('company_type',FILTER_SANITIZE_STRING);
			$trading_name = $this->request->getPost('trading_name',FILTER_SANITIZE_STRING);
			$registration_no = $this->request->getPost('registration_no',FILTER_SANITIZE_STRING);
			$xin_gtax = $this->request->getPost('xin_gtax',FILTER_SANITIZE_STRING);
			
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$data = [
				'company_name' => $company_name,
				'company_type_id'  => $company_type,
				'trading_name'  => $trading_name,
				'registration_no'  => $registration_no,
				'government_tax' => $xin_gtax
			];
			
			$result = $UsersModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_success_company_info_updated');
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
	// read record
	public function read()
	{
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$id = $request->getGet('field_id');
		$data = [
				'field_id' => $id,
			];
		if($session->has('sup_username')){
			return view('erp/companies/dialog_company', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	 // delete record
	public function delete_company() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$UsersModel = new UsersModel();
			$result = $UsersModel->where('user_id', $id)->delete($id);
			if ($result == TRUE) {
				$MainModel = new MainModel();
				$MainModel->delete_company_membership($id);
				$Return['result'] = lang('Company.xin_success_delete_company');
			} else {
				$Return['error'] = lang('Membership.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

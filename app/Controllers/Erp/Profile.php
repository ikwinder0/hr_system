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
 
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\CompanyModel;
use App\Models\MainModel;
use App\Models\RolesModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\ConstantsModel;
use App\Models\CountryModel;
use App\Models\StaffdetailsModel;
use App\Models\ContractModel;
use App\Models\UserdocumentsModel;
use App\Models\CompanysettingsModel;

class Profile extends BaseController {

	public function index()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_account_settings').' | '.$xin_system['application_name'];
		$data['path_url'] = 'my_profile';
		$data['breadcrumbs'] = lang('Main.xin_account_settings');

		$data['subview'] = view('erp/profile/my_profile', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	// update record
	public function update_profile() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'first_name' => 'required',
					'last_name' => 'required',
					'email' => 'required|valid_email',
					'username' => 'required',
					'contact_number' => 'required',
					'country' => 'required',
					'address_1' => 'required',
					'city' => 'required',
					'state' => 'required',
					'zipcode' => 'required'
				],
				[   // Errors
					'first_name' => [
						'required' => lang('Main.xin_employee_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_employee_error_last_name'),
					],
					'email' => [
						'required' => lang('Main.xin_employee_error_email'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email'),
					],
					'username' => [
						'required' => lang('Main.xin_employee_error_username'),
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_contact_field'),
					],
					'country' => [
						'required' => lang('Main.xin_error_country_field'),
					],
					'address_1' => [
						'required' => lang('Success.xin_address_field_error'),
					],
					'city' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'state' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'zipcode' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('first_name')) {
				$Return['error'] = $validation->getError('first_name');
			} elseif($validation->hasError('last_name')){
				$Return['error'] = $validation->getError('last_name');
			} elseif($validation->hasError('email')){
				$Return['error'] = $validation->getError('email');
			} elseif($validation->hasError('username')){
				$Return['error'] = $validation->getError('username');
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			} elseif($validation->hasError('country')){
				$Return['error'] = $validation->getError('country');
			} elseif($validation->hasError('address_1')){
				$Return['error'] = $validation->getError('address_1');
			} elseif($validation->hasError('city')){
				$Return['error'] = $validation->getError('city');
			} elseif($validation->hasError('state')){
				$Return['error'] = $validation->getError('state');
			} elseif($validation->hasError('zipcode')){
				$Return['error'] = $validation->getError('zipcode');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$username = $this->request->getPost('username',FILTER_SANITIZE_STRING);
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);
			$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
			$address_1 = $this->request->getPost('address_1',FILTER_SANITIZE_STRING);
			$address_2 = $this->request->getPost('address_2',FILTER_SANITIZE_STRING);
			$city = $this->request->getPost('city',FILTER_SANITIZE_STRING);
			$state = $this->request->getPost('state',FILTER_SANITIZE_STRING);
			$zipcode = $this->request->getPost('zipcode',FILTER_SANITIZE_STRING);

			$id = $usession['sup_user_id'];	
			$data = [
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'email'  => $email,
				'username'  => $username,
				'contact_number'  => $contact_number,
				'country'  => $country,
				'address_1'  => $address_1,
				'address_2'  => $address_2,
				'city'  => $city,
				'state'  => $state,
				'zipcode' => $zipcode,
				'gender' => $gender,
			];
			$UsersModel = new UsersModel();
			$result = $UsersModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_personal_information_updated_msg');
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
	public function update_profile_photo() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			$image = service('image');
			// set rules
			$validated = $this->validate([
				'file' => [
					'uploaded[file]',
					'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
					'max_size[file,4096]',
				],
			]);
			if (!$validated) {
				$Return['error'] = lang('Main.xin_error_profile_picture_field');
			} else {
				$avatar = $this->request->getFile('file');
				$file_name = $avatar->getName();
				$avatar->move('public/uploads/users/');
				$image->withFile(filesrc($file_name))
				->fit(100, 100, 'center')
				->save('public/uploads/users/thumb/'.$file_name);
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = $usession['sup_user_id'];	
			if ($validated) {
				$UsersModel = new UsersModel();
					
				
				$Return['result'] = lang('Main.xin_profile_picture_success_updated');
				$data = [
					'profile_photo'  => $file_name
				];
				$result = $UsersModel->update($id, $data);
				$Return['csrf_hash'] = csrf_hash();	
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
	public function update_password() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					//'current_password' => 'required|is_not_unique[xin_users.password]',
					'new_password' => 'required|min_length[6]',
					'confirm_password' => 'required|matches[new_password]',
				],
				[   // Errors
					'new_password' => [
						'required' => lang('Main.xin_error_new_password_field'),
						'min_length' => lang('Main.xin_error_new_password_short_field'),
					],
					'confirm_password' => [
						'required' => lang('Main.xin_error_confirm_password_field'),
						'matches' => lang('Main.xin_error_confirm_password_matches_field'),
					]
				]
			);
			$UsersModel = new UsersModel();
			$validation->withRequest($this->request)->run();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			//check error
			$new_password = $this->request->getPost('new_password',FILTER_SANITIZE_STRING);
			if($validation->hasError('new_password')){
				$Return['error'] = $validation->getError('new_password');
			} elseif($validation->hasError('confirm_password')){
				$Return['error'] = $validation->getError('confirm_password');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			
			$options = array('cost' => 12);
			$password_hash = password_hash($new_password, PASSWORD_BCRYPT, $options);
			$id = $usession['sup_user_id'];	
			$data = [
				'password' => $password_hash,
			];
			
			$result = $UsersModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_success_new_password_field');
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
			
			$id = $usession['sup_user_id'];	
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
	// |||update record|||
	public function update_basic_info() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'first_name' => 'required',
					'last_name' => 'required',
					'contact_number' => 'required',
					'employee_id' => 'required',
				],
				[   // Errors
					'first_name' => [
						'required' => lang('Main.xin_employee_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_employee_error_last_name'),
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_contact_field'),
					],
					'employee_id' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('first_name')) {
				$Return['error'] = $validation->getError('first_name');
			} elseif($validation->hasError('last_name')){
				$Return['error'] = $validation->getError('last_name');
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			//staff
			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
			$state = $this->request->getPost('state',FILTER_SANITIZE_STRING);
			$zipcode = $this->request->getPost('zipcode',FILTER_SANITIZE_STRING);
			$city = $this->request->getPost('city',FILTER_SANITIZE_STRING);
			$address_1 = $this->request->getPost('address_1',FILTER_SANITIZE_STRING);
			$address_2 = $this->request->getPost('address_2',FILTER_SANITIZE_STRING);
			$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);
			
			// staff details
			$date_of_birth = $this->request->getPost('date_of_birth',FILTER_SANITIZE_STRING);
			$marital_status = $this->request->getPost('marital_status',FILTER_SANITIZE_STRING);
			$religion = $this->request->getPost('religion',FILTER_SANITIZE_STRING);
			$blood_group = $this->request->getPost('blood_group',FILTER_SANITIZE_STRING);
			$citizenship_id = $this->request->getPost('citizenship_id',FILTER_SANITIZE_STRING);
			$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
			
			if(empty($country)){
				$country = 0;
			}
			if(empty($religion)){
				$religion = 0;
			}
			if(empty($citizenship_id)){
				$citizenship_id = 0;
			}
			
			$id = $usession['sup_user_id'];
			$UsersModel = new UsersModel();
			$data = [
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'contact_number'  => $contact_number,
				'country'  => $country,
				'address_1'  => $address_1,
				'address_2'  => $address_2,
				'city'  => $city,
				'state'  => $state,
				'zipcode' => $zipcode,
				'gender' => $gender
			];
			$result = $UsersModel->update($id, $data);
			// employee details
			$data2 = [
				'employee_id' => $employee_id,
				'date_of_birth' => $date_of_birth,
				'marital_status' => $marital_status,
				'religion_id' => $religion,
				'blood_group' => $blood_group,
				'citizenship_id' => $citizenship_id
			];
			
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$MainModel = new MainModel();
				$MainModel->update_employee_record($data2,$id);
				$Return['result'] = lang('Employees.xin_success_update_employee');
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
	// |||update record|||
	public function update_bio() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			//staff details
			$bio = $this->request->getPost('bio',FILTER_SANITIZE_STRING);
			$experience = $this->request->getPost('experience',FILTER_SANITIZE_STRING);
			// set rules
			$validation->setRules([
					'bio' => 'required'
				],
				[   // Errors
					'bio' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('bio')) {
				$Return['error'] = $validation->getError('bio');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$id = $usession['sup_user_id'];
			$UsersModel = new UsersModel();
			// employee details
			$data = [
				'bio' => $bio,
				'experience' => $experience,
			];
			$MainModel = new MainModel();
			$result = $MainModel->update_employee_record($data,$id);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				
				$Return['result'] = lang('Success.xin_bio_updated_success');
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
	// |||update record|||
	public function update_social() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			//staff details
			$fb_profile = $this->request->getPost('fb_profile',FILTER_SANITIZE_STRING);
			$twitter_profile = $this->request->getPost('twitter_profile',FILTER_SANITIZE_STRING);
			$gplus_profile = $this->request->getPost('gplus_profile',FILTER_SANITIZE_STRING);
			$linkedin_profile = $this->request->getPost('linkedin_profile',FILTER_SANITIZE_STRING);
			
			$id = $usession['sup_user_id'];
			$UsersModel = new UsersModel();
			// employee details
			$data = [
				'fb_profile' => $fb_profile,
				'twitter_profile' => $twitter_profile,
				'gplus_profile' => $gplus_profile,
				'linkedin_profile' => $linkedin_profile,
			];
			$MainModel = new MainModel();
			$result = $MainModel->update_employee_record($data,$id);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				
				$Return['result'] = lang('Success.xin_social_updated_success');
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
	// |||update record|||
	public function update_bankinfo() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			//staff details
			$account_title = $this->request->getPost('account_title',FILTER_SANITIZE_STRING);
			$account_number = $this->request->getPost('account_number',FILTER_SANITIZE_STRING);
			$bank_name = $this->request->getPost('bank_name',FILTER_SANITIZE_STRING);
			$iban = $this->request->getPost('iban',FILTER_SANITIZE_STRING);
			$swift_code = $this->request->getPost('swift_code',FILTER_SANITIZE_STRING);
			$bank_branch = $this->request->getPost('bank_branch',FILTER_SANITIZE_STRING);
			
			// set rules
			$validation->setRules([
					'account_title' => 'required',
					'account_number' => 'required',
					'bank_name' => 'required',				
					'iban' => 'required',
					'swift_code' => 'required',
					'bank_branch' => 'required'
				],
				[   // Errors
					'account_title' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'account_number' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'bank_name' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'iban' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'swift_code' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'bank_branch' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('account_title')) {
				$Return['error'] = $validation->getError('account_title');
			} else if ($validation->hasError('account_number')) {
				$Return['error'] = $validation->getError('account_number');
			} else if ($validation->hasError('bank_name')) {
				$Return['error'] = $validation->getError('bank_name');
			} else if ($validation->hasError('iban')) {
				$Return['error'] = $validation->getError('iban');
			} else if ($validation->hasError('swift_code')) {
				$Return['error'] = $validation->getError('swift_code');
			} else if ($validation->hasError('bank_branch')) {
				$Return['error'] = $validation->getError('bank_branch');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$id = $usession['sup_user_id'];
			$UsersModel = new UsersModel();
			// employee details
			$data = [
				'account_title' => $account_title,
				'account_number' => $account_number,
				'bank_name' => $bank_name,
				'iban' => $iban,
				'swift_code' => $swift_code,
				'bank_branch' => $bank_branch,
			];
			$MainModel = new MainModel();
			$result = $MainModel->update_employee_record($data,$id);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				
				$Return['result'] = lang('Success.xin_bank_account_updated_success');
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
	// |||update record|||
	public function update_contact_info() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			//staff details
			$contact_full_name = $this->request->getPost('contact_full_name',FILTER_SANITIZE_STRING);
			$contact_phone_no = $this->request->getPost('contact_phone_no',FILTER_SANITIZE_STRING);
			$contact_email = $this->request->getPost('contact_email',FILTER_SANITIZE_STRING);
			$contact_address = $this->request->getPost('contact_address',FILTER_SANITIZE_STRING);
			// set rules
			$validation->setRules([
					'contact_full_name' => 'required',
					'contact_phone_no' => 'required',
					'contact_email' => 'required',
					'contact_address' => 'required'
				],
				[   // Errors
					'contact_full_name' => [
						'required' => lang('Success.xin_full_name_field_error'),
					],
					'contact_phone_no' => [
						'required' => lang('Main.xin_error_contact_field'),
					],
					'contact_email' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'contact_address' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('contact_full_name')) {
				$Return['error'] = $validation->getError('contact_full_name');
			} else if ($validation->hasError('contact_phone_no')) {
				$Return['error'] = $validation->getError('contact_phone_no');
			} else if ($validation->hasError('contact_email')) {
				$Return['error'] = $validation->getError('contact_email');
			} else if ($validation->hasError('contact_address')) {
				$Return['error'] = $validation->getError('contact_address');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = $usession['sup_user_id'];
			$UsersModel = new UsersModel();
			// employee details
			$data = [
				'contact_full_name' => $contact_full_name,
				'contact_phone_no' => $contact_phone_no,
				'contact_email' => $contact_email,
				'contact_address' => $contact_address,
			];
			$MainModel = new MainModel();
			$result = $MainModel->update_employee_record($data,$id);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				
				$Return['result'] = lang('Success.xin_emergency_contact_updated_success');
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
	// |||update record|||
	public function update_account_info() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'email' => 'required|valid_email',
					'username' => 'required|min_length[6]',
				],
				[   // Errors
					'email' => [
						'required' => lang('Main.xin_employee_error_email'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email')
					],
					'username' => [
						'required' => lang('Main.xin_employee_error_username'),
						'min_length' => lang('Main.xin_min_error_username')
					],
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if($validation->hasError('email')){
				$Return['error'] = $validation->getError('email');
			} elseif($validation->hasError('username')){
				$Return['error'] = $validation->getError('username');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			//staff
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$username = $this->request->getPost('username',FILTER_SANITIZE_STRING);		
			$id = $usession['sup_user_id'];
			$UsersModel = new UsersModel();
			$data = [
				'email'  => $email,
				'username'  => $username,
			];
			$result = $UsersModel->update($id, $data);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Success.xin_account_information_updated_success');
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
	// record list
	public function user_documents_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$id = $usession['sup_user_id'];
		$UserdocumentsModel = new UserdocumentsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $UserdocumentsModel->where('user_id',$id)->orderBy('document_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
			
			$download_link = '<a href="'.site_url().'download?type=documents&filename='.uencode($r['document_file']).'">'.lang('Main.xin_download').'</a>';
			$data[] = array(
				$r['document_name'],
				$r['document_type'],
				$download_link
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     } 
	 // record list
	public function allowances_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$ContractModel = new ContractModel();
		$request = \Config\Services::request();
		$id = $usession['sup_user_id'];
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $ContractModel->where('user_id',$id)->where('salay_type','allowances')->orderBy('contract_option_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
						
			if($r['is_fixed']==1){
				$is_fixed = lang('xin_title_tax_fixed');
			} else {
				$is_fixed = lang('xin_title_tax_percent');
			}
			if($r['contract_tax_option']==1){
				$contract_tax_option = lang('xin_salary_allowance_non_taxable');
			} else if($r['contract_tax_option']==2){
				$contract_tax_option = lang('xin_fully_taxable');
			} else {
				$contract_tax_option = lang('xin_partially_taxable');
			}
			$data[] = array(
				$r['option_title'],
				$r['contract_amount'],
				$contract_tax_option,
				$is_fixed,
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     } 
	 // record list
	public function commissions_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$id = $usession['sup_user_id'];
		$ContractModel = new ContractModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $ContractModel->where('user_id',$id)->where('salay_type','commissions')->orderBy('contract_option_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
						
			if($r['is_fixed']==0){
				$is_fixed = lang('xin_title_tax_fixed');
			} else {
				$is_fixed = lang('xin_title_tax_percent');
			}
			if($r['contract_tax_option']==0){
				$contract_tax_option = lang('xin_salary_allowance_non_taxable');
			} else if($r['contract_tax_option']==1){
				$contract_tax_option = lang('xin_fully_taxable');
			} else {
				$contract_tax_option = lang('xin_partially_taxable');
			}
			$data[] = array(
				$r['option_title'],
				$r['contract_amount'],
				$contract_tax_option,
				$is_fixed,
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 // record list
	public function statutory_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$id = $usession['sup_user_id'];
		$ContractModel = new ContractModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $ContractModel->where('user_id',$id)->where('salay_type','statutory')->orderBy('contract_option_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
						
			if($r['is_fixed']==0){
				$is_fixed = lang('xin_title_tax_fixed');
			} else {
				$is_fixed = lang('xin_title_tax_percent');
			}		
			$data[] = array(
				$r['option_title'],
				$r['contract_amount'],
				$is_fixed
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     } 
	 // record list
	public function other_payments_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$id = $usession['sup_user_id'];
		$ContractModel = new ContractModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $ContractModel->where('user_id',$id)->where('salay_type','other_payments')->orderBy('contract_option_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
						
			if($r['is_fixed']==0){
				$is_fixed = lang('xin_title_tax_fixed');
			} else {
				$is_fixed = lang('xin_title_tax_percent');
			}
			if($r['contract_tax_option']==0){
				$contract_tax_option = lang('xin_salary_allowance_non_taxable');
			} else if($r['contract_tax_option']==1){
				$contract_tax_option = lang('xin_fully_taxable');
			} else {
				$contract_tax_option = lang('xin_partially_taxable');
			}
	
			$data[] = array(
				$r['option_title'],
				$r['contract_amount'],
				$contract_tax_option,
				$is_fixed,
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	// Validate and update info in database
	public function system_info() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'default_currency' => 'required',
					'date_format' => 'required',
					'system_timezone' => 'required',
					'default_language' => 'required',
					'invoice_terms_condition' => 'required',
				],
				[   // Errors
					'default_currency' => [
						'required' => lang('Main.xin_error_default_currency_field'),
					],
					'date_format' => [
						'required' => lang('Main.xin_error_date_format_field'),
					],
					
					'system_timezone' => [
						'required' => lang('Main.xin_error_timezone_field'),
					],
					'default_language' => [
						'required' => lang('Main.xin_error_default_language'),
					],
					'invoice_terms_condition' => [
						'required' => lang('Main.xin_invoice_terms_condition_error_field'),
					]
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if($validation->hasError('default_currency')){
				$Return['error'] = $validation->getError('default_currency');
			} elseif($validation->hasError('date_format')){
				$Return['error'] = $validation->getError('date_format');
			} elseif($validation->hasError('system_timezone')){
				$Return['error'] = $validation->getError('system_timezone');
			} elseif($validation->hasError('default_language')){
				$Return['error'] = $validation->getError('default_language');
			}elseif($validation->hasError('invoice_terms_condition')){
				$Return['error'] = $validation->getError('invoice_terms_condition');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
		
		$default_currency = $this->request->getPost('default_currency',FILTER_SANITIZE_STRING);
		$default_currency_symbol = $this->request->getPost('default_currency',FILTER_SANITIZE_STRING);
		$date_format = $this->request->getPost('date_format',FILTER_SANITIZE_STRING);
		$system_timezone = $this->request->getPost('system_timezone',FILTER_SANITIZE_STRING);
		$default_language = $this->request->getPost('default_language',FILTER_SANITIZE_STRING);	
		$invoice_terms_condition = $this->request->getPost('invoice_terms_condition',FILTER_SANITIZE_STRING);
		
		$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
		$data = [
            'default_currency'  => $default_currency,
			'default_currency_symbol'  => $default_currency_symbol,
			'date_format_xi'  => $date_format,
			'system_timezone'  => $system_timezone,
			'default_language'  => $default_language,
			'invoice_terms_condition'  => $invoice_terms_condition,
        ];
		$MainModel = new MainModel();
		$result = $MainModel->update_company_settings($data,$id);
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Success.xin_account_settings_updated_success');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	} 
	// Validate and update info in database
	public function update_payment_gateway() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		$SystemModel = new SystemModel();
	
		if ($this->request->getPost('type') === 'edit_record') {
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
		$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
		$data = [
            'paypal_email' => $paypal_email,
            'paypal_sandbox'  => $paypal_sandbox,
			'paypal_active'  => $paypal_active,
			'stripe_secret_key'  => $stripe_secret_key,
			'stripe_publishable_key'  => $stripe_publishable_key,
			'stripe_active'  => $stripe_active
        ];
        $MainModel = new MainModel();
		$result = $MainModel->update_company_settings($data,$id);
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
	public function notification_position_info() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$SystemModel = new SystemModel();
	
		if ($this->request->getPost('type') === 'edit_record') {
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
		$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
		$data = [
            'notification_position' => $notification_position,
            'notification_close_btn'  => $notification_close,
			 'notification_bar'  => $notification_bar
        ];
        $MainModel = new MainModel();
		$result = $MainModel->update_company_settings($data,$id);
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Main.xin_success_notify_position_config_updated');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	}
	// Validate and update info in database
	public function setup_modules_info() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$SystemModel = new SystemModel();
	
		if ($this->request->getPost('type') === 'setup_modules_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
					
			$setup_modules = $this->request->getPost('setup_module',FILTER_SANITIZE_STRING);
			$setup_modules = serialize($setup_modules);
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$data = [
				'setup_modules' => $setup_modules,
			];
			$MainModel = new MainModel();
			$result = $MainModel->update_company_settings($data,$id);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_modules_updated');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// Validate and update info in database
	public function layout_info() {
	
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');		
		$SystemModel = new SystemModel();
	
		if ($this->request->getPost('type') === 'layout_info') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
					
			$header_background = $this->request->getPost('header_background',FILTER_SANITIZE_STRING);
			$calendar_locale = $this->request->getPost('calendar_locale',FILTER_SANITIZE_STRING);
			$datepicker_locale = $this->request->getPost('datepicker_locale',FILTER_SANITIZE_STRING);
			$login_page = $this->request->getPost('login_page',FILTER_SANITIZE_STRING);
			$login_page_text = $this->request->getPost('login_page_text',FILTER_SANITIZE_STRING);
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$data = [
				'header_background' => $header_background,
				'calendar_locale' => $calendar_locale,
				'datepicker_locale' => $datepicker_locale,
				'login_page' => $login_page,
				'login_page_text' => $login_page_text
			];
			$MainModel = new MainModel();
			$result = $MainModel->update_company_settings($data,$id);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_theme_layout_updated');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
}

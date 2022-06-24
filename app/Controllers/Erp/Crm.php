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
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
 
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\RolesModel;
use App\Models\CompanyModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;
use App\Models\SuperroleModel;
use App\Models\LeadsModel;

class Crm extends BaseController {

	public function crm_dashboard()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'awards';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/crm/crm_dashboard', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function leads()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$LeadsModel = new LeadsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Users.xin_super_users').' | '.$xin_system['application_name'];
		$data['path_url'] = 'leads';
		$data['breadcrumbs'] = lang('Users.xin_super_users');
		$data['subview'] = view('erp/crm/leads_list', $data);
		return view('erp/layout/layout_main', $data); //page load////
	}
	public function customers()
	{		
		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Users.xin_super_users').' | '.$xin_system['application_name'];
		$data['path_url'] = 'customers';
		$data['breadcrumbs'] = lang('Users.xin_super_users');
		$data['subview'] = view('erp/crm/customers_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function customer_details()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Company.xin_companies').' | '.$xin_system['application_name'];
		$data['path_url'] = 'customer_details';
		$data['breadcrumbs'] = lang('Employees.xin_employee_details');

		$data['subview'] = view('erp/crm/customers_detail', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function leads_detail()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Company.xin_companies').' | '.$xin_system['application_name'];
		$data['path_url'] = 'lead_details';
		$data['breadcrumbs'] = lang('Employees.xin_employee_details');

		$data['subview'] = view('erp/crm/leads_detail', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function proposals()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'awards';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/hr_key_features/key_awards', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function estimates()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'awards';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/hr_key_features/key_awards', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function invoices()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'awards';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/hr_key_features/key_awards', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function payments()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'awards';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/hr_key_features/key_awards', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function items()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'awards';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/hr_key_features/key_awards', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	
	// list
	public function customers_list() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$UsersModel = new UsersModel();
		$ConstantsModel = new ConstantsModel();
		$CountryModel = new CountryModel();
		$SuperroleModel = new SuperroleModel();
		$SystemModel = new SystemModel();
		$users = $UsersModel->where('user_type', 'customer')->orderBy('user_id', 'ASC')->findAll();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
		$data = array();
		
          foreach($users as $r) {						
		  			
				$view = '<a href="'.site_url('erp/customer-detail/'). uencode($r['user_id']) . '"><span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></span></a>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['user_id']) . '"><i class="feather icon-trash-2"></i></button></span>';

			$role = $SuperroleModel->where('role_id', $r['user_role_id'])->first();
			if($r['is_active']==1){
				$status = '<span class="badge badge-outline-success">'.lang('Main.xin_employees_active').'</span>';
			} else {
				$status = '<span class="badge badge-outline-danger">'.lang('Main.xin_employees_inactive').'</span>';
			}
			$country_info = $CountryModel->where('country_id', $r['country'])->first();
			$name = $r['first_name'].' '.$r['last_name'];
			$uname = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/users/thumb/'.$r['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$name.'</h6>
					<p class="m-b-0">'.$r['email'].'</p>
				</div>
			</div>';   
			$combhr = $view.$delete;
			$links = '
				'.$status.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
									 			  				
			$data[] = array(
				$uname,
				$r['contact_number'],
				$role['role_name'],
				$country_info['country_name'],
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
	// list
	public function leads_list() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$UsersModel = new UsersModel();
		$ConstantsModel = new ConstantsModel();
		$CountryModel = new CountryModel();
		$SuperroleModel = new SuperroleModel();
		$SystemModel = new SystemModel();
		$users = $UsersModel->where('user_type', 'customer')->orderBy('user_id', 'ASC')->findAll();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
		$data = array();
		
          foreach($users as $r) {						
		  			
				$view = '<a href="'.site_url('erp/customer-detail/'). uencode($r['user_id']) . '"><span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></span></a>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['user_id']) . '"><i class="feather icon-trash-2"></i></button></span>';

			$role = $SuperroleModel->where('role_id', $r['user_role_id'])->first();
			if($r['is_active']==1){
				$status = '<span class="badge badge-outline-success">'.lang('Main.xin_employees_active').'</span>';
			} else {
				$status = '<span class="badge badge-outline-danger">'.lang('Main.xin_employees_inactive').'</span>';
			}
			$country_info = $CountryModel->where('country_id', $r['country'])->first();
			$name = $r['first_name'].' '.$r['last_name'];
			$uname = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/users/thumb/'.$r['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$name.'</h6>
					<p class="m-b-0">'.$r['email'].'</p>
				</div>
			</div>';   
			$combhr = $view.$delete;
			$links = '
				'.$status.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
									 			  				
			$data[] = array(
				$uname,
				$r['contact_number'],
				$role['role_name'],
				$country_info['country_name'],
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
	public function add_customer() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'first_name' => 'required',
					'last_name' => 'required',
					'email' => 'required|valid_email|is_unique[ci_erp_users.email]',
					'username' => 'required|min_length[6]|is_unique[ci_erp_users.username]',
					'password' => 'required|min_length[6]',
					'contact_number' => 'required',
					'country' => 'required',
					'role' => 'required'
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
						'is_unique' => lang('Main.xin_already_exist_error_email'),
					],
					'username' => [
						'required' => lang('Main.xin_employee_error_username'),
						'min_length' => lang('Main.xin_min_error_username'),
						'is_unique' => lang('Main.xin_already_exist_error_username')
					],
					'password' => [
						'required' => lang('Main.xin_employee_error_password'),
						'min_length' => lang('Login.xin_min_error_password')
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_contact_field'),
					],
					'country' => [
						'required' => lang('Main.xin_error_country_field'),
					],
					'role' => [
						'required' => lang('Users.xin_employee_error_user_role'),
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
			} elseif($validation->hasError('password')){
				$Return['error'] = $validation->getError('password');
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			} elseif($validation->hasError('role')){
				$Return['error'] = $validation->getError('role');
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
			if (!$validated) {
				$Return['error'] = lang('Users.xin_user_photo_field');
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
			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$username = $this->request->getPost('username',FILTER_SANITIZE_STRING);
			$password = $this->request->getPost('password',FILTER_SANITIZE_STRING);
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);
			$role = $this->request->getPost('role',FILTER_SANITIZE_STRING);
			$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
			$address_1 = '';
			$address_2 = '';
			$city = '';
			$state = '';
			$zipcode ='';
			// company info
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			
			$company_name = $user_info['company_name'];
			$company_type = $user_info['company_type'];
			$xin_gtax = $user_info['xin_gtax'];
			$trading_name = $user_info['trading_name'];
			$registration_no = $user_info['registration_no'];
			
			$options = array('cost' => 12);
			$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
			$data = [
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'email'  => $email,
				'user_type'  => 'customer',
				'username'  => $username,
				'password'  => $password_hash,
				'contact_number'  => $contact_number,
				'country'  => $country,
				'user_role_id' => $role,
				'address_1'  => $address_1,
				'address_2'  => $address_2,
				'city'  => $city,
				'profile_photo'  => $file_name,
				'state'  => $state,
				'zipcode' => $zipcode,
				'gender' => $gender,
				'company_name' => $company_name,
				'trading_name' => $trading_name,
				'registration_no' => $registration_no,
				'government_tax' => $xin_gtax,
				'company_type_id'  => $company_type,
				'last_login_date' => '0',
				'last_logout_date' => '0',
				'last_login_ip' => '0',
				'is_logged_in' => '0',
				'is_active'  => 1,
				'company_id'  => 0,
				'added_by'  => $usession['sup_user_id'],
				'created_at' => date('d-m-Y h:i:s')
			];
			$UsersModel = new UsersModel();
			$result = $UsersModel->insert($data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Users.xin_success_user_added');
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
	public function update_customer() {
			
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
					'username' => 'required|min_length[6]',
					'contact_number' => 'required',
					'country' => 'required',
					'role' => 'required',
					'status' => 'required'
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
						'valid_email' => lang('Main.xin_employee_error_invalid_email')
					],
					'username' => [
						'required' => lang('Main.xin_employee_error_username'),
						'min_length' => lang('Main.xin_min_error_username')
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_subscription_field'),
					],
					'country' => [
						'required' => lang('Main.xin_error_country_field'),
					],
					'role' => [
						'required' => lang('Users.xin_employee_error_user_role'),
					],
					'status' => [
						'required' => '{field} is required.',
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
			} elseif($validation->hasError('status')){
				$Return['error'] = $validation->getError('status');
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			} elseif($validation->hasError('role')){
				$Return['error'] = $validation->getError('role');
			} elseif($validation->hasError('country')){
				$Return['error'] = $validation->getError('country');
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
			$role = $this->request->getPost('role',FILTER_SANITIZE_STRING);
			$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
			$address_1 = $this->request->getPost('address_1',FILTER_SANITIZE_STRING);
			$address_2 = $this->request->getPost('address_2',FILTER_SANITIZE_STRING);
			$city = $this->request->getPost('city',FILTER_SANITIZE_STRING);
			$state = $this->request->getPost('state',FILTER_SANITIZE_STRING);
			$zipcode = $this->request->getPost('zipcode',FILTER_SANITIZE_STRING);
			$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
			$data = [
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'email'  => $email,
				'username'  => $username,
				'contact_number'  => $contact_number,
				'country'  => $country,
				'user_role_id' => $role,
				'address_1'  => $address_1,
				'address_2'  => $address_2,
				'city'  => $city,
				'state'  => $state,
				'zipcode' => $zipcode,
				'gender' => $gender,
				'is_active'  => $status,
			];
			$UsersModel = new UsersModel();
			$result = $UsersModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Users.xin_success_user_updated');
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
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
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
	 // delete record
	public function delete_customer() {
		
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
				$Return['result'] = lang('Users.xin_success_delete_user');
			} else {
				$Return['error'] = lang('Membership.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

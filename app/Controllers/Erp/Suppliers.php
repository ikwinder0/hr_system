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
use CodeIgniter\I18n\Time;
 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\CountryModel;
use App\Models\SuppliersModel;

class Suppliers extends BaseController {

	public function index()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('supplier1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Inventory.xin_suppliers').' | '.$xin_system['application_name'];
		$data['path_url'] = 'suppliers';
		$data['breadcrumbs'] = lang('Inventory.xin_suppliers');

		$data['subview'] = view('erp/inventory/key_suppliers', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	 // record list
	public function suppliers_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$CountryModel = new CountryModel();
		$SystemModel = new SystemModel();
		$SuppliersModel = new SuppliersModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $SuppliersModel->where('company_id',$user_info['company_id'])->orderBy('supplier_id', 'ASC')->findAll();
		} else {
			$get_data = $SuppliersModel->where('company_id',$usession['sup_user_id'])->orderBy('supplier_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('supplier3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['supplier_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('supplier4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['supplier_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			// country info
			$country_info = $CountryModel->where('country_id', $r['country'])->first();
			$cname = $country_info['country_name'];
			//added by
			$iuser = $UsersModel->where('user_id', $r['added_by'])->first();
			if($iuser){
				$employee_name = $iuser['first_name'].' '.$iuser['last_name'];
			} else {
				$employee_name = lang('Users.xin_user_data_removed');
			}
			$visitor_name = '<div class="d-inline-block align-middle">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$r['supplier_name'].'</h6>
					<p class="m-b-0">'.$r['email'].'</p>
				</div>
			</div>';
			$combhr = $edit.$delete;
			if(in_array('supplier3',staff_role_resource()) || in_array('supplier4',staff_role_resource()) || $user_info['user_type'] == 'company') {
					
				$ivisitor_name = '
				'.$visitor_name.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';	  				
			} else {
				$ivisitor_name = $visitor_name;
			}
			$data[] = array(
				$ivisitor_name,
				$r['contact_number'],
				$r['city'],
				$cname,
				$employee_name
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	// |||add record|||
	public function add_supplier() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' =>  lang('Main.xin_error_field_text')
					]
				],
				'email' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contact_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'country' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name'),
					"email" => $validation->getError('email'),
					"contact_number" => $validation->getError('contact_number'),
					"country" => $validation->getError('country')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
				$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
				$registration = $this->request->getPost('registration',FILTER_SANITIZE_STRING);
				$website_url = $this->request->getPost('website_url',FILTER_SANITIZE_STRING);
				$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
				$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);
				$address_1 = $this->request->getPost('address_1',FILTER_SANITIZE_STRING);
				$address_2 = $this->request->getPost('address_2',FILTER_SANITIZE_STRING);
				$city = $this->request->getPost('city',FILTER_SANITIZE_STRING);
				$state = $this->request->getPost('state',FILTER_SANITIZE_STRING);
				$zipcode = $this->request->getPost('zipcode',FILTER_SANITIZE_STRING);
								
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'supplier_name' => $name,
					'registration_no'  => $registration,
					'email'  => $email,
					'contact_number'  => $contact_number,
					'website_url'  => $website_url,
					'address_1'  => $address_1,
					'address_2'  => $address_2,
					'city'  => $city,
					'state'  => $state,
					'zipcode'  => $zipcode,
					'country'  => $country,
					'added_by'  => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s')
				];
				$SuppliersModel = new SuppliersModel();
				$result = $SuppliersModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_supplier_added_msg');
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
	// |||update record|||
	public function update_supplier() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' =>  lang('Main.xin_error_field_text')
					]
				],
				'email' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contact_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'country' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name'),
					"email" => $validation->getError('email'),
					"contact_number" => $validation->getError('contact_number'),
					"country" => $validation->getError('country')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
				$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
				$registration = $this->request->getPost('registration',FILTER_SANITIZE_STRING);
				$website_url = $this->request->getPost('website_url',FILTER_SANITIZE_STRING);
				$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
				$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);
				$address_1 = $this->request->getPost('address_1',FILTER_SANITIZE_STRING);
				$address_2 = $this->request->getPost('address_2',FILTER_SANITIZE_STRING);
				$city = $this->request->getPost('city',FILTER_SANITIZE_STRING);
				$state = $this->request->getPost('state',FILTER_SANITIZE_STRING);
				$zipcode = $this->request->getPost('zipcode',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
								
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'supplier_name' => $name,
					'registration_no'  => $registration,
					'email'  => $email,
					'contact_number'  => $contact_number,
					'website_url'  => $website_url,
					'address_1'  => $address_1,
					'address_2'  => $address_2,
					'city'  => $city,
					'state'  => $state,
					'zipcode'  => $zipcode,
					'country'  => $country,
				];
				$SuppliersModel = new SuppliersModel();
				$result = $SuppliersModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_supplier_updated_msg');
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
	// read record
	public function read_supplier()
	{
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		$id = $request->getGet('field_id');
		$data = [
				'field_id' => $id,
			];
		if($session->has('sup_username')){
			return view('erp/inventory/dialog_supplier', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_supplier() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$SuppliersModel = new SuppliersModel();
			$result = $SuppliersModel->where('supplier_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_supplier_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

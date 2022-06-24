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
use App\Models\DepartmentModel;
use App\Models\VisitorsModel;


class Visitors extends BaseController {

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
			if(!in_array('visitor1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_visitors').' | '.$xin_system['application_name'];
		$data['path_url'] = 'visitors';
		$data['breadcrumbs'] = lang('Main.xin_visitors');

		$data['subview'] = view('erp/visitors/key_visitors', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	 // record list
	public function visitors_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$DepartmentModel = new DepartmentModel();
		$VisitorsModel = new VisitorsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $VisitorsModel->where('company_id',$user_info['company_id'])->orderBy('visitor_id', 'ASC')->findAll();
		} else {
			$get_data = $VisitorsModel->where('company_id',$usession['sup_user_id'])->orderBy('visitor_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$department = $DepartmentModel->where('department_id', $r['department_id'])->first();
			if($department){
				$department_name = $department['department_name'];
			} else {
				$department_name = '--';
			}
			if(in_array('visitor3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['visitor_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('visitor4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['visitor_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$visit_date = set_date_format($r['visit_date']);
			$visitor_name = '<div class="d-inline-block align-middle">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$r['visitor_name'].'</h6>
					<p class="m-b-0">'.$r['email'].'</p>
				</div>
			</div>';
			$combhr = $edit.$delete;
			if(in_array('visitor3',staff_role_resource()) || in_array('visitor4',staff_role_resource()) || $user_info['user_type'] == 'company') {
					
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
				$department_name,
				$r['visit_purpose'],
				$r['phone'],
				$visit_date,
				$r['check_in'],
				$r['check_out']
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
	public function add_visitor() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'department_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' =>  lang('Employees.xin_employee_error_department')
					]
				],
				'visit_purpose' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'visitor_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'visit_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'check_in' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'phone' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'email' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'address' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "department_id" => $validation->getError('department_id'),
					"visit_purpose" => $validation->getError('visit_purpose'),
					"visitor_name" => $validation->getError('visitor_name'),
					"visit_date" => $validation->getError('visit_date'),
					"check_in" => $validation->getError('check_in'),
					"phone" => $validation->getError('phone'),
					"email" => $validation->getError('email'),
					"address" => $validation->getError('address')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$department_id = $this->request->getPost('department_id',FILTER_SANITIZE_STRING);
				$visit_purpose = $this->request->getPost('visit_purpose',FILTER_SANITIZE_STRING);
				$visitor_name = $this->request->getPost('visitor_name',FILTER_SANITIZE_STRING);
				$visit_date = $this->request->getPost('visit_date',FILTER_SANITIZE_STRING);
				$check_in = $this->request->getPost('check_in',FILTER_SANITIZE_STRING);
				$phone = $this->request->getPost('phone',FILTER_SANITIZE_STRING);
				$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
				$address = $this->request->getPost('address',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				
								
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'department_id' => $department_id,
					'visit_purpose'  => $visit_purpose,
					'visitor_name'  => $visitor_name,
					'phone'  => $phone,
					'email'  => $email,
					'visit_date'  => $visit_date,
					'check_in'  => $check_in,
					'check_out'  => '',
					'address'  => $address,
					'description'  => $description,
					'created_by'  => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s')
				];
				$VisitorsModel = new VisitorsModel();
				$result = $VisitorsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_visitor_added_msg');
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
	public function update_visitor() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'department_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Employees.xin_employee_error_department')
					]
				],
				'visit_purpose' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'visitor_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'visit_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'check_in' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'check_out' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'phone' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'email' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'address' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "department_id" => $validation->getError('department_id'),
					"visit_purpose" => $validation->getError('visit_purpose'),
					"visitor_name" => $validation->getError('visitor_name'),
					"visit_date" => $validation->getError('visit_date'),
					"check_in" => $validation->getError('check_in'),
					"check_out" => $validation->getError('check_out'),
					"phone" => $validation->getError('phone'),
					"email" => $validation->getError('email'),
					"address" => $validation->getError('address')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$department_id = $this->request->getPost('department_id',FILTER_SANITIZE_STRING);
				$visit_purpose = $this->request->getPost('visit_purpose',FILTER_SANITIZE_STRING);
				$visitor_name = $this->request->getPost('visitor_name',FILTER_SANITIZE_STRING);
				$visit_date = $this->request->getPost('visit_date',FILTER_SANITIZE_STRING);
				$check_in = $this->request->getPost('check_in',FILTER_SANITIZE_STRING);
				$check_out = $this->request->getPost('check_out',FILTER_SANITIZE_STRING);
				$phone = $this->request->getPost('phone',FILTER_SANITIZE_STRING);
				$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
				$address = $this->request->getPost('address',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
								
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'department_id' => $department_id,
					'visit_purpose'  => $visit_purpose,
					'visitor_name'  => $visitor_name,
					'phone'  => $phone,
					'email'  => $email,
					'visit_date'  => $visit_date,
					'check_in'  => $check_in,
					'check_out'  => $check_out,
					'address'  => $address,
					'description'  => $description,
				];
				$VisitorsModel = new VisitorsModel();
				$result = $VisitorsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_visitor_updated_msg');
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
	public function read_visitor()
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
			return view('erp/visitors/dialog_visitor', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_visitor() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$VisitorsModel = new VisitorsModel();
			$result = $VisitorsModel->where('visitor_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_visitor_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

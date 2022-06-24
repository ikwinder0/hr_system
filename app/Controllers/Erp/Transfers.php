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

use App\Models\OffModel; 
use App\Models\MainModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;
use App\Models\TransfersModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;

class Transfers extends BaseController {

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
			if(!in_array('transfers1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_transfers').' | '.$xin_system['application_name'];
		$data['path_url'] = 'transfers';
		$data['breadcrumbs'] = lang('Dashboard.left_transfers');

		$data['subview'] = view('erp/transfers/key_transfer', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// |||add record|||
	public function add_transfer() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'employee' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'department' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'designation' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'transfer_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'reason' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "employee" => $validation->getError('employee'),
					"department" => $validation->getError('department'),
					"designation" => $validation->getError('designation'),
					"transfer_date" => $validation->getError('transfer_date'),
					"reason" => $validation->getError('reason')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$staff_id = $this->request->getPost('employee',FILTER_SANITIZE_STRING);
				$department = $this->request->getPost('department',FILTER_SANITIZE_STRING);
				$designation = $this->request->getPost('designation',FILTER_SANITIZE_STRING);
				$transfer_date = $this->request->getPost('transfer_date',FILTER_SANITIZE_STRING);
				$reason = $this->request->getPost('reason',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'employee_id' => $staff_id,
					'transfer_date'  => $transfer_date,
					'transfer_department'  => $department,
					'transfer_designation'  => $designation,
					'reason'  => $reason,
					'added_by'  => $usession['sup_user_id'],
					'status'  => 0,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TransfersModel = new TransfersModel();
				$result = $TransfersModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_transfer_added_msg');
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
	// |||add record|||
	public function update_transfer() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type',FILTER_SANITIZE_STRING) === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'employee' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'department' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'designation' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'transfer_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'reason' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "employee" => $validation->getError('employee'),
					"department" => $validation->getError('department'),
					"designation" => $validation->getError('designation'),
					"transfer_date" => $validation->getError('transfer_date'),
					"reason" => $validation->getError('reason')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$staff_id = $this->request->getPost('employee',FILTER_SANITIZE_STRING);
				$department = $this->request->getPost('department',FILTER_SANITIZE_STRING);
				$designation = $this->request->getPost('designation',FILTER_SANITIZE_STRING);
				$transfer_date = $this->request->getPost('transfer_date',FILTER_SANITIZE_STRING);
				$reason = $this->request->getPost('reason',FILTER_SANITIZE_STRING);	
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);		
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'employee_id' => $staff_id,
					'transfer_date'  => $transfer_date,
					'transfer_department'  => $department,
					'transfer_designation'  => $designation,
					'reason'  => $reason,
					'status'  => $status,
				];
				$TransfersModel = new TransfersModel();
				$result = $TransfersModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					if($status == 1){
						// employee details
						$data2 = [
							'department_id' => $department,
							'designation_id' => $designation,
						];
						$MainModel = new MainModel();
						$MainModel->update_employee_record($data2,$staff_id);
					}
					$Return['result'] = lang('Success.ci_transfer_updated_msg');
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
	// record list
	public function transfers_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TransfersModel = new TransfersModel();
		$ConstantsModel = new ConstantsModel();
		$DepartmentModel = new DepartmentModel();
		$DesignationModel = new DesignationModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $TransfersModel->where('company_id',$user_info['company_id'])->orderBy('transfer_id', 'ASC')->findAll();
		} else {
			$get_data = $TransfersModel->where('company_id',$usession['sup_user_id'])->orderBy('transfer_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('transfers3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['transfer_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('transfers4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['transfer_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$transfer_date = set_date_format($r['transfer_date']);
			//
			if($r['status'] == 0){
				$app_status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>';
			} else if($r['status'] == 1){
				$app_status = '<span class="badge badge-light-success">'.lang('Main.xin_accepted').'</span>';
			} else if($r['status'] == 2){
				$app_status = '<span class="badge badge-light-danger">'.lang('Main.xin_rejected').'</span>';
			}
			// employee
			$iuser = $UsersModel->where('user_id', $r['employee_id'])->first();
			if($iuser){
				$employee_name = $iuser['first_name'].' '.$iuser['last_name'];
				$ruserinfo = $employee_name.'<br><small class="text-muted"><i>'.$iuser['email'].'<i></i></i></small>';
				$uname = '<div class="d-inline-block align-middle">
					<img src="'.base_url().'/public/uploads/users/thumb/'.$iuser['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
					<div class="d-inline-block">
						<h6 class="m-b-0">'.$employee_name.'</h6>
						<p class="m-b-0">'.$iuser['email'].'</p>
					</div>
				</div>';
				$combhr = $edit.$delete;
			} else {
				$combhr = $delete;
				$uname = lang('Users.xin_user_data_removed');
			}
			$idepartment = $DepartmentModel->where('department_id',$r['transfer_department'])->first();
			if($idepartment){
				$department_name = $idepartment['department_name'];
			} else {
				$department_name = '--';
			}
			$idesignation = $DesignationModel->where('designation_id',$r['transfer_designation'])->first();
			if($idesignation){
				$designation_name = $idesignation['designation_name'];
			} else {
				$designation_name = '--';
			}
			
			if(in_array('transfers3',staff_role_resource()) || in_array('transfers4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$iemployee_name = '
				'.$uname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';	 			  				
			} else {
				$iemployee_name = $uname;
			}
			$data[] = array(
				$iemployee_name,
				$department_name,
				$designation_name,
				$transfer_date,
				$app_status
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	// read record
	public function read_transfer()
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
			return view('erp/transfers/dialog_transfer', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	public function is_department() {
		
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		$id = $request->uri->getSegment(4);
		
		$data = array(
			'user_id' => $id
			);
		if($session->has('sup_username')){
			return view('erp/transfers/get_departments', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	 }
	 public function is_designation() {
		
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		$id = $request->uri->getSegment(4);
		
		$data = array(
			'department_id' => $id
			);
		if($session->has('sup_username')){
			return view('erp/transfers/get_designations', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	 }
	 public function is_departmentajx() {
		
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		$id = $request->uri->getSegment(4);
		
		$data = array(
			'user_id' => $id
			);
		if($session->has('sup_username')){
			return view('erp/transfers/get_departmentsajx', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	 }
	 public function is_designationajx() {
		
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		$id = $request->uri->getSegment(4);
		
		$data = array(
			'department_id' => $id
			);
		if($session->has('sup_username')){
			return view('erp/transfers/get_designationsajx', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	 }
	// delete record
	public function delete_transfer() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$TransfersModel = new TransfersModel();
			$result = $TransfersModel->where('transfer_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_transfer_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

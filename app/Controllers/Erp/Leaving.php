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

class Leaving extends BaseController {

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
			if(!in_array('staffexit1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_employees_exit').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employee_off';
		$data['breadcrumbs'] = lang('Dashboard.left_employees_exit');

		$data['subview'] = view('erp/exit/key_employee_exit', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// |||add record|||
	public function add_exit() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'employee_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_employee_field_error')
					]
				],
				'exit_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'exit_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'exit_interview' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'reason' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_description_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "employee_id" => $validation->getError('employee_id'),
					"exit_date" => $validation->getError('exit_date'),
					"exit_type" => $validation->getError('exit_type'),
					"exit_interview" => $validation->getError('exit_interview'),
					"reason" => $validation->getError('reason')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);		
				$exit_date = $this->request->getPost('exit_date',FILTER_SANITIZE_STRING);
				$exit_type = $this->request->getPost('exit_type',FILTER_SANITIZE_STRING);
				$exit_interview = $this->request->getPost('exit_interview',FILTER_SANITIZE_STRING);
				$is_inactivate_account = $this->request->getPost('is_inactivate_account',FILTER_SANITIZE_STRING);
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
					'employee_id' => $employee_id,
					'exit_date'  => $exit_date,
					'exit_type_id' => $exit_type,
					'exit_interview'  => $exit_interview,
					'is_inactivate_account' => $is_inactivate_account,
					'reason'  => $reason,
					'added_by' => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s')
				];
				$OffModel = new OffModel();
				$result = $OffModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_set_exit_success');
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
	// |||edit record|||
	public function update_exit() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'exit_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'exit_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'exit_interview' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'reason' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_description_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
					"exit_date" => $validation->getError('exit_date'),
					"exit_type" => $validation->getError('exit_type'),
					"exit_interview" => $validation->getError('exit_interview'),
					"is_inactivate_account" => $validation->getError('is_inactivate_account'),
					"reason" => $validation->getError('reason')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {	
				$exit_date = $this->request->getPost('exit_date',FILTER_SANITIZE_STRING);
				$exit_type = $this->request->getPost('exit_type',FILTER_SANITIZE_STRING);
				$exit_interview = $this->request->getPost('exit_interview',FILTER_SANITIZE_STRING);
				$is_inactivate_account = $this->request->getPost('is_inactivate_account',FILTER_SANITIZE_STRING);
				$reason = $this->request->getPost('reason',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'exit_date'  => $exit_date,
					'exit_type_id' => $exit_type,
					'exit_interview'  => $exit_interview,
					'is_inactivate_account' => $is_inactivate_account,
					'reason'  => $reason
				];
				$OffModel = new OffModel();
				$result = $OffModel->update($id,$data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_update_exit_success');
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
	public function employee_off_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$OffModel = new OffModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $OffModel->where('company_id',$user_info['company_id'])->orderBy('exit_id', 'ASC')->findAll();
		} else {
			$get_data = $OffModel->where('company_id',$usession['sup_user_id'])->orderBy('exit_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('staffexit3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['exit_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('staffexit4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['exit_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-light-success waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['exit_id']) . '"><span class="fas fa-eye"></span></button></span>';
			
			$exit_date = set_date_format($r['exit_date']);
			//
			if($r['is_inactivate_account'] == 0){
				$inactivate_account = lang('Main.xin_no');
			} else {
				$inactivate_account = lang('Main.xin_yes');
			}
			if($r['exit_interview'] == 1){
				$interview = lang('Main.xin_yes');
			} else {
				$interview = lang('Main.xin_no');
			}
			// employee
			$iuser = $UsersModel->where('user_id', $r['employee_id'])->first();
			if($iuser){
				$employee_name = $iuser['first_name'].' '.$iuser['last_name'];
				$profile_photo = $iuser['profile_photo'];
				$email = $iuser['email'];
				$uname = '<div class="d-inline-block align-middle">
					<img src="'.base_url().'/public/uploads/users/thumb/'.$profile_photo.'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
					<div class="d-inline-block">
						<h6 class="m-b-0">'.$employee_name.'</h6>
						<p class="m-b-0">'.$email.'</p>
					</div>
				</div>';
				$combhr = $edit.$view.$delete;	
			} else {
				$email = '';
				$uname = lang('Users.xin_user_data_removed');
				$profile_photo = '';
				$combhr = $delete;	
			}
			//// exit type
			$category_info = $ConstantsModel->where('constants_id', $r['exit_type_id'])->where('type','exit_type')->first();
			if($category_info){
				$category_name = $category_info['category_name'];
			} else {
				$category_name = '';
			}
			
			$iemployee_name = '
				'.$uname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$iemployee_name,
				$category_name,
				$exit_date,
				$interview,
				$inactivate_account
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
	public function read_employee_exit()
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
			return view('erp/exit/dialog_exit', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_employee_exit() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$OffModel = new OffModel();
			$result = $OffModel->where('exit_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.employee_delete_exit_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

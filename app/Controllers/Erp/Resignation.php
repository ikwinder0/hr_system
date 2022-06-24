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
use App\Models\ResignationsModel;

class Resignation extends BaseController {

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
			if(!in_array('resignation1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_resignations').' | '.$xin_system['application_name'];
		$data['path_url'] = 'resignation';
		$data['breadcrumbs'] = lang('Dashboard.left_resignations');

		$data['subview'] = view('erp/resignation/key_resignation', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// |||add record|||
	public function add_resignation() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'notice_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'resignation_date' => [
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
                    "notice_date" => $validation->getError('notice_date'),
					"resignation_date" => $validation->getError('resignation_date'),
					"reason" => $validation->getError('reason')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$notice_date = $this->request->getPost('notice_date',FILTER_SANITIZE_STRING);
				$resignation_date = $this->request->getPost('resignation_date',FILTER_SANITIZE_STRING);
				$reason = $this->request->getPost('reason',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$staff_id = $usession['sup_user_id'];
					$company_id = $user_info['company_id'];
				} else {
					$staff_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'employee_id' => $staff_id,
					'notice_date'  => $notice_date,
					'resignation_date'  => $resignation_date,
					'reason'  => $reason,
					'added_by'  => $usession['sup_user_id'],
					'status'  => 0,
					'created_at' => date('d-m-Y h:i:s')
				];
				$ResignationsModel = new ResignationsModel();
				$result = $ResignationsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_resignation_added_msg');
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
	public function update_resignation() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type',FILTER_SANITIZE_STRING) === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'notice_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'resignation_date' => [
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
                    "notice_date" => $validation->getError('notice_date'),
					"resignation_date" => $validation->getError('resignation_date'),
					"reason" => $validation->getError('reason')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$notice_date = $this->request->getPost('notice_date',FILTER_SANITIZE_STRING);
				$resignation_date = $this->request->getPost('resignation_date',FILTER_SANITIZE_STRING);
				$reason = $request->getPost('reason',FILTER_SANITIZE_STRING);		
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);		
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'notice_date'  => $notice_date,
					'resignation_date'  => $resignation_date,
					'reason'  => $reason,
					'status'  => $status,
				];
				$ResignationsModel = new ResignationsModel();
				$result = $ResignationsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_resignation_updated_msg');
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
	public function resignation_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ResignationsModel = new ResignationsModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $ResignationsModel->where('company_id',$user_info['company_id'])->orderBy('resignation_id', 'ASC')->findAll();
		} else {
			$get_data = $ResignationsModel->where('company_id',$usession['sup_user_id'])->orderBy('resignation_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('resignation3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['resignation_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('resignation4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['resignation_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$notice_date = set_date_format($r['notice_date']);
			$resignation_date = set_date_format($r['resignation_date']);
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
			
			if(in_array('resignation3',staff_role_resource()) || in_array('resignation4',staff_role_resource()) || $user_info['user_type'] == 'company') {
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
				$notice_date,
				$resignation_date,
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
	public function read_resignation()
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
			return view('erp/resignation/dialog_resignation', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_resignation() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ResignationsModel = new ResignationsModel();
			$result = $ResignationsModel->where('resignation_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_resignation_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

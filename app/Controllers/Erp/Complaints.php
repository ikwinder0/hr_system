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
use App\Models\ComplaintsModel;

class Complaints extends BaseController {
	
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
			if(!in_array('complaint1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_complaints').' | '.$xin_system['application_name'];
		$data['path_url'] = 'complaints';
		$data['breadcrumbs'] = lang('Dashboard.left_complaints');

		$data['subview'] = view('erp/complaints/key_complaints', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// |||add record|||
	public function add_complaint() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'complaint_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"complaint_date" => $validation->getError('complaint_date'),
					"description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);
				$complaint_date = $this->request->getPost('complaint_date',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$sup_user_id = $usession['sup_user_id'];
					$company_id = $user_info['company_id'];
				} else {
					$sup_user_id = $usession['sup_user_id'];
					$company_id = $usession['sup_user_id'];
				}
				$complaint_against = implode(',',$this->request->getPost('complaint_against',FILTER_SANITIZE_STRING));
				$staff_ids = $complaint_against;
				$data = [
					'company_id'  => $company_id,
					'complaint_from'  => $sup_user_id,
					'title'  => $title,
					'complaint_date'  => $complaint_date,
					'complaint_against'  => $staff_ids,
					'description'  => $description,
					'status'  => 0,
					'created_at' => date('d-m-Y h:i:s')
				];
				$ComplaintsModel = new ComplaintsModel();
				$result = $ComplaintsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_complaint_added_msg');
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
	public function update_complaint() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'complaint_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' =>lang('Main.xin_error_field_text')
					]
				],
				'status' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"complaint_date" => $validation->getError('complaint_date'),
					"description" => $validation->getError('description'),
					"status" => $validation->getError('status')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);
				$complaint_date = $this->request->getPost('complaint_date',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);			
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				
				$data = [
					'title'  => $title,
					'complaint_date'  => $complaint_date,
					'description'  => $description,
					'status'  => $status
				];
				$ComplaintsModel = new ComplaintsModel();
				$result = $ComplaintsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_complaint_updated_msg');
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
	public function complaints_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ComplaintsModel = new ComplaintsModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $ComplaintsModel->where('company_id',$user_info['company_id'])->orderBy('complaint_id', 'ASC')->findAll();
		} else {
			$get_data = $ComplaintsModel->where('company_id',$usession['sup_user_id'])->orderBy('complaint_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('complaint3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['complaint_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('complaint4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['complaint_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$complaint_date = set_date_format($r['complaint_date']);
			$complaint_against = explode(',',$r['complaint_against']);
			$multi_users = multi_user_profile_photo($complaint_against);
			//
			if($r['status'] == 0){
				$status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>';
			} else if($r['status'] == 1){
				$status = '<span class="badge badge-light-success">'.lang('Main.xin_accepted').'</span>';
			} else if($r['status'] == 2){
				$status = '<span class="badge badge-light-danger">'.lang('Main.xin_rejected').'</span>';
			}
			// employee
			$title = $r['title'];
			$combhr = $edit.$delete;
			
			if(in_array('complaint3',staff_role_resource()) || in_array('complaint4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$ititle = '
				'.$title.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';		 			  				
			} else {
				$ititle = $title;
			}
			$data[] = array(
				$ititle,
				$multi_users,
				$complaint_date,
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
	// read record
	public function read_complaints()
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
			return view('erp/complaints/dialog_complaint', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_complaint() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ComplaintsModel = new ComplaintsModel();
			$result = $ComplaintsModel->where('complaint_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_complaint_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

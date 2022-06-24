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
use App\Models\PolicyModel;

class Policies extends BaseController {

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
			if(!in_array('policy1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.header_policies').' | '.$xin_system['application_name'];
		$data['path_url'] = 'policies';
		$data['breadcrumbs'] = lang('Dashboard.header_policies');

		$data['subview'] = view('erp/policies/staff_policies', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function staff_policies_all()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_view_policies').' | '.$xin_system['application_name'];
		$data['path_url'] = 'policies';
		$data['breadcrumbs'] = lang('Dashboard.xin_view_policies');

		$data['subview'] = view('erp/policies/staff_policies_all', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	 // record list
	public function policies_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$PolicyModel = new PolicyModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $PolicyModel->where('company_id',$user_info['company_id'])->orderBy('policy_id', 'ASC')->findAll();
		} else {
			$get_data = $PolicyModel->where('company_id',$usession['sup_user_id'])->orderBy('policy_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('policy3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['policy_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('policy4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['policy_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$added_by = $UsersModel->where('user_id', $r['added_by'])->first();			
			$title = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/policy/'.$r['attachment'].'" alt="user image" class="align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$r['title'].'</h6>
				</div>
			</div>';
			$combhr = $edit.$delete;
			if(in_array('policy3',staff_role_resource()) || in_array('policy4',staff_role_resource()) || $user_info['user_type'] == 'company') {
					
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
				$created_at,
				$added_by['first_name'].' '.$added_by['last_name']
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
	public function add_policy() {
			
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
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'attachment' => [
					'rules'  => 'uploaded[attachment]|mime_in[attachment,image/jpg,image/jpeg,image/gif,image/png]|max_size[attachment,3072]',
					'errors' => [
						'uploaded' => lang('Main.xin_error_field_text'),
						'mime_in' => 'wrong size'
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"description" => $validation->getError('description'),
					"attachment" => $validation->getError('attachment')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				$attachment = $this->request->getFile('attachment');
				$file_name = $attachment->getName();
				$attachment->move('public/uploads/policy/');
				
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);
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
					'title'  => $title,
					'description'  => $description,
					'attachment'  => $file_name,
					'added_by'  => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s')
				];
				$PolicyModel = new PolicyModel();
				$result = $PolicyModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_policy_added_msg');
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
	public function update_policy() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();	
		if ($this->request->getPost('type') === 'edit_record') {
			
			// set rules
			$rules = [
				'title' => [
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
				],
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
			   $validated = $this->validate([
					'attachment' => [
						'rules'  => 'uploaded[attachment]|mime_in[attachment,image/jpg,image/jpeg,image/gif,image/png]|max_size[attachment,3072]',
						'errors' => [
							'uploaded' => lang('Main.xin_error_field_text'),
							'mime_in' => 'wrong size'
						]
					],
				]);
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				if ($validated) {
					$attachment = $this->request->getFile('attachment');
					$file_name = $attachment->getName();
					$attachment->move('public/uploads/policy/');
					$data = [
						'title' => $title,
						'description'  => $description,
						'attachment'  => $file_name,
					];
				} else {
						$data = [
						'title' => $title,
						'description'  => $description,
					];	
				}
				$PolicyModel = new PolicyModel();
				$result = $PolicyModel->update($id, $data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_policy_updated_msg');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		}			
	}
	// read record
	public function read_policy()
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
			return view('erp/policies/dialog_policy', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_policy() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$PolicyModel = new PolicyModel();
			$result = $PolicyModel->where('policy_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_policy_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

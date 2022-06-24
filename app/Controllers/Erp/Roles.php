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
 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;

class Roles extends BaseController {

	public function index()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Users.xin_staff_roles').' | '.$xin_system['application_name'];
		$data['path_url'] = 'staff_roles';
		$data['breadcrumbs'] = lang('Users.xin_staff_roles');

		$data['subview'] = view('erp/staff_roles/staff_role_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// |||add record|||
	public function add_role() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'role_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Users.xin_role_error_role_name')
					]
				],
				'role_access' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Users.xin_role_error_access')
					]
				]
			];
			
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "role_name" => $validation->getError('role_name'),
					"role_access" => $validation->getError('role_access')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$role_name = $this->request->getPost('role_name',FILTER_SANITIZE_STRING);
				$role_access = $this->request->getPost('role_access',FILTER_SANITIZE_STRING);
				$role_resources = implode(',',$this->request->getPost('role_resources',FILTER_SANITIZE_STRING));
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'role_name' => $role_name,
					'company_id'  => $company_id,
					'role_access'  => $role_access,
					'role_resources'  => $role_resources,
					'created_at' => date('d-m-Y h:i:s')
				];
				$RolesModel = new RolesModel();
				$result = $RolesModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Users.xin_strole_success_added');
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
	public function update_role() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			// set rules
			$rules = [
				'role_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Users.xin_role_error_role_name')
					]
				],
				'role_access' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Users.xin_role_error_access')
					]
				]
			];
			
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "role_name" => $validation->getError('role_name'),
					"role_access" => $validation->getError('role_access')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$role_name = $this->request->getPost('role_name',FILTER_SANITIZE_STRING);
				$role_access = $this->request->getPost('role_access',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$role_resources = implode(',',$this->request->getPost('role_resources',FILTER_SANITIZE_STRING));
				$data = [
					'role_name' => $role_name,
					'role_access'  => $role_access,
					'role_resources'  => $role_resources
				];
				$RolesModel = new RolesModel();
				$result = $RolesModel->update($id, $data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Users.xin_strole_success_updated');
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
	public function read_role()
	{
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$id = $request->getGet('field_id');
		$data = [
				'field_id' => $id,
			];
		if($session->has('sup_username')){
			return view('erp/staff_roles/dialog_role', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// record list
	public function staff_roles_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$roles = $RolesModel->where('company_id',$user_info['company_id'])->orderBy('role_id', 'ASC')->findAll();
		} else {
			$roles = $RolesModel->where('company_id',$usession['sup_user_id'])->orderBy('role_id', 'ASC')->findAll();
		}
		$data = array();
		$avatar_array = array('badge badge-dark','badge badge-primary','badge badge-info','badge badge-success','badge badge-warning','badge badge-secondary','badge badge-danger');
		$i=0;
        foreach($roles as $r) {						
		  			
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['role_id']) . '"><i class="feather icon-edit"></i></button></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['role_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			$combhr = $edit.$delete;
			if($r['role_access']==1){
				$role_access = lang('Users.xin_role_all_menu');
			} else {
				$role_access = lang('Users.xin_role_cmenu');
			}
			$created_at = set_date_format($r['created_at']);	
			/*$subs_role = substr($r['role_name'], 0, 1);	
			$role_title= '<div class="media align-items-center">
				<span class="bg-avatar d-block ui-w-30 '.$avatar_array[$i].'">'.$subs_role.'</span>
				<div class="media-body flex-basis-auto pl-3">
				  <div>'.$r['role_name'].'</div>
				</div>
			  </div>';*/
			  
			$role_name = '
				'.$r['role_name'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';				 			  				
			$data[] = array(
				$role_name,
				$role_access,
				$created_at
			);
			$i++;
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 // delete record
	public function delete_role() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$RolesModel = new RolesModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $RolesModel->where('role_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Users.xin_strole_success_deleted');
			} else {
				$Return['error'] = lang('Membership.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

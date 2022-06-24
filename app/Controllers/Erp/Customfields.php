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

use App\Models\MainModel; 
use App\Models\UsersModel;
use App\Models\RolesModel;
use App\Models\SystemModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;

class Customfields extends BaseController {

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
			if(!in_array('custom_fields',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_custom_fields').' | '.$xin_system['application_name'];
		$data['path_url'] = 'custom_fields';
		$data['breadcrumbs'] = lang('Main.xin_custom_fields');

		$data['subview'] = view('erp/customfields/key_customfields', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	 // record list
	public function customfields_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$Moduleattributes = new Moduleattributes();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $Moduleattributes->where('company_id',$user_info['company_id'])->orderBy('custom_field_id', 'ASC')->findAll();
		} else {
			$get_data = $Moduleattributes->where('company_id',$usession['sup_user_id'])->orderBy('custom_field_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['custom_field_id']) . '"><i class="feather icon-edit"></i></button></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['custom_field_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			
			if($r['validation'] == 0){
				$validation = '<span class="badge badge-light-success">'.lang('Main.xin_no').'</span>';
			} else {
				$validation = '<span class="badge badge-light-danger">'.lang('Main.xin_yes').'</span>';
			}
			if($r['module_id'] == 1){
				$module = lang('Dashboard.left_awards');
			} else if($r['module_id'] == 2){
				$module = lang('Dashboard.xin_assets');
			} else if($r['module_id'] == 3){
				$module = lang('Dashboard.dashboard_helpdesk');
			} else if($r['module_id'] == 4){
				$module = lang('Dashboard.left_training');
			} else if($r['module_id'] == 5){
				$module = lang('Main.xin_employee_contract');
			} else if($r['module_id'] == 7){
				$module = lang('Main.xin_inventory_products');
			} else if($r['module_id'] == 8){
				$module = lang('Main.xin_employee_bsic_info');
			} else if($r['module_id'] == 9){
				$module = lang('Main.xin_employee_personal_info_bio');
			} else {
				$module = lang('Dashboard.left_announcement_make');
			}
			//$validation = $validation;
			$combhr = $edit.$delete;
			$ivisitor_name = '
				'.$module.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$ivisitor_name,
				$r['attribute'],
				$r['attribute_label'],
				$r['attribute_type'],
				$r['col_width'],
				$validation
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
	public function add_customfield() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'module' => [
					'rules'  => 'required',
					'errors' => [
						'required' =>  lang('Main.xin_error_field_text')
					]
				],
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'field_label' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'priority' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'validation' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'field_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "module" => $validation->getError('module'),
					"name" => $validation->getError('name'),
					"field_label" => $validation->getError('field_label'),
					"priority" => $validation->getError('priority'),
					"validation" => $validation->getError('validation'),
					"field_type" => $validation->getError('field_type')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$module = $this->request->getPost('module',FILTER_SANITIZE_STRING);
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
				$field_label = $this->request->getPost('field_label',FILTER_SANITIZE_STRING);
				$priority = $this->request->getPost('priority',FILTER_SANITIZE_STRING);
				$validation = $this->request->getPost('validation',FILTER_SANITIZE_STRING);
				$field_type = $this->request->getPost('field_type',FILTER_SANITIZE_STRING);
				$column = $this->request->getPost('column',FILTER_SANITIZE_STRING);

				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'module_id' => $module,
					'attribute'  => $name,
					'attribute_label'  => $field_label,
					'attribute_type'  => $field_type,
					'col_width'  => $column,
					'validation'  => $validation,
					'priority'  => $priority,
					'created_at' => date('d-m-Y h:i:s')
				];
				$Moduleattributes = new Moduleattributes();
				$result = $Moduleattributes->insert($data);
				$module_id = $Moduleattributes->insertID();
				$Moduleattributesvalsel = new Moduleattributesvalsel();	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					foreach($this->request->getPost('select_value') as $items){
						if($items !=''){
							$select_val = array(
							'company_id' => $company_id,
							'custom_field_id' => $module_id,
							'select_label' => $items,
							);
							$Moduleattributesvalsel->insert($select_val);
						}
					}
					$Return['result'] = lang('Main.xin_custom_field_added_success');
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
	public function update_customfield() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'module' => [
					'rules'  => 'required',
					'errors' => [
						'required' =>  lang('Main.xin_error_field_text')
					]
				],
				'field_label' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'priority' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'validation' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "module" => $validation->getError('module'),
					"field_label" => $validation->getError('field_label'),
					"priority" => $validation->getError('priority'),
					"validation" => $validation->getError('validation'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$module = $this->request->getPost('module',FILTER_SANITIZE_STRING);
				$field_label = $this->request->getPost('field_label',FILTER_SANITIZE_STRING);
				$priority = $this->request->getPost('priority',FILTER_SANITIZE_STRING);
				$validation = $this->request->getPost('validation',FILTER_SANITIZE_STRING);
				$column = $this->request->getPost('column',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				$data = [
					'module_id' => $module,
					'attribute_label'  => $field_label,
					'col_width'  => $column,
					'validation'  => $validation,
					'priority'  => $priority
				];
				$Moduleattributes = new Moduleattributes();
				$result = $Moduleattributes->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Main.xin_custom_field_updated_success');
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
	public function read_customfield()
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
			return view('erp/customfields/dialog_customfields', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_customfield() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$Moduleattributes = new Moduleattributes();
			$result = $Moduleattributes->where('custom_field_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_custom_field_deleted_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

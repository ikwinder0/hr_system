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
use App\Models\CountryModel;
use App\Models\StaffdetailsModel;

class Department extends BaseController {
	
	public function corehr_dashboard()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_department').' | '.$xin_system['application_name'];
		$data['path_url'] = 'departments';
		$data['breadcrumbs'] = lang('Dashboard.left_department');

		$data['subview'] = view('erp/department/corehr_dashboard', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function index()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
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
			if(!in_array('department1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.left_department').' | '.$xin_system['application_name'];
		$data['path_url'] = 'departments';
		$data['breadcrumbs'] = lang('Dashboard.left_department');

		$data['subview'] = view('erp/department/staff_department', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function departments_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$DepartmentModel = new DepartmentModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $DepartmentModel->where('company_id',$user_info['company_id'])->orderBy('department_id', 'ASC')->findAll();
		} else {
			$get_data = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('department3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['department_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('department4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['department_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$d_head = $UsersModel->where('user_id', $r['department_head'])->first();
			if($d_head){
				$name = $d_head['first_name'].' '.$d_head['last_name'];
			} else {
				$name = '--';
			}
			$combhr = $edit.$delete;
			if(in_array('department3',staff_role_resource()) || in_array('department4',staff_role_resource()) || $user_info['user_type'] == 'company') {
					$department_name = '
					'.$r['department_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>';		  				
			} else {
				$department_name = $r['department_name'];
			}
			$data[] = array(
				$department_name,
				$name,
				$created_at
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
	public function add_department() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'department_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "department_name" => $validation->getError('department_name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$department_name = $this->request->getPost('department_name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$staff_id = 0;
					$company_id = $user_info['company_id'];
				} else {
					$staff_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
					$company_id = $usession['sup_user_id'];
				}
				if(empty($staff_id)){
					$staff_id = 0;
				}
				$data = [
					'company_id'  => $company_id,
					'department_name' => $department_name,
					'department_head'  => $staff_id,
					'added_by'  => $company_id,
					'created_at' => date('d-m-Y h:i:s')
				];
				$DepartmentModel = new DepartmentModel();
				$result = $DepartmentModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_department_added_msg');
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
	public function update_department() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'department_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "department_name" => $validation->getError('department_name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$department_name = $this->request->getPost('department_name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$staff_id = 0;
					$company_id = $user_info['company_id'];
				} else {
					$staff_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
					$company_id = $usession['sup_user_id'];
				}
				if(empty($staff_id)){
					$staff_id = 0;
				}
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'company_id'  => $company_id,
					'department_name' => $department_name,
					'department_head'  => $staff_id
				];
				$DepartmentModel = new DepartmentModel();
				$result = $DepartmentModel->update($id, $data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_department_updated_msg');
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
	public function read_department()
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
			return view('erp/department/dialog_department', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	public function department_wise_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$DepartmentModel = new DepartmentModel();
		$StaffdetailsModel = new StaffdetailsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $DepartmentModel->where('company_id',$user_info['company_id'])->orderBy('department_id', 'ASC')->findAll();
		} else {
			$get_data = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
		}
		$data = array();
		$Return = array('iseries'=>'', 'ilabels'=>'');
		$title_info = array();
		$series_info = array();
		foreach($get_data as $r){
			$dep_info = $StaffdetailsModel->where('department_id',$r['department_id'])->first();
			$dep_count = $StaffdetailsModel->where('department_id',$r['department_id'])->countAllResults();
			if($dep_count > 0){
				$title_info[] = $r['department_name'];
				$series_info[] = $dep_count;
			}
			
		}				  
		$Return['iseries'] = $series_info;
		$Return['ilabels'] = $title_info;
		$Return['total_label'] = lang('Main.xin_total');
		$this->output($Return);
		exit;
	}
	// delete record
	public function delete_department() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$DepartmentModel = new DepartmentModel();
			$result = $DepartmentModel->where('department_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_department_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

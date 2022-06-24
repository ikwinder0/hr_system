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
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;

class Designation extends BaseController {

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
			if(!in_array('designation1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.left_designation').' | '.$xin_system['application_name'];
		$data['path_url'] = 'designation';
		$data['breadcrumbs'] = lang('Dashboard.left_designation');

		$data['subview'] = view('erp/designation/staff_designation', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function designation_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$DepartmentModel = new DepartmentModel();
		$DesignationModel = new DesignationModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $DesignationModel->where('company_id',$user_info['company_id'])->orderBy('designation_id', 'ASC')->findAll();
		} else {
			$get_data = $DesignationModel->where('company_id',$usession['sup_user_id'])->orderBy('designation_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('designation3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['designation_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('designation4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['designation_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$department = $DepartmentModel->where('department_id', $r['department_id'])->first();
			if($department){
				$department_name = $department['department_name'];
			} else {
				$department_name = '--';
			}
			$idesignation_name = $r['designation_name'];
			$combhr = $edit.$delete;
			if(in_array('designation3',staff_role_resource()) || in_array('designation4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$iidesignation_name = '
					'.$idesignation_name.'
					<div class="overlay-edit">
						'.$combhr.'
					</div>';
						 			  				
			} else {
				$iidesignation_name = $idesignation_name;
			}
			$data[] = array(
				$iidesignation_name,
				$department_name
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
	public function add_designation() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'department' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'designation_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "department" => $validation->getError('department'),
					"designation_name" => $validation->getError('designation_name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$department = $this->request->getPost('department',FILTER_SANITIZE_STRING);
				$designation_name = $this->request->getPost('designation_name',FILTER_SANITIZE_STRING);
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
					'department_id' => $department,
					'designation_name'  => $designation_name,
					'description'  => $description,
					'created_at' => date('d-m-Y h:i:s')
				];
				$DesignationModel = new DesignationModel();
				$result = $DesignationModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_designation_added_msg');
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
	/// update record
	public function update_designation() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'department' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'designation_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "department" => $validation->getError('department'),
					"designation_name" => $validation->getError('designation_name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$department = $this->request->getPost('department',FILTER_SANITIZE_STRING);
				$designation_name = $this->request->getPost('designation_name',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'department_id' => $department,
					'designation_name'  => $designation_name,
					'description'  => $description
				];
				$DesignationModel = new DesignationModel();
				$result = $DesignationModel->update($id, $data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_designation_updated_msg');
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
	public function read_designation()
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
			return view('erp/designation/dialog_designation', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	public function designation_wise_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$DesignationModel = new DesignationModel();
		$StaffdetailsModel = new StaffdetailsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $DesignationModel->where('company_id',$user_info['company_id'])->orderBy('designation_id', 'ASC')->findAll();
		} else {
			$get_data = $DesignationModel->where('company_id',$usession['sup_user_id'])->orderBy('designation_id', 'ASC')->findAll();
		}
		$data = array();
		$Return = array('iseries'=>'', 'ilabels'=>'');
		$title_info = array();
		$series_info = array();
		foreach($get_data as $r){
			$dep_info = $StaffdetailsModel->where('designation_id',$r['designation_id'])->first();
			$dep_count = $StaffdetailsModel->where('designation_id',$r['designation_id'])->countAllResults();
			if($dep_count > 0){
				$title_info[] = $r['designation_name'];
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
	public function delete_designation() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$DesignationModel = new DesignationModel();
			$result = $DesignationModel->where('designation_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_designation_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

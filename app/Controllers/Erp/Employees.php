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
use App\Models\ConstantsModel;
use App\Models\CountryModel;
use App\Models\StaffdetailsModel;
use App\Models\ContractModel;
use App\Models\MembershipModel;
use App\Models\UserdocumentsModel;
use App\Models\EmailtemplatesModel;
use App\Models\CompanymembershipModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;

class Employees extends BaseController {

	public function index()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('staff2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employees';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/employees/staff_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function staff_grid()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$pager = \Config\Services::pager();
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
			if(!in_array('staff2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employees_grid';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');
		$data['subview'] = view('erp/employees/staff_grid', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function staff_dashboard()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_hrm_dashboard').' | '.$xin_system['application_name'];
		$data['path_url'] = 'assets';
		$data['breadcrumbs'] = lang('Dashboard.xin_hrm_dashboard');

		$data['subview'] = view('erp/employees/staff_dashboard', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function staff_details()
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
			if(!in_array('staff4',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$iuser_id = udecode($request->uri->getSegment(3));
		$user_val = $UsersModel->where('user_id', $iuser_id)->first();
		if(!$user_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Employees.xin_employee_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employee_details';
		$data['breadcrumbs'] = lang('Employees.xin_employee_details');

		$data['subview'] = view('erp/employees/staff_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	
	// list
	public function employees_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$UsersModel = new UsersModel();
		$config         = new \Config\Encryption();
		$config->key    = 'aBigsecret_ofAtleast32Characters';
		$config->driver = 'OpenSSL';
		
		$encrypter = \Config\Services::encrypter($config);
		$RolesModel = new RolesModel();
		$SystemModel = new SystemModel();
		$CountryModel = new CountryModel();
		$DesignationModel = new DesignationModel();
		$StaffdetailsModel = new StaffdetailsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$staff = $UsersModel->where('company_id',$user_info['company_id'])->where('user_type','staff')->orderBy('user_id', 'ASC')->findAll();
		} else {
			$staff = $UsersModel->where('company_id',$usession['sup_user_id'])->where('user_type','staff')->orderBy('user_id', 'ASC')->findAll();
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
		$data = array();
		
          foreach($staff as $r) {						
		  			
				if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') {
					$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/employee-details').'/'.uencode($r['user_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
				} else {
					$edit = '';
				}
				if(in_array('staff5',staff_role_resource()) || $user_info['user_type'] == 'company') {
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['user_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
				} else {
					$delete = '';
				}

			$role = $RolesModel->where('role_id', $r['user_role_id'])->first();
			if($role['role_name']){
				$role_name = $role['role_name'];
			} else {
				$role_name = '--';
			}
			if($r['is_active'] == 1){
				$status = '<span class="badge badge-light-success">'.lang('Main.xin_employees_active').'</span>';
			} else {
				$status = '<span class="badge badge-light-danger">'.lang('Main.xin_employees_inactive').'</span>';
			}
			if($r['gender'] == 1){
				$gender = lang('Main.xin_gender_male');
			} else {
				$gender = lang('Main.xin_gender_female');
			}
			
			$country_info = $CountryModel->where('country_id', $r['country'])->first();
			$name = $r['first_name'].' '.$r['last_name'];
			//designation
			$employee_detail = $StaffdetailsModel->where('user_id', $r['user_id'])->first();
			if($employee_detail['designation_id']){
				$idesignations = $DesignationModel->where('designation_id',$employee_detail['designation_id'])->first();
				$designation_name = $idesignations['designation_name'];
			} else {
				$designation_name = '--';
			}
			
			$uname = '<div class="d-inline-block align-middle">
				<img src="'.staff_profile_photo($r['user_id']).'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$name.'</h6>
					<p class="m-b-0">'.$r['email'].'</p>
				</div>
			</div>';
			$combhr = $edit.$delete;
			$links = '
				'.$uname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
									 			  				
			$data[] = array(
				$links,
				$designation_name,
				$r['contact_number'],
				$gender,
				$country_info['country_name'],
				$role_name,
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
	// record list
	public function allowances_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$ContractModel = new ContractModel();
		$request = \Config\Services::request();
		$id = $request->uri->getSegment(4);
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $ContractModel->where('user_id',$id)->where('salay_type','allowances')->orderBy('contract_option_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
			  
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_type="allowances" data-field_id="'. uencode($r['contract_option_id']) . '"><i class="feather icon-edit"></i></button></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-field_type="all_allowances" data-record-id="'. uencode($r['contract_option_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
						
			if($r['is_fixed']==1){
				$is_fixed = lang('Employees.xin_title_tax_fixed');
			} else {
				$is_fixed = lang('Employees.xin_title_tax_percent');
			}
			if($r['contract_tax_option']==1){
				$contract_tax_option = lang('Employees.xin_salary_allowance_non_taxable');
			} else if($r['contract_tax_option']==2){
				$contract_tax_option = lang('Employees.xin_fully_taxable');
			} else {
				$contract_tax_option = lang('Employees.xin_partially_taxable');
			}
		
			$combhr = $edit.$delete;
			$salary_option = '
				'.$r['option_title'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
			$data[] = array(
				$salary_option,
				$r['contract_amount'],
				$contract_tax_option,
				$is_fixed,
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     } 
	 // record list
	public function commissions_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$id = $request->uri->getSegment(4);
		$ContractModel = new ContractModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $ContractModel->where('user_id',$id)->where('salay_type','commissions')->orderBy('contract_option_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
			  
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_type="commissions" data-field_id="'. uencode($r['contract_option_id']) . '"><i class="feather icon-edit"></i></button></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-field_type="all_commissions" data-record-id="'. uencode($r['contract_option_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
						
			if($r['is_fixed']==0){
				$is_fixed = lang('Employees.xin_title_tax_fixed');
			} else {
				$is_fixed = lang('Employees.xin_title_tax_percent');
			}
			if($r['contract_tax_option']==0){
				$contract_tax_option = lang('Employees.xin_salary_allowance_non_taxable');
			} else if($r['contract_tax_option']==1){
				$contract_tax_option = lang('Employees.xin_fully_taxable');
			} else {
				$contract_tax_option = lang('Employees.xin_partially_taxable');
			}
		
			$combhr = $edit.$delete;
			$salary_option = '
				'.$r['option_title'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
			$data[] = array(
				$salary_option,
				$r['contract_amount'],
				$contract_tax_option,
				$is_fixed,
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 // record list
	public function statutory_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$id = $request->uri->getSegment(4);
		$ContractModel = new ContractModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $ContractModel->where('user_id',$id)->where('salay_type','statutory')->orderBy('contract_option_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
			  
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_type="statutory" data-field_id="'. uencode($r['contract_option_id']) . '"><i class="feather icon-edit"></i></button></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-field_type="all_statutory_deductions" data-record-id="'. uencode($r['contract_option_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
						
			if($r['is_fixed']==0){
				$is_fixed = lang('Employees.xin_title_tax_fixed');
			} else {
				$is_fixed = lang('Employees.xin_title_tax_percent');
			}		
			$combhr = $edit.$delete;
			$salary_option = '
				'.$r['option_title'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
			$data[] = array(
				$salary_option,
				$r['contract_amount'],
				$is_fixed
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     } 
	 // record list
	public function other_payments_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$id = $request->uri->getSegment(4);
		$ContractModel = new ContractModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $ContractModel->where('user_id',$id)->where('salay_type','other_payments')->orderBy('contract_option_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
			  
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_type="other_payments" data-field_id="'. uencode($r['contract_option_id']) . '"><i class="feather icon-edit"></i></button></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-field_type="all_other_payments" data-record-id="'. uencode($r['contract_option_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
						
			if($r['is_fixed']==0){
				$is_fixed = lang('Employees.xin_title_tax_fixed');
			} else {
				$is_fixed = lang('Employees.xin_title_tax_percent');
			}
			if($r['contract_tax_option']==0){
				$contract_tax_option = lang('Employees.xin_salary_allowance_non_taxable');
			} else if($r['contract_tax_option']==1){
				$contract_tax_option = lang('Employees.xin_fully_taxable');
			} else {
				$contract_tax_option = lang('Employees.xin_partially_taxable');
			}
		
			$combhr = $edit.$delete;
			$salary_option = '
				'.$r['option_title'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
			$data[] = array(
				$salary_option,
				$r['contract_amount'],
				$contract_tax_option,
				$is_fixed,
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	// record list
	public function user_documents_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$id = $request->uri->getSegment(4);
		$UserdocumentsModel = new UserdocumentsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $UserdocumentsModel->where('user_id',$id)->orderBy('document_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
			  
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_type="document" data-field_id="'. uencode($r['document_id']) . '"><i class="feather icon-edit"></i></button></span>';
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-field_type="document" data-record-id="'. uencode($r['document_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			$download_link = '<a href="'.site_url().'download?type=documents&filename='.uencode($r['document_file']).'">'.lang('Main.xin_download').'</a>';
			$combhr = $edit.$delete;
			$salary_option = '
				'.$r['document_name'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
			$data[] = array(
				$salary_option,
				$r['document_type'],
				$download_link
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
	public function add_employee() {
		
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			$UsersModel = new UsersModel();
			$SystemModel = new SystemModel();
			$MembershipModel = new MembershipModel();
			$CompanymembershipModel = new CompanymembershipModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
				$company_info = $UsersModel->where('company_id', $company_id)->first();
			} else {
				$company_id = $usession['sup_user_id'];
				$company_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			}
			// set rules
			$validation->setRules([
					'first_name' => 'required',
					'last_name' => 'required',
					'employee_id' => 'required',
					'office_shift_id' => 'required',
					'email' => 'required|valid_email|is_unique[ci_erp_users.email]',
					'department_id' => 'required',
					'designation_id' => 'required',
					'username' => 'required|min_length[6]|is_unique[ci_erp_users.username]',
					'password' => 'required|min_length[6]',
					'contact_number' => 'required',
					'role' => 'required',
					'basic_salary' => 'required',
					'salay_type' => 'required',
				],
				[   // Errors
					'first_name' => [
						'required' => lang('Main.xin_employee_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_employee_error_last_name'),
					],
					'employee_id' => [
						'required' => lang('Employees.xin_employee_error_employee_id'),
					],
					'office_shift_id' => [
						'required' => lang('Employees.xin_office_shift_field_error'),
					],
					'email' => [
						'required' => lang('Main.xin_employee_error_email'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email'),
						'is_unique' => lang('Main.xin_already_exist_error_email'),
					],
					'username' => [
						'required' => lang('Main.xin_employee_error_username'),
						'min_length' => lang('Main.xin_min_error_username'),
						'is_unique' => lang('Main.xin_already_exist_error_username')
					],
					'password' => [
						'required' => lang('Main.xin_employee_error_password'),
						'min_length' => lang('Login.xin_min_error_password')
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_contact_field'),
					],
					'role' => [
						'required' => lang('Employees.xin_employee_error_staff_role'),
					],
					'department_id' => [
						'required' => lang('Employees.xin_employee_error_department'),
					],
					'designation_id' => [
						'required' => lang('Employees.xin_employee_error_designation'),
					],
					'basic_salary' => [
						'required' => lang('Main.xin_employee_error_username'),
					],
					'salay_type' => [
						'required' => lang('Main.xin_employee_error_username'),
					],
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('first_name')) {
				$Return['error'] = $validation->getError('first_name');
			} elseif($validation->hasError('last_name')){
				$Return['error'] = $validation->getError('last_name');
			} elseif($validation->hasError('employee_id')) {
				$Return['error'] = $validation->getError('employee_id');
			} elseif($validation->hasError('office_shift_id')) {
				$Return['error'] = $validation->getError('office_shift_id');
			} elseif($validation->hasError('email')){
				$Return['error'] = $validation->getError('email');
			} elseif($validation->hasError('department_id')){
				$Return['error'] = $validation->getError('department_id');
			} elseif($validation->hasError('designation_id')){
				$Return['error'] = $validation->getError('designation_id');
			} elseif($validation->hasError('username')){
				$Return['error'] = $validation->getError('username');
			} elseif($validation->hasError('password')){
				$Return['error'] = $validation->getError('password');
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			} elseif($validation->hasError('role')){
				$Return['error'] = $validation->getError('role');
			} elseif($validation->hasError('basic_salary')) {
				$Return['error'] = $validation->getError('basic_salary');
			} elseif($validation->hasError('salay_type')){
				$Return['error'] = $validation->getError('salay_type');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$image = \Config\Services::image();
			$validated = $this->validate([
				'file' => [
					'uploaded[file]',
					'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
					'max_size[file,4096]',
				],
			]);
			if (!$validated) {
				$Return['error'] = lang('Employees.xin_staff_picture_field_error');
			} else {
				
				$user_image = $this->request->getFile('file');
				$file_name = $user_image->getName();
				$user_image->move('public/uploads/users/');
				$image->withFile(filesrc($file_name))
				->fit(100, 100, 'center')
				->save('public/uploads/users/thumb/'.$file_name);
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$username = $this->request->getPost('username',FILTER_SANITIZE_STRING);
			$password = $this->request->getPost('password',FILTER_SANITIZE_STRING);
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
			$role = $this->request->getPost('role',FILTER_SANITIZE_STRING);
			$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
			$office_shift_id = $this->request->getPost('office_shift_id',FILTER_SANITIZE_STRING);
			$department_id = $this->request->getPost('department_id',FILTER_SANITIZE_STRING);
			$designation_id = $this->request->getPost('designation_id',FILTER_SANITIZE_STRING);
			$basic_salary = $this->request->getPost('basic_salary',FILTER_SANITIZE_STRING);
			$hourly_rate = $this->request->getPost('hourly_rate',FILTER_SANITIZE_STRING);
			$salay_type = $this->request->getPost('salay_type',FILTER_SANITIZE_STRING);
			$options = array('cost' => 12);
			$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
			
			
			$EmailtemplatesModel = new EmailtemplatesModel();
			$xin_system = $SystemModel->where('setting_id', 1)->first();
			$data = [
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'email'  => $email,
				'user_type'  => 'staff',
				'username'  => $username,
				'password'  => $password_hash,
				'contact_number'  => $contact_number,
				'country'  => 0,
				'user_role_id' => $role,
				'address_1'  => '',
				'address_2'  => '',
				'city'  =>'',
				'profile_photo'  => $file_name,
				'state'  => '',
				'zipcode' => '',
				'gender' => $gender,
				'company_name' => $user_info['company_name'],
				'trading_name' => '',
				'registration_no' => '',
				'government_tax' => '',
				'company_type_id'  => 0,
				'last_login_date' => '0',
				'last_logout_date' => '0',
				'last_login_ip' => '0',
				'is_logged_in' => '0',
				'is_active'  => 1,
				'company_id'  => $company_id,
				'created_at' => date('d-m-Y h:i:s')
			];
			$StaffdetailsModel = new StaffdetailsModel();
			$result = $UsersModel->insert($data);
			$user_id = $UsersModel->insertID();
			// employee details
			$data2 = [
				'user_id' => $user_id,
				'employee_id'  => $employee_id,
				'department_id'  => $department_id,
				'designation_id'  => $designation_id,
				'office_shift_id' => $office_shift_id,
				'date_of_joining' => date('d-m-Y'),
				'date_of_leaving' => '',
				'date_of_birth' => '',
				'marital_status' => 0,
				'religion_id' => 0,
				'blood_group' => '',
				'citizenship_id' => 0,
				'basic_salary'  => $basic_salary,
				'hourly_rate'  => $hourly_rate,
				'salay_type' => $salay_type,
				'leave_categories' => 0,
				'role_description' => 'Enter role description here..',
				'bio' => 'Enter staff bio here..',
				'experience' => 0,
				'fb_profile' => '',
				'twitter_profile' => '',
				'gplus_profile' => '',
				'linkedin_profile' => '',
				'account_title' => '',
				'account_number' => '',
				'bank_name' => '',
				'iban' => '',
				'swift_code' => '',
				'bank_branch' => '',
				'contact_full_name' => '',
				'contact_phone_no' => '',
				'contact_email' => '',
				'contact_address' => '',
				'created_at' => date('d-m-Y h:i:s')
			];
			$StaffdetailsModel->insert($data2);
			
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Employees.xin_success_add_employee');
				if($xin_system['enable_email_notification'] == 1){
					// Send mail start
					$itemplate = $EmailtemplatesModel->where('template_id', 5)->first();
					$isubject = $itemplate['subject'];
					$ibody = html_entity_decode($itemplate['message']);
					$fbody = str_replace(array("{site_name}","{user_password}","{user_username}","{site_url}"),array($company_info['company_name'],$password,$username,site_url()),$ibody);
					timehrm_mail_data($company_info['email'],$company_info['company_name'],$email,$isubject,$fbody);
					// Send mail end
				}
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// contract options
	// |||add record|||
	public function add_allowance() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'contract_tax_option' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'is_fixed' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'option_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contract_amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "contract_tax_option" => $validation->getError('contract_tax_option'),
					"is_fixed" => $validation->getError('is_fixed'),
					"option_title" => $validation->getError('option_title'),
					"contract_amount" => $validation->getError('contract_amount')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$contract_tax_option = $this->request->getPost('contract_tax_option',FILTER_SANITIZE_STRING);
				$is_fixed = $this->request->getPost('is_fixed',FILTER_SANITIZE_STRING);
				$option_title = $this->request->getPost('option_title',FILTER_SANITIZE_STRING);	
				$contract_amount = $this->request->getPost('contract_amount',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				$UsersModel = new UsersModel();
				$ContractModel = new ContractModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'user_id'  => $id,
					'salay_type'  => 'allowances',
					'contract_tax_option' => $contract_tax_option,
					'is_fixed'  => $is_fixed,
					'option_title'  => $option_title,
					'contract_amount'  => $contract_amount
				];
				$result = $ContractModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_set_allowance_success');
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
	public function update_allowance() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'contract_tax_option' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'is_fixed' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'option_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contract_amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "contract_tax_option" => $validation->getError('contract_tax_option'),
					"is_fixed" => $validation->getError('is_fixed'),
					"option_title" => $validation->getError('option_title'),
					"contract_amount" => $validation->getError('contract_amount')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$contract_tax_option = $this->request->getPost('contract_tax_option',FILTER_SANITIZE_STRING);
				$is_fixed = $this->request->getPost('is_fixed',FILTER_SANITIZE_STRING);
				$option_title = $this->request->getPost('option_title',FILTER_SANITIZE_STRING);	
				$contract_amount = $this->request->getPost('contract_amount',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				$UsersModel = new UsersModel();
				$ContractModel = new ContractModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'salay_type'  => 'allowances',
					'contract_tax_option' => $contract_tax_option,
					'is_fixed'  => $is_fixed,
					'option_title'  => $option_title,
					'contract_amount'  => $contract_amount
				];
				$result = $ContractModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_updated_allowance_success');
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
	public function add_commissions() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'contract_tax_option' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'is_fixed' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'option_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contract_amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "contract_tax_option" => $validation->getError('contract_tax_option'),
					"is_fixed" => $validation->getError('is_fixed'),
					"option_title" => $validation->getError('option_title'),
					"contract_amount" => $validation->getError('contract_amount')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$contract_tax_option = $this->request->getPost('contract_tax_option',FILTER_SANITIZE_STRING);
				$is_fixed = $this->request->getPost('is_fixed',FILTER_SANITIZE_STRING);
				$option_title = $this->request->getPost('option_title',FILTER_SANITIZE_STRING);	
				$contract_amount = $this->request->getPost('contract_amount',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				$UsersModel = new UsersModel();
				$ContractModel = new ContractModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'user_id'  => $id,
					'salay_type'  => 'commissions',
					'contract_tax_option' => $contract_tax_option,
					'is_fixed'  => $is_fixed,
					'option_title'  => $option_title,
					'contract_amount'  => $contract_amount
				];
				$result = $ContractModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_set_commission_success');
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
	public function update_commission() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'contract_tax_option' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'is_fixed' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'option_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contract_amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "contract_tax_option" => $validation->getError('contract_tax_option'),
					"is_fixed" => $validation->getError('is_fixed'),
					"option_title" => $validation->getError('option_title'),
					"contract_amount" => $validation->getError('contract_amount')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$contract_tax_option = $this->request->getPost('contract_tax_option',FILTER_SANITIZE_STRING);
				$is_fixed = $this->request->getPost('is_fixed',FILTER_SANITIZE_STRING);
				$option_title = $this->request->getPost('option_title',FILTER_SANITIZE_STRING);	
				$contract_amount = $this->request->getPost('contract_amount',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				$UsersModel = new UsersModel();
				$ContractModel = new ContractModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'salay_type'  => 'commissions',
					'contract_tax_option' => $contract_tax_option,
					'is_fixed'  => $is_fixed,
					'option_title'  => $option_title,
					'contract_amount'  => $contract_amount
				];
				$result = $ContractModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_update_commission_success');
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
	public function add_statutory() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'is_fixed' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'option_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contract_amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
					"is_fixed" => $validation->getError('is_fixed'),
					"option_title" => $validation->getError('option_title'),
					"contract_amount" => $validation->getError('contract_amount')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$is_fixed = $this->request->getPost('is_fixed',FILTER_SANITIZE_STRING);
				$option_title = $this->request->getPost('option_title',FILTER_SANITIZE_STRING);	
				$contract_amount = $this->request->getPost('contract_amount',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				$UsersModel = new UsersModel();
				$ContractModel = new ContractModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'user_id'  => $id,
					'salay_type'  => 'statutory',
					'contract_tax_option' => 0,
					'is_fixed'  => $is_fixed,
					'option_title'  => $option_title,
					'contract_amount'  => $contract_amount
				];
				$result = $ContractModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_set_statutory_deduction_success');
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
	public function update_statutory() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'is_fixed' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'option_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contract_amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
					"is_fixed" => $validation->getError('is_fixed'),
					"option_title" => $validation->getError('option_title'),
					"contract_amount" => $validation->getError('contract_amount')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$is_fixed = $this->request->getPost('is_fixed',FILTER_SANITIZE_STRING);
				$option_title = $this->request->getPost('option_title',FILTER_SANITIZE_STRING);	
				$contract_amount = $this->request->getPost('contract_amount',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				$UsersModel = new UsersModel();
				$ContractModel = new ContractModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'salay_type'  => 'statutory',
					'is_fixed'  => $is_fixed,
					'option_title'  => $option_title,
					'contract_amount'  => $contract_amount
				];
				$result = $ContractModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_update_statutory_deduction_success');
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
	public function add_otherpayment() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'contract_tax_option' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'is_fixed' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'option_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contract_amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "contract_tax_option" => $validation->getError('contract_tax_option'),
					"is_fixed" => $validation->getError('is_fixed'),
					"option_title" => $validation->getError('option_title'),
					"contract_amount" => $validation->getError('contract_amount')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$contract_tax_option = $this->request->getPost('contract_tax_option',FILTER_SANITIZE_STRING);
				$is_fixed = $this->request->getPost('is_fixed',FILTER_SANITIZE_STRING);
				$option_title = $this->request->getPost('option_title',FILTER_SANITIZE_STRING);	
				$contract_amount = $this->request->getPost('contract_amount',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				$UsersModel = new UsersModel();
				$ContractModel = new ContractModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'user_id'  => $id,
					'salay_type'  => 'other_payments',
					'contract_tax_option' => $contract_tax_option,
					'is_fixed'  => $is_fixed,
					'option_title'  => $option_title,
					'contract_amount'  => $contract_amount
				];
				$result = $ContractModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_set_reimbursement_success');
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
	public function update_other_payments() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'contract_tax_option' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'is_fixed' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'option_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contract_amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "contract_tax_option" => $validation->getError('contract_tax_option'),
					"is_fixed" => $validation->getError('is_fixed'),
					"option_title" => $validation->getError('option_title'),
					"contract_amount" => $validation->getError('contract_amount')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$contract_tax_option = $this->request->getPost('contract_tax_option',FILTER_SANITIZE_STRING);
				$is_fixed = $this->request->getPost('is_fixed',FILTER_SANITIZE_STRING);
				$option_title = $this->request->getPost('option_title',FILTER_SANITIZE_STRING);	
				$contract_amount = $this->request->getPost('contract_amount',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				$UsersModel = new UsersModel();
				$ContractModel = new ContractModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'salay_type'  => 'other_payments',
					'contract_tax_option' => $contract_tax_option,
					'is_fixed'  => $is_fixed,
					'option_title'  => $option_title,
					'contract_amount'  => $contract_amount
				];
				$result = $ContractModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_update_reimbursement_success');
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
	public function add_document() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'document_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'document_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'document_file' => [
					'rules'  => 'uploaded[document_file]|mime_in[document_file,image/jpg,image/jpeg,image/gif,image/png]|max_size[document_file,5120]',
					'errors' => [
						'uploaded' => lang('Main.xin_error_field_text'),
						'mime_in' => 'wrong size'
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "document_name" => $validation->getError('document_name'),
					"document_type" => $validation->getError('document_type'),
					"document_file" => $validation->getError('document_file')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				$document_file = $this->request->getFile('document_file');
				$file_name = $document_file->getName();
				$document_file->move('public/uploads/documents/');
				
				$document_name = $this->request->getPost('document_name',FILTER_SANITIZE_STRING);
				$document_type = $this->request->getPost('document_type',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id' => $company_id,
					'user_id' => $id,
					'document_name'  => $document_name,
					'document_type'  => $document_type,
					'document_file'  => $file_name,
					'created_at' => date('d-m-Y h:i:s')
				];
				$UserdocumentsModel = new UserdocumentsModel();
				$result = $UserdocumentsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_set_document_success');
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
	public function update_document() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'document_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'document_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "document_name" => $validation->getError('document_name'),
					"document_type" => $validation->getError('document_type')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				 $validated = $this->validate([
					'document_file' => [
						'rules'  => 'uploaded[document_file]|mime_in[document_file,image/jpg,image/jpeg,image/gif,image/png]|max_size[document_file,5120]',
						'errors' => [
							'uploaded' => lang('Asset.xin_error_asset_image_field'),
							'mime_in' => 'wrong size'
						]
					]
				]);
				if ($validated) {
					$document_file = $this->request->getFile('document_file');
					$file_name = $document_file->getName();
					$document_file->move('public/uploads/documents/');
				}
				
				$document_name = $this->request->getPost('document_name',FILTER_SANITIZE_STRING);
				$document_type = $this->request->getPost('document_type',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				
				if ($validated) {
					$data = [
						'document_name'  => $document_name,
						'document_type'  => $document_type,
						'document_file'  => $file_name,
					];
				} else {
					$data = [
						'document_name'  => $document_name,
						'document_type'  => $document_type,
					];
				}
				$UserdocumentsModel = new UserdocumentsModel();
				$result = $UserdocumentsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_update_document_success');
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
	public function update_basic_info() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'first_name' => 'required',
					'last_name' => 'required',
					'contact_number' => 'required',		
					'employee_id' => 'required',			
					'role' => 'required',
				],
				[   // Errors
					'first_name' => [
						'required' => lang('Main.xin_employee_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_employee_error_last_name'),
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_contact_field'),
					],
					'employee_id' => [
						'required' => lang('Employees.xin_employee_error_employee_id'),
					],
					'role' => [
						'required' => lang('Employees.xin_employee_error_staff_role'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('first_name')) {
				$Return['error'] = $validation->getError('first_name');
			} elseif($validation->hasError('last_name')){
				$Return['error'] = $validation->getError('last_name');
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			} elseif($validation->hasError('employee_id')){
				$Return['error'] = $validation->getError('employee_id');
			} elseif($validation->hasError('role')){
				$Return['error'] = $validation->getError('role');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			//staff
			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$role = $this->request->getPost('role',FILTER_SANITIZE_STRING);
			$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
			$state = $this->request->getPost('state',FILTER_SANITIZE_STRING);
			$zipcode = $this->request->getPost('zipcode',FILTER_SANITIZE_STRING);
			$city = $this->request->getPost('city',FILTER_SANITIZE_STRING);
			$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
			$address_1 = $this->request->getPost('address_1',FILTER_SANITIZE_STRING);
			$address_2 = $this->request->getPost('address_2',FILTER_SANITIZE_STRING);
			$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);
			
			// staff details
			$date_of_birth = $this->request->getPost('date_of_birth',FILTER_SANITIZE_STRING);
			$marital_status = $this->request->getPost('marital_status',FILTER_SANITIZE_STRING);
			$religion = $this->request->getPost('religion',FILTER_SANITIZE_STRING);
			$blood_group = $this->request->getPost('blood_group',FILTER_SANITIZE_STRING);
			$citizenship_id = $this->request->getPost('citizenship_id',FILTER_SANITIZE_STRING);
			$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
			
			if(empty($country)){
				$country = 0;
			}
			if(empty($religion)){
				$religion = 0;
			}
			if(empty($citizenship_id)){
				$citizenship_id = 0;
			}
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$UsersModel = new UsersModel();
			$Moduleattributes = new Moduleattributes();
			$Moduleattributesval = new Moduleattributesval();
			$Moduleattributesvalsel = new Moduleattributesvalsel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
				$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',8)->orderBy('custom_field_id', 'ASC')->countAllResults();
				$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',8)->orderBy('custom_field_id', 'ASC')->findAll();
			} else {
				$company_id = $usession['sup_user_id'];
				$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',8)->orderBy('custom_field_id', 'ASC')->countAllResults();
				$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',8)->orderBy('custom_field_id', 'ASC')->findAll();
			}
			$i=1;
			if($count_module_attributes > 0){
				 foreach($module_attributes as $mattribute) {
					 if($mattribute['validation'] == 1){
						 if($this->request->getPost($mattribute['attribute'])=='') {
							$Return['error'] = $mattribute['attribute_label'].' '.lang('Main.xin_field_is_required');
						}
					 }
					 $i++;
				 }		
				 if($Return['error']!=''){
					$this->output($Return);
				}	
			}
			$data = [
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'contact_number'  => $contact_number,
				'country'  => $country,
				'user_role_id' => $role,
				'address_1'  => $address_1,
				'address_2'  => $address_2,
				'city'  => $city,
				'state'  => $state,
				'zipcode' => $zipcode,
				'gender' => $gender,
				'is_active'  => $status
			];
			$result = $UsersModel->update($id, $data);
			// employee details
			$data2 = [
				'employee_id' => $employee_id,
				'date_of_birth' => $date_of_birth,
				'marital_status' => $marital_status,
				'religion_id' => $religion,
				'blood_group' => $blood_group,
				'citizenship_id' => $citizenship_id
			];
			
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$MainModel = new MainModel();
				$MainModel->update_employee_record($data2,$id);
				$Return['result'] = lang('Employees.xin_success_update_employee');
				if($count_module_attributes > 0){
					foreach($module_attributes as $mattribute) {
						
						// update value
						$count_exist_values = $Moduleattributesval->where('user_id',$id)->where('module_attributes_id',$mattribute['custom_field_id'])->countAllResults();
						if($count_exist_values > 0){
							$attr_data = array(
								'attribute_value' => $this->request->getPost($mattribute['attribute']),
							);
							$MainModel->update_attributes_value_record($mattribute['custom_field_id'],$attr_data);
						} else {
							// add value
							if($this->request->getPost($mattribute['attribute']) == ''){
								$file_val = '';
							} else {
								$file_val = $this->request->getPost($mattribute['attribute']);
							}
							$iattr_data = array(
								'company_id' => $company_id,
								'user_id' => $id,
								'module_attributes_id' => $mattribute['custom_field_id'],
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
							$Moduleattributesval->insert($iattr_data);
						}
					}
				}
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// |||update record|||
	public function update_bio() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			//staff details
			$bio = $this->request->getPost('bio',FILTER_SANITIZE_STRING);
			$experience = $this->request->getPost('experience',FILTER_SANITIZE_STRING);
			// set rules
			$validation->setRules([
					'bio' => 'required'
				],
				[   // Errors
					'bio' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('bio')) {
				$Return['error'] = $validation->getError('bio');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$UsersModel = new UsersModel();
			$Moduleattributes = new Moduleattributes();
			$Moduleattributesval = new Moduleattributesval();
			$Moduleattributesvalsel = new Moduleattributesvalsel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
				$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',9)->orderBy('custom_field_id', 'ASC')->countAllResults();
				$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',9)->orderBy('custom_field_id', 'ASC')->findAll();
			} else {
				$company_id = $usession['sup_user_id'];
				$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',9)->orderBy('custom_field_id', 'ASC')->countAllResults();
				$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',9)->orderBy('custom_field_id', 'ASC')->findAll();
			}
			$i=1;
			if($count_module_attributes > 0){
				 foreach($module_attributes as $mattribute) {
					 if($mattribute['validation'] == 1){
						 if($this->request->getPost($mattribute['attribute'])=='') {
							$Return['error'] = $mattribute['attribute_label'].' '.lang('Main.xin_field_is_required');
						}
					 }
					 $i++;
				 }		
				 if($Return['error']!=''){
					$this->output($Return);
				}	
			}
			// employee details
			$data = [
				'bio' => $bio,
				'experience' => $experience,
			];
			$MainModel = new MainModel();
			$result = $MainModel->update_employee_record($data,$id);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Success.employee_update_bio_success');
				if($count_module_attributes > 0){
					foreach($module_attributes as $mattribute) {
						// update value
						$count_exist_values = $Moduleattributesval->where('user_id',$id)->where('module_attributes_id',$mattribute['custom_field_id'])->countAllResults();
						if($count_exist_values > 0){
							$attr_data = array(
								'attribute_value' => $this->request->getPost($mattribute['attribute']),
							);
							$MainModel->update_attributes_value_record($mattribute['custom_field_id'],$attr_data);
						} else {
							// add value
							if($this->request->getPost($mattribute['attribute']) == ''){
								$file_val = '';
							} else {
								$file_val = $this->request->getPost($mattribute['attribute']);
							}
							$iattr_data = array(
								'company_id' => $company_id,
								'user_id' => $id,
								'module_attributes_id' => $mattribute['custom_field_id'],
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
							$Moduleattributesval->insert($iattr_data);
						}
					}
				}
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// |||update record|||
	public function update_social() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			//staff details
			$fb_profile = $this->request->getPost('fb_profile',FILTER_SANITIZE_STRING);
			$twitter_profile = $this->request->getPost('twitter_profile',FILTER_SANITIZE_STRING);
			$gplus_profile = $this->request->getPost('gplus_profile',FILTER_SANITIZE_STRING);
			$linkedin_profile = $this->request->getPost('linkedin_profile',FILTER_SANITIZE_STRING);
			
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$UsersModel = new UsersModel();
			// employee details
			$data = [
				'fb_profile' => $fb_profile,
				'twitter_profile' => $twitter_profile,
				'gplus_profile' => $gplus_profile,
				'linkedin_profile' => $linkedin_profile,
			];
			$MainModel = new MainModel();
			$result = $MainModel->update_employee_record($data,$id);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				
				$Return['result'] = lang('Success.employee_update_social_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// |||update record|||
	public function update_bankinfo() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			//staff details
			$account_title = $this->request->getPost('account_title',FILTER_SANITIZE_STRING);
			$account_number = $this->request->getPost('account_number',FILTER_SANITIZE_STRING);
			$bank_name = $this->request->getPost('bank_name',FILTER_SANITIZE_STRING);
			$iban = $this->request->getPost('iban',FILTER_SANITIZE_STRING);
			$swift_code = $this->request->getPost('swift_code',FILTER_SANITIZE_STRING);
			$bank_branch = $this->request->getPost('bank_branch',FILTER_SANITIZE_STRING);
			
			// set rules
			$validation->setRules([
					'account_title' => 'required',
					'account_number' => 'required',
					'bank_name' => 'required',				
					'iban' => 'required',
					'swift_code' => 'required',
					'bank_branch' => 'required'
				],
				[   // Errors
					'account_title' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'account_number' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'bank_name' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'iban' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'swift_code' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'bank_branch' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('account_title')) {
				$Return['error'] = $validation->getError('account_title');
			} else if ($validation->hasError('account_number')) {
				$Return['error'] = $validation->getError('account_number');
			} else if ($validation->hasError('bank_name')) {
				$Return['error'] = $validation->getError('bank_name');
			} else if ($validation->hasError('iban')) {
				$Return['error'] = $validation->getError('iban');
			} else if ($validation->hasError('swift_code')) {
				$Return['error'] = $validation->getError('swift_code');
			} else if ($validation->hasError('bank_branch')) {
				$Return['error'] = $validation->getError('bank_branch');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$UsersModel = new UsersModel();
			// employee details
			$data = [
				'account_title' => $account_title,
				'account_number' => $account_number,
				'bank_name' => $bank_name,
				'iban' => $iban,
				'swift_code' => $swift_code,
				'bank_branch' => $bank_branch,
			];
			$MainModel = new MainModel();
			$result = $MainModel->update_employee_record($data,$id);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				
				$Return['result'] = lang('Success.employee_update_bankinfo_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// |||update record|||
	public function update_contact_info() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			//staff details
			$contact_full_name = $this->request->getPost('contact_full_name',FILTER_SANITIZE_STRING);
			$contact_phone_no = $this->request->getPost('contact_phone_no',FILTER_SANITIZE_STRING);
			$contact_email = $this->request->getPost('contact_email',FILTER_SANITIZE_STRING);
			$contact_address = $this->request->getPost('contact_address',FILTER_SANITIZE_STRING);
			// set rules
			$validation->setRules([
					'contact_full_name' => 'required',
					'contact_phone_no' => 'required',
					'contact_email' => 'required',
					'contact_address' => 'required'
				],
				[   // Errors
					'contact_full_name' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'contact_phone_no' => [
						'required' => lang('Main.xin_error_contact_field'),
					],
					'contact_email' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'contact_address' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('contact_full_name')) {
				$Return['error'] = $validation->getError('contact_full_name');
			} else if ($validation->hasError('contact_phone_no')) {
				$Return['error'] = $validation->getError('contact_phone_no');
			} else if ($validation->hasError('contact_email')) {
				$Return['error'] = $validation->getError('contact_email');
			} else if ($validation->hasError('contact_address')) {
				$Return['error'] = $validation->getError('contact_address');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$UsersModel = new UsersModel();
			// employee details
			$data = [
				'contact_full_name' => $contact_full_name,
				'contact_phone_no' => $contact_phone_no,
				'contact_email' => $contact_email,
				'contact_address' => $contact_address,
			];
			$MainModel = new MainModel();
			$result = $MainModel->update_employee_record($data,$id);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				
				$Return['result'] = lang('Success.employee_update_emergency_contact_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// |||update record|||
	public function update_company_info() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'first_name' => 'required',
					'last_name' => 'required',
					'email' => 'required|valid_email',
					'username' => 'required|min_length[6]',
					'department_id' => 'required',
					'designation_id' => 'required',
					'employee_id' => 'required',
					'contact_number' => 'required',
					'office_shift_id' => 'required',					
					'role' => 'required'
				],
				[   // Errors
					'first_name' => [
						'required' => lang('Main.xin_employee_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_employee_error_last_name'),
					],
					'employee_id' => [
						'required' => lang('Employees.xin_employee_error_employee_id'),
					],
					'office_shift_id' => [
						'required' => lang('Employees.xin_office_shift_field_error'),
					],
					'email' => [
						'required' => lang('Main.xin_employee_error_email'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email')
					],
					'department_id' => [
						'required' => lang('Employees.xin_employee_error_department'),
					],
					'designation_id' => [
						'required' => lang('Employees.xin_employee_error_designation'),
					],
					'username' => [
						'required' => lang('Main.xin_employee_error_username'),
						'min_length' => lang('Main.xin_min_error_username')
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_contact_field'),
					],
					'role' => [
						'required' => lang('Employees.xin_employee_error_staff_role'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('first_name')) {
				$Return['error'] = $validation->getError('first_name');
			} elseif($validation->hasError('last_name')){
				$Return['error'] = $validation->getError('last_name');
			} elseif($validation->hasError('email')){
				$Return['error'] = $validation->getError('email');
			} elseif($validation->hasError('username')){
				$Return['error'] = $validation->getError('username');
			} elseif($validation->hasError('department_id')){
				$Return['error'] = $validation->getError('department_id');
			} elseif($validation->hasError('designation_id')){
				$Return['error'] = $validation->getError('designation_id');
			} elseif($validation->hasError('employee_id')) {
				$Return['error'] = $validation->getError('employee_id');
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			} elseif($validation->hasError('office_shift_id')) {
				$Return['error'] = $validation->getError('office_shift_id');
			} elseif($validation->hasError('role')){
				$Return['error'] = $validation->getError('role');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			//staff
			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$username = $this->request->getPost('username',FILTER_SANITIZE_STRING);
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$role = $this->request->getPost('role',FILTER_SANITIZE_STRING);
			$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
			$state = $this->request->getPost('state',FILTER_SANITIZE_STRING);
			$zipcode = $this->request->getPost('zipcode',FILTER_SANITIZE_STRING);
			$city = $this->request->getPost('city',FILTER_SANITIZE_STRING);
			$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
			$address_1 = $this->request->getPost('address_1',FILTER_SANITIZE_STRING);
			$address_2 = $this->request->getPost('address_2',FILTER_SANITIZE_STRING);
			$country_id = $this->request->getPost('country',FILTER_SANITIZE_STRING);
			
			// staff details
			$cat_ids = implode(',',$this->request->getPost('leave_categories',FILTER_SANITIZE_STRING));
			$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
			$office_shift_id = $this->request->getPost('office_shift_id',FILTER_SANITIZE_STRING);
			$department_id = $this->request->getPost('department_id',FILTER_SANITIZE_STRING);
			$designation_id = $this->request->getPost('designation_id',FILTER_SANITIZE_STRING);
			$date_of_joining = $this->request->getPost('date_of_joining',FILTER_SANITIZE_STRING);
			$date_of_leaving = $this->request->getPost('date_of_leaving',FILTER_SANITIZE_STRING);
			$date_of_birth = $this->request->getPost('date_of_birth',FILTER_SANITIZE_STRING);
			$marital_status = $this->request->getPost('marital_status',FILTER_SANITIZE_STRING);
			$religion = $this->request->getPost('religion',FILTER_SANITIZE_STRING);
			$blood_group = $this->request->getPost('blood_group',FILTER_SANITIZE_STRING);
			$citizenship_id = $this->request->getPost('citizenship_id',FILTER_SANITIZE_STRING);
			
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$UsersModel = new UsersModel();
			$data = [
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'email'  => $email,
				'username'  => $username,
				'contact_number'  => $contact_number,
				'country'  => $country_id,
				'user_role_id' => $role,
				'address_1'  => $address_1,
				'address_2'  => $address_2,
				'city'  => $city,
				'state'  => $state,
				'zipcode' => $zipcode,
				'gender' => $gender,
				'is_active'  => $status
			];
			$result = $UsersModel->update($id, $data);
			// employee details
			$data2 = [
				'employee_id'  => $employee_id,
				'department_id'  => $department_id,
				'designation_id'  => $designation_id,
				'office_shift_id' => $office_shift_id,
				'leave_categories'  => $cat_ids,
				'date_of_joining' => $date_of_joining,
				'date_of_leaving' => $date_of_leaving,
				'date_of_birth' => $date_of_birth,
				'marital_status' => $marital_status,
				'religion_id' => $religion,
				'blood_group' => $blood_group,
				'citizenship_id' => $citizenship_id
			];
			
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$MainModel = new MainModel();
				$MainModel->update_employee_record($data2,$id);
				$Return['result'] = lang('Employees.xin_success_update_employee');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// |||update record|||
	public function update_contract_info() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'contract_date' => 'required',
					'department_id' => 'required',
					'designation_id' => 'required',
					'basic_salary' => 'required',
					'salay_type' => 'required',
					'office_shift_id' => 'required',					
					'role_description' => 'required'
				],
				[   // Errors
					'contract_date' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'department_id' => [
						'required' => lang('Employees.xin_employee_error_department'),
					],
					'designation_id' => [
						'required' => lang('Employees.xin_employee_error_designation'),
					],
					'basic_salary' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'salay_type' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'office_shift_id' => [
						'required' => lang('Employees.xin_office_shift_field_error'),
					],
					'role_description' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('contract_date')) {
				$Return['error'] = $validation->getError('contract_date');
			} elseif($validation->hasError('department_id')){
				$Return['error'] = $validation->getError('department_id');
			} elseif($validation->hasError('designation_id')){
				$Return['error'] = $validation->getError('designation_id');
			} elseif($validation->hasError('basic_salary')) {
				$Return['error'] = $validation->getError('basic_salary');
			} elseif($validation->hasError('salay_type')){
				$Return['error'] = $validation->getError('salay_type');
			} elseif($validation->hasError('office_shift_id')) {
				$Return['error'] = $validation->getError('office_shift_id');
			} elseif($validation->hasError('role_description')){
				$Return['error'] = $validation->getError('role_description');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			//staff details
			$date_of_joining = $this->request->getPost('contract_date',FILTER_SANITIZE_STRING);
			$department_id = $this->request->getPost('department_id',FILTER_SANITIZE_STRING);
			$designation_id = $this->request->getPost('designation_id',FILTER_SANITIZE_STRING);
			$basic_salary = $this->request->getPost('basic_salary',FILTER_SANITIZE_STRING);
			$hourly_rate = $this->request->getPost('hourly_rate',FILTER_SANITIZE_STRING);
			$salay_type = $this->request->getPost('salay_type',FILTER_SANITIZE_STRING);
			$office_shift_id = $this->request->getPost('office_shift_id',FILTER_SANITIZE_STRING);
			$role_description = $this->request->getPost('role_description',FILTER_SANITIZE_STRING);
			$date_of_leaving = $this->request->getPost('contract_end',FILTER_SANITIZE_STRING);
			$cat_ids = implode(',',$this->request->getPost('leave_categories'));
			
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$MainModel = new MainModel();
			$UsersModel = new UsersModel();
			$Moduleattributes = new Moduleattributes();
			$Moduleattributesval = new Moduleattributesval();
			$Moduleattributesvalsel = new Moduleattributesvalsel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
				$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',5)->orderBy('custom_field_id', 'ASC')->countAllResults();
				$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',5)->orderBy('custom_field_id', 'ASC')->findAll();
			} else {
				$company_id = $usession['sup_user_id'];
				$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',5)->orderBy('custom_field_id', 'ASC')->countAllResults();
				$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',5)->orderBy('custom_field_id', 'ASC')->findAll();
			}
			$i=1;
			if($count_module_attributes > 0){
				 foreach($module_attributes as $mattribute) {
					 if($mattribute['validation'] == 1){
						 if($this->request->getPost($mattribute['attribute'])=='') {
							$Return['error'] = $mattribute['attribute_label'].' '.lang('Main.xin_field_is_required');
						}
					 }
					 $i++;
				 }		
				 if($Return['error']!=''){
					$this->output($Return);
				}	
			}
			// employee details
			$data2 = [
				'date_of_joining'  => $date_of_joining,
				'department_id'  => $department_id,
				'designation_id'  => $designation_id,
				'office_shift_id' => $office_shift_id,
				'basic_salary'  => $basic_salary,
				'hourly_rate'  => $hourly_rate,
				'salay_type' => $salay_type,
				'leave_categories' => $cat_ids,
				'date_of_leaving' => $date_of_leaving,
				'role_description' => $role_description,
			];
			$MainModel = new MainModel();
			$result = $MainModel->update_employee_record($data2,$id);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				if($count_module_attributes > 0){
					foreach($module_attributes as $mattribute) {
						
						// update value
						$count_exist_values = $Moduleattributesval->where('user_id',$id)->where('module_attributes_id',$mattribute['custom_field_id'])->countAllResults();
						if($count_exist_values > 0){
							$attr_data = array(
								'attribute_value' => $this->request->getPost($mattribute['attribute']),
							);
							$MainModel->update_attributes_value_record($mattribute['custom_field_id'],$attr_data);
						} else {
							// add value
							if($this->request->getPost($mattribute['attribute']) == ''){
								$file_val = '';
							} else {
								$file_val = $this->request->getPost($mattribute['attribute']);
							}
							$iattr_data = array(
								'company_id' => $company_id,
								'user_id' => $id,
								'module_attributes_id' => $mattribute['custom_field_id'],
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
							$Moduleattributesval->insert($iattr_data);
						}
					}
				}
				$Return['result'] = lang('Success.employee_update_contract_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// |||update record|||
	public function update_account_info() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'email' => 'required|valid_email',
					'username' => 'required|min_length[6]',
				],
				[   // Errors
					'email' => [
						'required' => lang('Main.xin_employee_error_email'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email')
					],
					'username' => [
						'required' => lang('Main.xin_employee_error_username'),
						'min_length' => lang('Main.xin_min_error_username')
					],
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if($validation->hasError('email')){
				$Return['error'] = $validation->getError('email');
			} elseif($validation->hasError('username')){
				$Return['error'] = $validation->getError('username');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			//staff
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$username = $this->request->getPost('username',FILTER_SANITIZE_STRING);			
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$UsersModel = new UsersModel();
			$data = [
				'email'  => $email,
				'username'  => $username,
			];
			$result = $UsersModel->update($id, $data);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Success.employee_update_accountinfo_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// update record
	public function update_profile_photo() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			$image = service('image');
			// set rules
			$validated = $this->validate([
				'file' => [
					'uploaded[file]',
					'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
					'max_size[file,4096]',
				],
			]);
			if (!$validated) {
				$Return['error'] = lang('Main.xin_error_profile_picture_field');
			} else {
				$avatar = $this->request->getFile('file');
				$file_name = $avatar->getName();
				$avatar->move('public/uploads/users/');
				$image->withFile(filesrc($file_name))
				->fit(100, 100, 'center')
				->save('public/uploads/users/thumb/'.$file_name);
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			if ($validated) {
				$UsersModel = new UsersModel();
				$Return['result'] = lang('Main.xin_profile_picture_success_updated');
				$data = [
					'profile_photo'  => $file_name
				];
				$result = $UsersModel->update($id, $data);
				$Return['csrf_hash'] = csrf_hash();	
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	} 
	// update record
	public function update_password() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					//'current_password' => 'required|is_not_unique[xin_users.password]',
					'new_password' => 'required|min_length[6]',
					'confirm_password' => 'required|matches[new_password]',
				],
				[   // Errors
					'new_password' => [
						'required' => lang('Main.xin_error_new_password_field'),
						'min_length' => lang('Main.xin_error_new_password_short_field'),
					],
					'confirm_password' => [
						'required' => lang('Main.xin_error_confirm_password_field'),
						'matches' => lang('Main.xin_error_confirm_password_matches_field'),
					]
				]
			);
			$UsersModel = new UsersModel();
			$validation->withRequest($this->request)->run();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			//check error
			$new_password = $this->request->getPost('new_password',FILTER_SANITIZE_STRING);
			if($validation->hasError('new_password')){
				$Return['error'] = $validation->getError('new_password');
			} elseif($validation->hasError('confirm_password')){
				$Return['error'] = $validation->getError('confirm_password');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
			
			$options = array('cost' => 12);
			$password_hash = password_hash($new_password, PASSWORD_BCRYPT, $options);
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$data = [
				'password' => $password_hash,
			];
			
			$result = $UsersModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_success_new_password_field');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
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
			return view('erp/employees/get_designations', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	 }
	// read record
	public function dialog_user_data()
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
			return view('erp/employees/dialog_employee_details', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	} 
	// delete record
	public function delete_all_allowances() {
		
		$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			if($this->request->getPost('_method')=='DELETE') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ContractModel = new ContractModel();
			$result = $ContractModel->where('contract_option_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.employee_delete_allowance_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// delete record
	public function delete_all_commissions() {
		
		$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			if($this->request->getPost('_method')=='DELETE') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ContractModel = new ContractModel();
			$result = $ContractModel->where('contract_option_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.employee_delete_commission_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// delete record
	public function delete_all_statutory_deductions() {
		
		$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			if($this->request->getPost('_method')=='DELETE') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ContractModel = new ContractModel();
			$result = $ContractModel->where('contract_option_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.employee_delete_statutory_deduction_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// delete record
	public function delete_all_other_payments() {
		
		$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			if($this->request->getPost('_method')=='DELETE') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ContractModel = new ContractModel();
			$result = $ContractModel->where('contract_option_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.employee_delete_reimbursement_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// delete record
	public function delete_document() {
		
		$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			if($this->request->getPost('_method')=='DELETE') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$UserdocumentsModel = new UserdocumentsModel();
			$result = $UserdocumentsModel->where('document_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.employee_delete_document_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	// delete record
	public function delete_staff() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $UsersModel->where('user_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.employee_deleted_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

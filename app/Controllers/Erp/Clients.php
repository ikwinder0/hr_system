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
use App\Models\LeadsModel;
use App\Models\CountryModel;
use App\Models\LeadsfollowupModel;
use App\Models\EmailtemplatesModel;

class Clients extends BaseController {

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
			if(!in_array('client1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Projects.xin_manage_clients').' | '.$xin_system['application_name'];
		$data['path_url'] = 'clients';
		$data['breadcrumbs'] = lang('Projects.xin_manage_clients');

		$data['subview'] = view('erp/clients/clients_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function leads_index()
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
			if(!in_array('leads1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_leads').' | '.$xin_system['application_name'];
		$data['path_url'] = 'leads';
		$data['breadcrumbs'] = lang('Dashboard.xin_leads');

		$data['subview'] = view('erp/clients/leads_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function clients_grid()
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
			if(!in_array('client1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Projects.xin_manage_clients').' | '.$xin_system['application_name'];
		$data['path_url'] = 'clients_grid';
		$data['breadcrumbs'] = lang('Projects.xin_manage_clients');

		$data['subview'] = view('erp/clients/clients_grid', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function client_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $UsersModel->where('user_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
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
			if(!in_array('client1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_client_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'client_details';
		$data['breadcrumbs'] = lang('Main.xin_client_details');

		$data['subview'] = view('erp/clients/client_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function lead_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $UsersModel->where('user_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
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
			if(!in_array('client1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_lead_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'lead_details';
		$data['breadcrumbs'] = lang('Main.xin_lead_details');

		$data['subview'] = view('erp/clients/lead_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// list
	public function clients_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$UsersModel = new UsersModel();
		$RolesModel = new RolesModel();
		$SystemModel = new SystemModel();
		$CountryModel = new CountryModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$staff = $UsersModel->where('company_id',$user_info['company_id'])->where('user_type','customer')->orderBy('user_id', 'ASC')->findAll();
		} else {
			$staff = $UsersModel->where('company_id',$usession['sup_user_id'])->where('user_type','customer')->orderBy('user_id', 'ASC')->findAll();
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
		$data = array();
		
          foreach($staff as $r) {						
		  			
				if(in_array('client3',staff_role_resource()) || $user_info['user_type'] == 'company') {
					$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/view-client-info').'/'.uencode($r['user_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
				} else{
					$edit = '';
				}
				if(in_array('client4',staff_role_resource()) || $user_info['user_type'] == 'company') {
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['user_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
				} else {
					$delete = '';
				}

			if($r['is_active'] == 1){
				$status = '<span class="badge badge-light-success">'.lang('Main.xin_employees_active').'</span>';
			} else if($r['is_active'] == 2){
				$status = '<span class="badge badge-light-danger">'.lang('Main.xin_employees_inactive').'</span>';
			}
			if($r['gender'] == 1){
				$gender = lang('Main.xin_gender_male');
			} else {
				$gender = lang('Main.xin_gender_female');
			}
			$country_info = $CountryModel->where('country_id', $r['country'])->first();
			$name = $r['first_name'].' '.$r['last_name'];
			$uname = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/clients/thumb/'.$r['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$name.'</h6>
					<p class="m-b-0">'.$r['email'].'</p>
				</div>
			</div>';
			$combhr = $edit.$delete;
			if(in_array('client3',staff_role_resource()) || in_array('client4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$links = '
				'.$uname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
					 			  				
			} else {
				$links = $uname;
			}
			
									 			  				
			$data[] = array(
				$links,
				$r['username'],
				$r['contact_number'],
				$gender,
				$country_info['country_name'],
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
	 // list
	public function leads_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$UsersModel = new UsersModel();
		$LeadsModel = new LeadsModel();
		$RolesModel = new RolesModel();
		$SystemModel = new SystemModel();
		$CountryModel = new CountryModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$staff = $LeadsModel->where('company_id',$user_info['company_id'])->orderBy('lead_id', 'ASC')->findAll();
		} else {
			$staff = $LeadsModel->where('company_id',$usession['sup_user_id'])->orderBy('lead_id', 'ASC')->findAll();
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
		$data = array();
		
          foreach($staff as $r) {						
		  			
				if(in_array('leads3',staff_role_resource()) || $user_info['user_type'] == 'company') {
					$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/view-lead-info').'/'.uencode($r['lead_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
				} else{
					$edit = '';
				}
				if(in_array('leads5',staff_role_resource()) || $user_info['user_type'] == 'company') {
					if($r['status'] == 1){
						$change = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_change_to_client').'"><button type="button" class="btn icon-btn btn-sm btn-light-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['lead_id']) . '"><i class="feather icon-shuffle"></i></button></span>';
					} else {
						$change = '';
					}
				} else{
					$change = '';
				}
				if(in_array('leads4',staff_role_resource()) || $user_info['user_type'] == 'company') {
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['lead_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
				} else {
					$delete = '';
				}
				$count_leads_followup = count_leads_followup($r['lead_id']);

			if($r['status'] == 1){
				$status = '<span class="badge badge-light-primary">'.lang('Dashboard.xin_lead').'</span>';
				if($count_leads_followup > 0){
					$cfollowup = '<br><span class="badge badge-light-warning">'.lang('Main.xin_follow_up').'</span>';
				} else {
					$cfollowup = '';
				}
				$status = $status.$cfollowup;
			} else {
				$status = '<span class="badge badge-light-success">'.lang('Projects.xin_client').'</span>';
			}
			if($r['gender'] == 1){
				$gender = lang('Main.xin_gender_male');
			} else {
				$gender = lang('Main.xin_gender_female');
			}
			$country_info = $CountryModel->where('country_id', $r['country'])->first();
			$name = $r['first_name'].' '.$r['last_name'];
			$uname = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/clients/thumb/'.$r['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$name.'</h6>
					<p class="m-b-0">'.$r['email'].'</p>
				</div>
			</div>';
			$combhr = $edit.$change.$delete;
			if(in_array('leads3',staff_role_resource()) || in_array('leads4',staff_role_resource()) || in_array('leads5',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$links = '
				'.$uname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
					 			  				
			} else {
				$links = $uname;
			}
			
									 			  				
			$data[] = array(
				$links,
				$r['contact_number'],
				$gender,
				$country_info['country_name'],
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
	  // list
	public function leads_followup_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$UsersModel = new UsersModel();
		$LeadsfollowupModel = new LeadsfollowupModel();
		$RolesModel = new RolesModel();
		$SystemModel = new SystemModel();
		$CountryModel = new CountryModel();
		
		$lead_id = udecode($this->request->getVar('xlead_id',FILTER_SANITIZE_STRING));
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$followup = $LeadsfollowupModel->where('company_id',$user_info['company_id'])->where('lead_id',$lead_id)->orderBy('followup_id', 'ASC')->findAll();
		} else {
			$followup = $LeadsfollowupModel->where('company_id',$usession['sup_user_id'])->where('lead_id',$lead_id)->orderBy('followup_id', 'ASC')->findAll();
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
		$data = array();
		
          foreach($followup as $r) {
					
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['followup_id']) . '"><i class="feather icon-edit"></i></button></span>';
		
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['followup_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
					
			$combhr = $edit.$delete;
			$created_at = set_date_format($r['created_at']);
			$next_followup = set_date_format($r['next_followup']);
			$inext_followup = '
			'.$next_followup.'
			<div class="overlay-edit">
				'.$combhr.'
			</div>';
			
									 			  				
			$data[] = array(
				$inext_followup,
				$r['description'],
				$created_at,
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
	public function add_followup() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'next_follow_up' => [
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
                    "next_follow_up" => $validation->getError('next_follow_up'),
					 "description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$lead_id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$next_follow_up = $this->request->getPost('next_follow_up',FILTER_SANITIZE_STRING);	
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);		
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'lead_id'  => $lead_id,
					'company_id' => $company_id,
					'next_followup'  => $next_follow_up,
					'description'  => $description,
					'created_at' => date('d-m-Y h:i:s')
				];
				$LeadsfollowupModel = new LeadsfollowupModel();
				$result = $LeadsfollowupModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_lead_followup_added_msg');
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
	public function update_followup() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'next_follow_up' => [
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
                    "next_follow_up" => $validation->getError('next_follow_up'),
					 "description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$next_follow_up = $this->request->getPost('next_follow_up',FILTER_SANITIZE_STRING);	
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);		
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				$data = [
					'next_followup'  => $next_follow_up,
					'description'  => $description,
				];
				$LeadsfollowupModel = new LeadsfollowupModel();
				$result = $LeadsfollowupModel->update($id, $data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_lead_followup_updated_msg');
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
	public function add_client() {
			
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
			$validation->setRules([
					'first_name' => 'required',
					'last_name' => 'required',
					'email' => 'required|valid_email|is_unique[ci_erp_users.email]',
					'username' => 'required|min_length[6]|is_unique[ci_erp_users.username]',
					'password' => 'required|min_length[6]',
					'contact_number' => 'required'
				],
				[   // Errors
					'first_name' => [
						'required' => lang('Main.xin_employee_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_employee_error_last_name'),
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
			} elseif($validation->hasError('password')){
				$Return['error'] = $validation->getError('password');
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
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
				//$image = service('image');
				$avatar = $this->request->getFile('file');
				$file_name = $avatar->getName();
				$avatar->move('public/uploads/clients/');
				$image->withFile(filecsrc($file_name))
				->fit(100, 100, 'center')
				->save('public/uploads/clients/thumb/'.$file_name);
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
			$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
			$options = array('cost' => 12);
			$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
			
			$UsersModel = new UsersModel();
			$SystemModel = new SystemModel();
			$EmailtemplatesModel = new EmailtemplatesModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
				$iuser_info = $UsersModel->where('company_id', $company_id)->first();
			} else {
				$company_id = $usession['sup_user_id'];
				$iuser_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			}
			$xin_system = $SystemModel->where('setting_id', 1)->first();
			$data = [
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'email'  => $email,
				'user_type'  => 'customer',
				'username'  => $username,
				'password'  => $password_hash,
				'contact_number'  => $contact_number,
				'country'  => 0,
				'user_role_id' => 0,
				'address_1'  => '',
				'address_2'  => '',
				'city'  =>'',
				'profile_photo'  => $file_name,
				'state'  => '',
				'zipcode' => '',
				'gender' => $gender,
				'company_name' => $iuser_info['company_name'],
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
			$result = $UsersModel->insert($data);			
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_client_added_msg');
				if($xin_system['enable_email_notification'] == 1){
					// Send mail start
					$itemplate = $EmailtemplatesModel->where('template_id', 5)->first();
					$isubject = $itemplate['subject'];
					$ibody = html_entity_decode($itemplate['message']);
					$fbody = str_replace(array("{site_name}","{user_password}","{user_username}","{site_url}"),array($xin_system['company_name'],$password,$username,site_url()),$ibody);
					timehrm_mail_data($xin_system['email'],$xin_system['company_name'],$email,$isubject,$fbody);
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
	// |||add record|||
	public function add_lead() {
			
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
			$validation->setRules([
					'first_name' => 'required',
					'last_name' => 'required',
					'email' => 'required|valid_email|is_unique[ci_erp_users.email]',
					'contact_number' => 'required'
				],
				[   // Errors
					'first_name' => [
						'required' => lang('Main.xin_employee_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_employee_error_last_name'),
					],
					'email' => [
						'required' => lang('Main.xin_employee_error_email'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email'),
						'is_unique' => lang('Main.xin_already_exist_error_email'),
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_contact_field'),
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
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			//$image = service('image');
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
				
				$avatar = $this->request->getFile('file');
				$file_name = $avatar->getName();
				$avatar->move('public/uploads/clients/');
				
				$image->withFile(filecsrc($file_name))
				->fit(100, 100, 'center')
				->save('public/uploads/clients/thumb/'.$file_name);
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
				
			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
			
			$UsersModel = new UsersModel();
			$LeadsModel = new LeadsModel();
			$SystemModel = new SystemModel();
			//$EmailtemplatesModel = new EmailtemplatesModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
				//$iuser_info = $UsersModel->where('company_id', $company_id)->first();
			} else {
				$company_id = $usession['sup_user_id'];
				//$iuser_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			}
			
			$xin_system = $SystemModel->where('setting_id', 1)->first();
			$data = [
				'company_id'  => $company_id,
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'email'  => $email,
				'profile_photo'  => $file_name,
				'contact_number'  => $contact_number,
				'gender' => $gender,
				'address_1'  => '',
				'address_2'  => '',
				'city'  =>'',
				'state'  => '',
				'zipcode' => '',
				'country'  => 0,
				'status'  => 1,
				'created_at' => date('d-m-Y h:i:s')
			];
			$result = $LeadsModel->insert($data);			
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_lead_added_msg');
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
	public function update_lead() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'first_name' => 'required',
					'last_name' => 'required',
					'email' => 'required|valid_email',
					'contact_number' => 'required',
					'country' => 'required',
				],
				[   // Errors
					'first_name' => [
						'required' => lang('Main.xin_employee_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_employee_error_last_name'),
					],
					'email' => [
						'required' => lang('Main.xin_employee_error_email'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email')
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_subscription_field'),
					],
					'country' => [
						'required' => lang('Main.xin_error_country_field'),
					],
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
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			} elseif($validation->hasError('country')){
				$Return['error'] = $validation->getError('country');
			} 
			if($Return['error']!=''){
				$this->output($Return);
			}

			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);
			$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
			$address_1 = $this->request->getPost('address_1',FILTER_SANITIZE_STRING);
			$address_2 = $this->request->getPost('address_2',FILTER_SANITIZE_STRING);
			$city = $this->request->getPost('city',FILTER_SANITIZE_STRING);
			$state = $this->request->getPost('state',FILTER_SANITIZE_STRING);
			$zipcode = $this->request->getPost('zipcode',FILTER_SANITIZE_STRING);
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
			$data = [
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'email'  => $email,
				'contact_number'  => $contact_number,
				'country'  => $country,
				'address_1'  => $address_1,
				'address_2'  => $address_2,
				'city'  => $city,
				'state'  => $state,
				'zipcode' => $zipcode,
				'gender' => $gender,
			];
			$LeadsModel = new LeadsModel();
			$result = $LeadsModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_lead_updated_msg');
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
	public function update_client() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'first_name' => 'required',
					'last_name' => 'required',
					'email' => 'required|valid_email',
					'username' => 'required|min_length[6]',
					'contact_number' => 'required',
					'country' => 'required',
					'status' => 'required'
				],
				[   // Errors
					'first_name' => [
						'required' => lang('Main.xin_employee_error_first_name'),
					],
					'last_name' => [
						'required' => lang('Main.xin_employee_error_last_name'),
					],
					'email' => [
						'required' => lang('Main.xin_employee_error_email'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email')
					],
					'username' => [
						'required' => lang('Main.xin_employee_error_username'),
						'min_length' => lang('Main.xin_min_error_username')
					],
					'contact_number' => [
						'required' => lang('Main.xin_error_subscription_field'),
					],
					'country' => [
						'required' => lang('Main.xin_error_country_field'),
					],
					'status' => [
						'required' => lang('Main.xin_error_field_text'),
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
			} elseif($validation->hasError('status')){
				$Return['error'] = $validation->getError('status');
			} elseif($validation->hasError('contact_number')){
				$Return['error'] = $validation->getError('contact_number');
			} elseif($validation->hasError('country')){
				$Return['error'] = $validation->getError('country');
			} 
			if($Return['error']!=''){
				$this->output($Return);
			}

			$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
			$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
			$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
			$username = $this->request->getPost('username',FILTER_SANITIZE_STRING);
			$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
			$country = $this->request->getPost('country',FILTER_SANITIZE_STRING);
			$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
			$address_1 = $this->request->getPost('address_1',FILTER_SANITIZE_STRING);
			$address_2 = $this->request->getPost('address_2',FILTER_SANITIZE_STRING);
			$city = $this->request->getPost('city',FILTER_SANITIZE_STRING);
			$state = $this->request->getPost('state',FILTER_SANITIZE_STRING);
			$zipcode = $this->request->getPost('zipcode',FILTER_SANITIZE_STRING);
			$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
			$data = [
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'email'  => $email,
				'username'  => $username,
				'contact_number'  => $contact_number,
				'country'  => $country,
				'user_role_id' => 0,
				'address_1'  => $address_1,
				'address_2'  => $address_2,
				'city'  => $city,
				'state'  => $state,
				'zipcode' => $zipcode,
				'gender' => $gender,
				'is_active'  => $status,
			];
			$UsersModel = new UsersModel();
			$result = $UsersModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_client_updated_msg');
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
	public function update_client_status() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'status' => 'required'
				],
				[   // Errors
					'status' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if($validation->hasError('status')){
				$Return['error'] = $validation->getError('status');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
			$data = [
				'is_active'  => $status,
			];
			$UsersModel = new UsersModel();
			$result = $UsersModel->update($id, $data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_client_status_updated_msg');
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
				$avatar->move('public/uploads/clients/');
				$image->withFile(filesrc($file_name))
				->fit(100, 100, 'center')
				->save('public/uploads/clients/thumb/'.$file_name);
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
	public function update_lead_profile_photo() {
			
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
				$avatar->move('public/uploads/clients/');
				$image->withFile(filesrc($file_name))
				->fit(100, 100, 'center')
				->save('public/uploads/clients/thumb/'.$file_name);
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			if ($validated) {
				$LeadsModel = new LeadsModel();
				$Return['result'] = lang('Main.xin_profile_picture_success_updated');
				$data = [
					'profile_photo'  => $file_name
				];
				$result = $LeadsModel->update($id, $data);
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
	public function update_password_opt() {
			
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
				$Return['result'] = lang('Main.xin_success_user_password_field');
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
	
	// |||add record|||
	public function convert_lead() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type',FILTER_SANITIZE_STRING) === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();	
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$data = [
				'status'  => 2,
			];
			$UsersModel = new UsersModel();
			$LeadsModel = new LeadsModel();
			$result = $LeadsModel->update($id,$data);	
			$lead_info = $LeadsModel->where('lead_id', $id)->first();
			$iusername = explode('@',$lead_info['email']);
			$username = $iusername[0];
			$options = array('cost' => 12);
			$password_hash = password_hash($username, PASSWORD_BCRYPT, $options);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$data2 = [
					'first_name' => $lead_info['first_name'],
					'last_name'  => $lead_info['last_name'],
					'email'  => $lead_info['email'],
					'user_type'  => 'customer',
					'username'  => $username,
					'password'  => $password_hash,
					'contact_number'  => $lead_info['contact_number'],
					'country'  => $lead_info['country'],
					'user_role_id' => 0,
					'address_1'  => $lead_info['address_1'],
					'address_2'  => $lead_info['address_2'],
					'city'  =>$lead_info['city'],
					'profile_photo'  => $lead_info['profile_photo'],
					'state'  => $lead_info['state'],
					'zipcode' => $lead_info['zipcode'],
					'gender' => $lead_info['gender'],
					'company_name' => '',
					'trading_name' => '',
					'registration_no' => '',
					'government_tax' => '',
					'company_type_id'  => 0,
					'last_login_date' => '0',
					'last_logout_date' => '0',
					'last_login_ip' => '0',
					'is_logged_in' => '0',
					'is_active'  => 1,
					'company_id'  => $lead_info['company_id'],
					'created_at' => date('d-m-Y h:i:s')
				];
				$result = $UsersModel->insert($data2);
				$Return['result'] = lang('Success.ci_lead_changed_to_client_msg');
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
	// read record
	public function read_followup()
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
			return view('erp/clients/dialog_followup', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_lead()
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
			return view('erp/clients/change_to_client', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_client() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$UsersModel = new UsersModel();
			$result = $UsersModel->where('user_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_client_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_lead() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$LeadsModel = new LeadsModel();
			$result = $LeadsModel->where('lead_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_lead_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_lead_followup() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$LeadsfollowupModel = new LeadsfollowupModel();
			$result = $LeadsfollowupModel->where('followup_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_lead_followup_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

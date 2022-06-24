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
use CodeIgniter\I18n\Time;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\TasksModel;
use App\Models\ActivityModel;
use App\Models\ProjectsModel;
use App\Models\ProjectbugsModel;
use App\Models\SmstemplatesModel;
use App\Models\ProjectnotesModel;
use App\Models\ProjectfilesModel;
use App\Models\EmailtemplatesModel;
use App\Models\ProjecttimelogsModel;
use App\Models\ProjectdiscussionModel;

class Projects extends BaseController {

	public function projects_dashboard()
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
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employees';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/projects/projects_dashboard', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function projects()
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
			if(!in_array('project1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_projects').' | '.$xin_system['application_name'];
		$data['path_url'] = 'projects';
		$data['breadcrumbs'] = lang('Dashboard.left_projects');

		$data['subview'] = view('erp/projects/projects_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function projects_grid()
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
			if(!in_array('project1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_projects').' | '.$xin_system['application_name'];
		$data['path_url'] = 'projects_grid';
		$data['breadcrumbs'] = lang('Dashboard.left_projects');

		$data['subview'] = view('erp/projects/projects_grid', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function projects_client()
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
		if($user_info['user_type'] !=='customer'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_projects').' | '.$xin_system['application_name'];
		$data['path_url'] = 'projects_client';
		$data['breadcrumbs'] = lang('Dashboard.left_projects');

		$data['subview'] = view('erp/projects/clients_projects_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function project_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ProjectsModel = new ProjectsModel();
		$request = \Config\Services::request();
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
		$segment_id = $request->uri->getSegment(3);
		$ifield_id = udecode($segment_id);
		$isegment_val = $ProjectsModel->where('project_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] == 'staff'){
			$project_data = $ProjectsModel->where('company_id',$user_info['company_id'])->where('project_id',$ifield_id)->first();
		} else {
			$project_data = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('project_id', $ifield_id)->first();
		}
		$data['progress'] = $project_data['project_progress'];
		$data['title'] = lang('Projects.xin_project_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'project_details';
		$data['breadcrumbs'] = lang('Projects.xin_project_details');

		$data['subview'] = view('erp/projects/project_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function client_project_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ProjectsModel = new ProjectsModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] !='customer'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$segment_id = $request->uri->getSegment(3);
		$ifield_id = udecode($segment_id);
		$isegment_val = $ProjectsModel->where('project_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}		
		//$data['progress'] = $project_data['project_progress'];
		$data['title'] = lang('Projects.xin_project_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'project_details';
		$data['breadcrumbs'] = lang('Projects.xin_project_details');

		$data['subview'] = view('erp/projects/client_project_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function projects_calendar()
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
			if(!in_array('projects_calendar',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_acc_calendar').' | '.$xin_system['application_name'];
		$data['path_url'] = 'projects';
		$data['breadcrumbs'] = lang('Dashboard.xin_acc_calendar');

		$data['subview'] = view('erp/projects/calendar_projects', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function project_timelogs()
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
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employees';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/projects/projects_timelogs', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function projects_scrum_board()
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
			if(!in_array('projects_sboard',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_projects_scrm_board').' | '.$xin_system['application_name'];
		$data['path_url'] = 'projects_scrum_board';
		$data['breadcrumbs'] = lang('Dashboard.xin_projects_scrm_board');

		$data['subview'] = view('erp/projects/projects_scrum_board', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function invoices()
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
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employees';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/projects/projects_invoices', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function payments_history()
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
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employees';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/projects/projects_payments_history', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function invoice_taxes()
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
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employees';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/projects/projects_invoice_taxes', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function quotes()
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
		$data['title'] = lang('Dashboard.dashboard_employees').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employees';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/projects/projects_quotes', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function projects_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$ProjectsModel = new ProjectsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = assigned_staff_projects($usession['sup_user_id']);
		} else {
			$get_data = $ProjectsModel->where('company_id',$usession['sup_user_id'])->orderBy('project_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('project4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['project_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/project-detail').'/'.uencode($r['project_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			//assigned user
			$assigned_to = explode(',',$r['assigned_to']);
			$multi_users = multi_user_profile_photo($assigned_to);
			
			$start_date = set_date_format($r['start_date']);
			$end_date = set_date_format($r['end_date']);
			
			// project progress
			if($r['project_progress'] <= 20) {
				$progress_class = 'bg-danger';
			} else if($r['project_progress'] > 20 && $r['project_progress'] <= 50){
				$progress_class = 'bg-warning';
			} else if($r['project_progress'] > 50 && $r['project_progress'] <= 75){
				$progress_class = 'bg-info';
			} else {
				$progress_class = 'bg-success';
			}
			
			$progress_bar = '<div class="progress" style="height: 10px;"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" style="width: '.$r['project_progress'].'%;" aria-valuenow="'.$r['project_progress'].'" aria-valuemin="0" aria-valuemax="100">'.$r['project_progress'].'%</div></div>';
			// status			
			if($r['status'] == 0) {
				$status = '<span class="label label-warning">'.lang('Projects.xin_not_started').'</span>';
			} else if($r['status'] ==1){
				$status = '<span class="label label-primary">'.lang('Projects.xin_in_progress').'</span>';
			} else if($r['status'] ==2){
				$status = '<span class="label label-success">'.lang('Projects.xin_completed').'</span>';
			} else if($r['status'] ==3){
				$status = '<span class="label label-danger">'.lang('Projects.xin_project_cancelled').'</span>';
			} else {
				$status = '<span class="label label-danger">'.lang('Projects.xin_project_hold').'</span>';
			}
			// priority
			if($r['priority'] == 1) {
				$priority = '<span class="badge badge-light-danger">'.lang('Projects.xin_highest').'</span>';
			} else if($r['priority'] ==2){
				$priority = '<span class="badge badge-light-danger">'.lang('Projects.xin_high').'</span>';
			} else if($r['priority'] ==3){
				$priority = '<span class="badge badge-light-primary">'.lang('Projects.xin_normal').'</span>';
			} else {
				$priority = '<span class="badge badge-light-success">'.lang('Projects.xin_low').'</span>';
			}
				
			$project_summary = $r['title'];
			// create by
			$created_by = $UsersModel->where('user_id',$r['added_by'])->first();
			if($created_by){
				$u_name = $created_by['first_name'].' '.$created_by['last_name'];
			} else {
				$u_name = '--';
			}
			// client
			$client_info = $UsersModel->where('user_id', $r['client_id'])->where('user_type','customer')->first();	
			if($client_info){
				$iclient = $client_info['first_name'].' '.$client_info['last_name'];
			} else {
				$iclient = '--';
			}
			
			$combhr = $view.$delete;
			$ititle = '
				'.$project_summary.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$ititle,
				$iclient,
				$start_date,
				$end_date,
				$multi_users,
				$priority,
				$progress_bar
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
	public function timelogs_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$ProjecttimelogsModel = new ProjecttimelogsModel();
		$segment_id = $this->request->getVar('project_val',FILTER_SANITIZE_STRING);
		$ifield_id = udecode($segment_id);
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $ProjecttimelogsModel->where('company_id',$user_info['company_id'])->where('project_id',$ifield_id)->orderBy('timelogs_id', 'ASC')->findAll();
		} else {
			$get_data = $ProjecttimelogsModel->where('company_id',$usession['sup_user_id'])->where('project_id',$ifield_id)->orderBy('timelogs_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('hr_event3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['timelogs_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('hr_event4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete_timelog" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['timelogs_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			//assigned user
			$iuser = $UsersModel->where('user_id', $r['employee_id'])->first();
			if($iuser){
				$employee_name = $iuser['first_name'].' '.$iuser['last_name'];
				$combhr = $edit.$delete;	
			} else {
				$employee_name = lang('Users.xin_user_data_removed');
				$combhr = $delete;	
			}
			
			$start_date = set_date_format($r['start_date']);
			$end_date = set_date_format($r['end_date']);
			$total_hours = $r['total_hours'];
			
			if(in_array('hr_event3',staff_role_resource()) || in_array('hr_event4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$iemployee_name = '
				'.$employee_name.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>'; 			  				
			} else {
				$iemployee_name = $employee_name;
			}
			$data[] = array(
				$iemployee_name,
				$start_date,
				$end_date,
				$total_hours
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
	public function project_tasks_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TasksModel = new TasksModel();		
		$segment_id = $this->request->getVar('project_val',FILTER_SANITIZE_STRING);
		$ifield_id = udecode($segment_id);
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $TasksModel->where('company_id',$user_info['company_id'])->where('project_id',$ifield_id)->orderBy('task_id', 'ASC')->findAll();
		} else if($user_info['user_type'] == 'customer'){
			$get_data = $TasksModel->where('company_id',$user_info['company_id'])->where('project_id',$ifield_id)->orderBy('task_id', 'ASC')->findAll();
		} else {
			$get_data = $TasksModel->where('company_id',$usession['sup_user_id'])->where('project_id',$ifield_id)->orderBy('task_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('project4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['task_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a target="_blank" href="'.site_url('erp/task-detail').'/'.uencode($r['task_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			//assigned user
			$assigned_to = explode(',',$r['assigned_to']);
			$multi_users = multi_user_profile_photo($assigned_to);
						
			$start_date = set_date_format($r['start_date']);
			$end_date = set_date_format($r['end_date']);
			
			// task progress
			if($r['task_progress'] <= 20) {
				$progress_class = 'bg-danger';
			} else if($r['task_progress'] > 20 && $r['task_progress'] <= 50){
				$progress_class = 'bg-warning';
			} else if($r['task_progress'] > 50 && $r['task_progress'] <= 75){
				$progress_class = 'bg-info';
			} else {
				$progress_class = 'bg-success';
			}
			
			$progress_bar = '<div class="progress" style="height: 10px;"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" style="width: '.$r['task_progress'].'%;" aria-valuenow="'.$r['task_progress'].'" aria-valuemin="0" aria-valuemax="100">'.$r['task_progress'].'%</div></div>';
			// task status			
			if($r['task_status'] == 0) {
				$status = '<span class="badge badge-light-warning">'.lang('Projects.xin_not_started').'</span>';
			} else if($r['task_status'] ==1){
				$status = '<span class="badge badge-light-primary">'.lang('Projects.xin_in_progress').'</span>';
			} else if($r['task_status'] ==2){
				$status = '<span class="badge badge-light-success">'.lang('Projects.xin_completed').'</span>';
			} else if($r['task_status'] ==3){
				$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_cancelled').'</span>';
			} else {
				$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_hold').'</span>';
			}
			$created_by = $UsersModel->where('user_id',$r['created_by'])->first();
			$u_name = $created_by['first_name'].' '.$created_by['last_name'];
			$ttask_date = lang('xin_start_date').': '.$start_date.'<br>'.lang('xin_end_date').': '.$end_date;	
			$combhr = $view.$delete;
			$overall_progress = $progress_bar.$status;
			if(in_array('erp9',staff_role_resource()) || in_array('erp10',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$itask_name = '
				'.$r['task_name'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';		 			  				
			} else {
				$itask_name = $r['task_name'];
			}
			$data[] = array(
				$itask_name,
				$multi_users,
				$start_date,
				$end_date,
				$overall_progress
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
	public function client_projects_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$ProjectsModel = new ProjectsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $ProjectsModel->where('company_id',$user_info['company_id'])->where('client_id',$usession['sup_user_id'])->orderBy('project_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
			  
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['project_id']) . '"><i class="feather icon-trash-2"></i></button></span>';

				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/project-details').'/'.uencode($r['project_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
						
			//assigned user
			$assigned_to = explode(',',$r['assigned_to']);
			$multi_users = multi_user_profile_photo($assigned_to);
			
			$start_date = set_date_format($r['start_date']);
			$end_date = set_date_format($r['end_date']);
			
			// project progress
			if($r['project_progress'] <= 20) {
				$progress_class = 'bg-danger';
			} else if($r['project_progress'] > 20 && $r['project_progress'] <= 50){
				$progress_class = 'bg-warning';
			} else if($r['project_progress'] > 50 && $r['project_progress'] <= 75){
				$progress_class = 'bg-info';
			} else {
				$progress_class = 'bg-success';
			}
			
			$progress_bar = '<div class="progress" style="height: 10px;"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" style="width: '.$r['project_progress'].'%;" aria-valuenow="'.$r['project_progress'].'" aria-valuemin="0" aria-valuemax="100">'.$r['project_progress'].'%</div></div>';
			
			// project status			
			if($r['status'] == 0) {
				$status = '<span class="label bg-warning">'.lang('xin_not_started').'</span>';
			} else if($r['status'] ==1){
				$status = '<span class="label bg-primary">'.lang('xin_in_progress').'</span>';
			} else if($r['status'] ==2){
				$status = '<span class="label bg-success">'.lang('xin_completed').'</span>';
			} else if($r['status'] ==3){
				$status = '<span class="label bg-danger">'.lang('xin_project_cancelled').'</span>';
			} else {
				$status = '<span class="label bg-danger">'.lang('xin_project_hold').'</span>';
			}
			// priority
			if($r['priority'] == 1) {
				$priority = '<span class="badge badge-light-danger">'.lang('Projects.xin_highest').'</span>';
			} else if($r['priority'] ==2){
				$priority = '<span class="badge badge-light-danger">'.lang('Projects.xin_high').'</span>';
			} else if($r['priority'] ==3){
				$priority = '<span class="badge badge-light-primary">'.lang('Projects.xin_normal').'</span>';
			} else {
				$priority = '<span class="badge badge-light-success">'.lang('Projects.xin_low').'</span>';
			}
			
			$created_by = $UsersModel->where('user_id',$r['added_by'])->first();
			$u_name = $created_by['first_name'].' '.$created_by['last_name'];	
			$combhr = $view.$delete;
			
			$ititle = '
			'.$r['title'].'
			<div class="overlay-edit">
				'.$combhr.'
			</div>';
			$data[] = array(
				$ititle,
				$start_date,
				$end_date,
				$multi_users,
				$priority,
				$progress_bar
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
	public function client_profile_projects_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$request = \Config\Services::request();
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$ProjectsModel = new ProjectsModel();
		$client_id = udecode($this->request->getVar('client_id',FILTER_SANITIZE_STRING));
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		$get_data = $ProjectsModel->where('company_id',$company_id)->where('client_id',$client_id)->orderBy('project_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
			  
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/project-detail').'/'.uencode($r['project_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			
			//assigned user
			$assigned_to = explode(',',$r['assigned_to']);
			$multi_users = multi_user_profile_photo($assigned_to);
			
			$start_date = set_date_format($r['start_date']);
			$end_date = set_date_format($r['end_date']);
			
			// project progress
			if($r['project_progress'] <= 20) {
				$progress_class = 'bg-danger';
			} else if($r['project_progress'] > 20 && $r['project_progress'] <= 50){
				$progress_class = 'bg-warning';
			} else if($r['project_progress'] > 50 && $r['project_progress'] <= 75){
				$progress_class = 'bg-info';
			} else {
				$progress_class = 'bg-success';
			}
			
			$progress_bar = '<div class="progress" style="height: 10px;"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" style="width: '.$r['project_progress'].'%;" aria-valuenow="'.$r['project_progress'].'" aria-valuemin="0" aria-valuemax="100">'.$r['project_progress'].'%</div></div>';
			// task status			
			if($r['status'] == 0) {
				$status = '<span class="label label-warning">'.lang('xin_not_started').'</span>';
			} else if($r['status'] ==1){
				$status = '<span class="label label-primary">'.lang('xin_in_progress').'</span>';
			} else if($r['status'] ==2){
				$status = '<span class="label label-success">'.lang('xin_completed').'</span>';
			} else if($r['status'] ==3){
				$status = '<span class="label label-danger">'.lang('xin_project_cancelled').'</span>';
			} else {
				$status = '<span class="label label-danger">'.lang('xin_project_hold').'</span>';
			}
			// priority
			if($r['priority'] == 1) {
				$priority = '<span class="badge badge-light-danger">'.lang('Projects.xin_highest').'</span>';
			} else if($r['priority'] ==2){
				$priority = '<span class="badge badge-light-danger">'.lang('Projects.xin_high').'</span>';
			} else if($r['priority'] ==3){
				$priority = '<span class="badge badge-light-primary">'.lang('Projects.xin_normal').'</span>';
			} else {
				$priority = '<span class="badge badge-light-success">'.lang('Projects.xin_low').'</span>';
			}
				
			$project_summary = '<a href="'.site_url().'erp/project/detail/'.$r['project_id'] . '">'.$r['title'].'</a>';
			
			$created_by = $UsersModel->where('user_id',$r['added_by'])->first();
			$u_name = $created_by['first_name'].' '.$created_by['last_name'];
			$combhr = $view;
			$ititle = '
				'.$project_summary.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$ititle,
				$priority,
				$multi_users,
				$start_date,
				$end_date,
				$progress_bar
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
	public function add_project() {
			
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
				'client_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_client_field_error')
					]
				],
				'start_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'end_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'summary' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"client_id" => $validation->getError('client_id'),
					"start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
					"summary" => $validation->getError('summary')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$client_id = $this->request->getPost('client_id',FILTER_SANITIZE_STRING);
				$summary = $this->request->getPost('summary',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$priority = $this->request->getPost('priority',FILTER_SANITIZE_STRING);
				$budget_hours = $this->request->getPost('budget_hours',FILTER_SANITIZE_STRING);
				$assigned_ids = implode(',',$this->request->getPost('assigned_to',FILTER_SANITIZE_STRING));
				$employee_ids = $assigned_ids;			
				$UsersModel = new UsersModel();
				$SystemModel = new SystemModel();
				$SmstemplatesModel = new SmstemplatesModel();
				$EmailtemplatesModel = new EmailtemplatesModel();
				$xin_system = $SystemModel->where('setting_id', 1)->first();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
					$company_info = $UsersModel->where('company_id', $company_id)->first();
				} else {
					$company_id = $usession['sup_user_id'];
					$company_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				}
				$data = [
					'company_id'  => $company_id,
					'client_id' => $client_id,
					'title' => $title,
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'assigned_to'  => $employee_ids,
					'priority'  => $priority,
					'summary'  => $summary,
					'budget_hours'  => $budget_hours,
					'description'  => $description,
					'project_no'  => '',
					'project_progress'  => 0,
					'status'  => 0,
					'project_note'  => '',
					'added_by'  => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s')
				];
				$ProjectsModel = new ProjectsModel();
				$result = $ProjectsModel->insert($data);	
				$module_id = $ProjectsModel->insertID();
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_project_added_msg');
					if($xin_system['enable_email_notification'] == 1){
						// Send mail start
						$itemplate = $EmailtemplatesModel->where('template_id', 9)->first();
						$isubject = $itemplate['subject'];
						$ibody = html_entity_decode($itemplate['message']);
						$fbody = str_replace(array("{site_name}","{project_name}","{project_due_date}"),array($company_info['company_name'],$title,$end_date),$ibody);
						foreach($this->request->getPost('assigned_to') as $_staff_id){
							$staff_info = $UsersModel->where('user_id', $_staff_id)->first();
							timehrm_mail_data($company_info['email'],$company_info['company_name'],$staff_info['email'],$isubject,$fbody);
						}
						// Send mail end
					}
					if($xin_system['enable_sms_notification'] == 1){
						$stemplate = $SmstemplatesModel->where('template_id', 1)->first();
						$sbody = html_entity_decode($stemplate['message']);
						foreach($this->request->getPost('assigned_to') as $_staff_id){
							$staff_info = $UsersModel->where('user_id', $_staff_id)->first();
							$fbody = str_replace(array("{firstname}","{project_name}"),array($staff_info['first_name'],$title),$sbody);
							timehrm_sms_data($staff_info['contact_number'],$fbody);
						}
					}
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
	public function update_project() {
			
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
				'client_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_client_field_error')
					]
				],
				'start_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'end_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'summary' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"client_id" => $validation->getError('client_id'),
					"start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
					"summary" => $validation->getError('summary')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$client_id = $this->request->getPost('client_id',FILTER_SANITIZE_STRING);
				$summary = $this->request->getPost('summary',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$budget_hours = $this->request->getPost('budget_hours',FILTER_SANITIZE_STRING);
				$assigned_ids = implode(',',$this->request->getPost('assigned_to',FILTER_SANITIZE_STRING));
				$associated_goals = implode(',',$this->request->getPost('associated_goals',FILTER_SANITIZE_STRING));
				$employee_ids = $assigned_ids;
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'client_id' => $client_id,
					'title' => $title,
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'assigned_to'  => $employee_ids,
					'associated_goals'  => $associated_goals,
					'summary'  => $summary,
					'budget_hours'  => $budget_hours,
					'description'  => $description
				];
				$ProjectsModel = new ProjectsModel();
				$result = $ProjectsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_project_updated_msg');
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
	public function update_project_progress() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'progres_val' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_progress_field_error')
					]
				],
				'status' => [
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
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "progres_val" => $validation->getError('progres_val'),
					"status" => $validation->getError('status'),
					"priority" => $validation->getError('priority'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$progres_val = $this->request->getPost('progres_val',FILTER_SANITIZE_STRING);
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
				$priority = $this->request->getPost('priority',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'project_progress' => $progres_val,
					'status'  => $status,
					'priority'  => $priority
				];
				$ProjectsModel = new ProjectsModel();
				$result = $ProjectsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_project_status_updated_msg');
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
	public function add_note() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_note_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'company_id' => $company_id,
					'project_id' => $id,
					'employee_id'  => $usession['sup_user_id'],
					'project_note'  => $description,
					'created_at' => date('d-m-Y h:i:s')
				];
				$ProjectnotesModel = new ProjectnotesModel();
				$result = $ProjectnotesModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_project_note_added_msg');
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
	public function add_bug() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_bug_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'company_id' => $company_id,
					'project_id' => $id,
					'employee_id'  => $usession['sup_user_id'],
					'bug_note'  => $description,
					'created_at' => date('d-m-Y h:i:s')
				];
				$ProjectbugsModel = new ProjectbugsModel();
				$result = $ProjectbugsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_project_bug_added_msg');
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
	public function add_timelogs() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_timelogs') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'start_time' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'end_time' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'start_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'end_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'memo' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "start_time" => $validation->getError('start_time'),
					"end_time" => $validation->getError('end_time'),
					"start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
					"memo" => $validation->getError('memo')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
					$employee_id = $usession['sup_user_id'];
				} else {
					$company_id = $usession['sup_user_id'];
					$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
				}
				$start_time = $this->request->getPost('start_time',FILTER_SANITIZE_STRING);
				$end_time = $this->request->getPost('end_time',FILTER_SANITIZE_STRING);
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$memo = $this->request->getPost('memo',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				// total hours
				$start_time_opt = Time::parse($start_date.' '.$start_time);
				$end_time_opt    = Time::parse($end_date.' '.$end_time);
				$diff = $start_time_opt->difference($end_time_opt);
				$getHours = $diff->getHours();
				$getMinutes = $diff->getMinutes();
				$hours = floor($getMinutes / 60);
				$min = $getMinutes - ($hours * 60);
				$total_hours = $hours.":".$min;
				$data = [
					'company_id' => $company_id,
					'project_id' => $id,
					'employee_id'  => $employee_id,
					'start_time'  => $start_time,
					'end_time'  => $end_time,
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'total_hours'  => $total_hours,
					'timelogs_memo'  => $memo,
					'created_at' => date('d-m-Y h:i:s')
				];
				$ProjecttimelogsModel = new ProjecttimelogsModel();
				$result = $ProjecttimelogsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_timelog_added_msg');
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
	public function update_timelog() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'start_time' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'end_time' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'start_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'end_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'memo' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "start_time" => $validation->getError('start_time'),
					"end_time" => $validation->getError('end_time'),
					"start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
					"memo" => $validation->getError('memo')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
					$employee_id = $usession['sup_user_id'];
				} else {
					$company_id = $usession['sup_user_id'];
					$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
				}
				$start_time = $this->request->getPost('start_time',FILTER_SANITIZE_STRING);
				$end_time = $this->request->getPost('end_time',FILTER_SANITIZE_STRING);
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$memo = $this->request->getPost('memo',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				// total hours
				$start_time_opt = Time::parse($start_date.' '.$start_time);
				$end_time_opt    = Time::parse($end_date.' '.$end_time);
				$diff = $start_time_opt->difference($end_time_opt);
				$getHours = $diff->getHours();
				$getMinutes = $diff->getMinutes();
				$hours = floor($getMinutes / 60);
				$min = $getMinutes - ($hours * 60);
				$total_hours = $hours.":".$min;
				$data = [
					'employee_id'  => $employee_id,
					'start_time'  => $start_time,
					'end_time'  => $end_time,
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'total_hours'  => $total_hours,
					'timelogs_memo'  => $memo
				];
				$ProjecttimelogsModel = new ProjecttimelogsModel();
				$result = $ProjecttimelogsModel->update($id,$data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_timelog_updated_msg');
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
	public function add_discussion() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_discussion_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'company_id' => $company_id,
					'project_id' => $id,
					'employee_id'  => $usession['sup_user_id'],
					'discussion_text'  => $description,
					'created_at' => date('d-m-Y h:i:s')
				];
				$ProjectdiscussionModel = new ProjectdiscussionModel();
				$result = $ProjectdiscussionModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_project_discussion_added_msg');
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
	public function add_attachment() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'file_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'attachment_file' => [
					'rules'  => 'uploaded[attachment_file]|mime_in[attachment_file,image/jpg,image/jpeg,image/gif,image/png]|max_size[attachment_file,3072]',
					'errors' => [
						'uploaded' => lang('Success.xin_file_field_error'),
						'mime_in' => 'wrong size'
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "file_name" => $validation->getError('file_name'),
					"attachment_file" => $validation->getError('attachment_file')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				$attachment = $this->request->getFile('attachment_file');
				$file_name = $attachment->getName();
				$attachment->move('public/uploads/project_files/');
				
				$file_title = $this->request->getPost('file_name',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'project_id'  => $id,
					'employee_id'  => $usession['sup_user_id'],
					'file_title'  => $file_title,
					'attachment_file'  => $file_name,
					'created_at' => date('d-m-Y h:i:s')
				];
				$ProjectfilesModel = new ProjectfilesModel();
				$result = $ProjectfilesModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_project_file_added_msg');
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
	// update record
	public function update_project_status() {
		
		if($this->request->getVar('xfieldid')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = $this->request->getVar('xfieldid',FILTER_SANITIZE_STRING);
			$status = $this->request->getVar('xfieldst',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$data = [
				'status' => $status,
			];
			$ProjectsModel = new ProjectsModel();
			$result = $ProjectsModel->update($id,$data);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_project_status_updated_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	public function project_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$ConstantsModel = new ConstantsModel();
		$ProjectsModel = new ProjectsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_projects = $ProjectsModel->where('company_id',$user_info['company_id'])->countAllResults();
			$not_started = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 0)->countAllResults();
			$in_progress = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 1)->countAllResults();
			$completed = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 2)->countAllResults();
			$cancelled = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 3)->countAllResults();
			$hold = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 4)->countAllResults();
		} else {
			$get_projects = $ProjectsModel->where('company_id',$usession['sup_user_id'])->countAllResults();
			$not_started = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 0)->countAllResults();
			$in_progress = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 1)->countAllResults();
			$completed = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 2)->countAllResults();
			$cancelled = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 3)->countAllResults();
			$hold = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 4)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('not_started'=>'', 'in_progress'=>'','completed'=>'', 'cancelled'=>'','hold'=>'', 'not_started_lb'=>'', 'in_progress_lb'=>'','completed_lb'=>'', 'cancelled_lb'=>'','hold_lb'=>'',);
		$total = $not_started + $in_progress + $completed + $cancelled + $hold;;
		if($not_started > 0) {
			$not_started = $not_started / $get_projects * 100;
			$not_started = number_format((float)$not_started, 1, '.', '');
		} else {
			$not_started = $not_started;
		}
		if($in_progress > 0) {
			$in_progress = $in_progress / $get_projects * 100;
			$in_progress = number_format((float)$in_progress, 1, '.', '');
		} else {
			$in_progress = $in_progress;
		}
		if($completed > 0) {
			$completed = $completed / $get_projects * 100;
			$completed = number_format((float)$completed, 1, '.', '');
		} else {
			$completed = $completed;
		}
		if($cancelled > 0) {
			$cancelled = $cancelled / $get_projects * 100;
			$cancelled = number_format((float)$cancelled, 1, '.', '');
		} else {
			$cancelled = $cancelled;
		}
		if($hold > 0) {
			$hold = $hold / $get_projects * 100;
			$hold = number_format((float)$hold, 1, '.', '');
		} else {
			$hold = $hold;
		}
		// not_started
		$Return['not_started_lb'] = lang('Projects.xin_not_started');
		$Return['not_started'] = $not_started;
		// in_progress
		$Return['in_progress_lb'] = lang('Projects.xin_in_progress');
		$Return['in_progress'] = $in_progress;
		// completed
		$Return['completed_lb'] = lang('Projects.xin_completed');
		$Return['completed'] = $completed;
		// cancelled
		$Return['cancelled_lb'] = lang('Projects.xin_project_cancelled');
		$Return['cancelled'] = $cancelled;
		// hold
		$Return['hold_lb'] = lang('Projects.xin_project_hold');
		$Return['hold'] = $hold;
		$Return['total'] = $total;
		$Return['total_label'] = lang('Main.xin_total');
		$this->output($Return);
		exit;
	}
	public function staff_project_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$ConstantsModel = new ConstantsModel();
		$ProjectsModel = new ProjectsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_projects = $ProjectsModel->where('company_id',$user_info['company_id'])->countAllResults();
			$not_started = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 0)->countAllResults();
			$in_progress = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 1)->countAllResults();
			$completed = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 2)->countAllResults();
			$cancelled = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 3)->countAllResults();
			$hold = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 4)->countAllResults();
		} else {
			$get_projects = $ProjectsModel->where('company_id',$usession['sup_user_id'])->countAllResults();
			$not_started = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 0)->countAllResults();
			$in_progress = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 1)->countAllResults();
			$completed = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 2)->countAllResults();
			$cancelled = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 3)->countAllResults();
			$hold = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 4)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('not_started'=>'', 'in_progress'=>'','completed'=>'', 'cancelled'=>'','hold'=>'', 'not_started_lb'=>'', 'in_progress_lb'=>'','completed_lb'=>'', 'cancelled_lb'=>'','hold_lb'=>'',);
		// not_started
		$Return['not_started_lb'] = lang('Projects.xin_not_started');
		$Return['not_started'] = $not_started;
		// in_progress
		$Return['in_progress_lb'] = lang('Projects.xin_in_progress');
		$Return['in_progress'] = $in_progress;
		// completed
		$Return['completed_lb'] = lang('Projects.xin_completed');
		$Return['completed'] = $completed;
		// cancelled
		$Return['cancelled_lb'] = lang('Projects.xin_project_cancelled');
		$Return['cancelled'] = $cancelled;
		// hold
		$Return['hold_lb'] = lang('Projects.xin_project_hold');
		$Return['hold'] = $hold;
		$Return['total_label'] = lang('Main.xin_total');
		$this->output($Return);
		exit;
	}
	public function client_project_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$ConstantsModel = new ConstantsModel();
		$ProjectsModel = new ProjectsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_projects = $ProjectsModel->where('client_id',$usession['sup_user_id'])->countAllResults();
		$not_started = $ProjectsModel->where('client_id',$usession['sup_user_id'])->where('status', 0)->countAllResults();
		$in_progress = $ProjectsModel->where('client_id',$usession['sup_user_id'])->where('status', 1)->countAllResults();
		$completed = $ProjectsModel->where('client_id',$usession['sup_user_id'])->where('status', 2)->countAllResults();
		$cancelled = $ProjectsModel->where('client_id',$usession['sup_user_id'])->where('status', 3)->countAllResults();
		$hold = $ProjectsModel->where('client_id',$usession['sup_user_id'])->where('status', 4)->countAllResults();
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('not_started'=>'', 'in_progress'=>'','completed'=>'', 'cancelled'=>'','hold'=>'', 'not_started_lb'=>'', 'in_progress_lb'=>'','completed_lb'=>'', 'cancelled_lb'=>'','hold_lb'=>'',);
		// not_started
		$Return['not_started_lb'] = lang('Projects.xin_not_started');
		$Return['not_started'] = $not_started;
		// in_progress
		$Return['in_progress_lb'] = lang('Projects.xin_in_progress');
		$Return['in_progress'] = $in_progress;
		// completed
		$Return['completed_lb'] = lang('Projects.xin_completed');
		$Return['completed'] = $completed;
		// cancelled
		$Return['cancelled_lb'] = lang('Projects.xin_project_cancelled');
		$Return['cancelled'] = $cancelled;
		// hold
		$Return['hold_lb'] = lang('Projects.xin_project_hold');
		$Return['hold'] = $hold;
		$Return['total_label'] = lang('Main.xin_total');
		$this->output($Return);
		exit;
	}
	public function projects_priority_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();		
		$ProjectsModel = new ProjectsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$highest = $ProjectsModel->where('company_id',$user_info['company_id'])->where('priority', 1)->countAllResults();
			$high = $ProjectsModel->where('company_id',$user_info['company_id'])->where('priority', 2)->countAllResults();
			$normal = $ProjectsModel->where('company_id',$user_info['company_id'])->where('priority', 3)->countAllResults();
			$low = $ProjectsModel->where('company_id',$user_info['company_id'])->where('priority', 4)->countAllResults();
		} else {
			$highest = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('priority', 1)->countAllResults();
			$high = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('priority', 2)->countAllResults();
			$normal = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('priority', 3)->countAllResults();
			$low = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('priority', 4)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('highest'=>'','high'=>'','normal'=>'','low'=>'','highest_lb'=>'','high_lb'=>'','normal_lb'=>'','low_lb'=>'');
		
		// highest
		$Return['highest_lb'] = lang('Projects.xin_highest');
		$Return['highest'] = $highest;
		// high
		$Return['high_lb'] = lang('Projects.xin_high');
		$Return['high'] = $high;
		// normal
		$Return['normal_lb'] = lang('Projects.xin_normal');
		$Return['normal'] = $normal;
		// low
		$Return['low_lb'] = lang('Projects.xin_low');
		$Return['low'] = $low;
		$this->output($Return);
		exit;
	}
	// read record||read_timelog
	public function read_timelog()
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
			return view('erp/projects/dialog_timelog', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_project() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ProjectsModel = new ProjectsModel();
			$result = $ProjectsModel->where('project_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_project_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_project_note() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = $this->request->getVar('field_id',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();
			$ProjectnotesModel = new ProjectnotesModel();
			$result = $ProjectnotesModel->where('project_note_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_project_note_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_project_bug() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = $this->request->getVar('field_id',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();
			$ProjectbugsModel = new ProjectbugsModel();
			$result = $ProjectbugsModel->where('project_bug_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_project_bug_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_project_discussion() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = $this->request->getVar('field_id',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();
			$ProjectdiscussionModel = new ProjectdiscussionModel();
			$result = $ProjectdiscussionModel->where('project_discussion_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_project_discussion_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_timelog() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ProjecttimelogsModel = new ProjecttimelogsModel();
			$result = $ProjecttimelogsModel->where('timelogs_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_timelog_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_project_file() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = $this->request->getVar('field_id',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();
			$ProjectfilesModel = new ProjectfilesModel();
			$result = $ProjectfilesModel->where('project_file_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_project_file_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

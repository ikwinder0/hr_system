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
 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\TasksModel;
use App\Models\ProjectsModel;
use App\Models\TasknotesModel;
use App\Models\TaskfilesModel;
use App\Models\SmstemplatesModel;
use App\Models\TaskdiscussionModel;
use App\Models\EmailtemplatesModel;

class Tasks extends BaseController {

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
			if(!in_array('task1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_tasks').' | '.$xin_system['application_name'];
		$data['path_url'] = 'tasks';
		$data['breadcrumbs'] = lang('Dashboard.left_tasks');

		$data['subview'] = view('erp/projects/projects_tasks', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function tasks_grid()
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
			if(!in_array('task1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_tasks').' | '.$xin_system['application_name'];
		$data['path_url'] = 'tasks_grid';
		$data['breadcrumbs'] = lang('Dashboard.left_tasks');

		$data['subview'] = view('erp/projects/projects_tasks_grid', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function task_client()
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
		if($user_info['user_type'] !='customer'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_tasks').' | '.$xin_system['application_name'];
		$data['path_url'] = 'task_client';
		$data['breadcrumbs'] = lang('Dashboard.left_tasks');

		$data['subview'] = view('erp/projects/projects_task_client', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function task_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TasksModel = new TasksModel();
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
		$isegment_val = $TasksModel->where('task_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] == 'staff'){
			$task_data = $TasksModel->where('company_id',$user_info['company_id'])->where('task_id',$ifield_id)->first();
		} else {
			$task_data = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_id', $ifield_id)->first();
		}
		$data['progress'] = $task_data['task_progress'];
		$data['title'] = lang('Projects.xin_task_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'task_details';
		$data['breadcrumbs'] = lang('Projects.xin_task_details');

		$data['subview'] = view('erp/projects/task_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function client_task_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TasksModel = new TasksModel();
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
		$isegment_val = $TasksModel->where('task_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		
		//$data['progress'] = $task_data['task_progress'];
		$data['title'] = lang('Projects.xin_task_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'task_details';
		$data['breadcrumbs'] = lang('Projects.xin_task_details');

		$data['subview'] = view('erp/projects/client_task_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function tasks_summary()
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
		$data['path_url'] = 'tasks';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_employees');

		$data['subview'] = view('erp/projects/tasks_summary', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function tasks_calendar()
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
			if(!in_array('tasks_calendar',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_acc_calendar').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employees';
		$data['breadcrumbs'] = lang('Dashboard.xin_acc_calendar');

		$data['subview'] = view('erp/projects/calendar_tasks', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function tasks_scrum_board()
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
			if(!in_array('tasks_sboard',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_projects_scrm_board').' | '.$xin_system['application_name'];
		$data['path_url'] = 'tasks_scrum_board';
		$data['breadcrumbs'] = lang('Dashboard.xin_projects_scrm_board');

		$data['subview'] = view('erp/projects/projects_tasks_scrum_board', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function tasks_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$TasksModel = new TasksModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = assigned_staff_tasks($usession['sup_user_id']);
		} else {
			$get_data = $TasksModel->where('company_id',$usession['sup_user_id'])->orderBy('task_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('task4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['task_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/task-detail').'/'.uencode($r['task_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
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
			$combhr = $view.$delete;
			$itask_name = '
				'.$r['task_name'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$itask_name,
				$multi_users,
				$start_date,
				$end_date,
				$status,
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
	public function client_tasks_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ProjectsModel = new ProjectsModel();
		$TasksModel = new TasksModel();
		$MainModel = new MainModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $MainModel->get_client_tasks($usession['sup_user_id']);
		//->where('project_id',$project_data['project_id']
		$data = array();
		
          foreach($get_data as $r) {
			  
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r->task_id) . '"><i class="feather icon-trash-2"></i></button></span>';

				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/task-details').'/'.uencode($r->task_id).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			//assigned user
			$assigned_to = explode(',',$r->assigned_to);
			$multi_users = multi_user_profile_photo($assigned_to);
			
			$start_date = set_date_format($r->start_date);
			$end_date = set_date_format($r->end_date);
			// get project
			$_project = $ProjectsModel->where('project_id',$r->project_id)->first();
			if($_project){
				$ptitle = $_project['title'];
			} else {
				$ptitle = '--';
			}
			// task progress
			if($r->task_progress <= 20) {
				$progress_class = 'bg-danger';
			} else if($r->task_progress > 20 && $r->task_progress <= 50){
				$progress_class = 'bg-warning';
			} else if($r->task_progress > 50 && $r->task_progress <= 75){
				$progress_class = 'bg-info';
			} else {
				$progress_class = 'bg-success';
			}
			
			$progress_bar = '<div class="progress" style="height: 10px;"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" style="width: '.$r->task_progress.'%;" aria-valuenow="'.$r->task_progress.'" aria-valuemin="0" aria-valuemax="100">'.$r->task_progress.'%</div></div>';
			
			// task status			
			if($r->task_status == 0) {
				$status = '<span class="badge badge-light-warning">'.lang('Projects.xin_not_started').'</span>';
			} else if($r->task_status ==1){
				$status = '<span class="badge badge-light-primary">'.lang('Projects.xin_in_progress').'</span>';
			} else if($r->task_status ==2){
				$status = '<span class="badge badge-light-success">'.lang('Projects.xin_completed').'</span>';
			} else if($r->task_status ==3){
				$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_cancelled').'</span>';
			} else {
				$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_hold').'</span>';
			}
			$overall_progress = $progress_bar.$status;
			$combhr = $view.$delete;
				$itask_name = '
				'.$r->task_name.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$itask_name,
				$multi_users,
				$start_date,
				$end_date,
				$ptitle,
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
	public function client_profile_tasks_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$request = \Config\Services::request();
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ProjectsModel = new ProjectsModel();
		$MainModel = new MainModel();
		$TasksModel = new TasksModel();
		$client_id = udecode($this->request->getVar('client_id',FILTER_SANITIZE_STRING));
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
	//	$project_data = $ProjectsModel->where('company_id',$company_id)->where('client_id',$client_id)->first();
		$get_data = $MainModel->get_client_tasks($client_id);
		//$get_data = $TasksModel->where('company_id',$company_id)->where('project_id',$project_data['project_id'])->orderBy('task_id', 'ASC')->findAll();
		
		$data = array();
		
          foreach($get_data as $r) {
			  
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r->task_id) . '"><i class="feather icon-trash-2"></i></button></span>';

				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/task-detail').'/'.uencode($r->task_id).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			//assigned user
			$assigned_to = explode(',',$r->assigned_to);
			$multi_users = multi_user_profile_photo($assigned_to);
			
			$start_date = set_date_format($r->start_date);
			$end_date = set_date_format($r->end_date);
			// get project
			$_project = $ProjectsModel->where('project_id',$r->project_id)->first();
			
			// task progress
			if($r->task_progress <= 20) {
				$progress_class = 'bg-danger';
			} else if($r->task_progress > 20 && $r->task_progress <= 50){
				$progress_class = 'bg-warning';
			} else if($r->task_progress > 50 && $r->task_progress <= 75){
				$progress_class = 'bg-info';
			} else {
				$progress_class = 'bg-success';
			}
			
			$progress_bar = '<div class="progress" style="height: 10px;"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" style="width: '.$r->task_progress.'%;" aria-valuenow="'.$r->task_progress.'" aria-valuemin="0" aria-valuemax="100">'.$r->task_progress.'%</div></div>';
			
			// task status			
			if($r->task_status == 0) {
				$status = '<span class="badge badge-light-warning">'.lang('Projects.xin_not_started').'</span>';
			} else if($r->task_status ==1){
				$status = '<span class="badge badge-light-primary">'.lang('Projects.xin_in_progress').'</span>';
			} else if($r->task_status ==2){
				$status = '<span class="badge badge-light-success">'.lang('Projects.xin_completed').'</span>';
			} else if($r->task_status ==3){
				$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_cancelled').'</span>';
			} else {
				$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_hold').'</span>';
			}
			$overall_progress = $progress_bar.$status;
			$combhr = $view.$delete;
				$itask_name = '
				'.$r->task_name.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$itask_name,
				$_project['title'],
				$multi_users,
				$overall_progress,
				$end_date,				
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
	public function add_task() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'task_name' => [
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
				'project_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_project_field_error')
					]
				],
				'summary' => [
					'rules'  => 'required|min_length[60]',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "task_name" => $validation->getError('task_name'),
					"start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
					"project_id" => $validation->getError('project_id'),
					"summary" => $validation->getError('summary')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$task_name = $this->request->getPost('task_name',FILTER_SANITIZE_STRING);
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$project_id = $this->request->getPost('project_id',FILTER_SANITIZE_STRING);
				$task_hour = $this->request->getPost('task_hour',FILTER_SANITIZE_STRING);
				$summary = $this->request->getPost('summary',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
							
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else if($user_info['user_type'] == 'customer'){
					$company_id = $user_info['company_id'];
				}else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'task_name' => $task_name,
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'project_id'  => $project_id,
					'summary'  => $summary,
					'task_hour'  => $task_hour,
					'description'  => $description,
					'assigned_to'  => 0,
					'task_progress'  => 0,
					'task_status'  => 0,
					'task_note'  => '',
					'created_by'  => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s')
				];
				$TasksModel = new TasksModel();
				$result = $TasksModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_task_added_msg');
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
	public function update_task() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'task_name' => [
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
				'project_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_project_field_error')
					]
				],
				'summary' => [
					'rules'  => 'required|min_length[60]',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "task_name" => $validation->getError('task_name'),
					"start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
					"project_id" => $validation->getError('project_id'),
					"summary" => $validation->getError('summary')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$task_name = $this->request->getPost('task_name',FILTER_SANITIZE_STRING);
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$project_id = $this->request->getPost('project_id',FILTER_SANITIZE_STRING);
				$task_hour = $this->request->getPost('task_hour',FILTER_SANITIZE_STRING);
				$summary = $this->request->getPost('summary',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$assigned_ids = implode(',',$this->request->getPost('assigned_to',FILTER_SANITIZE_STRING));
				$associated_goals = implode(',',$this->request->getPost('associated_goals',FILTER_SANITIZE_STRING));
				$employee_ids = $assigned_ids;
				$data = [
					'task_name' => $task_name,
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'project_id'  => $project_id,
					'task_hour'  => $task_hour,
					'summary'  => $summary,
					'description'  => $description,
					'assigned_to'  => $employee_ids,
					'associated_goals'  => $associated_goals
				];
				$TasksModel = new TasksModel();
				$UsersModel = new UsersModel();
				$SystemModel = new SystemModel();
				$SmstemplatesModel = new SmstemplatesModel();
				$EmailtemplatesModel = new EmailtemplatesModel();
				$xin_system = $SystemModel->where('setting_id', 1)->first();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'company'){
					$company_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				} else {
					$company_info = $UsersModel->where('company_id', $user_info['company_id'])->first();
				}
				$result = $TasksModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_task_updated_msg');
					if($xin_system['enable_email_notification'] == 1){
						// Send mail start
						$itemplate = $EmailtemplatesModel->where('template_id', 10)->first();
						$isubject = $itemplate['subject'];
						$ibody = html_entity_decode($itemplate['message']);
						$fbody = str_replace(array("{site_name}","{task_name}","{task_due_date}"),array($company_info['company_name'],$task_name,$end_date),$ibody);
						foreach($this->request->getPost('assigned_to',FILTER_SANITIZE_STRING) as $_staff_id){
							$staff_info = $UsersModel->where('user_id', $_staff_id)->first();
							timehrm_mail_data($company_info['email'],$company_info['company_name'],$staff_info['email'],$isubject,$fbody);
						}
						// Send mail end
					}
					if($xin_system['enable_sms_notification'] == 1){
						$stemplate = $SmstemplatesModel->where('template_id', 2)->first();
						$sbody = html_entity_decode($stemplate['message']);
						foreach($this->request->getPost('assigned_to',FILTER_SANITIZE_STRING) as $_staff_id){
							$staff_info = $UsersModel->where('user_id', $_staff_id)->first();
							$fbody = str_replace(array("{firstname}","{task_name}"),array($staff_info['first_name'],$task_name),$sbody);
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
	// |||update record|||
	public function update_task_progress() {
			
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
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "progres_val" => $validation->getError('progres_val'),
					"status" => $validation->getError('status'),
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
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'task_progress' => $progres_val,
					'task_status'  => $status
				];
				$TasksModel = new TasksModel();
				$result = $TasksModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_task_status_updated_msg');
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
					'task_id' => $id,
					'employee_id'  => $usession['sup_user_id'],
					'task_note'  => $description,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TasknotesModel = new TasknotesModel();
				$result = $TasknotesModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_task_note_added_msg');
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
	public function update_task_status() {
		
		if($this->request->getVar('xfieldid')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$task_id = $this->request->getVar('xfieldid',FILTER_SANITIZE_STRING);	
			//$task_id = $request->uri->getSegment(4);
			$task_status = $this->request->getVar('xfieldst',FILTER_SANITIZE_STRING);	
			$Return['csrf_hash'] = csrf_hash();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$data = [
				'task_status' => $task_status,
			];
			$TasksModel = new TasksModel();
			$result = $TasksModel->update($task_id,$data);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_task_status_updated_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
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
					'task_id' => $id,
					'employee_id'  => $usession['sup_user_id'],
					'discussion_text'  => $description,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TaskdiscussionModel = new TaskdiscussionModel();
				$result = $TaskdiscussionModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_task_discussion_added_msg');
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
						'uploaded' => lang('Success.xin_attachment_field_error'),
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
				$attachment->move('public/uploads/task_files/');
				
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
					'task_id'  => $id,
					'employee_id'  => $usession['sup_user_id'],
					'file_title'  => $file_title,
					'attachment_file'  => $file_name,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TaskfilesModel = new TaskfilesModel();
				$result = $TaskfilesModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_task_file_added_msg');
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
	public function task_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$ConstantsModel = new ConstantsModel();
		$TasksModel = new TasksModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_tasks = $TasksModel->where('company_id',$user_info['company_id'])->countAllResults();
			$not_started = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 0)->countAllResults();
			$in_progress = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 1)->countAllResults();
			$completed = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 2)->countAllResults();
			$cancelled = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 3)->countAllResults();
			$hold = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 4)->countAllResults();
		} else {
			$get_tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->countAllResults();
			$not_started = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 0)->countAllResults();
			$in_progress = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 1)->countAllResults();
			$completed = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 2)->countAllResults();
			$cancelled = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 3)->countAllResults();
			$hold = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 4)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('not_started'=>'', 'in_progress'=>'','completed'=>'', 'cancelled'=>'','hold'=>'', 'not_started_lb'=>'', 'in_progress_lb'=>'','completed_lb'=>'', 'cancelled_lb'=>'','hold_lb'=>'',);
		$total = $not_started + $in_progress + $completed + $cancelled + $hold;;
		if($not_started > 0) {
			$not_started = $not_started / $get_tasks * 100;
			$not_started = number_format((float)$not_started, 1, '.', '');
		} else {
			$not_started = $not_started;
		}
		if($in_progress > 0) {
			$in_progress = $in_progress / $get_tasks * 100;
			$in_progress = number_format((float)$in_progress, 1, '.', '');
		} else {
			$in_progress = $in_progress;
		}
		if($completed > 0) {
			$completed = $completed / $get_tasks * 100;
			$completed = number_format((float)$completed, 1, '.', '');
		} else {
			$completed = $completed;
		}
		if($cancelled > 0) {
			$cancelled = $cancelled / $get_tasks * 100;
			$cancelled = number_format((float)$cancelled, 1, '.', '');
		} else {
			$cancelled = $cancelled;
		}
		if($hold > 0) {
			$hold = $hold / $get_tasks * 100;
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
		$this->output($Return);
		exit;
	}
	public function staff_task_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$ConstantsModel = new ConstantsModel();
		$TasksModel = new TasksModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_tasks = $TasksModel->where('company_id',$user_info['company_id'])->countAllResults();
			$not_started = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 0)->countAllResults();
			$in_progress = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 1)->countAllResults();
			$completed = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 2)->countAllResults();
			$cancelled = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 3)->countAllResults();
			$hold = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 4)->countAllResults();
		} else {
			$get_tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->countAllResults();
			$not_started = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 0)->countAllResults();
			$in_progress = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 1)->countAllResults();
			$completed = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 2)->countAllResults();
			$cancelled = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 3)->countAllResults();
			$hold = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 4)->countAllResults();
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
		//$Return['total'] = $total;
		$this->output($Return);
		exit;
	}
	public function client_task_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ProjectsModel = new ProjectsModel();
		$TasksModel = new TasksModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$_project = $ProjectsModel->where('client_id',$usession['sup_user_id'])->first();
		$not_started = $TasksModel->where('project_id',$_project['project_id'])->where('task_status', 0)->countAllResults();
		$in_progress = $TasksModel->where('project_id',$_project['project_id'])->where('task_status', 1)->countAllResults();
		$completed = $TasksModel->where('project_id',$_project['project_id'])->where('task_status', 2)->countAllResults();
		$cancelled = $TasksModel->where('project_id',$_project['project_id'])->where('task_status', 3)->countAllResults();
		$hold = $TasksModel->where('project_id',$_project['project_id'])->where('task_status', 4)->countAllResults();
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
		//$Return['total'] = $total;
		$this->output($Return);
		exit;
	}
	public function tasks_by_projects_chart() {
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ProjectsModel = new ProjectsModel();
		$TasksModel = new TasksModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_projects = $ProjectsModel->where('company_id',$user_info['company_id'])->orderBy('project_id', 'ASC')->findAll();
		} else {
			$get_projects = $ProjectsModel->where('company_id',$usession['sup_user_id'])->orderBy('project_id', 'ASC')->findAll();
		}
		$data = array();
		$Return = array('iseries'=>'', 'ilabels'=>'');
		$title_info = array();
		$series_info = array();
		foreach($get_projects as $r){
			$task_info = $TasksModel->where('project_id',$r['project_id'])->first();
			$task_count = $TasksModel->where('project_id',$r['project_id'])->countAllResults();
			if($task_count > 0){
				$title_info[] = $r['title'];
				$series_info[] = $task_count;
			}
			
		}				  
		$Return['iseries'] = $series_info;
		$Return['ilabels'] = $title_info;
		$Return['total_label'] = lang('Main.xin_total');
		$this->output($Return);
		exit;
	}
	// delete record
	public function delete_task() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$TasksModel = new TasksModel();
			$result = $TasksModel->where('task_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_task_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_task_note() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = $this->request->getVar('field_id',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();
			$TasknotesModel = new TasknotesModel();
			$result = $TasknotesModel->where('task_note_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_task_note_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_task_discussion() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = $this->request->getVar('field_id',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();
			$TaskdiscussionModel = new TaskdiscussionModel();
			$result = $TaskdiscussionModel->where('task_discussion_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_task_discussion_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_task_file() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = $this->request->getVar('field_id',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();
			$TaskfilesModel = new TaskfilesModel();
			$result = $TaskfilesModel->where('task_file_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_task_file_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

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
use App\Models\JobsModel;
use App\Models\DesignationModel;
use App\Models\JobcandidatesModel;
use App\Models\JobinterviewsModel;
use App\Models\EmailtemplatesModel;

class Recruitment extends BaseController {

	public function create_job()
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
			if(!in_array('ats3',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Recruitment.xin_add_new_job').' | '.$xin_system['application_name'];
		$data['path_url'] = 'job_create';
		$data['breadcrumbs'] = lang('Recruitment.xin_add_new_job');

		$data['subview'] = view('erp/recruitment/key_create_job', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function edit_job()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$JobsModel = new JobsModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $JobsModel->where('job_id', $ifield_id)->first();
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
			if(!in_array('ats4',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Recruitment.xin_edit_job').' | '.$xin_system['application_name'];
		$data['path_url'] = 'job_create';
		$data['breadcrumbs'] = lang('Recruitment.xin_edit_job');

		$data['subview'] = view('erp/recruitment/key_edit_job', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function jobs()
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
			if(!in_array('ats2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Recruitment.xin_new_opening').' | '.$xin_system['application_name'];
		$data['path_url'] = 'jobs';
		$data['breadcrumbs'] = lang('Recruitment.xin_new_opening');

		$data['subview'] = view('erp/recruitment/key_jobs_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function job_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$JobsModel = new JobsModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $JobsModel->where('job_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Recruitment.xin_job_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'job_details';
		$data['breadcrumbs'] = lang('Recruitment.xin_job_details');

		$data['subview'] = view('erp/recruitment/key_job_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function candidates()
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
			if(!in_array('candidate',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Recruitment.xin_candidates').' | '.$xin_system['application_name'];
		$data['path_url'] = 'job_candidates';
		$data['breadcrumbs'] = lang('Recruitment.xin_candidates');

		$data['subview'] = view('erp/recruitment/key_job_candidates', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function interviews()
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
			if(!in_array('interview',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Recruitment.xin_interviews').' | '.$xin_system['application_name'];
		$data['path_url'] = 'job_interviews';
		$data['breadcrumbs'] = lang('Recruitment.xin_interviews');

		$data['subview'] = view('erp/recruitment/key_job_interviews', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function promotions()
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
			if(!in_array('promotion',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_promotions').' | '.$xin_system['application_name'];
		$data['path_url'] = 'job_promotions';
		$data['breadcrumbs'] = lang('Dashboard.left_promotions');

		$data['subview'] = view('erp/recruitment/key_job_promotions', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	
	// record list
	public function jobs_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$JobsModel = new JobsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $JobsModel->where('company_id',$user_info['company_id'])->orderBy('job_id', 'ASC')->findAll();
		} else {
			$get_data = $JobsModel->where('company_id',$usession['sup_user_id'])->orderBy('job_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('erp9',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('xin_view_details').'"><a href="'.site_url().'erp/view-job/'.uencode($r['job_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			} else {
				$view = '';
			}
			if(in_array('erp10',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['job_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$date_of_closing = set_date_format($r['date_of_closing']);
			$combhr = $view.$delete;
			if(in_array('erp9',staff_role_resource()) || in_array('erp10',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$job_title = '
				'.$r['job_title'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
					 			  				
			} else {
				$job_title = $r['job_title'];
			}
			$data[] = array(
				$job_title,
				$r['designation_id'],
				$created_at,
				$date_of_closing
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
	public function candidates_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$JobsModel = new JobsModel();
		$JobcandidatesModel = new JobcandidatesModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $JobcandidatesModel->where('company_id',$user_info['company_id'])->where('staff_id!=',$usession['sup_user_id'])->orderBy('candidate_id', 'ASC')->findAll();
		} else {
			$get_data = $JobcandidatesModel->where('company_id',$usession['sup_user_id'])->orderBy('candidate_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$download = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_download').'"><a href="'.site_url().'download?type=candidates&filename='.uencode($r['job_resume']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fas fa-cloud-download-alt"></span></button></a></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['candidate_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			$status_opt = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.dashboard_xin_status').'"><button type="button" class="btn icon-btn btn-sm btn-light-success waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['candidate_id']) . '"><i class="feather icon-edit"></i></button></span>';
			
			
			$created_at = set_date_format($r['created_at']);
		//	$date_of_closing = set_date_format($r['date_of_closing']);
			$job_title = $JobsModel->where('job_id', $r['job_id'])->first();
			if($job_title){
				$eijob_title = $job_title['job_title'];
			} else {
				$eijob_title = '--';
			}
			$staff_info = $UsersModel->where('user_id', $r['staff_id'])->first();
			if($staff_info){
				$istaff_info = $staff_info['first_name'].' '.$staff_info['last_name'];
				$istaff_email = $staff_info['email'];
			} else {
				$istaff_info = '--';
				$istaff_email = '--';
			}
			// applicant status
			if($r['application_status'] == 0){
				$status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>';
			} else if($r['application_status'] == 1){
				$status = '<span class="badge badge-light-success">'.lang('Recruitment.xin_call_for_interview').'</span>';
			} elseif($r['application_status'] == 3){
				$status = '<span class="badge badge-light-danger">'.lang('Main.xin_rejected').'</span>';
			}
			$cover_letter = '<a><button class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".payroll-modal-data" data-application_id="'. uencode($r['candidate_id']) . '">'.lang('Main.xin_view').' '.lang('Recruitment.xin_cover_letter').'</button></a>';
			if($r['application_status'] == 1 || $r['application_status'] == 3){
				$combhr = $download.$delete;
			} else {
				$combhr = $status_opt.$download.$delete;
			}
			
			$ijob_title = '
				'.$eijob_title.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$ijob_title,
				$istaff_info,
				$istaff_email,
				$status,
				$cover_letter,
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
	// record list
	public function interview_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$JobsModel = new JobsModel();
		$SystemModel = new SystemModel();
		$JobinterviewsModel = new JobinterviewsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $JobinterviewsModel->where('company_id',$user_info['company_id'])->where('interviewer_id',$usession['sup_user_id'])->orderBy('job_interview_id', 'ASC')->findAll();
		} else {
			$get_data = $JobinterviewsModel->where('company_id',$usession['sup_user_id'])->orderBy('job_interview_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
						
			$created_at = set_date_format($r['created_at']);
			$status_opt = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Recruitment.xin_update_status').'"><button type="button" class="btn icon-btn btn-sm btn-light-success waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['job_interview_id']) . '"><i class="feather icon-edit"></i></button></span>';
			$combhr = $status_opt;
			// applicant status
			if($r['status'] == 1){
				$status = '<span class="badge badge-light-warning">'.lang('Projects.xin_not_started').'</span>';
			} else if($r['status'] == 2){
				$status = '<span class="badge badge-light-primary">'.lang('Recruitment.xin_passed_interview').'</span>';
			} elseif($r['status'] == 3){
				$status = '<span class="badge badge-light-danger">'.lang('Main.xin_rejected').'</span>';
			}
			$job_title = $JobsModel->where('job_id', $r['job_id'])->first();
			if($job_title){
				$eijob_title = $job_title['job_title'];
			} else {
				$eijob_title = '--';
			}
			$staff_info = $UsersModel->where('user_id', $r['staff_id'])->first();
			if($staff_info){
				$istaff_info = $staff_info['first_name'].' '.$staff_info['last_name'];
			} else {
				$istaff_info = '--';
			}
			$interviewer = $UsersModel->where('user_id', $r['interviewer_id'])->first();
			if($interviewer){
				$iinterviewer = $interviewer['first_name'].' '.$interviewer['last_name'];
			} else {
				$iinterviewer = '--';
			}
			
			if($r['status'] == 2 || $r['status'] == 3){
					$ijob_title = $eijob_title;
				} else {
					$ijob_title = '
					'.$eijob_title.'
					<div class="overlay-edit">
						'.$combhr.'
					</div>';
				}
			$data[] = array(
				$ijob_title,
				$istaff_info,
				$r['interview_place'],
				$r['interview_date'].' '.$r['interview_time'],
				$iinterviewer,
				$status,
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
	// record list
	public function promotion_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$JobsModel = new JobsModel();
		$SystemModel = new SystemModel();
		$DesignationModel = new DesignationModel();
		$JobinterviewsModel = new JobinterviewsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $JobinterviewsModel->where('company_id',$user_info['company_id'])->where('status',2)->where('staff_id',$usession['sup_user_id'])->orderBy('job_interview_id', 'ASC')->findAll();
		} else {
			$get_data = $JobinterviewsModel->where('company_id',$usession['sup_user_id'])->where('status',2)->orderBy('job_interview_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
						
			$created_at = set_date_format($r['created_at']);
			//$job_title = $JobsModel->where('job_id', $r['job_id'])->first();
			
			$interviewer = $UsersModel->where('user_id', $r['interviewer_id'])->first();
			if($interviewer){
				$iinterviewer = $interviewer['first_name'].' '.$interviewer['last_name'];
			} else {
				$iinterviewer = '--';
			}
			// designation
			$idesignations = $DesignationModel->where('designation_id',$r['designation_id'])->first();
			if($idesignations){
				$designation_name = $idesignations['designation_name'];
			} else {
				$designation_name = '--';
			}			
			// remarks
			$remarks = '<a><button class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-interview_id="'. uencode($r['job_interview_id']) . '">'.lang('Main.xin_view').' '.lang('Recruitment.xin_remarks').'</button></a>';
			// promotion user
			$staff_info = $UsersModel->where('user_id', $r['staff_id'])->first();
			if($staff_info){
			$employee_name = $staff_info['first_name'].' '.$staff_info['last_name'];
			$uname = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/users/thumb/'.$staff_info['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$employee_name.'</h6>
					<p class="m-b-0">'.$staff_info['email'].'</p>
				</div>
			</div>';
			} else {
				$uname = lang('Users.xin_user_data_removed');
			}
			$data[] = array(
				$uname,
				$designation_name,
				$iinterviewer,
				$created_at,
				$remarks				
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
	public function add_job() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'job_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'job_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'designation_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Employees.xin_employee_error_designation')
					]
				],
				'vacancy' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'date_of_closing' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'short_description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'long_description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "job_title" => $validation->getError('job_title'),
					"job_type" => $validation->getError('job_type'),
					"designation_id" => $validation->getError('designation_id'),
					"vacancy" => $validation->getError('vacancy'),
					"date_of_closing" => $validation->getError('date_of_closing'),
					"short_description" => $validation->getError('short_description'),
					"long_description" => $validation->getError('long_description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$job_title = $this->request->getPost('job_title',FILTER_SANITIZE_STRING);
				$job_type = $this->request->getPost('job_type',FILTER_SANITIZE_STRING);
				$designation_id = $this->request->getPost('designation_id',FILTER_SANITIZE_STRING);
				$vacancy = $this->request->getPost('vacancy',FILTER_SANITIZE_STRING);
				$date_of_closing = $this->request->getPost('date_of_closing',FILTER_SANITIZE_STRING);
				$short_description = $this->request->getPost('short_description',FILTER_SANITIZE_STRING);
				$long_description = $this->request->getPost('long_description',FILTER_SANITIZE_STRING);
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
				$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
				$experience = $this->request->getPost('experience',FILTER_SANITIZE_STRING);
							
				$UsersModel = new UsersModel();
				$SystemModel = new SystemModel();
				$EmailtemplatesModel = new EmailtemplatesModel();
				$xin_system = $SystemModel->where('setting_id', 1)->first();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
					$company_info = $UsersModel->where('company_id', $company_id)->first();
					$staff = $UsersModel->where('company_id',$user_info['company_id'])->where('user_type','staff')->orderBy('user_id', 'ASC')->findAll();
				} else {
					$company_id = $usession['sup_user_id'];
					$company_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
					$staff = $UsersModel->where('company_id',$usession['sup_user_id'])->where('user_type','staff')->orderBy('user_id', 'ASC')->findAll();
				}
				$data = [
					'company_id'  => $company_id,
					'job_title' => $job_title,
					'designation_id'  => $designation_id,
					'job_type'  => $job_type,
					'job_vacancy'  => $vacancy,
					'gender'  => $gender,
					'minimum_experience'  => $experience,
					'date_of_closing'  => $date_of_closing,
					'short_description'  => $short_description,
					'long_description'  => $long_description,
					'status'  => $status,
					'created_at' => date('d-m-Y h:i:s')
				];
				$JobsModel = new JobsModel();
				$result = $JobsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_set_job_success');
					if($xin_system['enable_email_notification'] == 1){
						// Send mail start
						$itemplate = $EmailtemplatesModel->where('template_id', 16)->first();
						$isubject = $itemplate['subject'];
						$ibody = html_entity_decode($itemplate['message']);
						$fbody = str_replace(array("{site_name}","{job_title}","{closing_date}"),array($company_info['company_name'],$job_title,$date_of_closing),$ibody);
						foreach($staff as $_staff_id){
							//$staff_info = $UsersModel->where('user_id', $_staff_id)->first();
							timehrm_mail_data($company_info['email'],$company_info['company_name'],$_staff_id['email'],$isubject,$fbody);
						}
						// Send mail end
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
	public function update_job() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'job_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'job_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'designation_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Employees.xin_employee_error_designation')
					]
				],
				'vacancy' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'date_of_closing' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'short_description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'long_description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "job_title" => $validation->getError('job_title'),
					"job_type" => $validation->getError('job_type'),
					"designation_id" => $validation->getError('designation_id'),
					"vacancy" => $validation->getError('vacancy'),
					"date_of_closing" => $validation->getError('date_of_closing'),
					"short_description" => $validation->getError('short_description'),
					"long_description" => $validation->getError('long_description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$job_title = $this->request->getPost('job_title',FILTER_SANITIZE_STRING);
				$job_type = $this->request->getPost('job_type',FILTER_SANITIZE_STRING);
				$designation_id = $this->request->getPost('designation_id',FILTER_SANITIZE_STRING);
				$vacancy = $this->request->getPost('vacancy',FILTER_SANITIZE_STRING);
				$date_of_closing = $this->request->getPost('date_of_closing',FILTER_SANITIZE_STRING);
				$short_description = $this->request->getPost('short_description',FILTER_SANITIZE_STRING);
				$long_description = $this->request->getPost('long_description',FILTER_SANITIZE_STRING);
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
				$gender = $this->request->getPost('gender',FILTER_SANITIZE_STRING);
				$experience = $this->request->getPost('experience',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
							
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'job_title' => $job_title,
					'designation_id'  => $designation_id,
					'job_type'  => $job_type,
					'job_vacancy'  => $vacancy,
					'gender'  => $gender,
					'minimum_experience'  => $experience,
					'date_of_closing'  => $date_of_closing,
					'short_description'  => $short_description,
					'long_description'  => $long_description,
					'status'  => $status
				];
				$JobsModel = new JobsModel();
				$result = $JobsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_update_jobt_success');
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
	public function update_candidate_status() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			if($this->request->getPost('status') == 3){
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);		
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
							
				$Return['csrf_hash'] = csrf_hash();	
					$data2 = [
					'application_status'  => $status,
					];
				$JobcandidatesModel = new JobcandidatesModel();
				$result = $JobcandidatesModel->update($id,$data2);
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_candidate_updated_msg');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			} else {
				// set rules
				$rules = [
					'status' => [
						'rules'  => 'required',
						'errors' => [
							'required' => lang('Main.xin_error_field_text')
						]
					],
					'interview_date' => [
						'rules'  => 'required',
						'errors' => [
							'required' => lang('Main.xin_error_field_text')
						]
					],
					'interview_time' => [
						'rules'  => 'required',
						'errors' => [
							'required' => lang('Main.xin_error_field_text')
						]
					],
					'interview_place' => [
						'rules'  => 'required',
						'errors' => [
							'required' => lang('Main.xin_error_field_text')
						]
					],
					'interviewer_id' => [
						'rules'  => 'required',
						'errors' => [
							'required' => lang('Success.xin_interviewer_field_error')
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
						"status" => $validation->getError('status'),
						"interview_date" => $validation->getError('interview_date'),
						"interview_time" => $validation->getError('interview_time'),
						"interview_place" => $validation->getError('interview_place'),
						"interviewer_id" => $validation->getError('interviewer_id'),
						"description" => $validation->getError('description')
					];
					foreach($ruleErrors as $err){
						$Return['error'] = $err;
						if($Return['error']!=''){
							$this->output($Return);
						}
					}
				} else {
					$interview_date = $this->request->getPost('interview_date',FILTER_SANITIZE_STRING);
					$interview_time = $this->request->getPost('interview_time',FILTER_SANITIZE_STRING);
					$interview_place = $this->request->getPost('interview_place',FILTER_SANITIZE_STRING);
					$interviewer_id = $this->request->getPost('interviewer_id',FILTER_SANITIZE_STRING);
					$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
					$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);		
					$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
						
					$UsersModel = new UsersModel();
					$JobsModel = new JobsModel();
					$JobcandidatesModel = new JobcandidatesModel();
					$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
					if($user_info['user_type'] == 'staff'){
						$company_id = $user_info['company_id'];
					} else {
						$company_id = $usession['sup_user_id'];
					}
					$job_opt = $JobcandidatesModel->where('candidate_id', $id)->first();
					$data = [
						'company_id'  => $company_id,
						'job_id' => $job_opt['job_id'],
						'staff_id'  => $job_opt['staff_id'],
						'designation_id'  => $job_opt['designation_id'],
						'interview_place'  => $interview_place,
						'interview_date'  => $interview_date,
						'interview_time'  => $interview_time,
						'interviewer_id'  => $interviewer_id,
						'description'  => $description,
						'interview_remarks'  => 'interview marks goes here',
						'status'  => $status,
						'created_at' => date('d-m-Y h:i:s')
					];
					$JobinterviewsModel = new JobinterviewsModel();
					$result = $JobinterviewsModel->insert($data);
					$Return['csrf_hash'] = csrf_hash();	
					if ($result == TRUE) {
						$data2 = [
						'application_status'  => $status,
					];
					$JobcandidatesModel = new JobcandidatesModel();
					$result = $JobcandidatesModel->update($id,$data2);
						$Return['result'] = lang('Success.ci_candidate_updated_msg');
					} else {
						$Return['error'] = lang('Main.xin_error_msg');
					}
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
	public function update_interview_status() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'status' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_interview_remarks_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "status" => $validation->getError('status'),
					"description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);		
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
					
				$UsersModel = new UsersModel();
				$JobcandidatesModel = new JobcandidatesModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'status'  => $status,
					'interview_remarks'  => $description
				];
				$JobinterviewsModel = new JobinterviewsModel();
				$job_int = $JobinterviewsModel->where('job_interview_id', $id)->first();
				$result = $JobinterviewsModel->update($id,$data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					// employee details
					if($status == 2){
						$data2 = [
							'designation_id' => $job_int['designation_id'],
						];
						$MainModel = new MainModel();
						$MainModel->update_employee_record($data2,$job_int['staff_id']);
					}
					$Return['result'] = lang('Success.ci_interview_updated_msg');
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
	public function apply_job() {
			
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
				'cover_letter' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'file_cv' => [
					'rules'  => 'uploaded[file_cv]|mime_in[file_cv,image/jpg,image/jpeg,image/gif,image/png]|max_size[file_cv,3072]',
					'errors' => [
						'uploaded' => lang('Success.xin_resume_field_error'),
						'mime_in' => 'wrong size'
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "cover_letter" => $validation->getError('cover_letter'),
					"file_cv" => $validation->getError('file_cv')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				$file_cv = $this->request->getFile('file_cv');
				$file_name = $file_cv->getName();
				$file_cv->move('public/uploads/candidates/');
				
				$cover_letter = $this->request->getPost('cover_letter',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				
				$JobsModel = new JobsModel();
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$staff_id = $usession['sup_user_id'];
					$company_id = $user_info['company_id'];
				} else {
					$staff_id = $usession['sup_user_id'];
					$company_id = $usession['sup_user_id'];
				}
				$job_info = $JobsModel->where('company_id',$company_id)->where('job_id', $id)->first();
				$data = [
					'company_id' => $company_id,
					'job_id'  => $id,
					'staff_id'  => $staff_id,
					'designation_id'  => $job_info['designation_id'],
					'message'  => $cover_letter,
					'job_resume'  => $file_name,
					'application_status'  => 0,
					'application_remarks'  => 'application remarks here',
					'created_at' => date('d-m-Y h:i:s')
				];
				$JobcandidatesModel = new JobcandidatesModel();
				$result = $JobcandidatesModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_job_apply_success_msg');
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
	public function read_candidate()
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
			return view('erp/recruitment/dialog_candidate', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	public function jobs_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$ConstantsModel = new ConstantsModel();
		$JobsModel = new JobsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$open = $JobsModel->where('company_id',$user_info['company_id'])->where('status', 1)->countAllResults();
			$closed = $JobsModel->where('company_id',$user_info['company_id'])->where('status', 2)->countAllResults();
		} else {
			$open = $JobsModel->where('company_id',$usession['sup_user_id'])->where('status', 1)->countAllResults();
			$closed = $JobsModel->where('company_id',$usession['sup_user_id'])->where('status', 2)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('open_count'=>'', 'open_label'=>'','closed'=>'', 'closed_label'=>'');
		
		// closed
		$Return['closed_label'] = lang('Recruitment.xin_unpublished');
		$Return['closed'] = $closed;
		// open
		$Return['open_label'] = lang('Recruitment.xin_published');
		$Return['open_count'] = $open;
		$this->output($Return);
		exit;
	}
	public function jobs_type_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$ConstantsModel = new ConstantsModel();
		$JobsModel = new JobsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$full_time = $JobsModel->where('company_id',$user_info['company_id'])->where('job_type', 1)->countAllResults();
			$part_time = $JobsModel->where('company_id',$user_info['company_id'])->where('job_type', 2)->countAllResults();
			$internship = $JobsModel->where('company_id',$user_info['company_id'])->where('job_type', 3)->countAllResults();
			$freelance = $JobsModel->where('company_id',$user_info['company_id'])->where('job_type', 4)->countAllResults();
		} else {
			$full_time = $JobsModel->where('company_id',$usession['sup_user_id'])->where('job_type', 1)->countAllResults();
			$part_time = $JobsModel->where('company_id',$usession['sup_user_id'])->where('job_type', 2)->countAllResults();
			$internship = $JobsModel->where('company_id',$usession['sup_user_id'])->where('job_type', 3)->countAllResults();
			$freelance = $JobsModel->where('company_id',$usession['sup_user_id'])->where('job_type', 4)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('full_time'=>'', 'part_time'=>'','internship'=>'', 'freelance'=>'','full_time_lb'=>'', 'part_time_lb'=>'','internship_lb'=>'', 'freelance_lb'=>'');
		
		// full_time
		$Return['full_time_lb'] = lang('Recruitment.xin_full_time');
		$Return['full_time'] = $full_time;
		// part_time
		$Return['part_time_lb'] = lang('Recruitment.xin_part_time');
		$Return['part_time'] = $part_time;
		// internship
		$Return['internship_lb'] = lang('Recruitment.xin_internship');
		$Return['internship'] = $internship;
		// freelance
		$Return['freelance_lb'] = lang('Recruitment.xin_freelance');
		$Return['freelance'] = $freelance;
		$this->output($Return);
		exit;
	}
	public function job_by_designation_chart() {
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$JobsModel = new JobsModel();
		$DesignationModel = new DesignationModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_designation = $DesignationModel->where('company_id',$user_info['company_id'])->orderBy('designation_id', 'ASC')->findAll();
		} else {
			$get_designation = $DesignationModel->where('company_id',$usession['sup_user_id'])->orderBy('designation_id', 'ASC')->findAll();
		}
		$data = array();
		$Return = array('iseries'=>'', 'ilabels'=>'');
		$title_info = array();
		$series_info = array();
		foreach($get_designation as $r){
			$job_info = $JobsModel->where('designation_id',$r['designation_id'])->first();
			$job_count = $JobsModel->where('designation_id',$r['designation_id'])->countAllResults();
			if($job_count > 0){
				$title_info[] = $r['designation_name'];
				$series_info[] = $job_count;
			}
			
		}				  
		$Return['iseries'] = $series_info;
		$Return['ilabels'] = $title_info;
		$this->output($Return);
		exit;
	}
	// delete record
	public function delete_job() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$JobsModel = new JobsModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $JobsModel->where('job_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.employee_delete_job_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

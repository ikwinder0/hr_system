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
use App\Models\ConstantsModel;
use App\Models\TrackgoalsModel;

class Trackgoals extends BaseController {

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
			if(!in_array('tracking1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_hr_goal_tracking').' | '.$xin_system['application_name'];
		$data['path_url'] = 'trackgoals';
		$data['breadcrumbs'] = lang('Dashboard.xin_hr_goal_tracking');

		$data['subview'] = view('erp/talent/goal_tracking', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function goal_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TrackgoalsModel = new TrackgoalsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();
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
		$isegment_val = $TrackgoalsModel->where('tracking_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] == 'staff'){
			$track_data = $TrackgoalsModel->where('company_id',$user_info['company_id'])->where('tracking_id',$ifield_id)->first();
		} else {
			$track_data = $TrackgoalsModel->where('company_id',$usession['sup_user_id'])->where('tracking_id', $ifield_id)->first();
		}
		$data['progress'] = $track_data['goal_progress'];
		$data['title'] = lang('Performance.xin_goal_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'trackgoal_details';
		$data['breadcrumbs'] = lang('Performance.xin_goal_details');

		$data['subview'] = view('erp/talent/goal_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function goals_calendar()
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
			if(!in_array('track_calendar',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Performance.xin_goals_calendar').' | '.$xin_system['application_name'];
		$data['path_url'] = 'trackgoals';
		$data['breadcrumbs'] = lang('Performance.xin_goals_calendar');

		$data['subview'] = view('erp/talent/calendar_goals', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function goals_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$TrackgoalsModel = new TrackgoalsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $TrackgoalsModel->where('company_id',$user_info['company_id'])->orderBy('tracking_id', 'ASC')->findAll();
		} else {
			$get_data = $TrackgoalsModel->where('company_id',$usession['sup_user_id'])->orderBy('tracking_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/goal-details/'.uencode($r['tracking_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			if(in_array('tracking4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['tracking_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$start_date = set_date_format($r['start_date']);
			$end_date = set_date_format($r['end_date']);
			/// goal type
			$tracking_type = $ConstantsModel->where('constants_id',$r['tracking_type_id'])->first();
			if($tracking_type){
				$itracking_type = $tracking_type['category_name'];
			} else {
				$itracking_type = '--';
			}
			/////
			$itype = $itracking_type;//.'<br><small class="text-muted"><i>'.$r['subject'].'<i></i></i></small>';
			
			//goal_progress
			if($r['goal_progress'] <= 20) {
				$progress_class = 'bg-danger';
			} else if($r['goal_progress'] > 20 && $r['goal_progress'] <= 50){
				$progress_class = 'bg-warning';
			} else if($r['goal_progress'] > 50 && $r['goal_progress'] <= 75){
				$progress_class = 'bg-info';
			} else {
				$progress_class = 'bg-success';
			}			
			$pbar = '<div class="progress" style="height: 10px;"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" style="width: '.$r['goal_progress'].'%;" aria-valuenow="'.$r['goal_progress'].'" aria-valuemin="0" aria-valuemax="100">'.$r['goal_progress'].'%</div></div>';
			$rating_val = $r['goal_rating'];
			$total_stars = '<span class="overall-stars">';
			for ( $i = 1; $i <= 5; $i++ ) {
				if ( round( $rating_val - .49 ) >= $i ) {
					$total_stars .= "<i class='fa fa-star'></i>"; //fas fa-star for v5
				} elseif ( round( $rating_val + .49 ) >= $i ) {
					$total_stars .= "<i class='fas fa-star-half-alt'></i>"; //fas fa-star-half-alt for v5
				} else {
					$total_stars .= "<i class='far fa-star'></i>"; //far fa-star for v5
				}
			}
			$total_stars .= '</span> '.$rating_val;
			$combhr = $edit.$delete;
			$xitype = '
			'.$itype.'
			<div class="overlay-edit">
				'.$combhr.'
			</div>';
			$data[] = array(
				$xitype,
				$r['subject'],
				$start_date,
				$end_date,
				$total_stars,
				$pbar
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
	public function add_tracking() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'tracking_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'subject' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'target_achiement' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'start_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' =>lang('Main.xin_error_field_text')
					]
				],
				'end_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "tracking_type" => $validation->getError('tracking_type'),
					"subject" => $validation->getError('subject'),
					"target_achiement" => $validation->getError('target_achiement'),
					"start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$tracking_type = $this->request->getPost('tracking_type',FILTER_SANITIZE_STRING);
				$subject = $this->request->getPost('subject',FILTER_SANITIZE_STRING);
				$target_achiement = $this->request->getPost('target_achiement',FILTER_SANITIZE_STRING);
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
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
					'tracking_type_id' => $tracking_type,
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'subject'  => $subject,
					'target_achiement'  => $target_achiement,
					'description'  => $description,
					'goal_progress'  => '',
					'goal_status'  => 0,
					'goal_rating'  => 0,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TrackgoalsModel = new TrackgoalsModel();
				$result = $TrackgoalsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_goal_added_msg');
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
	public function update_goal_tracking() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'tracking_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'subject' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'target_achiement' => [
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
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "tracking_type" => $validation->getError('tracking_type'),
					"subject" => $validation->getError('subject'),
					"target_achiement" => $validation->getError('target_achiement'),
					"start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$tracking_type = $this->request->getPost('tracking_type',FILTER_SANITIZE_STRING);
				$subject = $this->request->getPost('subject',FILTER_SANITIZE_STRING);
				$target_achiement = $this->request->getPost('target_achiement',FILTER_SANITIZE_STRING);
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
				$progres_val = $this->request->getPost('progres_val',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'tracking_type_id' => $tracking_type,
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'subject'  => $subject,
					'target_achiement'  => $target_achiement,
					'description'  => $description,
					'goal_progress'  => $progres_val,
					'goal_status'  => $status,
				];
				$TrackgoalsModel = new TrackgoalsModel();
				$result = $TrackgoalsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_goal_updated_msg');
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
	public function update_rating() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'goal_rating' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "goal_rating" => $validation->getError('goal_rating'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$goal_rating = $this->request->getPost('goal_rating',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'goal_rating' => $goal_rating,
				];
				$TrackgoalsModel = new TrackgoalsModel();
				$result = $TrackgoalsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_goal_rating_updated_msg');
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
	// |||add work for goal|||
	public function add_work() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			
			$goal_work = $this->request->getPost('goal_work',FILTER_SANITIZE_STRING);	
			//$goal_work = implode(',',$this->request->getPost('goal_work'));
			$goal_work = serialize($goal_work);
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			
			$data = [
				'goal_work' => $goal_work,
			];
			$TrackgoalsModel = new TrackgoalsModel();
			$result = $TrackgoalsModel->update($id,$data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Main.xin_add_work_updated');
			} else {
				$Return['error'] = lang('Main.xin_error_msg').$goal_work;
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// delete record
	public function delete_goal() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$TrackgoalsModel = new TrackgoalsModel();
			$result = $TrackgoalsModel->where('tracking_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_goal_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

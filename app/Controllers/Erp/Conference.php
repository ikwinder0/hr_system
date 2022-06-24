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
use App\Models\ConstantsModel;
use App\Models\MeetingModel;

class Conference extends BaseController {

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
			if(!in_array('conference1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_hr_meetings').' | '.$xin_system['application_name'];
		$data['path_url'] = 'meetings';
		$data['breadcrumbs'] = lang('Dashboard.xin_hr_meetings');

		$data['subview'] = view('erp/meeting/staff_meetings', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function meetings_calendar()
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
			if(!in_array('conference_calendar',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_acc_calendar').' | '.$xin_system['application_name'];
		$data['path_url'] = 'meetings';
		$data['breadcrumbs'] = lang('Dashboard.xin_acc_calendar');

		$data['subview'] = view('erp/meeting/calendar_meetings', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function meetings_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$MeetingModel = new MeetingModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = assigned_staff_conference($usession['sup_user_id']);
		} else {
			$get_data = $MeetingModel->where('company_id',$usession['sup_user_id'])->orderBy('meeting_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('conference3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['meeting_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('conference4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['meeting_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			//assigned user
			$assigned_to = explode(',',$r['employee_id']);
			$multi_users = multi_user_profile_photo($assigned_to);
			
			$meeting_date = set_date_format($r['meeting_date']);
			//$meeting_title = '<span class="badge" style="background:'.$r['meeting_color'].';color:#fff;">'.$r['meeting_title'].'</span>';
			$meeting_title = '<span class="badge wid-15 hei-15" style="background:'.$r['meeting_color'].'">&nbsp;</span> '.$r['meeting_title'];
			$meeting_time  = date("g:i a", strtotime($r['meeting_time'])); 
			$combhr = $edit.$delete;
			if(in_array('conference3',staff_role_resource()) || in_array('conference4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$imeeting_title = '
				'.$meeting_title.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';		 			  				
			} else {
				$imeeting_title = $meeting_title;
			}
			$data[] = array(
				$imeeting_title,
				$multi_users,
				$meeting_date,
				$meeting_time
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
	public function add_meeting() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'conference_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'conference_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'conference_time' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'conference_room' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'conference_color' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'conference_note' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "conference_title" => $validation->getError('conference_title'),
					"conference_date" => $validation->getError('conference_date'),
					"conference_time" => $validation->getError('conference_time'),
					"conference_room" => $validation->getError('conference_room'),
					"conference_color" => $validation->getError('conference_color'),
					"conference_note" => $validation->getError('conference_note'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$conference_title = $this->request->getPost('conference_title',FILTER_SANITIZE_STRING);
				$conference_date = $this->request->getPost('conference_date',FILTER_SANITIZE_STRING);
				$conference_time = $this->request->getPost('conference_time',FILTER_SANITIZE_STRING);
				$conference_room = $this->request->getPost('conference_room',FILTER_SANITIZE_STRING);
				$conference_color = $this->request->getPost('conference_color',FILTER_SANITIZE_STRING);
				$conference_note = $this->request->getPost('conference_note',FILTER_SANITIZE_STRING);
							
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$staff_id = $usession['sup_user_id'];
					$company_id = $user_info['company_id'];
				} else {
					$assigned_ids = implode(',',$this->request->getPost('employee_id',FILTER_SANITIZE_STRING));
					$staff_id = $assigned_ids;
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'employee_id' => $staff_id,
					'meeting_title'  => $conference_title,
					'meeting_date'  => $conference_date,
					'meeting_time'  => $conference_time,
					'meeting_room'  => $conference_room,
					'meeting_note'  => $conference_note,
					'meeting_color'  => $conference_color,
					'created_at' => date('d-m-Y h:i:s')
				];
				$MeetingModel = new MeetingModel();
				$result = $MeetingModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_conference_added_msg');
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
	public function update_meeting() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'conference_title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'conference_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'conference_time' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'conference_room' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'conference_color' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'conference_note' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "conference_title" => $validation->getError('conference_title'),
					"conference_date" => $validation->getError('conference_date'),
					"conference_time" => $validation->getError('conference_time'),
					"conference_room" => $validation->getError('conference_room'),
					"conference_color" => $validation->getError('conference_color'),
					"conference_note" => $validation->getError('conference_note'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$conference_title = $this->request->getPost('conference_title',FILTER_SANITIZE_STRING);
				$conference_date = $this->request->getPost('conference_date',FILTER_SANITIZE_STRING);
				$conference_time = $this->request->getPost('conference_time',FILTER_SANITIZE_STRING);
				$conference_room = $this->request->getPost('conference_room',FILTER_SANITIZE_STRING);
				$conference_color = $this->request->getPost('conference_color',FILTER_SANITIZE_STRING);
				$conference_note = $this->request->getPost('conference_note',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'meeting_title'  => $conference_title,
					'meeting_date'  => $conference_date,
					'meeting_time'  => $conference_time,
					'meeting_room'  => $conference_room,
					'meeting_note'  => $conference_note,
					'meeting_color'  => $conference_color
				];
				$MeetingModel = new MeetingModel();
				$result = $MeetingModel->update($id, $data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_conference_updated_msg');
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
	public function read_meeting_record()
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
			return view('erp/meeting/dialog_meetings', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_meeting() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$MeetingModel = new MeetingModel();
			$result = $MeetingModel->where('meeting_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_conference_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

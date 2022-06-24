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
use App\Models\HolidaysModel;

class Holidays extends BaseController {

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
			if(!in_array('holiday1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_holidays').' | '.$xin_system['application_name'];
		$data['path_url'] = 'holidays';
		$data['breadcrumbs'] = lang('Dashboard.left_holidays');

		$data['subview'] = view('erp/holidays/timesheet_holidays', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function holidays_calendar()
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
			if(!in_array('holidays_calendar',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_acc_calendar').' | '.$xin_system['application_name'];
		$data['path_url'] = 'travel';
		$data['breadcrumbs'] = lang('Dashboard.xin_acc_calendar');

		$data['subview'] = view('erp/holidays/calendar_holiday', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function holidays_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$HolidaysModel = new HolidaysModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $HolidaysModel->where('company_id',$user_info['company_id'])->orderBy('holiday_id', 'ASC')->findAll();
		} else {
			$get_data = $HolidaysModel->where('company_id',$usession['sup_user_id'])->orderBy('holiday_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('holiday3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['holiday_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('holiday4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['holiday_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			// start and end date
			$start_date = set_date_format($r['start_date']);
			$end_date = set_date_format($r['end_date']);
			 /* get publish/unpublish label*/
			 if($r['is_publish']==1):
			 	$publish = '<span class="badge badge-light-success">'.lang('Recruitment.xin_published').'</span>';
			else:
				$publish = '<span class="badge badge-light-danger">'.lang('Recruitment.xin_unpublished').'</span>';
			endif;
			$ievent_name = $r['event_name'];
			$combhr = $edit.$delete;	
			if(in_array('holiday3',staff_role_resource()) || in_array('holiday4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$hevent_name = '
				'.$ievent_name.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';						 			  				
			} else {
				$hevent_name = $ievent_name;
			}
			$data[] = array(
				$hevent_name,
				$start_date,
				$end_date,
				$publish
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
	public function add_holiday() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'event_name' => [
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
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "event_name" => $validation->getError('event_name'),
					"start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
					"description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$event_name = $this->request->getPost('event_name',FILTER_SANITIZE_STRING);
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$is_publish = $this->request->getPost('is_publish',FILTER_SANITIZE_STRING);
							
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'event_name' => $event_name,
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'description'  => $description,
					'is_publish'  => $is_publish,
					'created_at' => date('d-m-Y h:i:s')
				];
				$HolidaysModel = new HolidaysModel();
				$result = $HolidaysModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_holiday_added_msg');
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
	public function update_holiday() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'event_name' => [
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
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "event_name" => $validation->getError('event_name'),
					"start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
					"description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$event_name = $this->request->getPost('event_name',FILTER_SANITIZE_STRING);
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$is_publish = $this->request->getPost('is_publish',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));				
				$data = [
					'event_name' => $event_name,
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'description'  => $description,
					'is_publish'  => $is_publish
				];
				$HolidaysModel = new HolidaysModel();
				$result = $HolidaysModel->update($id, $data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_holiday_updated_msg');
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
	public function read_holiday()
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
			return view('erp/holidays/dialog_holiday', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_holiday() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$HolidaysModel = new HolidaysModel();
			$result = $HolidaysModel->where('holiday_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_holiday_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

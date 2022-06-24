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
use App\Models\ShiftModel;

class Officeshifts extends BaseController {

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
			if(!in_array('shift1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_office_shifts').' | '.$xin_system['application_name'];
		$data['path_url'] = 'office_shift';
		$data['breadcrumbs'] = lang('Dashboard.left_office_shifts');

		$data['subview'] = view('erp/office_shift/staff_officeshifts', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	 // record list
	public function office_shifts_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$ShiftModel = new ShiftModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $ShiftModel->where('company_id',$user_info['company_id'])->orderBy('office_shift_id', 'ASC')->findAll();
		} else {
			$get_data = $ShiftModel->where('company_id',$usession['sup_user_id'])->orderBy('office_shift_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('shift3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['office_shift_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('shift4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['office_shift_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
		
			if($r['monday_in_time'] == '') {
				$monday = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';
			} else {
				$monday_in_time = strtotime($r['monday_in_time']);
				$imonday_in_time = date("h:i a", $monday_in_time);
				$monday_out_time = strtotime($r['monday_out_time']);
				$imonday_out_time = date("h:i a", $monday_out_time);
				$monday = $imonday_in_time .' ' .lang('Employees.dashboard_to').' ' .$imonday_out_time;
			}
			if($r['tuesday_in_time'] == '') {
				$tuesday = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';
			} else {
				$tuesday_in_time = strtotime($r['tuesday_in_time']);
				$ituesday_in_time = date("h:i a", $tuesday_in_time);
				$tuesday_out_time = strtotime($r['tuesday_out_time']);
				$ituesday_out_time = date("h:i a", $tuesday_out_time);
				$tuesday = $ituesday_in_time .' ' . lang('Employees.dashboard_to').' '.$ituesday_out_time;
			}
			if($r['wednesday_in_time'] == '') {
				$wednesday = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';
			} else {
				$wednesday_in_time = strtotime($r['wednesday_in_time']);
				$iwednesday_in_time = date("h:i a", $wednesday_in_time);
				$wednesday_out_time = strtotime($r['wednesday_out_time']);
				$iwednesday_out_time = date("h:i a", $wednesday_out_time);
				$wednesday = $iwednesday_in_time .' ' . lang('Employees.dashboard_to').' ' .$iwednesday_out_time;
			}
			if($r['thursday_in_time'] == '') {
				$thursday = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';
			} else {
				$thursday_in_time = strtotime($r['thursday_in_time']);
				$ithursday_in_time = date("h:i a", $thursday_in_time);
				$thursday_out_time = strtotime($r['thursday_out_time']);
				$ithursday_out_time = date("h:i a", $thursday_out_time);
				$thursday = $ithursday_in_time .' ' . lang('Employees.dashboard_to').' ' .$ithursday_out_time;
			}
			if($r['friday_in_time'] == '') {
				$friday = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';
			} else {
				$friday_in_time = strtotime($r['friday_in_time']);
				$ifriday_in_time = date("h:i a", $friday_in_time);
				$friday_out_time = strtotime($r['friday_out_time']);
				$ifriday_out_time = date("h:i a", $friday_out_time);
				$friday = $ifriday_in_time .' ' . lang('Employees.dashboard_to').' ' .$ifriday_out_time;
			}
			if($r['saturday_in_time'] == '') {
				$saturday = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';
			} else {
				$saturday_in_time = strtotime($r['saturday_in_time']);
				$isaturday_in_time = date("h:i a", $saturday_in_time);
				$saturday_out_time = strtotime($r['saturday_out_time']);
				$isaturday_out_time = date("h:i a", $saturday_out_time);
				$saturday = $isaturday_in_time .' ' . lang('Employees.dashboard_to').' ' .$isaturday_out_time;
			}
			if($r['sunday_in_time'] == '') {
				$sunday = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';
			} else {
				$sunday_in_time = strtotime($r['sunday_in_time']);
				$isunday_in_time = date("h:i a", $sunday_in_time);
				$sunday_out_time = strtotime($r['sunday_out_time']);
				$isunday_out_time = date("h:i a", $sunday_out_time);
				$sunday = $isunday_in_time .' ' . lang('Employees.dashboard_to').' ' .$isunday_out_time;
			}
			$combhr = $edit.$delete;
			if(in_array('shift3',staff_role_resource()) || in_array('shift4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$ishift_name = '
				'.$r['shift_name'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
						 			  				
			} else {
				$ishift_name = $r['shift_name'];
			}
			$data[] = array(
				$ishift_name,
				$monday,
				$tuesday,
				$wednesday,
				$thursday,
				$friday,
				$saturday,
				$sunday
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
	public function add_office_shift() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'shift_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "shift_name" => $validation->getError('shift_name'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$shift_name = $this->request->getPost('shift_name',FILTER_SANITIZE_STRING);
				$monday_in_time = $this->request->getPost('monday_in_time',FILTER_SANITIZE_STRING);
				$monday_out_time = $this->request->getPost('monday_out_time',FILTER_SANITIZE_STRING);
				$tuesday_in_time = $this->request->getPost('tuesday_in_time',FILTER_SANITIZE_STRING);
				$tuesday_out_time = $this->request->getPost('tuesday_out_time',FILTER_SANITIZE_STRING);
				$wednesday_in_time = $this->request->getPost('wednesday_in_time',FILTER_SANITIZE_STRING);
				$wednesday_out_time = $this->request->getPost('wednesday_out_time',FILTER_SANITIZE_STRING);
				$thursday_in_time = $this->request->getPost('thursday_in_time',FILTER_SANITIZE_STRING);
				$thursday_out_time = $this->request->getPost('thursday_out_time',FILTER_SANITIZE_STRING);
				$friday_in_time = $this->request->getPost('friday_in_time',FILTER_SANITIZE_STRING);
				$friday_out_time = $this->request->getPost('friday_out_time',FILTER_SANITIZE_STRING);
				$saturday_in_time = $this->request->getPost('saturday_in_time',FILTER_SANITIZE_STRING);
				$saturday_out_time = $this->request->getPost('saturday_out_time',FILTER_SANITIZE_STRING);
				$sunday_in_time = $this->request->getPost('sunday_in_time',FILTER_SANITIZE_STRING);
				$sunday_out_time = $this->request->getPost('sunday_out_time',FILTER_SANITIZE_STRING);
							
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'shift_name' => $shift_name,
					'monday_in_time'  => $monday_in_time,
					'monday_out_time'  => $monday_out_time,
					'tuesday_in_time'  => $tuesday_in_time,
					'tuesday_out_time'  => $tuesday_out_time,
					'wednesday_in_time'  => $wednesday_in_time,
					'wednesday_out_time'  => $wednesday_out_time,
					'thursday_in_time'  => $thursday_in_time,
					'thursday_out_time'  => $thursday_out_time,
					'friday_in_time'  => $friday_in_time,
					'friday_out_time'  => $friday_out_time,
					'saturday_in_time'  => $saturday_in_time,
					'saturday_out_time'  => $saturday_out_time,
					'sunday_in_time'  => $sunday_in_time,
					'sunday_out_time'  => $sunday_out_time,
					'created_at' => date('d-m-Y h:i:s')
				];
				$ShiftModel = new ShiftModel();
				$result = $ShiftModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_set_shift_success');
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
	public function update_office_shift() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'shift_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "shift_name" => $validation->getError('shift_name'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$shift_name = $this->request->getPost('shift_name',FILTER_SANITIZE_STRING);
				$monday_in_time = $this->request->getPost('monday_in_time',FILTER_SANITIZE_STRING);
				$monday_out_time = $this->request->getPost('monday_out_time',FILTER_SANITIZE_STRING);
				$tuesday_in_time = $this->request->getPost('tuesday_in_time',FILTER_SANITIZE_STRING);
				$tuesday_out_time = $this->request->getPost('tuesday_out_time',FILTER_SANITIZE_STRING);
				$wednesday_in_time = $this->request->getPost('wednesday_in_time',FILTER_SANITIZE_STRING);
				$wednesday_out_time = $this->request->getPost('wednesday_out_time',FILTER_SANITIZE_STRING);
				$thursday_in_time = $this->request->getPost('thursday_in_time',FILTER_SANITIZE_STRING);
				$thursday_out_time = $this->request->getPost('thursday_out_time',FILTER_SANITIZE_STRING);
				$friday_in_time = $this->request->getPost('friday_in_time',FILTER_SANITIZE_STRING);
				$friday_out_time = $this->request->getPost('friday_out_time',FILTER_SANITIZE_STRING);
				$saturday_in_time = $this->request->getPost('saturday_in_time',FILTER_SANITIZE_STRING);
				$saturday_out_time = $this->request->getPost('saturday_out_time',FILTER_SANITIZE_STRING);
				$sunday_in_time = $this->request->getPost('sunday_in_time',FILTER_SANITIZE_STRING);
				$sunday_out_time = $this->request->getPost('sunday_out_time',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				
				$data = [
					'shift_name' => $shift_name,
					'monday_in_time'  => $monday_in_time,
					'monday_out_time'  => $monday_out_time,
					'tuesday_in_time'  => $tuesday_in_time,
					'tuesday_out_time'  => $tuesday_out_time,
					'wednesday_in_time'  => $wednesday_in_time,
					'wednesday_out_time'  => $wednesday_out_time,
					'thursday_in_time'  => $thursday_in_time,
					'thursday_out_time'  => $thursday_out_time,
					'friday_in_time'  => $friday_in_time,
					'friday_out_time'  => $friday_out_time,
					'saturday_in_time'  => $saturday_in_time,
					'saturday_out_time'  => $saturday_out_time,
					'sunday_in_time'  => $sunday_in_time,
					'sunday_out_time'  => $sunday_out_time
				];
				$ShiftModel = new ShiftModel();
				$result = $ShiftModel->update($id, $data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.employee_update_shift_success');
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
	public function read_shift()
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
			return view('erp/office_shift/dialog_office_shift', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_office_shift() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ShiftModel = new ShiftModel();
			$result = $ShiftModel->where('office_shift_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.employee_delete_shift_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

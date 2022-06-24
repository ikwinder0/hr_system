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
use App\Models\LeaveModel;
use App\Models\SmstemplatesModel;
use App\Models\EmailtemplatesModel;

class Leave extends BaseController {

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
			if(!in_array('leave2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_manage_leaves').' | '.$xin_system['application_name'];
		$data['path_url'] = 'leave';
		$data['breadcrumbs'] = lang('Dashboard.xin_manage_leaves');

		$data['subview'] = view('erp/leave/staff_leave_list', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function leave_status()
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
			if(!in_array('leave2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Employees.xin_employee_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'leave';
		$data['breadcrumbs'] = lang('Employees.xin_employee_details');

		$data['subview'] = view('erp/leave/leave_status', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function leave_calendar()
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
			if(!in_array('leave_calendar',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_acc_calendar').' | '.$xin_system['application_name'];
		$data['path_url'] = 'meetings';
		$data['breadcrumbs'] = lang('Dashboard.xin_acc_calendar');

		$data['subview'] = view('erp/leave/calendar_leave', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function view_leave()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$LeaveModel = new LeaveModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$ifield_id = udecode($request->uri->getSegment(3));
		$leave_val = $LeaveModel->where('leave_id', $ifield_id)->first();
		if(!$leave_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Leave.xin_leave_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'leave_details';
		$data['breadcrumbs'] = lang('Leave.xin_leave_details');

		$data['subview'] = view('erp/leave/leave_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}	 
	// record list
	public function leave_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$LeaveModel = new LeaveModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $LeaveModel->where('employee_id',$usession['sup_user_id'])->orderBy('leave_id', 'ASC')->findAll();
		} else {
			$get_data = $LeaveModel->where('company_id',$usession['sup_user_id'])->orderBy('leave_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('leave4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['leave_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('leave6',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['leave_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/view-leave-info/'.uencode($r['leave_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			// leave type
			$ltype = $ConstantsModel->where('constants_id', $r['leave_type_id'])->where('type','leave_type')->first();
			if($ltype){
				$itype_name = $ltype['category_name'];
			} else {
				$itype_name = '';
			}
			
			// applied on
			$applied_on = set_date_format($r['created_at']);
			// get employee info
			$staff = $UsersModel->where('user_id', $r['employee_id'])->first();
			if($staff){
				$name = $staff['first_name'].' '.$staff['last_name'];
				$uname = '<div class="d-inline-block align-middle">
					<img src="'.base_url().'/public/uploads/users/thumb/'.$staff['profile_photo'].'" alt="'.$name.'" class="img-radius align-top m-r-15" style="width:40px;">
					<div class="d-inline-block">
						<h6 class="m-b-0">'.$name.'</h6>
						<p class="m-b-0">'.$staff['email'].'</p>
					</div>
				</div>';
				$combhr = $edit.$view.$delete;
			} else {
				$uname = lang('Users.xin_user_data_removed');
				$combhr = $edit.$delete;
			}
			// get leave date difference
			$no_of_days = erp_date_difference($r['from_date'],$r['to_date']);
		
			if($r['is_half_day'] == 1){
			$idays = lang('Employees.xin_hr_leave_half_day');
			} else {
				$idays = $no_of_days.' '.lang('Leave.xin_leave_days');
			}
			$duration = set_date_format($r['from_date']).' '.lang('Employees.dashboard_to').' '.set_date_format($r['to_date']);
			$total_days = $idays;
			// leave status
			if($r['status']==1): $status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>';
			elseif($r['status']==2): $status = '<span class="badge badge-light-success">'.lang('Main.xin_approved').'</span>';
			elseif($r['status']==3): $status = '<span class="badge badge-light-danger">'.lang('Main.xin_rejected').'</span>';
			else: $status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>'; endif;
			$combhr = $edit.$view.$delete;
			$icname = '
				'.$uname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$icname,
				$itype_name,
				$duration,
				$total_days,
				$applied_on,
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
	// |||add record|||
	public function add_leave() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();	
		if ($this->request->getPost('type') === 'add_record') {
			
			// set rules
			$rules = [
				'employee_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_staff_field_error')
					]
				],
				'leave_type' => [
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
				'reason' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "employee_id" => $validation->getError('employee_id'),
					"leave_type" => $validation->getError('leave_type'),
					"start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
					"reason" => $validation->getError('reason')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
			   $validated = $this->validate([
					'attachment' => [
						'rules'  => 'uploaded[attachment]|mime_in[attachment,image/jpg,image/jpeg,image/gif,image/png]|max_size[attachment,3072]',
						'errors' => [
							'uploaded' => lang('Main.xin_error_field_text'),
							'mime_in' => 'wrong size'
						]
					],
				]);
				$leave_type = $this->request->getPost('leave_type',FILTER_SANITIZE_STRING);
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$reason = $this->request->getPost('reason',FILTER_SANITIZE_STRING);
				$leave_half_day = $this->request->getPost('leave_half_day',FILTER_SANITIZE_STRING);
				$remarks = $this->request->getPost('remarks',FILTER_SANITIZE_STRING);
				$luser_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
				$UsersModel = new UsersModel();
				$ConstantsModel = new ConstantsModel();
				$leave_user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($leave_user_info['user_type'] == 'staff'){
					$leave_types = $ConstantsModel->where('company_id',$leave_user_info['company_id'])->where('type','leave_type')->first();
				} else {
					$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->first();
				}
				// check half leave
				$no_of_days = erp_date_difference($start_date,$end_date);
				$tinc = count_employee_leave($luser_id,$leave_type);
				$days_per_year = $leave_types['field_one'];
				$rem_leave = $days_per_year - $tinc;
				
				if($rem_leave == 0){
					$Return['error'] = lang('Main.xin_hr_cant_appply_leave_quota_completed');
				} else if($no_of_days > $rem_leave){
					$Return['error'] = lang('Main.xin_hr_cant_appply_morethan').$rem_leave.' '.lang('Main.xin_day');
				}
				if($Return['error']!=''){
					$Return['csrf_hash'] = csrf_hash();
					$this->output($Return);
				}
				if($leave_half_day==1 && $no_of_days > 1) {
					$Return['error'] = lang('Success.xin_hr_cant_appply_morethan').' 1 '.lang('Main.xin_day');
				} 
				if($Return['error']!=''){
					$Return['csrf_hash'] = csrf_hash();
					$this->output($Return);
				}
				if($leave_half_day==1) {
					$leave_half_day_opt = 1;
				} else {
					$leave_half_day_opt = 0;
				}
				// check users
				
				$SystemModel = new SystemModel();
				$xin_system = $SystemModel->where('setting_id', 1)->first();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$staff_id = $usession['sup_user_id'];
					$company_id = $user_info['company_id'];
					$company_info = $UsersModel->where('company_id', $company_id)->first();
				} else {
					$staff_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
					$company_id = $usession['sup_user_id'];
					$company_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				}
				
				$require_info = $ConstantsModel->where('constants_id', $leave_type)->where('type','leave_type')->first();
				if($require_info['field_two'] == 0){
					$status = 2;
				} else {
					$status = 1;
				}
				if ($validated) {
					$attachment = $this->request->getFile('attachment');
					$file_name = $attachment->getName();
					$attachment->move('public/uploads/leave/');
					$data = [
						'company_id' => $company_id,
						'employee_id'  => $staff_id,
						'leave_type_id'  => $leave_type,
						'from_date'  => $start_date,
						'to_date'  => $end_date,
						'reason'  => $reason,
						'remarks'  => $remarks,
						'status'  => $status,
						'is_half_day'  => $leave_half_day_opt,
						'leave_attachment'  => $file_name,
						'created_at'  => date('d-m-Y h:i:s'),
					];
				} else {
						$data = [
						'company_id' => $company_id,
						'employee_id'  => $staff_id,
						'leave_type_id'  => $leave_type,
						'from_date'  => $start_date,
						'to_date'  => $end_date,
						'reason'  => $reason,
						'remarks'  => $remarks,
						'status'  => $status,
						'is_half_day'  => $leave_half_day_opt,
						'leave_attachment'  => '',
						'created_at'  => date('d-m-Y h:i:s'),
					];	
				}
				$LeaveModel = new LeaveModel();
				$EmailtemplatesModel = new EmailtemplatesModel();
				$result = $LeaveModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					if($xin_system['enable_email_notification'] == 1){
						// Send mail start
						$itemplate = $EmailtemplatesModel->where('template_id', 13)->first();
						$istaff_info = $UsersModel->where('user_id', $staff_id)->first();
						$full_name = $istaff_info['first_name'].' '.$istaff_info['last_name'];
						// leave type
						$ltype = $ConstantsModel->where('constants_id', $leave_type)->where('type','leave_type')->first();
						$category_name = $ltype['category_name'];	
						$isubject = $itemplate['subject'];
						$ibody = html_entity_decode($itemplate['message']);
						$fbody = str_replace(array("{site_name}","{employee_name}","{leave_type}"),array($company_info['company_name'],$full_name,$category_name),$ibody);
						timehrm_mail_data($istaff_info['email'],$company_info['company_name'],$company_info['email'],$isubject,$fbody);
						$Return['result'] = lang('Success.ci_leave_created__msg');
						// Send mail end
					}
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
			}
			$this->output($Return);
			exit;
		}			
	}
	public function leave_type_chart() {
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$LeaveModel = new LeaveModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$get_data = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		$Return = array('iseries'=>'', 'ilabels'=>'');
		$title_info = array();
		$series_info = array();
		foreach($get_data as $r){
			$leave_info = $LeaveModel->where('leave_type_id',$r['constants_id'])->first();
			$leave_count = $LeaveModel->where('leave_type_id',$r['constants_id'])->countAllResults();
			if($leave_count > 0){
				$title_info[] = $r['category_name'];
				$series_info[] = $leave_count;
			}
			
		}				  
		$Return['iseries'] = $series_info;
		$Return['ilabels'] = $title_info;
		$this->output($Return);
		exit;
	}
	public function leave_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$LeaveModel = new LeaveModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$leave_pending = $LeaveModel->where('employee_id',$usession['sup_user_id'])->where('status', 1)->countAllResults();
			$total_accepted = $LeaveModel->where('employee_id',$usession['sup_user_id'])->where('status', 2)->countAllResults();
			$total_rejected = $LeaveModel->where('employee_id',$usession['sup_user_id'])->where('status', 3)->countAllResults();
		} else {
			$leave_pending = $LeaveModel->where('company_id',$usession['sup_user_id'])->where('status', 1)->countAllResults();
			$total_accepted = $LeaveModel->where('company_id',$usession['sup_user_id'])->where('status', 2)->countAllResults();
			$total_rejected = $LeaveModel->where('company_id',$usession['sup_user_id'])->where('status', 3)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('accepted'=>'', 'accepted_count'=>'','pending'=>'', 'pending_count'=>'','rejected'=>'', 'rejected_count'=>'');
		
		//accepted
		$Return['accepted'] = lang('Main.xin_approved');
		$Return['accepted_count'] = $total_accepted;
		// pending
		$Return['pending'] = lang('Main.xin_pending');
		$Return['pending_count'] = $leave_pending;
		// rejected
		$Return['rejected'] = lang('Main.xin_rejected');
		$Return['rejected_count'] = $total_rejected;
		$this->output($Return);
		exit;
	}
	// |||update record|||
	public function update_leave() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'remarks' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'reason' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "remarks" => $validation->getError('remarks'),
					"reason" => $validation->getError('reason')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$remarks = $this->request->getPost('remarks',FILTER_SANITIZE_STRING);	
				$reason = $this->request->getPost('reason',FILTER_SANITIZE_STRING);	
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
				$data = [
					'remarks' => $remarks,
					'reason'  => $reason
				];
				$LeaveModel = new LeaveModel();
				$result = $LeaveModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_leave_updated_msg');
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
	public function update_leave_status() {
			
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
				'remarks' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "remarks" => $validation->getError('remarks'),
					"status" => $validation->getError('status')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$remarks = $this->request->getPost('remarks',FILTER_SANITIZE_STRING);	
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);	
				$id = udecode($this->request->getPost('token_status',FILTER_SANITIZE_STRING));	
				$data = [
					'remarks' => $remarks,
					'status'  => $status
				];
				$UsersModel = new UsersModel();
				$LeaveModel = new LeaveModel();
				$ConstantsModel = new ConstantsModel();
				$EmailtemplatesModel = new EmailtemplatesModel();
				$SmstemplatesModel = new SmstemplatesModel();
				$result = $LeaveModel->update($id,$data);	
				$SystemModel = new SystemModel();
				$xin_system = $SystemModel->where('setting_id', 1)->first();
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_leave_status_updated_msg');
					//if($xin_system['enable_email_notification'] == 1){
						$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
						if($user_info['user_type'] == 'staff'){
							$company_info = $UsersModel->where('company_id', $user_info['company_id'])->first();
						} else {
							$company_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
						}
						$leave_result = $LeaveModel->where('leave_id', $id)->first();
						if($status  == 2){ //approve
							// Send mail start
							if($xin_system['enable_email_notification'] == 1){
								$itemplate = $EmailtemplatesModel->where('template_id', 14)->first();
								$istaff_info = $UsersModel->where('user_id', $leave_result['employee_id'])->first();
								// leave type
								$ltype = $ConstantsModel->where('constants_id', $leave_result['leave_type_id'])->where('type','leave_type')->first();
								$category_name = $ltype['category_name'];	
								$isubject = $itemplate['subject'];
								$ibody = html_entity_decode($itemplate['message']);
								$fbody = str_replace(array("{site_name}","{leave_type}","{start_date}","{end_date}","{remarks}"),array($company_info['company_name'],$category_name,$leave_result['from_date'],$leave_result['to_date'],$remarks),$ibody);
								timehrm_mail_data($company_info['email'],$company_info['company_name'],$istaff_info['email'],$isubject,$fbody);
							}
							if($xin_system['enable_sms_notification'] == 1){
								$itemplate = $SmstemplatesModel->where('template_id', 4)->first();
								$istaff_info = $UsersModel->where('user_id', $leave_result['employee_id'])->first();
								// leave type
								$ltype = $ConstantsModel->where('constants_id', $leave_result['leave_type_id'])->where('type','leave_type')->first();
								$category_name = $ltype['category_name'];	
								$ibody = html_entity_decode($itemplate['message']);
								$fbody = str_replace(array("{firstname}","{leave_name}"),array($istaff_info['first_name'],$category_name),$ibody);
								timehrm_sms_data($istaff_info['contact_number'],$fbody);
							}
						} elseif($status == 3){
							// Send mail start
							if($xin_system['enable_email_notification'] == 1){
								$itemplate = $EmailtemplatesModel->where('template_id', 15)->first();
								$istaff_info = $UsersModel->where('user_id', $leave_result['employee_id'])->first();
								// leave type
								$ltype = $ConstantsModel->where('constants_id', $leave_result['leave_type_id'])->where('type','leave_type')->first();
								$category_name = $ltype['category_name'];	
								$isubject = $itemplate['subject'];
								$ibody = html_entity_decode($itemplate['message']);
								$fbody = str_replace(array("{site_name}","{leave_type}","{start_date}","{end_date}","{remarks}"),array($company_info['company_name'],$category_name,$leave_result['from_date'],$leave_result['to_date'],$remarks),$ibody);
							timehrm_mail_data($company_info['email'],$company_info['company_name'],$istaff_info['email'],$isubject,$fbody);
							}
							if($xin_system['enable_sms_notification'] == 1){
								$itemplate = $SmstemplatesModel->where('template_id', 5)->first();
								$istaff_info = $UsersModel->where('user_id', $leave_result['employee_id'])->first();
								// leave type
								$ltype = $ConstantsModel->where('constants_id', $leave_result['leave_type_id'])->where('type','leave_type')->first();
								$category_name = $ltype['category_name'];	
								$ibody = html_entity_decode($itemplate['message']);
								$fbody = str_replace(array("{firstname}","{leave_name}"),array($istaff_info['first_name'],$category_name),$ibody);
								timehrm_sms_data($istaff_info['contact_number'],$fbody);
							}
						} else {
						}
					//}
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
	public function read_leave()
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
			return view('erp/leave/dialog_leave', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read leave type record
	public function get_employee_assigned_leave_types()
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
			return view('erp/leave/get_employee_assigned_leave_types', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_leave() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$LeaveModel = new LeaveModel();
			$result = $LeaveModel->where('leave_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_leave_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

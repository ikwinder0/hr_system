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
use App\Models\TimesheetModel;
use App\Models\StaffdetailsModel;
use App\Models\OvertimerequestModel;

class Timesheet extends BaseController {

	public function timesheet_dashboard()
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

		$data['subview'] = view('erp/timesheet/timesheet_dashboard', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function attendance()
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
			if(!in_array('attendance',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_attendance').' | '.$xin_system['application_name'];
		$data['path_url'] = 'timesheet_attendance';
		$data['breadcrumbs'] = lang('Dashboard.left_attendance');

		$data['subview'] = view('erp/timesheet/timesheet_attendance', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function attendance_view()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$TimesheetModel = new TimesheetModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$date_info = $request->uri->getSegment(4);
		$attendance_date = udecode($date_info);
		
		$isegment_val = $TimesheetModel->where('employee_id', $ifield_id)->first();
		$isegment_date = $TimesheetModel->where('attendance_date', $attendance_date)->first();
		if(!$isegment_val || !$isegment_date){
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
		$data['title'] = lang('Dashboard.xin_hrm_dashboard').' | '.$xin_system['application_name'];
		$data['path_url'] = 'timesheet_attendance';
		$data['breadcrumbs'] = lang('Dashboard.xin_hrm_dashboard');

		$data['subview'] = view('erp/timesheet/timesheet_attendance_view', $data);
		return view('erp/layout/pre_layout_main', $data); //page load
	}
	public function update_attendance()
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
			if(!in_array('upattendance1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_update_attendance').' | '.$xin_system['application_name'];
		$data['path_url'] = 'timesheet_update';
		$data['breadcrumbs'] = lang('Dashboard.left_update_attendance');

		$data['subview'] = view('erp/timesheet/timesheet_update', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function monthly_timesheet()
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
			if(!in_array('monthly_time',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_month_timesheet_title').' | '.$xin_system['application_name'];
		$data['path_url'] = 'empty';
		$data['breadcrumbs'] = lang('Dashboard.xin_month_timesheet_title');

		$data['subview'] = view('erp/reports/attendance_report', $data);
		return view('erp/layout/pre_layout_main', $data); //page load
	}
	public function monthly_timesheet_filter()
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
			if(!in_array('monthly_time',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_month_timesheet_title').' | '.$xin_system['application_name'];
		$data['path_url'] = 'empty';
		$data['breadcrumbs'] = lang('Dashboard.xin_month_timesheet_title');

		$data['subview'] = view('erp/timesheet/timesheet_monthly', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function timesheet_calendar()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Employees.xin_employee_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employee_details';
		$data['breadcrumbs'] = lang('Employees.xin_employee_details');

		$data['subview'] = view('erp/timesheet/timesheet_calendar', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function overtime_request()
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
			if(!in_array('overtime_req1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_overtime_request').' | '.$xin_system['application_name'];
		$data['path_url'] = 'overtime_request';
		$data['breadcrumbs'] = lang('Dashboard.xin_overtime_request');

		$data['subview'] = view('erp/timesheet/timesheet_overtime_request', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	
	// record list
	public function attendance_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TimesheetModel = new TimesheetModel();
		$ShiftModel = new ShiftModel();
		$MainModel = new MainModel();
		$StaffdetailsModel = new StaffdetailsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $UsersModel->where('user_id',$usession['sup_user_id'])->where('user_type','staff')->findAll();
		} else {
			$get_data = $UsersModel->where('company_id',$usession['sup_user_id'])->where('user_type','staff')->where('is_active',1)->findAll();
		}
		$data = array();
		$attendance_date = date('Y-m-d');
		foreach($get_data as $r) {
			
			//
			$get_day = strtotime($attendance_date);
			$day = date('l', $get_day);
			// get user info
			//$iuser_info = $UsersModel->where('user_id', $r['user_id'])->first();
			$user_detail = $StaffdetailsModel->where('user_id', $r['user_id'])->first();
			// shift info
			$office_shift = $ShiftModel->where('office_shift_id',$user_detail['office_shift_id'])->first();
			if($office_shift){
				
			if($day == 'Monday') {
				if($office_shift['monday_in_time']==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift['monday_in_time'];
					$out_time = $office_shift['monday_out_time'];
				}
			} else if($day == 'Tuesday') {
				if($office_shift['tuesday_in_time']==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift['tuesday_in_time'];
					$out_time = $office_shift['tuesday_out_time'];
				}
			} else if($day == 'Wednesday') {
				if($office_shift['wednesday_in_time']==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift['wednesday_in_time'];
					$out_time = $office_shift['wednesday_out_time'];
				}
			} else if($day == 'Thursday') {
				if($office_shift['thursday_in_time']==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift['thursday_in_time'];
					$out_time = $office_shift['thursday_out_time'];
				}
			} else if($day == 'Friday') {
				if($office_shift['friday_in_time']==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift['friday_in_time'];
					$out_time = $office_shift['friday_out_time'];
				}
			} else if($day == 'Saturday') {
				if($office_shift['saturday_in_time']==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift['saturday_in_time'];
					$out_time = $office_shift['saturday_out_time'];
				}
			} else if($day == 'Sunday') {
				if($office_shift['sunday_in_time']==''){
					$in_time = '00:00:00';
					$out_time = '00:00:00';
				} else {
					$in_time = $office_shift['sunday_in_time'];
					$out_time = $office_shift['sunday_out_time'];
				}
			}
			} else {
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			}
			// check clock_in
			$check_in_row = $MainModel->attendance_first_in_check($r['user_id'],$attendance_date);
			if($check_in_row > 0){
				// for clock-in
				$attendance = $TimesheetModel->where('employee_id', $r['user_id'])->where('attendance_date', $attendance_date)->first();
				// clock in time
				$clock_in_time = strtotime($attendance['clock_in']);
				$fclock_in = date("h:i a", $clock_in_time);
				//time diff > total time late
				$office_time_new = strtotime($in_time.' '.$attendance_date);
				$clock_in_time_new = strtotime($attendance['clock_in']);
				$ioffice_time_new = date_create($in_time.' '.$attendance_date);
				$iclock_in_time = date_create($attendance['clock_in']);
				if($clock_in_time_new <= $office_time_new) {
					$total_time_l = '00:00';
				} else {
					$interval_late = date_diff($iclock_in_time, $ioffice_time_new);//$office_time_new->date_diff($office_time_new);
					$hours_l   = $interval_late->format('%h');
					$minutes_l = $interval_late->format('%i');			
					$total_time_l = $hours_l ."h ".$minutes_l."m";
				}
				if($total_time_l=='') {
					$total_time_l = '00:00';
				} else {
					$total_time_l = $total_time_l;
				}
				// total hours worked
				$total_hrs = $TimesheetModel->where('employee_id', $r['user_id'])->where('attendance_date', $attendance_date)->where('total_work !=', '')->findAll();
				$hrs_old_int1 = 0;
				$Total = '';
				$Trest = '';
				$total_time_rs = '';
				$hrs_old_int_res1 = '';
				foreach ($total_hrs as $hour_work){		
					// total work			
					$timee = $hour_work['total_work'].':00';
					$str_time =$timee;
		
					$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
					
					sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
					
					$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
					
					$hrs_old_int1 += $hrs_old_seconds;
					
					$Total = gmdate("H:i", $hrs_old_int1);	
				}
				if($Total=='') {
					$total_work = '00:00';
				} else {
					$total_work = $Total;
				}
				 
				// total rest > 
				$total_rest = $TimesheetModel->where('employee_id', $r['user_id'])->where('attendance_date', $attendance_date)->where('total_rest !=', '')->findAll();
				foreach ($total_rest as $rest){			
					// total rest
					$str_time_rs = $rest['total_rest'].':00';
					//$str_time_rs =$timee_rs;
		
					$str_time_rs = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time_rs);
					
					sscanf($str_time_rs, "%d:%d:%d", $hours_rs, $minutes_rs, $seconds_rs);
					
					$hrs_old_seconds_rs = $hours_rs * 3600 + $minutes_rs * 60 + $seconds_rs;
					
					$hrs_old_int_res1 = $hrs_old_seconds_rs;
					
					$total_time_rs = gmdate("H:i", $hrs_old_int_res1);
				}
			
				// check attendance status
				$status = '<span class="badge badge-light-success">'.$attendance['attendance_status'].'</span>';
				if($total_time_rs=='') {
					$Trest = '00:00';
				} else {
					$Trest = $total_time_rs;
				}
				
			} else {
				$fclock_in = '00:00';
				$total_time_l = '00:00';
				$total_work = '00:00';
				$Trest = '00:00';
				$view_info = '';
				$fclock_in_ip = $fclock_in;
				// ||leave check
				$leave_date_chck = $MainModel->leave_date_check($r['user_id'],$attendance_date);
				// ||holiday check
				$holiday_date_check = $MainModel->holiday_date_check($attendance_date);
				if($office_shift){
					if($office_shift['monday_in_time'] == '' && $day == 'Monday') {
						$status = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';	
					} else if($office_shift['tuesday_in_time'] == '' && $day == 'Tuesday') {
						$status = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';	
					} else if($office_shift['wednesday_in_time'] == '' && $day == 'Wednesday') {
						$status = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';	
					} else if($office_shift['thursday_in_time'] == '' && $day == 'Thursday') {
						$status = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';	
					} else if($office_shift['friday_in_time'] == '' && $day == 'Friday') {
						$status = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';	
					} else if($office_shift['saturday_in_time'] == '' && $day == 'Saturday') {
						$status = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';	
					} else if($office_shift['sunday_in_time'] == '' && $day == 'Sunday') {
						$status = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';	
					} else if($holiday_date_check['holiday_count'] > 0){ // holiday
						$status = '<span class="badge badge-light-success">'.lang('Dashboard.left_holiday').'</span>';
					} else if($leave_date_chck['leave_count'] > 0){ // on leave
						$status = '<span class="badge badge-light-info">'.lang('Leave.left_on_leave').'</span>';
					} else {
						$status = '<span class="badge badge-light-danger">'.lang('Attendance.attendance_absent').'</span>';
					}
				} else {
					$status = '<span class="badge badge-light-danger">'.lang('Users.xin_no_shift_assigned').'</span>';
				}
				 
			}
			// if checkout||| limit-1
			$check_out_row = $MainModel->attendance_first_out_check($r['user_id'],$attendance_date);
			if($check_out_row>0){
				/* early time */
				$early_time = strtotime($out_time.' '.$attendance_date);
				// check clock in time
				$first_out = $MainModel->attendance_first_out($r['user_id'],$attendance_date);
				//$first_out = $TimesheetModel->where('employee_id', $r['user_id'])->where('attendance_date', $attendance_date)->orderBy('time_attendance_id', 'DESC')->limit(1)->first();
				// clock out time
				$clock_out = strtotime($first_out[0]->clock_out);
				if ($first_out[0]->clock_out!='') {
					$clock_out2 = date("h:i a", $clock_out);
					$fclock_out = $clock_out2;
					//time diff > // early leaving
					$early_new_time = strtotime($out_time.' '.$attendance_date);
					$clock_out_time_new = strtotime($first_out[0]->clock_out);
					$ioffice_time_new = date_create($out_time.' '.$attendance_date);
					$iclock_in_time = date_create($first_out[0]->clock_out);
					if($early_new_time <= $clock_out_time_new) {
						$total_time_e = '00:00';
					} else {
						$interval_lateo = date_diff($ioffice_time_new, $iclock_in_time);
						$hours_e   = $interval_lateo->format('%h');
						$minutes_e = $interval_lateo->format('%i');			
						$total_time_e = $hours_e ."h ".$minutes_e."m";
					}	
				} else {
					$clock_out2 =  '00:00';
					$total_time_e = '00:00';
					//$overtime2 = '00:00';
					$fclock_out = $clock_out2;
				}
				$view_info = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Attendance.xin_attendance_details').'"><a target="_blank" href="'.site_url('erp/attendance-info').'/'.uencode($r['user_id']).'/'.uencode($attendance_date).'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			} else {
				$clock_out2 =  '00:00';
				$total_time_e = '00:00';
				//$overtime2 = '00:00';
				$view_info = '';
				$fclock_out = $clock_out2;
			}
			$employee_name = $r['first_name'].' '.$r['last_name'];
			
			
			$staff_name = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/users/thumb/'.$r['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$employee_name.'</h6>
					<p class="m-b-0">'.$r['email'].'</p>
				</div>
			</div>';
			$links = '
				'.$staff_name.'
				<div class="overlay-edit">
					'.$view_info.'
				</div>
			';
			$Trest = '';
			$data[] = array(
				$links,
				$attendance_date,
				$status,
				$fclock_in,
				$fclock_out,
				$total_time_l,
				$total_time_e,
				$total_work,
				//$Trest,				
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
	public function update_attendance_list() {

		$request = \Config\Services::request();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TimesheetModel = new TimesheetModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $TimesheetModel->where('company_id',$user_info['company_id'])->orderBy('time_attendance_id', 'ASC')->findAll();
		} else {
			$get_data = $TimesheetModel->where('company_id',$usession['sup_user_id'])->orderBy('time_attendance_id', 'ASC')->findAll();
		}
		if ($this->request->getGet('user')) {
			if($user_info['user_type'] == 'staff'){
				$uid = $usession['sup_user_id'];
			} else {
				$uid = $this->request->getGet('user');
			}
			$date = $this->request->getGet('date');
			$get_data = $TimesheetModel->where('employee_id',$uid)->where('attendance_date',$date)->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {						
		  		
			if(in_array('upattendance3',staff_role_resource()) || $user_info['user_type'] == 'company') {	
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['time_attendance_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('upattendance4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['time_attendance_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			//get user info
			$iuser = $UsersModel->where('user_id', $r['employee_id'])->first();
			if($iuser){
				$uname = $iuser['first_name'].' '.$iuser['last_name'];
				$profile_photo = $iuser['profile_photo'];
				$email = $iuser['email'];
				$fname = '<div class="d-inline-block align-middle">
					<img src="'.base_url().'/public/uploads/users/thumb/'.$profile_photo.'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
					<div class="d-inline-block">
						<h6 class="m-b-0">'.$uname.'</h6>
						<p class="m-b-0">'.$email.'</p>
					</div>
				</div>';
				$combhr = $edit.$delete;
			} else {
				$uname = '';
				$email = '';
				$combhr = $delete;
				$fname = lang('Users.xin_user_data_removed');
				$profile_photo = '';
			}
			$clock_in_time = strtotime($r['clock_in']);
			$fclckIn = date("h:i a", $clock_in_time);
			
			$clock_out_time = strtotime($r['clock_out']);
			$fclckOut = date("h:i a", $clock_out_time);
			$attendance_date = set_date_format($r['attendance_date']);	
			$ifname = '
				'.$fname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';					 			  				
			$data[] = array(
				$ifname,
				$attendance_date,
				$fclckIn,
				$fclckOut,
				$r['total_work'],
			);
		}
          $output = array(
               "csrf_hash" => csrf_hash(),
			   "data" => $data
            );
		//  $output['csrf_hash'] = csrf_hash();	
		  $this->output($output);
         // echo json_encode($output);
          exit();
     }
	// record list
	public function overtime_request_list() {

		$request = \Config\Services::request();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$OvertimerequestModel = new OvertimerequestModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $OvertimerequestModel->where('staff_id',$usession['sup_user_id'])->orderBy('time_request_id', 'ASC')->findAll();
		} else {
			$get_data = $OvertimerequestModel->where('company_id',$usession['sup_user_id'])->orderBy('time_request_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {						
		  			
				if(in_array('overtime_req3',staff_role_resource()) || $user_info['user_type'] == 'company') {
					$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['time_request_id']) . '"><i class="feather icon-edit"></i></button></span>';
				} else {
					$edit = '';
				}
				if(in_array('overtime_req4',staff_role_resource()) || $user_info['user_type'] == 'company') {
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['time_request_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
				} else {
					$delete = '';
				}
				
				//get user info
				$iuser = $UsersModel->where('user_id', $r['staff_id'])->first();
				if($iuser){
					$uname = $iuser['first_name'].' '.$iuser['last_name'];
					$fname = '<div class="d-inline-block align-middle">
						<img src="'.base_url().'/public/uploads/users/thumb/'.$iuser['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
						<div class="d-inline-block">
							<h6 class="m-b-0">'.$uname.'</h6>
							<p class="m-b-0">'.$iuser['email'].'</p>
						</div>
					</div>';
					$combhr = $edit.$delete;
				} else {
					$combhr = $delete;	
					$fname = lang('Users.xin_user_data_removed');
				}
				$clock_in_time = strtotime($r['clock_in']);
				$fclckIn = date("h:i a", $clock_in_time);
				
				$clock_out_time = strtotime($r['clock_out']);
				$fclckOut = date("h:i a", $clock_out_time);
				$attendance_date = set_date_format($r['request_date']);	
				// status
				if($r['is_approved'] == 0){
					$status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>';
				} else if($r['is_approved'] == 1){
					$status = '<span class="badge badge-light-success">'.lang('Main.xin_accepted').'</span>';
				} else {
					$status = '<span class="badge badge-light-danger">'.lang('Main.xin_rejected').'</span>';
				}
				$ifname = '
					'.$fname.'
					<div class="overlay-edit">
						'.$combhr.'
					</div>';					 			  				
				$data[] = array(
					$ifname,
					$attendance_date,
					$fclckIn,
					$fclckOut,
					$r['total_hours'],
					$status
				);
			}
          $output = array(
               "csrf_hash" => csrf_hash(),
			   "data" => $data
            );
		//  $output['csrf_hash'] = csrf_hash();	
		  $this->output($output);
         // echo json_encode($output);
          exit();
     }
	// |||add record|||
	public function add_attendance() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'attendance_date_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_attendance_date_field_error')
					]
				],
				'clock_in_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_clock_in_field_error')
					]
				],
				'clock_out_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_clock_out_field_error')
					]
				]
			];
			
			if(!$this->validate($rules)){
				$ruleErrors = [
					"attendance_date_m" => $validation->getError('attendance_date_m'),
					"clock_in_m" => $validation->getError('clock_in_m'),
					"clock_out_m" => $validation->getError('clock_out_m')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$attendance_date = $this->request->getPost('attendance_date_m',FILTER_SANITIZE_STRING);
				$clock_in = $this->request->getPost('clock_in_m',FILTER_SANITIZE_STRING);
				$clock_out = $this->request->getPost('clock_out_m',FILTER_SANITIZE_STRING);
				
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
					$employee_id = $usession['sup_user_id'];
				} else {
					$company_id = $usession['sup_user_id'];
					$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
				}
				$clock_in2 = $attendance_date.' '.$clock_in.':00';
				$clock_out2 = $attendance_date.' '.$clock_out.':00';
				
				$total_work_cin = date_create($clock_in2);
				$total_work_cout = date_create($clock_out2);
				$interval_cin = date_diff($total_work_cin, $total_work_cout);
				$hours_in   = $interval_cin->format('%h');
				$minutes_in = $interval_cin->format('%i');			
				$total_work = $hours_in .":".$minutes_in;
					
				$data = [
					'company_id' => $company_id,
					'employee_id'  => $employee_id,
					'attendance_date'  => $attendance_date,
					'clock_in'  => $clock_in2,
					'clock_in_ip_address' => 1,
					'clock_out'  => $clock_out2,
					'clock_out_ip_address'  => 1,
					'clock_in_out'  => 0,
					'clock_in_latitude' => 1,
					'clock_in_longitude'  => 1,
					'clock_out_latitude'  => 1,
					'clock_out_longitude'  => 1,
					'time_late'  => $clock_in2,
					'early_leaving'  => $clock_out2,
					'overtime' => $clock_out2,
					'total_work'  => $total_work,
					'total_rest'  => 0,
					'attendance_status'  => 'Present',
				];
				$TimesheetModel = new TimesheetModel();
				$result = $TimesheetModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_attendance_added_msg');
				} else {
					$Return['error'] = lang('Main.xin_error_msg').' Error';
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
	public function add_overtime() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'attendance_date_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_attendance_date_field_error')
					]
				],
				'clock_in_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_clock_in_field_error')
					]
				],
				'clock_out_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_clock_out_field_error')
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
					"attendance_date_m" => $validation->getError('attendance_date_m'),
					"clock_in_m" => $validation->getError('clock_in_m'),
					"clock_out_m" => $validation->getError('clock_out_m'),
					"reason" => $validation->getError('reason')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$attendance_date = $this->request->getPost('attendance_date_m',FILTER_SANITIZE_STRING);
				$clock_in = $this->request->getPost('clock_in_m',FILTER_SANITIZE_STRING);
				$clock_out = $this->request->getPost('clock_out_m',FILTER_SANITIZE_STRING);
				$reason = $this->request->getPost('reason',FILTER_SANITIZE_STRING);
				
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
					$employee_id = $usession['sup_user_id'];
				} else {
					$company_id = $usession['sup_user_id'];
					$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
				}
				$clock_in2 = $attendance_date.' '.$clock_in.':00';
				$clock_out2 = $attendance_date.' '.$clock_out.':00';
				
				$total_work_cin = date_create($clock_in2);
				$total_work_cout = date_create($clock_out2);
				$interval_cin = date_diff($total_work_cin, $total_work_cout);
				$hours_in   = $interval_cin->format('%h');
				$minutes_in = $interval_cin->format('%i');			
				$total_work = $hours_in .":".$minutes_in;
					
				$data = [
					'company_id' => $company_id,
					'staff_id'  => $employee_id,
					'request_date'  => $attendance_date,
					'clock_in'  => $clock_in2,
					'request_month' => date('Y-m'),
					'clock_out'  => $clock_out2,
					'total_hours'  => $total_work,
					'request_reason'  => $reason,
					'is_approved'  => 0,
					'created_at'  => date('d-m-Y h:i:s')
				];
				$OvertimerequestModel = new OvertimerequestModel();
				$result = $OvertimerequestModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_overtime_added_msg');
				} else {
					$Return['error'] = lang('Main.xin_error_msg').' Error';
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
	public function update_attendance_record() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'attendance_date_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_attendance_date_field_error')
					]
				],
				'clock_in_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_clock_in_field_error')
					]
				],
				'clock_out_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_clock_out_field_error')
					]
				]
			];
			
			if(!$this->validate($rules)){
				$ruleErrors = [
					"attendance_date_m" => $validation->getError('attendance_date_m'),
					"clock_in_m" => $validation->getError('clock_in_m'),
					"clock_out_m" => $validation->getError('clock_out_m')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$attendance_date = $this->request->getPost('attendance_date_m',FILTER_SANITIZE_STRING);
				$clock_in = $this->request->getPost('clock_in_m',FILTER_SANITIZE_STRING);
				$clock_out = $this->request->getPost('clock_out_m',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
					$employee_id = $usession['sup_user_id'];
				} else {
					$company_id = $usession['sup_user_id'];
					$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
				}
				$clock_in2 = $attendance_date.' '.$clock_in.':00';
				$clock_out2 = $attendance_date.' '.$clock_out.':00';
				
				$total_work_cin = date_create($clock_in2);
				$total_work_cout = date_create($clock_out2);
				$interval_cin = date_diff($total_work_cin, $total_work_cout);
				$hours_in   = $interval_cin->format('%h');
				$minutes_in = $interval_cin->format('%i');			
				$total_work = $hours_in .":".$minutes_in;
					
				$data = [
					'company_id' => $company_id,
					'employee_id'  => $employee_id,
					'attendance_date'  => $attendance_date,
					'clock_in'  => $clock_in2,
					'clock_out'  => $clock_out2,
					'time_late'  => $clock_in2,
					'early_leaving'  => $clock_out2,
					'overtime' => $clock_out2,
					'total_work'  => $total_work,
					'attendance_status'  => 'Present',
				];
				$TimesheetModel = new TimesheetModel();
				$result = $TimesheetModel->update($id, $data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_attendance_updated_msg');
				} else {
					$Return['error'] = lang('Main.xin_error_msg').' Error';
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
	public function update_overtime_record() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'attendance_date_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_attendance_date_field_error')
					]
				],
				'clock_in_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_clock_in_field_error')
					]
				],
				'clock_out_m' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_clock_out_field_error')
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
					"attendance_date_m" => $validation->getError('attendance_date_m'),
					"clock_in_m" => $validation->getError('clock_in_m'),
					"clock_out_m" => $validation->getError('clock_out_m'),
					"reason" => $validation->getError('reason')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$attendance_date = $this->request->getPost('attendance_date_m',FILTER_SANITIZE_STRING);
				$clock_in = $this->request->getPost('clock_in_m',FILTER_SANITIZE_STRING);
				$clock_out = $this->request->getPost('clock_out_m',FILTER_SANITIZE_STRING);
				$reason = $this->request->getPost('reason',FILTER_SANITIZE_STRING);
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
					$employee_id = $usession['sup_user_id'];
				} else {
					$company_id = $usession['sup_user_id'];
					$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
				}
				$clock_in2 = $attendance_date.' '.$clock_in.':00';
				$clock_out2 = $attendance_date.' '.$clock_out.':00';
				
				$total_work_cin = date_create($clock_in2);
				$total_work_cout = date_create($clock_out2);
				$interval_cin = date_diff($total_work_cin, $total_work_cout);
				$hours_in   = $interval_cin->format('%h');
				$minutes_in = $interval_cin->format('%i');			
				$total_work = $hours_in .":".$minutes_in;
				$data = [
					'company_id' => $company_id,
					'staff_id'  => $employee_id,
					'request_date'  => $attendance_date,
					'clock_in'  => $clock_in2,
					'clock_out'  => $clock_out2,
					'total_hours'  => $total_work,
					'request_reason'  => $reason,
					'is_approved'  => $status
				];
				$OvertimerequestModel = new OvertimerequestModel();
				$result = $OvertimerequestModel->update($id, $data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_overtime_updated_msg');
				} else {
					$Return['error'] = lang('Main.xin_error_msg').' Error';
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
	public function update_attendance_add()
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
			return view('erp/timesheet/dialog_attendance', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_overtime_request()
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
			return view('erp/timesheet/dialog_overtime_request', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_overtime() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$OvertimerequestModel = new OvertimerequestModel();
			$result = $OvertimerequestModel->where('time_request_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_overtime_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	public function staff_working_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
				
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();		
		$TimesheetModel = new TimesheetModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$current_date = date('Y-m-d');
		if($user_info['user_type'] == 'staff'){
			$total_staff = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','staff')->countAllResults();
			$working = $TimesheetModel->where('company_id',$user_info['company_id'])->where('attendance_date', $current_date)->countAllResults();
		} else {
			$total_staff = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->countAllResults();
			$working = $TimesheetModel->where('company_id',$usession['sup_user_id'])->where('attendance_date', $current_date)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('absent'=>'', 'working'=>'','absent_label'=>'', 'working_label'=>'');
		
		// get actual data
		//$employee_w = $working / $total_staff * 100;
		// absent
		$abs = $total_staff - $working;
		//$employee_ab = $abs / $total * 100;
		$Return['absent'] = $abs;
		$Return['absent_label'] = lang('xin_absent');
		$Return['total'] = $total_staff;
		$Return['total_label'] = lang('Employees');
		// working
		$Return['working_label'] = lang('xin_emp_working');
		$Return['working'] = $working;
		$this->output($Return);
		exit;
	}
	// delete record
	public function delete_attendance() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$TimesheetModel = new TimesheetModel();
			$result = $TimesheetModel->where('time_attendance_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_attendance_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// set clock in - clock out > attendance
	public function set_clocking() {
		
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'set_clocking') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			$company_id = $user_info['company_id'];
			$employee_id = $usession['sup_user_id'];
			
			$clock_state = $this->request->getPost('clock_state',FILTER_SANITIZE_STRING);
			$latitude = $this->request->getPost('latitude',FILTER_SANITIZE_STRING);
			$longitude = $this->request->getPost('longitude',FILTER_SANITIZE_STRING);
			$time_id = $this->request->getPost('time_id',FILTER_SANITIZE_STRING);
			$ip_address = $request->getIPAddress();
			//time|today
			$nowtime = date("Y-m-d H:i:s");
			$today_date = date('Y-m-d');
			// set rules
			if($clock_state=='clock_in') {
				$check_user_attendance = check_user_attendance();
				if($check_user_attendance < 1) {
					$total_rest = '';
				} else {
					$check_user_attendance_value = check_user_attendance_value();
					$cout = date_create($check_user_attendance_value[0]->clock_out);
					$cin = date_create($nowtime);
					
					$interval_cin = date_diff($cin, $cout);
					$hours_in   = $interval_cin->format('%h');
					$minutes_in = $interval_cin->format('%i');			
					$total_rest = $hours_in .":".$minutes_in;
				}
				$data = [
					'company_id' => $company_id,
					'employee_id'  => $employee_id,
					'attendance_date'  => $today_date,
					'clock_in'  => $nowtime,
					'clock_in_ip_address' => $ip_address,
					'clock_out'  => '',
					'clock_out_ip_address'  => 1,
					'clock_in_out'  => 0,
					'clock_in_latitude' => $latitude,
					'clock_in_longitude'  => $longitude,
					'clock_out_latitude'  => 1,
					'clock_out_longitude'  => 1,
					'time_late'  => $nowtime,
					'early_leaving'  => $nowtime,
					'overtime' => $nowtime,
					'total_work'  => '00:00',
					'total_rest'  => $total_rest,
					'attendance_status'  => 'Present',
				];
				$TimesheetModel = new TimesheetModel();
				$result = $TimesheetModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Users.xin_strole_success_added');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
			} else if($clock_state=='clock_out') {
				$clockout_value = check_user_attendance_clockout_value();
				$cout = date_create($clockout_value[0]->clock_in);
				$cin = date_create($nowtime);
				
				$interval_cin = date_diff($cout, $cin);
				$hours_in   = $interval_cin->format('%h');
				$minutes_in = $interval_cin->format('%i');			
				$total_work = $hours_in .":".$minutes_in;
				
				$data = array(
					'employee_id' => $employee_id,
					'clock_out' => $nowtime,
					'clock_out_ip_address' => $ip_address,
					'clock_out_latitude' => $latitude,
					'clock_out_longitude' => $longitude,
					'clock_in_out' => '0',
					'early_leaving' => $nowtime,
					'overtime' => $nowtime,
					'total_work' => $total_work
				);
				$id = udecode($this->request->getPost('time_id'));
				$TimesheetModel = new TimesheetModel();
				$result = $TimesheetModel->update($id, $data);
				if ($result == TRUE) {
					$Return['result'] = lang('Users.xin_strole_success_added');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
			}
			$Return['csrf_hash'] = csrf_hash();
			$this->output($Return);
			exit;
		}
	}
}

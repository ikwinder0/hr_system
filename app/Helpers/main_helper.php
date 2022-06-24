<?php
//Process String
if( !function_exists('super_user_role_resource') ){

	function super_user_role_resource(){
				
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SuperroleModel = new \App\Models\SuperroleModel();
		
		$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$role_user = $SuperroleModel->where('role_id', $user['user_role_id'])->first();
		$role_resources_ids = explode(',',$role_user['role_resources']);
		return $role_resources_ids;
	}
}
if( !function_exists('set_date_format') ){
	//set currency sign
	function set_date_format($date) {
		
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$com_xin_system = erp_company_settings();
		if($user_info['user_type'] == 'super_user'){
			
			$xin_system = $SystemModel->where('setting_id', 1)->first();
			// date format
			if($xin_system['date_format_xi']=='Y-m-d'){
				$d_format = date("Y-m-d", strtotime($date));
			} else if($xin_system['date_format_xi']=='Y-d-m'){
				$d_format = date("Y-d-m", strtotime($date));
			} else if($xin_system['date_format_xi']=='d-m-Y'){
				$d_format = date("d-m-Y", strtotime($date));
			} else if($xin_system['date_format_xi']=='m-d-Y'){
				$d_format = date("m-d-Y", strtotime($date));
			} else if($xin_system['date_format_xi']=='Y/m/d'){
				$d_format = date("Y/m/d", strtotime($date));
			} else if($xin_system['date_format_xi']=='Y/d/m'){
				$d_format = date("Y/d/m", strtotime($date));
			} else if($xin_system['date_format_xi']=='d/m/Y'){
				$d_format = date("d/m/Y", strtotime($date));
			} else if($xin_system['date_format_xi']=='m/d/Y'){
				$d_format = date("m/d/Y", strtotime($date));
			} else if($xin_system['date_format_xi']=='Y.m.d'){
				$d_format = date("Y.m.d", strtotime($date));
			} else if($xin_system['date_format_xi']=='Y.d.m'){
				$d_format = date("Y.d.m", strtotime($date));
			} else if($xin_system['date_format_xi']=='d.m.Y'){
				$d_format = date("d.m.Y", strtotime($date));
			} else if($xin_system['date_format_xi']=='m.d.Y'){
				$d_format = date("m.d.Y", strtotime($date));
			} else if($xin_system['date_format_xi']=='F j, Y'){
				$d_format = date("F j, Y", strtotime($date));
			} else {
				$d_format = date('Y-m-d');
			}
		} else {
			$xin_system = erp_company_settings();
			if($com_xin_system['datepicker_locale']=='ar-sa'){
				$d_format = $date;
			} else if($com_xin_system['datepicker_locale']=='ar'){
				$d_format = $date;
			} else if($com_xin_system['datepicker_locale']=='fa'){
				$d_format = $date;
			} else if($com_xin_system['datepicker_locale']=='hi'){
				$d_format = $date;
			} else if($com_xin_system['datepicker_locale']=='ne'){
				$d_format = $date;
			} else if($com_xin_system['datepicker_locale']=='ta-in'){
				$d_format = $date;
			} else {
				// date format
				if($date!='') {
					if($xin_system['date_format_xi']=='Y-m-d'){
						$d_format = date("Y-m-d", strtotime($date));
					} else if($xin_system['date_format_xi']=='Y-d-m'){
						$d_format = date("Y-d-m", strtotime($date));
					} else if($xin_system['date_format_xi']=='d-m-Y'){
						$d_format = date("d-m-Y", strtotime($date));
					} else if($xin_system['date_format_xi']=='m-d-Y'){
						$d_format = date("m-d-Y", strtotime($date));
					} else if($xin_system['date_format_xi']=='Y/m/d'){
						$d_format = date("Y/m/d", strtotime($date));
					} else if($xin_system['date_format_xi']=='Y/d/m'){
						$d_format = date("Y/d/m", strtotime($date));
					} else if($xin_system['date_format_xi']=='d/m/Y'){
						$d_format = date("d/m/Y", strtotime($date));
					} else if($xin_system['date_format_xi']=='m/d/Y'){
						$d_format = date("m/d/Y", strtotime($date));
					} else if($xin_system['date_format_xi']=='Y.m.d'){
						$d_format = date("Y.m.d", strtotime($date));
					} else if($xin_system['date_format_xi']=='Y.d.m'){
						$d_format = date("Y.d.m", strtotime($date));
					} else if($xin_system['date_format_xi']=='d.m.Y'){
						$d_format = date("d.m.Y", strtotime($date));
					} else if($xin_system['date_format_xi']=='m.d.Y'){
						$d_format = date("m.d.Y", strtotime($date));
					} else if($xin_system['date_format_xi']=='F j, Y'){
						$d_format = date("F j, Y", strtotime($date));
					} else {
						$d_format = date('Y-m-d');
					}
				} else {
					$d_format = '--';
				}
			}
		}
		
		return $d_format;
	}
}
if( !function_exists('js_set_date_format') ){
	//set currency sign
	function js_set_date_format() {
		
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		
		$xin_system = erp_company_settings();
		// date format
		if($xin_system['date_format_xi']=='Y-m-d'){
			$d_format = 'YYYY-MM-DD';
		} else if($xin_system['date_format_xi']=='Y-d-m'){
			$d_format = 'YYYY-DD-MM';
		} else if($xin_system['date_format_xi']=='d-m-Y'){
			$d_format = 'DD-MM-YYYY';
		} else if($xin_system['date_format_xi']=='m-d-Y'){
			$d_format = 'MM-DD-YYYY';
		} else if($xin_system['date_format_xi']=='Y/m/d'){
			$d_format = 'YYYY/MM/DD';
		} else if($xin_system['date_format_xi']=='Y/d/m'){
			$d_format = 'YYYY/DD/MM';
		} else if($xin_system['date_format_xi']=='d/m/Y'){
			$d_format = 'DD/MM/YYYY';
		} else if($xin_system['date_format_xi']=='m/d/Y'){
			$d_format = 'MM/DD/YYYY';
		} else if($xin_system['date_format_xi']=='Y.m.d'){
			$d_format = 'YYYY.MM.DD';
		} else if($xin_system['date_format_xi']=='Y.d.m'){
			$d_format = 'YYYY.DD.MM';
		} else if($xin_system['date_format_xi']=='d.m.Y'){
			$d_format = 'DD.MM.YYYY';
		} else if($xin_system['date_format_xi']=='m.d.Y'){
			$d_format = 'MM.DD.YYYY';
		} else {
			$d_format = 'YYYY-MM-DD';
		}
		
		return $d_format;
	}
}
if ( ! function_exists('leave_halfday_cal'))
{
	function leave_halfday_cal($employee_id,$leave_type_id) {
		
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$LeaveModel = new \App\Models\LeaveModel();
		$leave_halfday_cal = $LeaveModel->where('employee_id', $employee_id)->where('leave_type_id', $leave_type_id)->where('is_half_day', 1)->where('status', 2)->findAll();
		$hlfcount = 0;
		foreach($leave_halfday_cal as $lhalfday):
			$hlfcount += 0.5;
		endforeach;
		return $hlfcount;
	}
}
if ( ! function_exists('count_employee_leave'))
{
	function count_employee_leave($employee_id,$leave_type_id) {
		
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$LeaveModel = new \App\Models\LeaveModel();
		$res_leave = $LeaveModel->where('employee_id', $employee_id)->where('leave_type_id', $leave_type_id)->where('status', 2)->findAll();
		$tinc =0;
		foreach($res_leave as $ires_leave):
			$no_of_days = erp_date_difference($ires_leave['from_date'],$ires_leave['to_date']);
			if($no_of_days < 2){
				$tinc +=1;
			} else {
				$tinc += $no_of_days;
			}
		endforeach;
		return $tinc;
	}
}
// generate employee id
if( !function_exists('generate_random_employeeid') ){
	function generate_random_employeeid($length = 6) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}
// generate subscription id
if( !function_exists('generate_subscription_id') ){
	function generate_subscription_id($length = 10) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}
// generate code
if( !function_exists('generate_random_code') ){
	function generate_random_code($length = 6) {
		$characters = '01Ikro23JKW2ElOK32IKlqwe902LOK789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}
// generate employee id
if( !function_exists('erp_date_difference') ){
	function erp_date_difference($datetime1,$datetime2) {
		
		$idatetime1 = date_create($datetime1);
		$idatetime2 = date_create($datetime2);
		$interval = date_diff($idatetime1, $idatetime2);
		$no_of_days = $interval->format('%a') +1;
				
		return $no_of_days;
	}
}
if( !function_exists('staff_role_resource') ){
// get user role > links > all
	function staff_role_resource(){
		
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$RolesModel = new \App\Models\RolesModel();
		
		// get userinfo and role
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$role_user = $RolesModel->where('role_id', $user_info['user_role_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$role_resources_ids = explode(',',$role_user['role_resources']);
		} else {
			$role_resources_ids = array(0,0);
		}
		return $role_resources_ids;
	}
}
// get selected module
if( !function_exists('select_module_class') ){
	function select_module_class($mClass,$mMethod) {
		$arr = array();
		// dashboard
		if($mClass=='\App\Controllers\Erp\Dashboard') {
			$arr['desk_active'] = 'active';
			$arr['super_open'] = '';
			return $arr;
		} else if($mMethod=='constants' || $mMethod=='email_templates' || $mClass=='\App\Controllers\Erp\Languages') {
			$arr['constants_active'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Companies' && $mMethod=='company_details') {
			$arr['companies_active'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Membership' && $mMethod=='membership_details') {
			$arr['membership_active'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Users' && $mMethod=='user_details') {
			$arr['users_active'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Membershipinvoices' && $mMethod=='billing_details') {
			$arr['billing_details_active'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Projects' && $mMethod=='client_project_details') {
			$arr['client_project_active'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Tasks' && $mMethod=='client_task_details') {
			$arr['client_task_active'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Invoices' && $mMethod=='invoice_details') {
			$arr['invoice_details_active'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Department' && $mMethod=='index') {
			$arr['department_active'] = 'active';
			$arr['core_style_ul'] = 'style="display: block;"';
			$arr['corehr_open'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Designation' && $mMethod=='index') {
			$arr['designation_active'] = 'active';
			$arr['core_style_ul'] = 'style="display: block;"';
			$arr['corehr_open'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Announcements' && $mMethod=='index') {
			$arr['announcements_active'] = 'active';
			$arr['core_style_ul'] = 'style="display: block;"';
			$arr['corehr_open'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Policies' && $mMethod=='index') {
			$arr['policies_active'] = 'active';
			$arr['core_style_ul'] = 'style="display: block;"';
			$arr['corehr_open'] = 'active';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Timesheet' && $mMethod=='attendance') {
			$arr['attnd_active'] = 'active';
			$arr['attendance_open'] = 'active';
			$arr['attendance_style_ul'] = 'style="display: block;"';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Timesheet' && $mMethod=='update_attendance') {
			$arr['upd_attnd_active'] = 'active';
			$arr['attendance_open'] = 'active';
			$arr['attendance_style_ul'] = 'style="display: block;"';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Timesheet' && $mMethod=='monthly_timesheet') {
			$arr['timesheet_active'] = 'active';
			$arr['attendance_open'] = 'active';
			$arr['attendance_style_ul'] = 'style="display: block;"';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Timesheet' && $mMethod=='overtime_request') {
			$arr['overtime_request_act'] = 'active';
			$arr['attendance_open'] = 'active';
			$arr['attendance_style_ul'] = 'style="display: block;"';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Talent' && $mMethod=='performance_indicator') {
			$arr['indicator_active'] = 'active';
			$arr['talent_open'] = 'active';
			$arr['talent_style_ul'] = 'style="display: block;"';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Talent' && $mMethod=='performance_appraisal') {
			$arr['appraisal_active'] = 'active';
			$arr['talent_open'] = 'active';
			$arr['talent_style_ul'] = 'style="display: block;"';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Trackgoals' && $mMethod=='index') {
			$arr['goal_track_active'] = 'active';
			$arr['talent_open'] = 'active';
			$arr['talent_style_ul'] = 'style="display: block;"';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Trackgoals' && $mMethod=='goals_calendar') {
			$arr['goals_calendar_active'] = 'active';
			$arr['talent_open'] = 'active';
			$arr['talent_style_ul'] = 'style="display: block;"';
			return $arr;
		} else if($mClass=='\App\Controllers\Erp\Types' && $mMethod=='competencies') {
			$arr['competencies_active'] = 'active';
			$arr['talent_open'] = 'active';
			$arr['talent_style_ul'] = 'style="display: block;"';
			return $arr;
		}  else if($mClass=='\App\Controllers\Erp\Types' && $mMethod=='goal_type') {
			$arr['tracking_type_active'] = 'active';
			$arr['talent_open'] = 'active';
			$arr['talent_style_ul'] = 'style="display: block;"';
			return $arr;
		}
	}
}
// get timezone
if( !function_exists('all_timezones') ){	
	function all_timezones() {
	$timezones = array(
		'Pacific/Midway'       => "(GMT-11:00) Midway Island",
		'US/Samoa'             => "(GMT-11:00) Samoa",
		'US/Hawaii'            => "(GMT-10:00) Hawaii",
		'US/Alaska'            => "(GMT-09:00) Alaska",
		'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
		'America/Tijuana'      => "(GMT-08:00) Tijuana",
		'US/Arizona'           => "(GMT-07:00) Arizona",
		'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
		'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
		'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
		'America/Mexico_City'  => "(GMT-06:00) Mexico City",
		'America/Monterrey'    => "(GMT-06:00) Monterrey",
		'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
		'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
		'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
		'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
		'America/Bogota'       => "(GMT-05:00) Bogota",
		'America/Lima'         => "(GMT-05:00) Lima",
		'America/Caracas'      => "(GMT-04:30) Caracas",
		'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
		'America/La_Paz'       => "(GMT-04:00) La Paz",
		'America/Santiago'     => "(GMT-04:00) Santiago",
		'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
		'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
		'Greenland'            => "(GMT-03:00) Greenland",
		'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
		'Atlantic/Azores'      => "(GMT-01:00) Azores",
		'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
		'Africa/Casablanca'    => "(GMT) Casablanca",
		'Europe/Dublin'        => "(GMT) Dublin",
		'Europe/Lisbon'        => "(GMT) Lisbon",
		'Europe/London'        => "(GMT) London",
		'Africa/Monrovia'      => "(GMT) Monrovia",
		'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
		'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
		'Europe/Berlin'        => "(GMT+01:00) Berlin",
		'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
		'Europe/Brussels'      => "(GMT+01:00) Brussels",
		'Europe/Budapest'      => "(GMT+01:00) Budapest",
		'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
		'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
		'Europe/Madrid'        => "(GMT+01:00) Madrid",
		'Europe/Paris'         => "(GMT+01:00) Paris",
		'Europe/Prague'        => "(GMT+01:00) Prague",
		'Europe/Rome'          => "(GMT+01:00) Rome",
		'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
		'Europe/Skopje'        => "(GMT+01:00) Skopje",
		'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
		'Europe/Vienna'        => "(GMT+01:00) Vienna",
		'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
		'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
		'Europe/Athens'        => "(GMT+02:00) Athens",
		'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
		'Africa/Cairo'         => "(GMT+02:00) Cairo",
		'Africa/Harare'        => "(GMT+02:00) Harare",
		'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
		'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
		'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
		'Europe/Kiev'          => "(GMT+02:00) Kyiv",
		'Europe/Minsk'         => "(GMT+02:00) Minsk",
		'Europe/Riga'          => "(GMT+02:00) Riga",
		'Europe/Sofia'         => "(GMT+02:00) Sofia",
		'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
		'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
		'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
		'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
		'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
		'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
		'Europe/Moscow'        => "(GMT+03:00) Moscow",
		'Asia/Tehran'          => "(GMT+03:30) Tehran",
		'Asia/Baku'            => "(GMT+04:00) Baku",
		'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
		'Asia/Muscat'          => "(GMT+04:00) Muscat",
		'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
		'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
		'Asia/Kabul'           => "(GMT+04:30) Kabul",
		'Asia/Karachi'         => "(GMT+05:00) Karachi",
		'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
		'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
		'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
		'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
		'Asia/Almaty'          => "(GMT+06:00) Almaty",
		'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
		'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
		'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
		'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
		'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
		'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
		'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
		'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
		'Australia/Perth'      => "(GMT+08:00) Perth",
		'Asia/Singapore'       => "(GMT+08:00) Singapore",
		'Asia/Taipei'          => "(GMT+08:00) Taipei",
		'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
		'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
		'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
		'Asia/Seoul'           => "(GMT+09:00) Seoul",
		'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
		'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
		'Australia/Darwin'     => "(GMT+09:30) Darwin",
		'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
		'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
		'Australia/Canberra'   => "(GMT+10:00) Canberra",
		'Pacific/Guam'         => "(GMT+10:00) Guam",
		'Australia/Hobart'     => "(GMT+10:00) Hobart",
		'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
		'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
		'Australia/Sydney'     => "(GMT+10:00) Sydney",
		'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
		'Asia/Magadan'         => "(GMT+12:00) Magadan",
		'Pacific/Auckland'     => "(GMT+12:00) Auckland",
		'Pacific/Fiji'         => "(GMT+12:00) Fiji",
		);
		return $timezones;
	}
	if( !function_exists('secret_key') ){	
		function secret_key($string='') {
			$data = 'J87JUHYTG5623GHrhej789kjhyrRe34k';
			$data = str_replace(['+','/','='],['-','_',''],$data);
			return $data;
		}
	}
	if( !function_exists('safe_b64encode') ){	
		function safe_b64encode($string='') {
			$data = base64_encode($string);
			$data = str_replace(['+','/','='],['-','_',''],$data);
			return $data;
		}
	}
	if( !function_exists('safe_b64decode') ){
		function safe_b64decode($string='') {
			$data = str_replace(['-','_'],['+','/'],$string);
			$mod4 = strlen($data) % 4;
			if ($mod4) {
				$data .= substr('====', $mod4);
			}
			return base64_decode($data);
		}
	}
	if( !function_exists('uencode') ){
		function uencode($value=false){ 
			if(!$value) return false;
			$iv_size = openssl_cipher_iv_length('aes-256-cbc');
			$iv = openssl_random_pseudo_bytes($iv_size);
			$crypttext = openssl_encrypt($value, 'aes-256-cbc', secret_key(), OPENSSL_RAW_DATA, $iv);
			return safe_b64encode($iv.$crypttext); 
		}
	}
	if( !function_exists('udecode') ){
		function udecode($value=false){
			if(!$value) return false;
			$crypttext = safe_b64decode($value);
			$iv_size = openssl_cipher_iv_length('aes-256-cbc');
			$iv = substr($crypttext, 0, $iv_size);
			$crypttext = substr($crypttext, $iv_size);
			if(!$crypttext) return false;
			$decrypttext = openssl_decrypt($crypttext, 'aes-256-cbc', secret_key(), OPENSSL_RAW_DATA, $iv);
			return rtrim($decrypttext);
		}
	}
	
	//// file helper
	if( !function_exists('filesrc') ){
		function filesrc($fileName, $type ='full'){
			
			$path = './public/uploads/users/';
			if($type!='full')
				$path .= $type.'/';
			return $path . $fileName;	
		}
	}
	if( !function_exists('filecsrc') ){
		function filecsrc($fileName, $type ='full'){
			
			$path = './public/uploads/clients/';
			if($type!='full')
				$path .= $type.'/';
			return $path . $fileName;	
		}
	}
	if( !function_exists('langfilesrc') ){
		function langfilesrc($fileName, $type ='full'){
			
			$path = './public/uploads/languages_flag/temp/';
			if($type!='full')
				$path .= $type.'/';
			return $path . $fileName;	
		}
	}
	if( !function_exists('convertNumberToWord') ){
		function convertNumberToWord($num = false) {
			$num = str_replace(array(',', ' '), '' , trim($num));
			if(! $num) {
				return false;
			}
			$num = (int) $num;
			$words = array();
			$list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
				'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
			);
			$list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
			$list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
				'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
				'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
			);
			$num_length = strlen($num);
			$levels = (int) (($num_length + 2) / 3);
			$max_length = $levels * 3;
			$num = substr('00' . $num, -$max_length);
			$num_levels = str_split($num, 3);
			for ($i = 0; $i < count($num_levels); $i++) {
				$levels--;
				$hundreds = (int) ($num_levels[$i] / 100);
				$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
				$tens = (int) ($num_levels[$i] % 100);
				$singles = '';
				if ( $tens < 20 ) {
					$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
				} else {
					$tens = (int)($tens / 10);
					$tens = ' ' . $list2[$tens] . ' ';
					$singles = (int) ($num_levels[$i] % 10);
					$singles = ' ' . $list1[$singles] . ' ';
				}
				$words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
			} //end for loop
			$commas = count($words);
			if ($commas > 1) {
				$commas = $commas - 1;
			}
			return implode(' ', $words);
		}
	}
	if( !function_exists('erp_paid_invoices') ){

		function erp_paid_invoices($invoice_month){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$InvoicesModel = new \App\Models\InvoicesModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$paid_invoice = $InvoicesModel->where('company_id',$company_id)->where('invoice_month', $invoice_month)->where('status', 1)->findAll();
			$pinc = 0;
			foreach($paid_invoice as $pinvoice){
				$pinc += $pinvoice['grand_total'];
			}
			
			return $pinc;
		}
	}
	if( !function_exists('company_paid_invoices') ){

		function company_paid_invoices($invoice_month){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$InvoicepaymentsModel = new \App\Models\InvoicepaymentsModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			$paid_invoice = $InvoicepaymentsModel->where('invoice_month', $invoice_month)->findAll();
			$pinc = 0;
			foreach($paid_invoice as $pinvoice){
				$pinc += $pinvoice['membership_price'];
			}
			
			return $pinc;
		}
	}
	if( !function_exists('client_paid_invoices') ){

		function client_paid_invoices($invoice_month){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$InvoicesModel = new \App\Models\InvoicesModel();
			$paid_invoice = $InvoicesModel->where('client_id',$usession['sup_user_id'])->where('invoice_month', $invoice_month)->where('status', 1)->findAll();
			$pinc = 0;
			foreach($paid_invoice as $pinvoice){
				$pinc += $pinvoice['grand_total'];
			}
			
			return $pinc;
		}
	}
	if( !function_exists('erp_unpaid_invoices') ){

		function erp_unpaid_invoices($invoice_month){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$InvoicesModel = new \App\Models\InvoicesModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$paid_invoice = $InvoicesModel->where('company_id',$company_id)->where('invoice_month', $invoice_month)->where('status', 0)->findAll();
			$pinc = 0;
			foreach($paid_invoice as $pinvoice){
				$pinc += $pinvoice['grand_total'];
			}
			
			return $pinc;
		}
	}
	if( !function_exists('client_unpaid_invoices') ){

		function client_unpaid_invoices($invoice_month){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$InvoicesModel = new \App\Models\InvoicesModel();
			$paid_invoice = $InvoicesModel->where('client_id',$usession['sup_user_id'])->where('invoice_month', $invoice_month)->where('status', 0)->findAll();
			$pinc = 0;
			foreach($paid_invoice as $pinvoice){
				$pinc += $pinvoice['grand_total'];
			}
			
			return $pinc;
		}
	}
	if( !function_exists('erp_payroll') ){

		function erp_payroll($salary_month){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$PayrollModel = new \App\Models\PayrollModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$paid_amount = $PayrollModel->where('company_id',$company_id)->where('salary_month', $salary_month)->findAll();
			$pinc = 0;
			$pamn = 0;
			foreach($paid_amount as $pamount){
				$pamn += $pamount['net_salary'];
			}
			
			return $pamn;
		}
	}
	if( !function_exists('staff_payroll') ){

		function staff_payroll($salary_month,$staff_id){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$PayrollModel = new \App\Models\PayrollModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$paid_amount = $PayrollModel->where('company_id',$company_id)->where('salary_month', $salary_month)->where('staff_id', $staff_id)->findAll();
			$pinc = 0;
			$pamn = 0;
			foreach($paid_amount as $pamount){
				$pamn += $pamount['net_salary'];
			}
			
			return $pamn;
		}
	}
	if( !function_exists('total_expense') ){

		function total_expense(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$TransactionsModel = new \App\Models\TransactionsModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$expense = $TransactionsModel->where('company_id',$company_id)->where('transaction_type', 'expense')->findAll();
			$exp_amn = 0;
			foreach($expense as $pamount){
				$exp_amn += $pamount['amount'];
			}
			
			return $exp_amn;
		}
	}
	if( !function_exists('total_deposit') ){

		function total_deposit(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$TransactionsModel = new \App\Models\TransactionsModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$expense = $TransactionsModel->where('company_id',$company_id)->where('transaction_type', 'income')->findAll();
			$exp_amn = 0;
			foreach($expense as $pamount){
				$exp_amn += $pamount['amount'];
			}
			
			return $exp_amn;
		}
	}
	if( !function_exists('total_payroll') ){

		function total_payroll(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$PayrollModel = new \App\Models\PayrollModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$paid_amount = $PayrollModel->where('company_id',$company_id)->findAll();
			$pinc = 0;
			$pamn = 0;
			foreach($paid_amount as $pamount){
				$pamn += $pamount['net_salary'];
			}
			if($pamn > 0){
				$pamn = $pamn;
			} else {
				$pamn = 0;
			}
			return $pamn;
		}
	}
	if (!function_exists('payroll_this_month'))
	{
		function payroll_this_month() {
				// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$PayrollModel = new \App\Models\PayrollModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$paid_amount = $PayrollModel->where('company_id',$company_id)->where('salary_month', date('Y-m'))->findAll();
			$pinc = 0;
			$pamn = 0;
			foreach($paid_amount as $pamount){
				$pamn += $pamount['net_salary'];
			}
			if($pamn > 0){
				$pamn = $pamn;
			} else {
				$pamn = 0;
			}
			return $pamn;
		}
	}
	if( !function_exists('staff_total_payroll') ){

		function staff_total_payroll(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$PayrollModel = new \App\Models\PayrollModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$paid_amount = $PayrollModel->where('company_id',$company_id)->where('staff_id', $usession['sup_user_id'])->findAll();
			$pinc = 0;
			$pamn = 0;
			foreach($paid_amount as $pamount){
				$pamn += $pamount['net_salary'];
			}
			if($pamn > 0){
				$pamn = $pamn;
			} else {
				$pamn = 0;
			}
			return $pamn;
		}
	}
	if (!function_exists('staff_payroll_this_month'))
	{
		function staff_payroll_this_month() {
				// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$PayrollModel = new \App\Models\PayrollModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$paid_amount = $PayrollModel->where('company_id',$company_id)->where('salary_month', date('Y-m'))->where('staff_id', $usession['sup_user_id'])->findAll();
			$pinc = 0;
			$pamn = 0;
			foreach($paid_amount as $pamount){
				$pamn += $pamount['net_salary'];
			}
			if($pamn > 0){
				$pamn = $pamn;
			} else {
				$pamn = 0;
			}
			return $pamn;
		}
	}
	if( !function_exists('erp_total_paid_invoices') ){

		function erp_total_paid_invoices(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$InvoicesModel = new \App\Models\InvoicesModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$paid_invoice = $InvoicesModel->where('company_id',$company_id)->where('status', 1)->findAll();
			$pinc = 0;
			foreach($paid_invoice as $pinvoice){
				$pinc += $pinvoice['grand_total'];
			}
			
			return $pinc;
		}
	}
	if( !function_exists('erp_total_unpaid_invoices') ){

		function erp_total_unpaid_invoices(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$InvoicesModel = new \App\Models\InvoicesModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$paid_invoice = $InvoicesModel->where('company_id',$company_id)->where('status', 0)->findAll();
			$pinc = 0;
			foreach($paid_invoice as $pinvoice){
				$pinc += $pinvoice['grand_total'];
			}
			
			return $pinc;
		}
	}
	if( !function_exists('client_total_unpaid_invoices') ){

		function client_total_unpaid_invoices(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$InvoicesModel = new \App\Models\InvoicesModel();
			$paid_invoice = $InvoicesModel->where('client_id',$usession['sup_user_id'])->where('status', 0)->findAll();
			$pinc = 0;
			foreach($paid_invoice as $pinvoice){
				$pinc += $pinvoice['grand_total'];
			}
			
			return $pinc;
		}
	}
	if( !function_exists('client_total_paid_invoices') ){

		function client_total_paid_invoices(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$InvoicesModel = new \App\Models\InvoicesModel();
			$paid_invoice = $InvoicesModel->where('client_id',$usession['sup_user_id'])->where('status', 1)->findAll();
			$pinc = 0;
			foreach($paid_invoice as $pinvoice){
				$pinc += $pinvoice['grand_total'];
			}
			
			return $pinc;
		}
	}
	if( !function_exists('total_membership_payments') ){

		function total_membership_payments(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$InvoicepaymentsModel = new \App\Models\InvoicepaymentsModel();
			$paid_invoice = $InvoicepaymentsModel->orderBy('membership_invoice_id','ASC')->findAll();
			$pinc = 0;
			foreach($paid_invoice as $pinvoice){
				$pinc += $pinvoice['membership_price'];
			}
			
			return $pinc;
		}
	}
	if( !function_exists('staff_total_expense') ){

		function staff_total_expense(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$TransactionsModel = new \App\Models\TransactionsModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$expense = $TransactionsModel->where('company_id',$company_id)->where('transaction_type', 'expense')->where('staff_id', $usession['sup_user_id'])->findAll();
			$exp_amn = 0;
			foreach($expense as $pamount){
				$exp_amn += $pamount['amount'];
			}
			
			return $exp_amn;
		}
	}
	if( !function_exists('staff_leave') ){

		function staff_leave(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$LeaveModel = new \App\Models\LeaveModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$leave = $LeaveModel->where('company_id',$company_id)->where('employee_id', $usession['sup_user_id'])->countAllResults();			
			return $leave;
		}
	}
	if( !function_exists('staff_overtime_request') ){

		function staff_overtime_request(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$OvertimerequestModel = new \App\Models\OvertimerequestModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$overtime_req = $OvertimerequestModel->where('company_id',$company_id)->where('staff_id', $usession['sup_user_id'])->countAllResults();			
			return $overtime_req;
		}
	}
	if( !function_exists('staff_travel_request') ){

		function staff_travel_request(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$TravelModel = new \App\Models\TravelModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$travel_req = $TravelModel->where('company_id',$company_id)->where('employee_id', $usession['sup_user_id'])->countAllResults();			
			return $travel_req;
		}
	}
	if( !function_exists('staff_awards') ){

		function staff_awards(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$AwardsModel = new \App\Models\AwardsModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$awards = $AwardsModel->where('company_id',$company_id)->where('employee_id', $usession['sup_user_id'])->countAllResults();			
			return $awards;
		}
	}
	if( !function_exists('staff_assets') ){

		function staff_assets(){
					
			// get session
			$session = \Config\Services::session();
			$usession = $session->get('sup_username');
			
			$UsersModel = new \App\Models\UsersModel();
			$AssetsModel = new \App\Models\AssetsModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$assets = $AssetsModel->where('company_id',$company_id)->where('employee_id', $usession['sup_user_id'])->countAllResults();			
			return $assets;
		}
	}
	if( !function_exists('time_ago') ){
		function time_ago($time_ago)
		{
			$time_ago = strtotime($time_ago);
			$cur_time   = time();
			$time_elapsed   = $cur_time - $time_ago;
			$seconds    = $time_elapsed ;
			$minutes    = round($time_elapsed / 60 );
			$hours      = round($time_elapsed / 3600);
			$days       = round($time_elapsed / 86400 );
			$weeks      = round($time_elapsed / 604800);
			$months     = round($time_elapsed / 2600640 );
			$years      = round($time_elapsed / 31207680 );
			// Seconds
			if($seconds <= 60){
				return lang('Main.xin_just_now');
			}
			//Minutes
			else if($minutes <=60){
				if($minutes==1){
					return lang('Main.xin_one_minute_ago');
				}
				else{
					return "$minutes ".lang('Main.xin_minutes_ago');
				}
			}
			//Hours
			else if($hours <=24){
				if($hours==1){
					return lang('Main.xin_an_hour_ago');
				}else{
					return "$hours ".lang('Main.xin_hours_ago');
				}
			}
			//Days
			else if($days <= 7){
				if($days==1){
					return lang('Main.xin_yesterday');
				}else{
					return "$days ".lang('Main.xin_days_ago');
				}
			}
			//Weeks
			else if($weeks <= 4.3){
				if($weeks==1){
					return lang('Main.xin_a_week_ago');
				}else{
					return "$weeks ".lang('Main.xin_weeks_ago');
				}
			}
			//Months
			else if($months <=12){
				if($months==1){
					return lang('Main.xin_a_month_ago');
				}else{
					return "$months ".lang('Main.xin_months_ago');
				}
			}
			//Years
			else{
				if($years==1){
					return lang('Main.xin_one_year_ago');
				}else{
					return "$years ".lang('Main.xin_years_go');
				}
			}
		}
	}
}
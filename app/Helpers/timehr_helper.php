<?php
use CodeIgniter\I18n\Time;
//TimeHRM - Helper
if( !function_exists('dashboard_profile_completeness') ){

	function dashboard_profile_completeness(){
				
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$ShiftModel = new \App\Models\ShiftModel();
		$RolesModel = new \App\Models\RolesModel();
		$ConstantsModel = new \App\Models\ConstantsModel();
		$DesignationModel = new \App\Models\DesignationModel();
		$DepartmentModel = new \App\Models\DepartmentModel();		
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->countAllResults();
		$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->countAllResults();
		$office_shifts = $ShiftModel->where('company_id',$usession['sup_user_id'])->countAllResults();
		$roles = $RolesModel->where('company_id',$usession['sup_user_id'])->countAllResults();
		$competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->countAllResults();
		$competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->countAllResults();
		$fcompetencies = $competencies + $competencies2;
		if($roles > 0): $roles = 1; endif;
		if($fcompetencies > 1): $fcompetencies = 1; else: $fcompetencies = 0; endif;
		if($departments > 0): $departments = 1; endif;
		if($designations > 0): $designations = 1; endif;
		if($office_shifts > 0): $office_shifts = 1; endif;
		
		$val = $roles + $fcompetencies + $departments + $designations + $office_shifts;
		$total_val = $val * 20;
		$data = array('departments' => $departments,'designations' => $designations,'office_shifts' => $office_shifts,'roles' => $roles,'competencies' => $fcompetencies,'percent' => $total_val);
		return $data;
	}
}
if( !function_exists('attendance_time_checks') ){

	function attendance_time_checks(){
		
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$today_date = date('Y-m-d');
		$UsersModel = new \App\Models\UsersModel();
		$TimesheetModel = new \App\Models\TimesheetModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $TimesheetModel->where('company_id',$user_info['company_id'])->where('employee_id',$usession['sup_user_id'])->where('attendance_date',$today_date)->where('clock_out','')->orderBy('time_attendance_id', 'DESC')->countAllResults();
		if($get_data > 0): $get_data = 1; else: $get_data = 0; endif;
		return $get_data;
	}
}
if( !function_exists('attendance_time_checks_value') ){
	// attendance_time_checks_value
	function attendance_time_checks_value(){	

		$db      = \Config\Database::connect();
		// get session
		$session = \Config\Services::session();
		$UsersModel = new \App\Models\UsersModel();
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$builder = $db->table('ci_timesheet');
		$builder->where('company_id', $user_info['company_id']);
		$builder->where('employee_id', $usession['sup_user_id']);
		$builder->where('clock_out', '');
		$builder->orderBy('time_attendance_id', 'DESC');
		$builder->limit(1);
		$query = $builder->get();
		return $query->getResult();
	}
}
if( !function_exists('check_user_attendance') ){

	function check_user_attendance(){
		
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$today_date = date('Y-m-d');
		$UsersModel = new \App\Models\UsersModel();
		$TimesheetModel = new \App\Models\TimesheetModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $TimesheetModel->where('company_id',$user_info['company_id'])->where('employee_id',$usession['sup_user_id'])->where('attendance_date',$today_date)->orderBy('time_attendance_id', 'DESC')->countAllResults();
		if($get_data > 0): $get_data = 1; else: $get_data = 0; endif;
		return $get_data;
	}
}
if( !function_exists('check_user_attendance_value') ){
	// check_user_attendance
	function check_user_attendance_value(){	

		$db      = \Config\Database::connect();
		// get session
		$session = \Config\Services::session();
		$UsersModel = new \App\Models\UsersModel();
		$usession = $session->get('sup_username');
		$today_date = date('Y-m-d');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$builder = $db->table('ci_timesheet');
		$builder->where('company_id', $user_info['company_id']);
		$builder->where('employee_id', $usession['sup_user_id']);
		$builder->where('attendance_date', $today_date);
		$builder->orderBy('time_attendance_id', 'DESC');
		$builder->limit(1);
		$query = $builder->get();
		return $query->getResult();
	}
}
if( !function_exists('check_user_attendance_clockout_value') ){
	// check_user_attendance
	function check_user_attendance_clockout_value(){	

		$db      = \Config\Database::connect();
		// get session
		$session = \Config\Services::session();
		$UsersModel = new \App\Models\UsersModel();
		$usession = $session->get('sup_username');
		$today_date = date('Y-m-d');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$builder = $db->table('ci_timesheet');
		$builder->where('company_id', $user_info['company_id']);
		$builder->where('employee_id', $usession['sup_user_id']);
		$builder->where('attendance_date', $today_date);
		$builder->where('clock_out', '');
		$builder->orderBy('time_attendance_id', 'DESC');
		$builder->limit(1);
		$query = $builder->get();
		return $query->getResult();
	}
}
if( !function_exists('user_attendance_monthly_value') ){
	// user_attendance_monthly_value
	function user_attendance_monthly_value($attendance_date,$user_id){	

		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$UsersModel = new \App\Models\UsersModel();
		$TimesheetModel = new \App\Models\TimesheetModel();
		$user_info = $UsersModel->where('user_id', $user_id)->first();
		$get_data = $TimesheetModel->where('company_id',$user_info['company_id'])->where('employee_id',$user_id)->where('attendance_date',$attendance_date)->orderBy('time_attendance_id', 'DESC')->countAllResults();
		if($get_data > 0): $get_data = 1; else: $get_data = 0; endif;
		return $get_data;
	}
}
// single user
if( !function_exists('staff_profile_photo') ){
	function staff_profile_photo($user_id){
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$user_info = $UsersModel->where('user_id', $user_id)->first();
		if($user_info['user_type'] != 'customer'){
			if($user_info['profile_photo'] == '' || $user_info['profile_photo'] == 'no'){
				if($user_info['gender']==1) {
					$user_img = base_url().'/public/uploads/users/default/default_profile.jpg';
				} else {
					$user_img = base_url().'/public/uploads/users/default/default_profile.jpg';
				}
			} else {
				$user_img = base_url().'/public/uploads/users/thumb/'.$user_info['profile_photo'];
			}
		} else {
			if($user_info['profile_photo'] == '' || $user_info['profile_photo'] == 'no'){
				if($user_info['gender']==1) {
					$user_img = base_url().'/public/uploads/users/default/default_profile.jpg';
				} else {
					$user_img = base_url().'/public/uploads/users/default/default_profile.jpg';
				}
			} else {
				$user_img = base_url().'/public/uploads/clients/thumb/'.$user_info['profile_photo'];
			}
		}
		return $user_img;
	}
}
// multi users with profile photo
if( !function_exists('multi_user_profile_photo') ){
	function multi_user_profile_photo($multi_user){
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		
		$ol = '';
		foreach($multi_user as $user_id) {
			// get staff info
			if($user_id!=0){
				$assigned_to = $UsersModel->where('user_id', $user_id)->where('user_type','staff')->first();
				if($assigned_to){
					$assigned_name = $assigned_to['first_name'].' '.$assigned_to['last_name'];
					if($assigned_to['profile_photo'] == ''){
						if($assigned_to['gender']==1) {
							$user_img = base_url().'/public/uploads/users/default/default_male.png';
						} else {
							$user_img = base_url().'/public/uploads/users/default/default_female.png';
						}
						$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="mb-1"><img src="'.$user_img.'" class="img-fluid img-radius wid-30 mr-1" alt=""></span></a>';
					} else {
						$user_img = base_url().'/public/uploads/users/thumb/'.$assigned_to['profile_photo'];
						$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="mb-1"><img src="'.$user_img.'" class="img-fluid img-radius wid-30 mr-1" alt=""></span></a>';
					}
					$ol .= '';
				} else {
					$ol .= '';
				}
			}
			$ol .= '';
		}
		$ol .= '';
		return $ol;
	}
}
// multi users only names
if( !function_exists('multi_users_info') ){
	function multi_users_info($multi_user){
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		
		$ol = ''; $i=0;
		foreach($multi_user as $user_id) {
			// get staff info
			if($user_id) {
				if($user_id!=0){
					$assigned_to = $UsersModel->where('user_id', $user_id)->where('user_type','staff')->first();
					if($assigned_to) {
					$assigned_name = $assigned_to['first_name'].' '.$assigned_to['last_name'];
					$ol .= $i.': '.$assigned_name.'<br>';
					} else {
						$ol .= '';
					}
				}
			} else {
				$ol .= '';
			}
			$ol .= '';
			$i++;
		}
		$ol .= '';
		return $ol;
	}
}
// company membership || expiry
if( !function_exists('user_company_info') ){
	function user_company_info(){
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$UsersModel = new \App\Models\UsersModel();
				
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'company'){
			$company_id = $usession['sup_user_id'];
		} else if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else if($user_info['user_type'] == 'customer'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		return $company_id;
	}
}
// company membership || expiry
if( !function_exists('company_membership_details') ){
	function company_membership_details(){
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		//use CodeIgniter\I18n\Time;
		//new \App\I18n\Time();
		$UsersModel = new \App\Models\UsersModel();
		$MembershipModel = new \App\Models\MembershipModel();
		$CompanymembershipModel = new \App\Models\CompanymembershipModel();
	
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
					
		$company_membership = $CompanymembershipModel->where('company_id', $usession['sup_user_id'])->first();
		$subs_plan = $MembershipModel->where('membership_id', $company_membership['membership_id'])->first();
		
		if($subs_plan['plan_duration']==1){
			if($subs_plan['membership_id']==1){
				$time = Time::parse($company_membership['update_at'], 'Asia/Karachi');
				$add_time = $time->addMonths(1);
				$now = Time::now('Asia/Karachi');
				$itime = Time::parse($add_time, 'Asia/Karachi');
				$diff_days = $now->difference($itime);
				$plan_msg = lang('Membership.xin_trial_is_expiring').' '.$diff_days->getDays().' '.lang('Leave.xin_leave_days');
				$remaing_days = $diff_days->getDays();
			} else {
				$time = Time::parse($company_membership['update_at'], 'Asia/Karachi');
				$add_time = $time->addMonths(1);
				$now = Time::now('Asia/Karachi');
				$itime = Time::parse($add_time, 'Asia/Karachi');
				$diff_days = $now->difference($itime);
				$plan_msg = lang('Membership.xin_plan_is_expiring').' '.$diff_days->getDays().' '.lang('Leave.xin_leave_days');
				$remaing_days = $diff_days->getDays();
			}
			$plan_duration = lang('Membership.xin_subscription_monthly');
		} else if($subs_plan['plan_duration']==2){
			if($subs_plan['membership_id']==1){
				$time = Time::parse($company_membership['update_at'], 'Asia/Karachi');
				$add_time = $time->addYears(1);
				$now = Time::now('Asia/Karachi');
				$itime = Time::parse($add_time, 'Asia/Karachi');
				$diff_days = $now->difference($itime);
				$plan_msg = lang('Membership.xin_trial_is_expiring').' '.$diff_days->getDays().' '.lang('Leave.xin_leave_days');
				$remaing_days = $diff_days->getDays();
			} else {
				$time = Time::parse($company_membership['update_at'], 'Asia/Karachi');
				$add_time = $time->addYears(1);
				$now = Time::now('Asia/Karachi');
				$itime = Time::parse($add_time, 'Asia/Karachi');
				$diff_days = $now->difference($itime);
				$plan_msg = lang('Membership.xin_plan_is_expiring').' '.$diff_days->getDays().' '.lang('Leave.xin_leave_days');
				$remaing_days = $diff_days->getDays();
			}
			$plan_duration = lang('Membership.xin_subscription_yearly');
		} else {
			if($subs_plan['membership_id']==1){
				$plan_msg = lang('Membership.xin_you_are_using_unlimited_plan');
			} else {
				$plan_msg = lang('Membership.xin_you_are_using_unlimited_plan');
			}
			$time_diff = '';
			$plan_duration = lang('Membership.xin_subscription_unlimit');
			$remaing_days = 300*100;
		}
		$plan_data = array('plan_msg' => $plan_msg,'plan_duration' => $plan_duration,'diff_days' => $remaing_days);
		return $plan_data;
	}
}
// company membership || In-Active|Active
if( !function_exists('company_membership_activation') ){
	function company_membership_activation(){
		
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		//use CodeIgniter\I18n\Time;
		//new \App\I18n\Time();
		$UsersModel = new \App\Models\UsersModel();
		$MembershipModel = new \App\Models\MembershipModel();
		$CompanymembershipModel = new \App\Models\CompanymembershipModel();
	
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'company'){
			$company_id = $usession['sup_user_id'];
		} else if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else if($user_info['user_type'] == 'customer'){
			$company_id = $user_info['company_id'];
		}
		
		$company_membership = $CompanymembershipModel->where('company_id', $company_id)->first();
		$subs_plan = $MembershipModel->where('membership_id', $company_membership['membership_id'])->first();
		
		if($subs_plan['plan_duration']==1){
			$time = Time::parse($company_membership['update_at'], 'Asia/Karachi');
			$add_time = $time->addMonths(1);
			$now = Time::now('Asia/Karachi');
			$itime = Time::parse($add_time, 'Asia/Karachi');
			$diff_days = $now->difference($itime);
			$time_diff = $itime->isAfter($now);
			return $time_diff;
		} else if($subs_plan['plan_duration']==2){
			$time = Time::parse($company_membership['update_at'], 'Asia/Karachi');
			$add_time = $time->addYears(1);
			$now = Time::now('Asia/Karachi');
			$itime = Time::parse($add_time, 'Asia/Karachi');
			$diff_days = $now->difference($itime);
			$time_diff = $itime->isAfter($now);
			return $time_diff;
		} else {
			return 1;
		}
	}
}
if( !function_exists('notification_data') ){
	function notification_data(){
	}
}
if( !function_exists('erp_company_settings') ){
	function erp_company_settings(){
		
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');

		$UsersModel = new \App\Models\UsersModel();
		$CompanysettingsModel = new \App\Models\CompanysettingsModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'super_user'){
		    $company_id = $usession['sup_user_id'];
		}else if($user_info['user_type'] == 'company'){
			$company_id = $usession['sup_user_id'];
		} else if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else if($user_info['user_type'] == 'customer'){
			$company_id = $user_info['company_id'];
		}
		
		$company_settings = $CompanysettingsModel->where('company_id', $company_id)->first();
		return $company_settings;
	}
}

if( !function_exists('generate_timezone_list') ){
function generate_timezone_list()
	{
		static $regions = array(
			DateTimeZone::AFRICA,
			DateTimeZone::AMERICA,
			DateTimeZone::ANTARCTICA,
			DateTimeZone::ASIA,
			DateTimeZone::ATLANTIC,
			DateTimeZone::AUSTRALIA,
			DateTimeZone::EUROPE,
			DateTimeZone::INDIAN,
			DateTimeZone::PACIFIC,
		);
	
		$timezones = array();
		foreach( $regions as $region )
		{
			$timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
		}
	
		$timezone_offsets = array();
		foreach( $timezones as $timezone )
		{
			$tz = new DateTimeZone($timezone);
			$timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
		}
	
		// sort timezone by offset
		asort($timezone_offsets);
	
		$timezone_list = array();
		foreach( $timezone_offsets as $timezone => $offset )
		{
			$offset_prefix = $offset < 0 ? '-' : '+';
			$offset_formatted = gmdate( 'H:i', abs($offset) );
	
			$pretty_offset = "UTC${offset_prefix}${offset_formatted}";
	
			$timezone_list[$timezone] = "(${pretty_offset}) $timezone";
		}
	
		return $timezone_list;
	}
}
if( !function_exists('timehrm_mail_data') ){

	function timehrm_mail_data($from,$from_name,$to,$subject,$body){
	  
		
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$SystemModel = new \App\Models\SystemModel();
		$UsersModel = new \App\Models\UsersModel();
		//$EmailtemplatesModel = new \App\Models\EmailtemplatesModel();
		
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		
		if($xin_system['email_type']=="codeigniter"){
			//default email config
			$email = \Config\Services::email();
			//$email->mailType("html");
			$email->setFrom($from,$from_name);
			$email->setTo($to);
			$email->setSubject($subject);
			$email->setMessage($body);
			$email->send();
		
		} elseif($xin_system['email_type']=="smtp"){
			//default smtp config
			$email = \Config\Services::smtp();
			//$email->mailType("html");
			$email->setFrom($from,$from_name);
			$email->setTo($to);
			$email->setSubject($subject);
			$email->setMessage($body);
			$email->send();
		
		} elseif($xin_system['email_type']=="phpmail"){
		
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
			// More headers
			$headers .= 'From: ' .$from. "\r\n";
			
			mail($to,$subject,$body,$headers); 
		
		}
	  
	}
}
if( !function_exists('account_statement_report') ){

	function account_statement_report($start_date,$end_date,$get_id){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$AccountsModel = new \App\Models\AccountsModel();
		$TransactionsModel = new \App\Models\TransactionsModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		
		$builder = $db->table('ci_finance_transactions');
		$builder->where('transaction_date BETWEEN "'. $start_date. '" and "'. $end_date.'"');
		$builder->where('account_id', $get_id);
		$builder->where('company_id', $company_id);
		$query = $builder->get();
		$transaction_data = $query->getResult();
		
		return $transaction_data;
	}
}
if( !function_exists('training_report') ){

	function training_report($start_date,$end_date,$status){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$TrainingModel = new \App\Models\TrainingModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		if($status == 'all_status'){
			$training_data = $TrainingModel->where('company_id', $company_id)->where('start_date >=',$start_date)->where('finish_date <=' ,$end_date)->findAll();
		} else {
			$training_data = $TrainingModel->where('company_id', $company_id)->where('start_date >=',$start_date)->where('finish_date <=' ,$end_date)->where('training_status' ,$status)->findAll();
		}
		
		return $training_data;
	}
}
if( !function_exists('leave_report') ){

	function leave_report($start_date,$end_date,$status){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$LeaveModel = new \App\Models\LeaveModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		if($status == 'all_status'){
			$leave_data = $LeaveModel->where('company_id', $company_id)->where('from_date >=',$start_date)->where('to_date <=' ,$end_date)->findAll();
		} else {
			$leave_data = $LeaveModel->where('company_id', $company_id)->where('from_date >=',$start_date)->where('to_date <=' ,$end_date)->where('status' ,$status)->findAll();
		}
		
		return $leave_data;
	}
}
if( !function_exists('purchases_report') ){

	function purchases_report($start_date,$end_date,$status){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$PurchasesModel = new \App\Models\PurchasesModel();
		//$TransactionsModel = new \App\Models\TransactionsModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		
		$builder = $db->table('ci_stock_purchases');
		if($status == 'all_status'){
			$builder->where('purchase_date BETWEEN "'. $start_date. '" and "'. $end_date.'"');
			$builder->where('company_id', $company_id);
		} else {
			$builder->where('purchase_date BETWEEN "'. $start_date. '" and "'. $end_date.'"');
			$builder->where('status', $status);
			$builder->where('company_id', $company_id);
		}
		
		$query = $builder->get();
		$purchases_data = $query->getResult();
		
		return $purchases_data;
	}
}
if( !function_exists('invoice_report') ){

	function invoice_report($start_date,$end_date,$status){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$AccountsModel = new \App\Models\AccountsModel();
		$TransactionsModel = new \App\Models\TransactionsModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		
		$builder = $db->table('ci_invoices');
		if($status == 'all_status'){
			$builder->where('invoice_date BETWEEN "'. $start_date. '" and "'. $end_date.'"');
			$builder->where('company_id', $company_id);
		} else {
			$builder->where('invoice_date BETWEEN "'. $start_date. '" and "'. $end_date.'"');
			$builder->where('status', $status);
			$builder->where('company_id', $company_id);
		}
		
		$query = $builder->get();
		$transaction_data = $query->getResult();
		
		return $transaction_data;
	}
}
if( !function_exists('sales_report') ){

	function sales_report($start_date,$end_date,$status){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$AccountsModel = new \App\Models\AccountsModel();
		$TransactionsModel = new \App\Models\TransactionsModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		
		$builder = $db->table('ci_stock_orders');
		if($status == 'all_status'){
			$builder->where('invoice_date BETWEEN "'. $start_date. '" and "'. $end_date.'"');
			$builder->where('company_id', $company_id);
		} else {
			$builder->where('invoice_date BETWEEN "'. $start_date. '" and "'. $end_date.'"');
			$builder->where('status', $status);
			$builder->where('company_id', $company_id);
		}
		
		$query = $builder->get();
		$transaction_data = $query->getResult();
		
		return $transaction_data;
	}
}
if( !function_exists('currency_converter_values') ){

	function currency_converter_values() {	
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
		$url = 'https://api.exchangerate-api.com/v4/latest/'.$xin_system['default_currency'];
		//$to_currency = $toCurrency;
		$url=file_get_contents($url);
		$url = json_decode($url);
		$rates = $url->rates;
		return $rates;
	}
}
if( !function_exists('currency_converted_values') ){

	function currency_converted_values() {	
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$currency_val = unserialize($xin_system['currency_converter']);
		
		$converted=0;
		foreach($currency_val as $_val=>$_key){
			if($_val == $xin_system['default_currency']){
				echo $converted = $_key;
			} 
		}
	}
}
if( !function_exists('currency_converter') ){

	function currency_converter($amount) {	
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$xin_system = erp_company_settings();
		$xin_super_system = $SystemModel->where('setting_id', 1)->first();
		$currency_val = unserialize($xin_super_system['currency_converter']);
		$i=0;
		foreach($currency_val as $_val=>$_key){
			if($_val == $xin_system['default_currency']){
				$converted = $_key * $amount;
				return $converted;
			}
			$i++;
		}
	}
}
if( !function_exists('staff_projects') ){

	function staff_projects($id){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$ProjectsModel = new \App\Models\ProjectsModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$company_id = $user_info['company_id'];
		
		$data = $ProjectsModel->where('company_id',$company_id)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'")->findAll();
		
		return $data;
	}
}
if( !function_exists('assigned_staff_projects') ){

	function assigned_staff_projects($id){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$ProjectsModel = new \App\Models\ProjectsModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$company_id = $user_info['company_id'];
		
		$data = $ProjectsModel->where('company_id',$company_id)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id' or added_by = '$id'")->findAll();
		
		return $data;
	}
}
if( !function_exists('assigned_staff_projects_board') ){

	function assigned_staff_projects_board($id){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$ProjectsModel = new \App\Models\ProjectsModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$company_id = $user_info['company_id'];
		
		$not_started_projects = $ProjectsModel->where('company_id',$company_id)->where('status',0)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'")->findAll();
		$inprogress_projects = $ProjectsModel->where('company_id',$company_id)->where('status',1)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'")->findAll();
		$completed_projects = $ProjectsModel->where('company_id',$company_id)->where('status',2)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'")->findAll();
		$cancelled_projects = $ProjectsModel->where('company_id',$company_id)->where('status',3)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'")->findAll();
		$hold_projects = $ProjectsModel->where('company_id',$company_id)->where('status',4)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'")->findAll();
		$data = array('not_started_projects'=>$not_started_projects,'inprogress_projects'=>$inprogress_projects,'completed_projects'=>$completed_projects,'cancelled_projects'=>$cancelled_projects,'hold_projects'=>$hold_projects);
		return $data;
	}
}
if( !function_exists('assigned_staff_tasks') ){

	function assigned_staff_tasks($id){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$TasksModel = new \App\Models\TasksModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$company_id = $user_info['company_id'];
		
		$data = $TasksModel->where('company_id',$company_id)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id' or created_by = '$id'")->findAll();
		
		return $data;
	}
}
if( !function_exists('assigned_staff_tasks_board') ){

	function assigned_staff_tasks_board($id){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$TasksModel = new \App\Models\TasksModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$company_id = $user_info['company_id'];
		
		$not_started_tasks = $TasksModel->where('company_id',$company_id)->where('task_status',0)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'")->findAll();
		$inprogress_tasks = $TasksModel->where('company_id',$company_id)->where('task_status',1)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'")->findAll();
		$completed_tasks = $TasksModel->where('company_id',$company_id)->where('task_status',2)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'")->findAll();
		$cancelled_tasks = $TasksModel->where('company_id',$company_id)->where('task_status',3)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'")->findAll();
		$hold_tasks = $TasksModel->where('company_id',$company_id)->where('task_status',4)->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'")->findAll();
		$data = array('not_started_tasks'=>$not_started_tasks,'inprogress_tasks'=>$inprogress_tasks,'completed_tasks'=>$completed_tasks,'cancelled_tasks'=>$cancelled_tasks,'hold_tasks'=>$hold_tasks);
		
		return $data;
	}
}
if( !function_exists('assigned_staff_training') ){

	function assigned_staff_training($id){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$TrainingModel = new \App\Models\TrainingModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$company_id = $user_info['company_id'];
		
		$data = $TrainingModel->where('company_id',$company_id)->where("employee_id like '%$id,%' or employee_id like '%,$id%' or employee_id = '$id'")->findAll();
		
		return $data;
	}
}
if( !function_exists('assigned_staff_events') ){

	function assigned_staff_events($id){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$EventsModel = new \App\Models\EventsModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$company_id = $user_info['company_id'];
		
		$data = $EventsModel->where('company_id',$company_id)->where("employee_id like '%$id,%' or employee_id like '%,$id%' or employee_id = '$id'")->findAll();
		
		return $data;
	}
}
if( !function_exists('assigned_staff_conference') ){

	function assigned_staff_conference($id){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$MeetingModel = new \App\Models\MeetingModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$company_id = $user_info['company_id'];
		
		$data = $MeetingModel->where('company_id',$company_id)->where("employee_id like '%$id,%' or employee_id like '%,$id%' or employee_id = '$id'")->findAll();
		
		return $data;
	}
}
if( !function_exists('count_leads_followup') ){

	function count_leads_followup($lead_id){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$LeadsfollowupModel = new \App\Models\LeadsfollowupModel();
		
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		
		$count_result = $LeadsfollowupModel->where('company_id',$company_id)->where('lead_id',$lead_id)->countAllResults();
		
		return $count_result;
	}
}
if( !function_exists('timehrm_sms_data') ){

	function timehrm_sms_data($recipient,$sms_body){
		// get db
		$db      = \Config\Database::connect();	
		// get session
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		$SmstemplatesModel = new \App\Models\SmstemplatesModel();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$service_plan_id = $xin_system['sms_service_plan_id'];
		$bearer_token = $xin_system['sms_bearer_token'];
		
		$send_from = $xin_system['sms_from'];
		$recipient_phone_numbers = $recipient; //May be several, separate with a comma `,`.
		$message = $sms_body;
		
		// Check recipient_phone_numbers for multiple numbers and make it an array.
		if(stristr($recipient_phone_numbers, ',')){
		  $recipient_phone_numbers = explode(',', $recipient_phone_numbers);
		}else{
		  $recipient_phone_numbers = [$recipient_phone_numbers];
		}
		
		// Set necessary fields to be JSON encoded
		$content = [
		  'to' => array_values($recipient_phone_numbers),
		  'from' => $send_from,
		  'body' => $message
		];
		
		$data = json_encode($content);
		
		$ch = curl_init("https://us.sms.api.sinch.com/xms/v1/{$service_plan_id}/batches");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
		curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $bearer_token);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$result = curl_exec($ch);
		
		if(curl_errno($ch)) {
			//echo 'Curl error: ' . curl_error($ch);
		} else {
			//echo $result;
		}
		curl_close($ch);
		 //return $result;
			
			return $data;
	}
}



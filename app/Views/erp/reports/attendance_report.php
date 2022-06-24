<?php
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\ShiftModel;
use App\Models\TimesheetModel;
use App\Models\ConstantsModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;
use App\Models\OvertimerequestModel;

$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$MainModel = new MainModel();
$ShiftModel = new ShiftModel();
$ConstantsModel = new ConstantsModel();
$TimesheetModel = new TimesheetModel();
$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$StaffdetailsModel = new StaffdetailsModel();
$OvertimerequestModel = new OvertimerequestModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$staff_info = udecode($_REQUEST['S']);
$seg_user_id = $staff_info;
$req_month_year = $_REQUEST['M'];

//$attendance_date = $date_info;

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$timesheet_data = $TimesheetModel->where('company_id', $user_info['company_id'])->where('employee_id', $seg_user_id)->first();
	$user_data = $UsersModel->where('company_id', $user_info['company_id'])->where('user_id', $seg_user_id)->first();
	// userdata
	$employee_detail = $StaffdetailsModel->where('user_id', $seg_user_id)->first();
	$idesignations = $DesignationModel->where('company_id', $user_info['company_id'])->where('designation_id',$employee_detail['designation_id'])->first();
} else {
	$timesheet_data = $TimesheetModel->where('company_id', $usession['sup_user_id'])->where('employee_id', $seg_user_id)->first();
	$user_data = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_id', $seg_user_id)->first();
	// userdata
	$employee_detail = $StaffdetailsModel->where('user_id', $seg_user_id)->first();
	$idesignations = $DesignationModel->where('company_id', $usession['sup_user_id'])->where('designation_id',$employee_detail['designation_id'])->first();
}
if($idesignations){
	$designation_name = $idesignations['designation_name'];
} else {
	$designation_name = '';
}
?>
<?php
?>
<?php
$date_info = strtotime($req_month_year.'-01');
$imonth_year = explode('-',$req_month_year);
$day = date('d', $date_info);
$month = date($imonth_year[1], $date_info);
$year = date($imonth_year[0], $date_info);

/* Set the date */
$date = date("F, Y", strtotime($req_month_year.'-01'));//strtotime(date("Y-m-d"),$date_info);
// total days in month
$daysInMonth =  date('t');
//$date = strtotime(date("Y-m-d"));
$day = date('d', $date_info);
$month = date('m', $date_info);
$year = date('Y', $date_info);
$month_year = date('Y-m');
$ci_erp_settings = $SystemModel->where('setting_id', 1)->first();
?>

<div class="row justify-content-md-center"> 
  <!-- [ Attendance view ] start -->
  <div class="col-md-8"> 
    <!-- [ Attendance view ] start -->
    <div class="container">
      <div>
        <div class="card" id="printTable">
          <div class="card-header">
            <h5><img class="img-fluid" width="171" height="30" src="<?= base_url();?>/public/uploads/logo/other/<?= $ci_erp_settings['other_logo'];?>" alt=""></h5>
          </div>
          <div class="card-body pb-0">
            <div class="row invoive-info d-pdrint-inline-flex justify-content-md-center">
              <div class="col-md-6">
                <div class="media user-about-block align-items-center mt-0">
                  <div class="position-relative d-inline-block"> <img class="img-radius img-fluid wid-80" src="<?= staff_profile_photo($seg_user_id);?>" alt="<?= $user_data['first_name'].' '.$user_data['last_name'];?>"> </div>
                  <div class="media-body ml-3">
                    <h6 class="mb-1">
                      <?= $user_data['first_name'].' '.$user_data['last_name'];?>
                    </h6>
                    <p class="mb-0 text-muted">
                      <?= $designation_name;?>
                    </p>
                    <p class="mb-0 text-muted">
                      <?= $user_data['email'];?>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <h5 class="m-b-10 text-primary text-uppercase"><?php echo lang('Attendance.xin_attendance_month');?></h5>
                <h4 class="text-uppercase text-primary m-l-30"> <strong>
                  <?= $date;?>
                  </strong> </h4>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <div class="table-responsive">
                  <table class="table invoice-detail-table">
                    <thead>
                      <tr class="thead-default">
                        <th><?= lang('Main.xin_day');?></th>
                        <th><?= lang('Main.xin_e_details_date');?></th>
                        <th><?= lang('Main.dashboard_xin_status');?></th>
                        <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
                      <?php
						$i = str_pad($i, 2, 0, STR_PAD_LEFT);
						// get date <
						$attendance_date = $year.'-'.$month.'-'.$i;
						$tdate = $year.'-'.$month.'-'.$i;
						$get_day = strtotime($attendance_date);
						$day = date('l', $get_day);
						// shift info
						$office_shift = $ShiftModel->where('office_shift_id',$employee_detail['office_shift_id'])->first();
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
						$check_attendance = user_attendance_monthly_value($attendance_date,$seg_user_id);
						if($check_attendance > 0) {
							$status = '<span class="text-success">'.lang('Attendance.attendance_present').'</span>';
						} else {
							// ||leave check
							$leave_date_chck = $MainModel->leave_date_check($seg_user_id,$attendance_date);
							// ||holiday check
							$holiday_date_check = $MainModel->holiday_date_check($attendance_date);
							 // check office shift time
							if($office_shift['monday_in_time'] == '' && $day == 'Monday') {
								$status = '<span class="text-warning">'.lang('Dashboard.left_holiday').'</span>';
								$event_name = lang('Attendance.no_set_schedule');
							} else if($office_shift['tuesday_in_time'] == '' && $day == 'Tuesday') {
								$status = '<span class="text-warning">'.lang('Dashboard.left_holiday').'</span>';	
								$event_name = lang('Attendance.no_set_schedule');
							} else if($office_shift['wednesday_in_time'] == '' && $day == 'Wednesday') {
								$status = '<span class="text-warning">'.lang('Dashboard.left_holiday').'</span>';
								$event_name = lang('Attendance.no_set_schedule');
							} else if($office_shift['thursday_in_time'] == '' && $day == 'Thursday') {
								$status = '<span class="text-warning">'.lang('Dashboard.left_holiday').'</span>';
								$event_name = lang('Attendance.no_set_schedule');
							} else if($office_shift['friday_in_time'] == '' && $day == 'Friday') {
								$status = '<span class="text-warning">'.lang('Dashboard.left_holiday').'</span>';	
								$event_name = lang('Attendance.no_set_schedule');
							} else if($office_shift['saturday_in_time'] == '' && $day == 'Saturday') {
								$status = '<span class="text-warning">'.lang('Dashboard.left_holiday').'</span>';	
								$event_name = lang('Attendance.no_set_schedule');
							} else if($office_shift['sunday_in_time'] == '' && $day == 'Sunday') {
								$status = '<span class="text-warning">'.lang('Dashboard.left_holiday').'</span>';	
								$event_name = lang('Attendance.no_set_schedule');
							} else if($holiday_date_check['holiday_count'] > 0){ // holiday
								$status = '<span class="text-primary">'.lang('Dashboard.left_holiday').'</span>';
								$holiday_result = $holiday_date_check['holiday_result'];
								$event_name = $holiday_result[0]->event_name;
							} else if($leave_date_chck['leave_count'] > 0){ // on leave
								$status = '<span class="text-info">'.lang('Leave.left_on_leave').'</span>';
								$leave_result = $leave_date_chck['leave_result'];
								$ltype = $ConstantsModel->where('constants_id', $leave_result[0]->leave_type_id)->where('type','leave_type')->first();
								$event_name = $ltype['category_name'];
							} else {
								$event_name = '';
								$status = '<span class="text-danger">'.lang('Attendance.attendance_absent').'</span>';
								// set to present date
								$iattendance_date = strtotime($attendance_date);
								$icurrent_date = strtotime(date('Y-m-d'));
								$status = $status;
								if($iattendance_date <= $icurrent_date){
									$status = $status;
								} else {
									$status = '';
								}
								$idate_of_joining = strtotime($employee_detail['date_of_joining']);
								if($idate_of_joining < $iattendance_date){
									$status = $status;
								} else {
									$status = '';
								}
							}
						}
						?>
                      <tr>
                        <td width="150"><?= $day;?></td>
                        <td width="200"><?= $attendance_date;?></td>
                        <td><?= $status;?></td>
                        <td><?= $event_name;?></td>
                      </tr>
                      <?php endfor;?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row text-center d-print-none">
          <div class="col-sm-12 invoice-btn-group text-center">
            <button type="button" class="btn btn-print-invoice waves-effect waves-light btn-success m-b-10">
            <?= lang('Main.xin_print');?>
            </button>
           </div>
        </div>
      </div>
    </div>
    <!-- [ Attendance view ] end --> 
  </div>
</div>

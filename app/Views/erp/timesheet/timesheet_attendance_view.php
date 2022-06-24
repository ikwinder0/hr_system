<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\ShiftModel;
use App\Models\TimesheetModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;
use App\Models\OvertimerequestModel;

$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$MainModel = new MainModel();
$ShiftModel = new ShiftModel();
$TimesheetModel = new TimesheetModel();
$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$StaffdetailsModel = new StaffdetailsModel();
$OvertimerequestModel = new OvertimerequestModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$staff_info = $request->uri->getSegment(3);
$seg_user_id = udecode($staff_info);
$date_info = $request->uri->getSegment(4);
$attendance_date = udecode($date_info);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$timesheet_data = $TimesheetModel->where('company_id', $user_info['company_id'])->where('employee_id', $seg_user_id)->first();
	$user_data = $UsersModel->where('company_id', $user_info['company_id'])->where('user_id', $timesheet_data['employee_id'])->first();
	// userdata
	$employee_detail = $StaffdetailsModel->where('user_id', $user_data['user_id'])->first();
	$idesignations = $DesignationModel->where('company_id', $user_info['company_id'])->where('designation_id',$employee_detail['designation_id'])->first();
	$get_data = $TimesheetModel->where('company_id', $user_info['company_id'])->where('employee_id',$seg_user_id)->where('attendance_date',$attendance_date)->findAll();
	// total hours worked
	$first_data = $TimesheetModel->where('company_id', $user_info['company_id'])->where('employee_id', $seg_user_id)->where('attendance_date', $attendance_date)->first();
} else {
	$timesheet_data = $TimesheetModel->where('company_id', $usession['sup_user_id'])->where('employee_id', $seg_user_id)->first();
	$user_data = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_id', $timesheet_data['employee_id'])->first();
	// userdata
	$employee_detail = $StaffdetailsModel->where('user_id', $user_data['user_id'])->first();
	$idesignations = $DesignationModel->where('company_id', $usession['sup_user_id'])->where('designation_id',$employee_detail['designation_id'])->first();
	$get_data = $TimesheetModel->where('company_id', $usession['sup_user_id'])->where('employee_id',$seg_user_id)->where('attendance_date',$attendance_date)->findAll();
	// total hours worked
	$first_data = $TimesheetModel->where('company_id', $usession['sup_user_id'])->where('employee_id', $seg_user_id)->where('attendance_date', $attendance_date)->first();
}
?>
<?php
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
//time diff > total time late
$office_time_new = strtotime($in_time.' '.$attendance_date);
$clock_in_time_new = strtotime($first_data['clock_in']);
$ioffice_time_new = date_create($in_time.' '.$attendance_date);
$iclock_in_time = date_create($first_data['clock_in']);
if($clock_in_time_new <= $office_time_new) {
	$total_time_l = '00:00';
} else {
	$interval_late = date_diff($iclock_in_time, $ioffice_time_new);
	$hours_l   = $interval_late->format('%h');
	$minutes_l = $interval_late->format('%i');			
	$total_time_l = $hours_l ."h ".$minutes_l."m";
}
if($total_time_l=='') {
	$total_time_l = '00:00';
} else {
	$total_time_l = $total_time_l;
}
$ci_erp_settings = $SystemModel->where('setting_id', 1)->first();
?>

<div class="row justify-content-md-center"> 
  <!-- [ Attendance view ] start -->
  <div class="col-md-10"> 
    <!-- [ Attendance view ] start -->
    <div class="container">
      <div>
        <div class="card" id="printTable">
          <div class="card-header">
            <h5><img class="img-fluid" width="171" height="30" src="<?= base_url();?>/public/uploads/logo/other/<?= $ci_erp_settings['other_logo'];?>" alt=""></h5>
          </div>
          <div class="card-body pb-0">
            <div class="media user-about-block align-items-center mt-0 mb-3">
              <div class="position-relative d-inline-block"> <img class="img-radius img-fluid wid-80" src="<?= staff_profile_photo($seg_user_id);?>" alt="<?= $user_data['first_name'].' '.$user_data['last_name'];?>"> </div>
              <div class="media-body ml-3">
                <h6 class="mb-1">
                  <?= $user_data['first_name'].' '.$user_data['last_name'];?>
                </h6>
                <p class="mb-0 text-muted">
                  <?= $idesignations['designation_name'];?>
                </p>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row invoive-info d-pdrint-inline-flex justify-content-md-center">
              <div class="col-md-12">
                <h5 class="text-primary m-l-10"><?php echo lang('Employees.xin_employees_info');?></h5>
                <table class="m-t-10 table table-responsive table-borderless">
                  <tbody>
                    <tr>
                      <th><?php echo lang('Employees.xin_employee_office_shift');?> :</th>
                      <td><?= $office_shift['shift_name'];?></td>
                    </tr>
                    <tr>
                      <th><?php echo lang('Employees.xin_account_email');?> :</th>
                      <td><span class="label label-warning">
                        <?= $user_data['email'];?>
                        </span></td>
                    </tr>
                    <tr>
                      <th><?php echo lang('Attendance.xin_attendance_date');?> :</th>
                      <td><?= set_date_format($attendance_date);?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <div class="table-responsive">
                  <table class="table m-b-0 f-14 b-solid requid-table">
                    <thead>
                      <tr class="text-uppercase">
                        <th colspan="3"><?php echo lang('Attendance.xin_attendance_information');?></th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <tr>
                        <th><?= lang('Employees.xin_shift_in_time');?></th>
                        <th><?= lang('Employees.xin_shift_out_time');?></th>
                        <th><?= lang('Attendance.dashboard_total_work');?></th>
                      </tr>
                      <?php $hrs_old_int1 = 0; ?>
                      <?php foreach($get_data as $r) { ?>
                      <?php
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
						// clock in time
						$clock_in_time = strtotime($r['clock_in']);
						$fclock_in = date("h:i a", $clock_in_time);
						// clock out time
						$clock_out_time = strtotime($r['clock_out']);
						$fclock_out = date("h:i a", $clock_out_time);
						// total work			
						$timee = $r['total_work'].':00';
						$str_time =$timee;
			
						$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
						
						sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
						
						$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
						
						$hrs_old_int1 += $hrs_old_seconds;
						$total_work = gmdate("H:i", $hrs_old_int1);
						if($total_work=='') {
							$total_work = '00:00';
						} else {
							$total_work = $total_work;
						}
						
                        ?>
                      <tr>
                        <td width="300"><?= $fclock_in;?></td>
                        <td width="360"><?= $fclock_out;?></td>
                        <td><?= $r['total_work'];?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-responsive invoice-table invoice-total">
                  <tbody>
                    <tr>
                      <th><?= lang('Attendance.dashboard_total_work');?>
                        : </th>
                      <th>&nbsp;&nbsp;
                        <?= $total_work;?></th>
                    </tr>
                    <tr>
                      <th><?= lang('Attendance.dashboard_late');?>
                        :</th>
                      <td>&nbsp;&nbsp;
                        <?= $total_time_l;?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row text-center d-print-none">
          <div class="col-sm-12 invoice-btn-group text-center">
            <button type="button" class="btn btn-print-invoice waves-effect waves-light btn-success m-b-10">
            <?= lang('Main.xin_print');?>
            </button>
            <a href="<?= site_url('erp/attendance-list');?>" class="btn waves-effect waves-light btn-primary m-b-10">
            <?= lang('Main.xin_view');?>
            <?= lang('Dashboard.left_attendance');?>
            </a> </div>
        </div>
      </div>
    </div>
    <!-- [ Attendance view ] end --> 
  </div>
</div>

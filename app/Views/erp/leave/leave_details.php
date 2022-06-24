<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\LeaveModel;
use App\Models\ConstantsModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$LeaveModel = new LeaveModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

///
$segment_id = $request->uri->getSegment(3);
$ifield_id = udecode($segment_id);
$result = $LeaveModel->where('leave_id', $ifield_id)->first();
$user_info = $UsersModel->where('user_id', $result['employee_id'])->first();
if($user_info){
	$staff_leave_info = $user_info['first_name'].' '.$user_info['last_name'];
} else {
	$staff_leave_info = '';
}
$ltype = $ConstantsModel->where('constants_id', $result['leave_type_id'])->where('type','leave_type')->first();
if($ltype){
	$itype_name = $ltype['category_name'];
} else {
	$itype_name = '';
}
$iuser_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($iuser_info['user_type'] == 'staff'){
	$leave_types = $ConstantsModel->where('company_id',$iuser_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
} else {
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
}
?>

<div class="row">
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h5>
          <?= lang('Leave.xin_leave_details');?>
        </h5>
      </div>
      <?php if(in_array('leave7',staff_role_resource()) || $iuser_info['user_type'] == 'company') { ?>
      <?php $attributes = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 1, 'token_status' => $segment_id);?>
      <?php echo form_open('erp/leave/update_leave_status', $attributes, $hidden);?>
      <?php } ?>
      <div class="card-body task-details">
        <table class="table-responsive table">
          <tbody>
            <tr>
              <td><i class="fas fa-user-plus m-r-5"></i>
                <?= lang('Dashboard.dashboard_employee');?>
                :</td>
              <td class="text-right"><span class="float-right"><?php echo $staff_leave_info;?></span></td>
            </tr>
            <tr>
              <td><i class="fas fa-adjust m-r-5"></i>
                <?= lang('Leave.xin_leave_type');?>
                :</td>
              <td class="text-right"><?php echo $itype_name;?></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i>
                <?= lang('Leave.xin_applied_on');?>
                :</td>
              <td class="text-right"><?= set_date_format($result['created_at']);?></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i>
                <?= lang('Projects.xin_start_date');?>
                :</td>
              <td class="text-right"><div class="btn-group"> <a href="#!" class="text-secondary">
                  <?= set_date_format($result['from_date']);?>
                  </a> </div></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i>
                <?= lang('Projects.xin_end_date');?>
                :</td>
              <td class="text-right"><?= set_date_format($result['to_date']);?></td>
            </tr>
            <tr>
              <td><i class="fas fa-upload m-r-5"></i>
                <?= lang('Main.xin_attachment');?>
                :</td>
              <td class="text-right"><?php if($result['leave_attachment']!='' && $result['leave_attachment']!='NULL'):?>
                <a href="<?= site_url()?>download?type=leave&filename=<?php echo uencode($result['leave_attachment']);?>">
                <?= lang('Main.xin_download');?>
                </a>
                <?php else:?>
                <?php endif;?></td>
            </tr>
            <tr>
              <td><i class="fas fa-thermometer-half m-r-5"></i>
                <?= lang('Employees.xin_leave_total_days');?>
                :</td>
              <td class="text-right"><?php 
			  	// get leave date difference
				$no_of_days = erp_date_difference($result['from_date'],$result['to_date']);
				if($result['is_half_day'] == 1){
					$leave_day_info = lang('Employees.xin_hr_leave_half_day');
				} else {
					$leave_day_info = $no_of_days;
				}
				echo $leave_day_info;?></td>
            </tr>
          </tbody>
        </table>
        <div>
          <div class="row mt-2 mb-2">
            <div class="col-md-12"> <span class=" txt-primary"> <i class="fas fa-chart-line"></i> <strong>
              <?= lang('Main.dashboard_xin_status');?>
              </strong> </span> </div>
          </div>
          <div class="row justify-content-md-center mb-2">
            <div class="col-md-12">
              <div class="form-group leave-status">
                <select class="form-control demo-movie" id="demo-movie" name="status" autocomplete="off">
                  <option value="1" <?php if($result['status']=='1'):?> selected <?php endif; ?>>
                  <?= lang('Main.xin_pending');?>
                  </option>
                  <option value="2" <?php if($result['status']=='2'):?> selected <?php endif; ?>>
                  <?= lang('Main.xin_approved');?>
                  </option>
                  <option value="3" <?php if($result['status']=='3'):?> selected <?php endif; ?>>
                  <?= lang('Main.xin_rejected');?>
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="remarks">
                  <?= lang('Recruitment.xin_remarks');?>
                </label>
                <textarea class="form-control textarea" placeholder="<?= lang('Recruitment.xin_remarks');?>" name="remarks" id="remarks"><?php echo $result['remarks'];?></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if(in_array('leave7',staff_role_resource()) || $iuser_info['user_type'] == 'company') { ?>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-success">
        <?= lang('Main.xin_update_status');?>
        </button>
      </div>
      <?= form_close(); ?>
      <?php } ?>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h5><i class="feather icon-lock mr-1"></i>
          <?= lang('Leave.xin_leave_reason');?>
        </h5>
      </div>
      <div class="card-body hd-detail hdd-admin border-bottom">
        <div class="row"> <?php echo $result['reason'];?> </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
            <?= lang('Leave.xin_leave_statistics');?>
            </strong></span> </div>
          <div class="card-body">
            <div class="box-block card-dashboard">
              <?php
				foreach($leave_types as $type) {
					$days_per_year = $type['field_one'];
					$hlfcount =0;
					$hlfcount = leave_halfday_cal($user_info['user_id'],$type['constants_id']);
					$tinc = count_employee_leave($user_info['user_id'],$type['constants_id']);
					$count_l = $tinc - $hlfcount;
					if($count_l == 0){
						$progress_class = '';
						$count_data = 0;
					} else {
						if($days_per_year > 0){
							$count_data = $count_l / $days_per_year * 100;
						} else {
							$count_data = 0;
						}
						// progress
						if($count_data <= 20) {
							$progress_class = 'bg-success';
						} else if($count_data > 20 && $count_data <= 50){
							$progress_class = 'bg-info';
						} else if($count_data > 50 && $count_data <= 75){
							$progress_class = 'bg-warning';
						} else {
							$progress_class = 'bg-danger';
						}
					}
				?>
              <p><strong><?php echo $type['category_name'];?> (<?php echo $count_l;?>/<?php echo $days_per_year;?>)</strong></p>
              <div class="progress mb-2" style="height:12px;">
                <div class="progress-bar <?= $progress_class;?>" style="width: <?= $count_data;?>%;">
                  <?= round($count_data);?>
                  %</div>
              </div>
              <?php } //}?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

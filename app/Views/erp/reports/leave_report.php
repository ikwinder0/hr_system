<?php
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\LeaveModel;
use App\Models\ConstantsModel;

$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$MainModel = new MainModel();
$LeaveModel = new LeaveModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$status = $_REQUEST['P'];
$start_date = $_REQUEST['S'];
$end_date = $_REQUEST['E'];
//$attendance_date = $date_info;

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$xin_system = erp_company_settings();
$leave_data = leave_report($start_date,$end_date,$status);
$ci_erp_settings = $SystemModel->where('setting_id', 1)->first();
?>
<div class="row justify-content-md-center"> 
  <div class="col-md-10"> 
    <!-- [ Leave view ] start -->
    <div class="container">
      <div>
        <div class="card" id="printTable">
          <div class="card-header">
            <h5><img class="img-fluid" width="171" height="30" src="<?= base_url();?>/public/uploads/logo/other/<?= $ci_erp_settings['other_logo'];?>" alt=""></h5>
          </div>
          <div class="card-body pb-0">
            <div class="row invoive-info d-pdrint-inline-flex">
              <div class="col-md-8">
                    <h6 class="text-primary">Leave Report :</h6>
                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                        <tbody>
                            <tr class="text-primary">
                                <th>From :</th>
                                <td><?= set_date_format($start_date);?></td>
                            </tr>
                            <tr class="text-primary">
                                <th>To :</th>
                                <td><?= set_date_format($end_date);?></td>
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
                            <th><?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Leave.xin_leave_type');?></th>
                            <th>
                              <?= lang('Leave.xin_leave_duration');?></th>
                            <th><?= lang('Leave.xin_leave_days');?></th>
                            <th>
                              <?= lang('Leave.xin_applied_on');?></th>
                            <th><?= lang('Main.dashboard_xin_status');?></th>
                          </tr>
                    </thead>
                    <tbody>
                      <?php foreach($leave_data as $_leave) { ?>
                      <?php
						  $leave_user = $UsersModel->where('user_id', $_leave['employee_id'])->first();
						  if($leave_user){
							  $ltype = $ConstantsModel->where('constants_id', $_leave['leave_type_id'])->where('type','leave_type')->first();
							  if($ltype){
									$category_name = $ltype['category_name'];
								} else {
									$category_name = '--';
								}
						  // applied on
						  $applied_on = set_date_format($_leave['created_at']);
						  // get leave date difference
							$no_of_days = erp_date_difference($_leave['from_date'],$_leave['to_date']);
						
							if($_leave['is_half_day'] == 1){
							$idays = lang('Employees.xin_hr_leave_half_day');
							} else {
								$idays = $no_of_days.' '.lang('Leave.xin_leave_days');
							}
							$duration = set_date_format($_leave['from_date']).' '.lang('Employees.dashboard_to').' '.set_date_format($_leave['to_date']);
							$total_days = $idays;
							// leave status
							if($_leave['status']==1): $status = '<span class="text-warning">'.lang('Main.xin_pending').'</span>';
							elseif($_leave['status']==2): $status = '<span class="text-success">'.lang('Main.xin_approved').'</span>';
							elseif($_leave['status']==3): $status = '<span class="text-danger">'.lang('Main.xin_rejected').'</span>';
							else: $status = '<span class="text-warning">'.lang('Main.xin_pending').'</span>'; endif;
						?>
                      <tr>
                        <td width="150"><div class="d-inline-block align-middle">
                            <img src="<?= staff_profile_photo($_leave['employee_id']);?>" class="img-radius align-top m-r-15" style="width:40px;">
                            <div class="d-inline-block">
                                <h6 class="m-b-0"><?= $leave_user['first_name'].' '.$leave_user['last_name'];?></h6>
                                <p class="m-b-0"><?= $leave_user['email'];?></p>
                            </div>
                        </div></td>
                        <td width="200"><?= $category_name;?></td>
                        <td><?= $duration;?></td>
                        <td><?= $total_days;?></td>
                        <td><?= $applied_on;?></td>
                        <td><?= $status;?></td>
                      </tr>
                    <?php } } ?> 
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
    <!-- [ Leave view ] end --> 
  </div>
</div>

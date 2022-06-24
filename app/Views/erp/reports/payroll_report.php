<?php
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\PayrollModel;

$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$MainModel = new MainModel();
$PayrollModel = new PayrollModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
if($_REQUEST['S']=='all_employees'){
	$staff_info = $_REQUEST['S'];
} else {
	$staff_info = udecode($_REQUEST['S']);
}

$seg_user_id = $staff_info;
$req_month_year = $_REQUEST['M'];

//$attendance_date = $date_info;

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	//$payslip_data = $PayrollModel->where('company_id', $user_info['company_id'])->where('staff_id', $seg_user_id)->where('salary_month', $req_month_year)->findAll();
	if($seg_user_id == 'all_employees'){
		$payslip_data = $PayrollModel->where('company_id', $user_info['company_id'])->where('salary_month', $req_month_year)->findAll();
	} else {
		$payslip_data = $PayrollModel->where('company_id', $user_info['company_id'])->where('staff_id', $seg_user_id)->where('salary_month', $req_month_year)->findAll();
	}
} else {
	if($seg_user_id == 'all_employees'){
		$payslip_data = $PayrollModel->where('company_id', $usession['sup_user_id'])->where('salary_month', $req_month_year)->findAll();
	} else {
		$payslip_data = $PayrollModel->where('company_id', $usession['sup_user_id'])->where('staff_id', $seg_user_id)->where('salary_month', $req_month_year)->findAll();
	}
}
$xin_system = erp_company_settings();
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
  <div class="col-md-10"> 
    <!-- [ Attendance view ] start -->
    <div class="container">
      <div>
        <div class="card" id="printTable">
          <div class="card-header">
            <h5><img class="img-fluid" width="171" height="30" src="<?= base_url();?>/public/uploads/logo/other/<?= $ci_erp_settings['other_logo'];?>" alt=""></h5>
          </div>
          <div class="card-body pb-0">
            <div class="row invoive-info d-pdrint-inline-flex">
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
                  <table class="table m-b-0 f-14 b-solid requid-table">
                    <thead>
                      <tr class="text-uppercase">
                        <th>Employee</th>
                        <th>Paid Amount</th>
                        <th>Pay Month</th>
                        <th>Pay Date</th>
                        <th>Payslip Type</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($payslip_data as $_payslip) { ?>
                      <?php $pay_user = $UsersModel->where('user_id', $_payslip['staff_id'])->first();?>
                      <?php
					   if($_payslip['wages_type'] == 1){
							$wages_type = lang('Membership.xin_per_month');
						} else {
							$wages_type = lang('Membership.xin_per_hour');
						}?>
                      <tr>
                        <td width="150"><div class="d-inline-block align-middle">
                            <img src="<?= staff_profile_photo($_payslip['staff_id']);?>" alt="" class="img-radius align-top m-r-15" style="width:40px;">
                            <div class="d-inline-block">
                                <h6 class="m-b-0"><?= $pay_user['first_name'].' '.$pay_user['last_name'];?></h6>
                                <p class="m-b-0"><?= $pay_user['email'];?></p>
                            </div>
                        </div></td>
                        <td width="200"><strong class="text-success"><?= number_to_currency($_payslip['net_salary'], $xin_system['default_currency'],null,2);?></strong></td>
                        <td><?= $_payslip['salary_month'];?></td>
                        <td><?= set_date_format($_payslip['created_at']);?></td>
                        <td><?= $wages_type;?></td>
                      </tr>
                    <?php } ?> 
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

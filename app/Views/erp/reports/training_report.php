<?php
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\TrainersModel;
use App\Models\ConstantsModel;
use App\Models\TrainingModel;

$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$MainModel = new MainModel();
$TrainersModel = new TrainersModel();
$TrainingModel = new TrainingModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

/*if($_REQUEST['P']=='all_employees'){
	$get_user = $_REQUEST['P'];
} else {
	$get_user = udecode($_REQUEST['P']);
}*/
$status = $_REQUEST['P'];
$start_date = $_REQUEST['S'];
$end_date = $_REQUEST['E'];

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$company_id = $user_info['company_id'];
} else {
	$company_id = $usession['sup_user_id'];
}
$xin_system = erp_company_settings();
$training_report = training_report($start_date,$end_date,$status);
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
              <div class="col-md-8">
                    <h6 class="text-primary">Training Report :</h6>
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
                        <th>Employee</th>
                        <th>Training Type</th>
                        <th>Trainer</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Cost</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($training_report as $_training) {
						  	$training_type = $ConstantsModel->where('company_id',$company_id)->where('type','training_type')->where('constants_id',$_training['training_type_id'])->first(); 
								if($training_type){
									$category_name = $training_type['category_name'];
								} else {
									$category_name = '--';
								}
							  $assigned_to = explode(',',$_training['employee_id']);
							  $multi_users = multi_users_info($assigned_to);
							  /// trainer
							  $trainer = $TrainersModel->where('trainer_id', $_training['trainer_id'])->first();
							  if($trainer){
									$trainer_name = $trainer['first_name'].' '.$trainer['last_name'];
								} else {
									$trainer_name = '--';
								}
							if($_training['training_status']==0):
								$status = '<span class="text-warning">'.lang('Main.xin_pending').'</span>';
							elseif($_training['training_status']==1):
								$status = '<span class="text-info">'.lang('Projects.xin_started').'</span>';
							elseif($_training['training_status']==2):
								$status = '<span class="text-success">'.lang('Projects.xin_completed').'</span>';
							else:
								$status = '<span class="text-danger">'.lang('Main.xin_rejected').'</span>'; endif;
				
							  ?>
							  <tr>
								<td width="150"><?= $multi_users;?>
								</td>
								<td width="200"><?= $category_name;?></td>
								<td><?= $trainer_name;?></td>
								<td><?= set_date_format($_training['start_date']);?></td>
								<td><?= set_date_format($_training['finish_date']);?></td>
								<td><?= number_to_currency($_training['training_cost'], $xin_system['default_currency'],null,2);;?></td>
								<td><?= $status;?></td>
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

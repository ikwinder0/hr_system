<?php
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\ActivityModel;
$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$ActivityModel = new ActivityModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$company_id = $user_info['company_id'];
	$activities = $ActivityModel->where('company_id', $company_id)->where('staff_id', $usession['sup_user_id'])->findAll();
} else {
	$company_id = $usession['sup_user_id'];
	$activities = $ActivityModel->where('company_id', $company_id)->findAll(1);
}
?>

<div class="modal notification-modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <?= lang('Notifications');?>
          <br>
          <small class="text-muted">
          <?= lang('Mark all as read');?>
          </small> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade show active" id="pc-noti-home" role="tabpanel" aria-labelledby="pc-noti-home-tab">
          <ul class="list-unstyled task-list">
           <?php $bg_color = array('bg-success','bg-primary','bg-danger','bg-warning','bg-secondary','bg-info','bg-dark');?>
           <?php /*?><?php foreach($activities as $activity){ ?>
           <?php //$created_at = strtotime($activity['created_at']);?>
            <li> <i class="feather task-icon bg-success"></i>
              <p class="m-b-5"><?= set_date_format($activity['created_at']);?></p>
              <h6 class="text-muted"><span class="text-primary"><a href="#!" class="text-primary">Jeny</a></span> assigned you a task <span class="text-primary"><a href="#!" class="text-primary">Mockup Design.</a></span></h6>
            </li>
			<?php } ?><?php */?>
            <?= notification_data();?>
          </ul>
          <!--<div class="text-center"> <a href="#!" class="b-b-primary text-primary">View Friend List</a> </div>-->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

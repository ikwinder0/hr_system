<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AssetsModel;
use App\Models\AssetscategoryModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
/*
* Job Interview - View Page
*/
?>

<?php if(in_array('ats2',staff_role_resource()) || in_array('candidate',staff_role_resource()) || in_array('interview',staff_role_resource()) || in_array('promotion',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2 mb-3">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('ats2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/jobs-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-gitlab"></span>
      <?= lang('Recruitment.xin_new_opening');?>
      <div class="text-muted small">
        <?= lang('Recruitment.xin_add_new_jobs');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('candidate',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/candidates-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-users"></span>
      <?= lang('Recruitment.xin_candidates');?>
      <div class="text-muted small">
        <?= lang('Dashboard.left_job_candidates');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('interview',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/jobs-interviews');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Recruitment.xin_interviews');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Recruitment.xin_interviews');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('promotion',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/promotion-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-user-plus"></span>
      <?= lang('Dashboard.left_promotions');?>
      <div class="text-muted small">
        <?= lang('Dashboard.dashboard_employee');?>
        <?= lang('Dashboard.left_promotions');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Recruitment.xin_interviews');?>
    </h5>
  </div>
  <div class="card-body">
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo lang('Recruitment.xin_job_title');?></th>
            <th><?php echo lang('Recruitment.xin_selected_candidate');?></th>
            <th><?php echo lang('Recruitment.xin_place_of_interview');?></th>
            <th><?php echo lang('Recruitment.xin_interview_time');?></th>
            <th><?php echo lang('Recruitment.xin_interviewer');?></th>
            <th><?php echo lang('Main.dashboard_xin_status');?></th>
            <th><?php echo lang('Main.xin_created_at');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

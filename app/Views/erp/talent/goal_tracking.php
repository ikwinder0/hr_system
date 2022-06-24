<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\ConstantsModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$request = \Config\Services::request();
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'company'){
	$all_tracking_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','goal_type')->orderBy('constants_id', 'ASC')->findAll();
} else {
	$all_tracking_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','goal_type')->orderBy('constants_id', 'ASC')->findAll();
}
$get_animate ='';
?>

<?php if(in_array('indicator1',staff_role_resource()) || in_array('appraisal1',staff_role_resource()) || in_array('competency1',staff_role_resource()) || in_array('tracking1',staff_role_resource()) || in_array('track_type1',staff_role_resource()) || in_array('track_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('indicator1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/performance-indicator-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-aperture"></span>
      <?= lang('Dashboard.left_performance_indicator');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?> <?= lang('Dashboard.left_performance_xindicator');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('appraisal1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/performance-appraisal-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-slack"></span>
      <?= lang('Dashboard.left_performance_appraisal');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?> <?= lang('Dashboard.left_performance_xappraisal');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('tracking1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/track-goals');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-target"></span>
      <?= lang('Dashboard.xin_hr_goal_tracking');?>
      <div class="text-muted small">
        <?= lang('Performance.xin_set_up_goals');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('track_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/goals-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Performance.xin_goals_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('competency1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/competencies');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-sliders-h"></span>
      <?= lang('Performance.xin_competencies');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Performance.xin_competencies');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('track_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/goal-type');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Dashboard.xin_hr_goal_tracking_type');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.xin_hr_goal_tracking_type');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<?php if(in_array('tracking2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-12">
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card">
        <div id="accordion">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Performance.xin_goal');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <?php $attributes = array('name' => 'add_tracking', 'id' => 'xin-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('_user' => 1);?>
          <?php echo form_open('erp/trackgoals/add_tracking', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="tracking_type"><?php echo lang('Dashboard.xin_hr_goal_tracking_type');?> <span class="text-danger">*</span></label>
                  <select class="form-control" name="tracking_type" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.xin_hr_goal_tracking_type');?>">
                    <option value=""></option>
                    <?php foreach($all_tracking_types as $tracking_type) {?>
                    <option value="<?= $tracking_type['constants_id'];?>">
                    <?= $tracking_type['category_name'];?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="xin_subject"><?php echo lang('Main.xin_subject');?> <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?php echo lang('Main.xin_subject');?>" name="subject" type="text" value="">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="target_achiement"><?php echo lang('Performance.xin_hr_target_achiement');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-vector-square"></i></span></div>
                    <input class="form-control" placeholder="<?php echo lang('Performance.xin_hr_target_achiement');?>" name="target_achiement" type="text" value="">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="start_date"><?php echo lang('Projects.xin_start_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_start_date');?>" name="start_date" type="text" value="">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="end_date"><?php echo lang('Projects.xin_end_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_end_date');?>" name="end_date" type="text" value="">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description"><?php echo lang('Main.xin_description');?></label>
                  <textarea class="form-control editor" placeholder="<?php echo lang('Main.xin_description');?>" name="description" rows="3" id="description"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="true"><?php echo lang('Main.xin_reset');?></button>
            &nbsp;
            <button type="submit" class="btn btn-primary"><?php echo lang('Main.xin_save');?></button>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Dashboard.xin_hr_goal_tracking');?>
    </h5>
    <?php if(in_array('tracking2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
      <?= lang('Main.xin_add_new');?>
      </a> </div>
    <?php } ?>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo lang('Dashboard.xin_hr_goal_tracking_type');?></th>
            <th><?php echo lang('Main.xin_subject');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_start_date');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_end_date');?></th>
            <th><?php echo lang('Performance.xin_goal_rating');?></th>
            <th><?php echo lang('Projects.dashboard_xin_progress');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
</div>
</div>

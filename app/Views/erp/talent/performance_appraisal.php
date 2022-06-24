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
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','staff')->findAll();
	$competencies = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies')->orderBy('constants_id', 'ASC')->findAll();
	$competencies2 = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies2')->orderBy('constants_id', 'ASC')->findAll();
} else {
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
	$competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->orderBy('constants_id', 'ASC')->findAll();
	$competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->orderBy('constants_id', 'ASC')->findAll();
}

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
    <li class="nav-item active"> <a href="<?= site_url('erp/performance-appraisal-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-slack"></span>
      <?= lang('Dashboard.left_performance_appraisal');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?> <?= lang('Dashboard.left_performance_xappraisal');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('tracking1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/track-goals');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-target"></span>
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
<?php if(in_array('appraisal2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <div class="card">
    <div id="accordion">
      <div class="card-header">
        <h5>
          <?= lang('Performance.xin_give_performance_appraisal');?>
        </h5>
        <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
          <?= lang('Main.xin_hide');?>
          </a> </div>
      </div>
      <?php $attributes = array('name' => 'add_appraisal', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 1);?>
      <?php echo form_open('erp/talent/add_appraisal', $attributes, $hidden);?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="company_name">
                <?= lang('Dashboard.xin_title');?>
                <span class="text-danger">*</span> </label>
              <input class="form-control" placeholder="<?php echo lang('Dashboard.xin_title');?>" id="title" name="title" type="text">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="company_name">
                <?= lang('Dashboard.dashboard_employee');?>
                <span class="text-danger">*</span> </label>
              <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.dashboard_employee');?>" name="employee_id" id="employee_id">
                <option value=""></option>
                <?php foreach($staff_info as $staff) {?>
                <option value="<?= $staff['user_id']?>">
                <?= $staff['first_name'].' '.$staff['last_name'] ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="company_name">
                <?= lang('Payroll.xin_select_month');?>
                <span class="text-danger">*</span> </label>
              	<div class="input-group">
                    <input class="form-control hr_month_year" placeholder="<?php echo lang('Payroll.xin_select_month');?>" id="month_year" name="month_year" type="text">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                </div>
            </div>
          </div>
        </div>
        <div class="row m-b-1">
          <div class="col-md-6 table-border-style">
            <div class="table-responsive">
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th colspan="3"><?php echo lang('Performance.xin_performance_technical');?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="table-success">
                    <th colspan="2"><?php echo lang('Dashboard.left_performance_xappraisal');?></th>
                    <th><?php echo lang('Performance.xin_set_value');?></th>
                  </tr>
                  <?php foreach($competencies as $itech_comp):?>
                  <tr class="m-b-2">
                    <td scope="row" colspan="2"><?php echo $itech_comp['category_name'];?></td>
                    <td><select class="bar-rating" name="technical_competencies_value[<?php echo $itech_comp['constants_id'];?>]" autocomplete="off">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select></td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-6">
            <div class="table-responsive">
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th colspan="3"><?php echo lang('Performance.xin_performance_org');?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="table-success">
                    <th colspan="2"><?php echo lang('Dashboard.left_performance_xappraisal');?></th>
                    <th><?php echo lang('Performance.xin_set_value');?></th>
                  </tr>
                  <?php foreach($competencies2 as $iorg_comp):?>
                  <tr class="m-b-2">
                    <td scope="row" colspan="2"><?php echo $iorg_comp['category_name'];?></td>
                    <td><select name="organizational_competencies_value[<?php echo $iorg_comp['constants_id'];?>]" class="bar-rating" autocomplete="off">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select></td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white">
              <div class="form-group">
                <label for="remarks"><?php echo lang('Recruitment.xin_remarks');?></label>
                <textarea class="form-control textarea" placeholder="<?php echo lang('Recruitment.xin_remarks');?>" name="remarks" id="remarks"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false"><?= lang('Main.xin_reset');?></button>
            &nbsp;
            <button type="submit" class="btn btn-primary"><?= lang('Main.xin_save');?></button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Performance.xin_performance_apps');?>
    </h5>
    <?php if(in_array('appraisal2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
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
            <th><?php echo lang('Dashboard.xin_title');?></th>
            <th><i class="fa fa-user"></i> <?php echo lang('Dashboard.dashboard_employee');?></th>
            <th><?php echo lang('Performance.xin_appraisal_date');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo lang('Main.xin_added_by');?></th>
            <th><?php echo lang('Performance.xin_overall_rating');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo lang('Main.xin_created_at');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>

<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AssetsModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$SystemModel = new SystemModel();		
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$xin_system = erp_company_settings();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','travel_type')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','travel_type')->findAll();
}
/* Assets view
*/
$get_animate = '';
?>
<?php if(in_array('travel1',staff_role_resource()) || in_array('travel_type1',staff_role_resource()) || in_array('travel_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('travel1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/business-travel');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-globe"></span>
      <?= lang('Dashboard.left_travels');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_travel');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('travel_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/arrangement-type');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Employees.xin_arragement_type');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Employees.xin_arragement_type');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('travel_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/travel-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Employees.xin_travel_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<?php if(in_array('travel2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-12">
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <?php $attributes = array('name' => 'add_travel', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php echo form_open('erp/travel/add_travel', $attributes);?>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div id="accordion">
              <div class="card-header">
                <h5>
                  <?= lang('Main.xin_add_new');?>
                  <?= lang('Dashboard.left_travel');?>
                </h5>
                <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
                  <?= lang('Main.xin_hide');?>
                  </a> </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <?php if($user_info['user_type'] == 'company'){?>
                  <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="first_name">
                        <?= lang('Dashboard.dashboard_employee');?> <span class="text-danger">*</span>
                      </label>
                      <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>">
                        <?php foreach($staff_info as $staff) {?>
                        <option value="<?= $staff['user_id']?>">
                        <?= $staff['first_name'].' '.$staff['last_name'] ?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php $colmd = 'col-md-4'?>
                  <?php } else {?>
                  <?php $colmd = 'col-md-6'?>
                  <?php } ?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="visit_purpose">
                        <?= lang('Employees.xin_visit_purpose');?> <span class="text-danger">*</span>
                      </label>
                      <input class="form-control" placeholder="<?= lang('Employees.xin_visit_purpose');?>" name="visit_purpose" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="visit_place">
                        <?= lang('Employees.xin_visit_place');?> <span class="text-danger">*</span>
                      </label>
                      <input class="form-control" placeholder="<?= lang('Employees.xin_visit_place');?>" name="visit_place" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date">
                        <?= lang('Projects.xin_start_date');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input class="form-control date" placeholder="<?= lang('Projects.xin_start_date');?>" name="start_date" type="text">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date">
                        <?= lang('Projects.xin_end_date');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input class="form-control date" placeholder="<?= lang('Projects.xin_end_date');?>" name="end_date" type="text">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="travel_mode">
                        <?= lang('Employees.xin_travel_mode');?> <span class="text-danger">*</span>
                      </label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_travel_mode');?>" name="travel_mode">
                        <option value="1">
                        <?= lang('Employees.xin_by_bus');?>
                        </option>
                        <option value="2">
                        <?= lang('Employees.xin_by_train');?>
                        </option>
                        <option value="3">
                        <?= lang('Employees.xin_by_plane');?>
                        </option>
                        <option value="4">
                        <?= lang('Employees.xin_by_taxi');?>
                        </option>
                        <option value="5">
                        <?= lang('Employees.xin_by_rental_car');?>
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="<?= $colmd?>">
                    <div class="form-group">
                      <label for="arrangement_type">
                        <?= lang('Employees.xin_arragement_type');?> <span class="text-danger">*</span>
                      </label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_arragement_type');?>" name="arrangement_type">
                        <option value=""></option>
                        <?php foreach($category_info as $icategory) {?>
                        <option value="<?= $icategory['constants_id']?>">
                        <?= $icategory['category_name']?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="<?= $colmd?>">
                    <div class="form-group">
                      <label for="expected_budget">
                        <?= lang('Employees.xin_expected_travel_budget');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                          <?= $xin_system['default_currency'];?>
                          </span></div>
                        <input class="form-control" placeholder="<?= lang('Employees.xin_expected_travel_budget');?>" name="expected_budget" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="<?= $colmd?>">
                    <div class="form-group">
                      <label for="actual_budget">
                        <?= lang('Employees.xin_actual_travel_budget');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                          <?= $xin_system['default_currency'];?>
                          </span></div>
                        <input class="form-control" placeholder="<?= lang('Employees.xin_actual_travel_budget');?>" name="actual_budget" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="description">
                        <?= lang('Main.xin_description');?>
                      </label>
                      <textarea class="form-control editor" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="2" id="description"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false">
                <?= lang('Main.xin_reset');?>
                </button>
                &nbsp;
                <button type="submit" class="btn btn-primary">
                <?= lang('Main.xin_save');?>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>
<?php } ?>
<div class="card user-profile-list <?php echo $get_animate;?>">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Dashboard.left_travels');?>
    </h5>
    <?php if(in_array('travel2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
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
            <th><i class="fa fa-user"></i>
              <?= lang('Dashboard.dashboard_employee');?></th>
            <th><?= lang('Employees.xin_visit_place');?></th>
            <th><?= lang('Employees.xin_visit_purpose');?></th>
            <th><?= lang('Employees.xin_arragement_type');?></th>
            <th> <?= lang('Employees.xin_actual_travel_budget');?></th>
            <th><i class="fa fa-calendar"></i>
              <?= lang('Projects.xin_end_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

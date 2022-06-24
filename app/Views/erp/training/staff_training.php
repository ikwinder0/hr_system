<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\TrainersModel;
use App\Models\ConstantsModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$CountryModel = new CountryModel();
$TrainersModel = new TrainersModel();
$ConstantsModel = new ConstantsModel();
$Moduleattributes = new Moduleattributes();
$Moduleattributesval = new Moduleattributesval();
$Moduleattributesvalsel = new Moduleattributesvalsel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$xin_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'company'){
	$trainer = $TrainersModel->where('company_id', $usession['sup_user_id'])->orderBy('trainer_id','ASC')->findAll();
	$training_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','training_type')->orderBy('constants_id', 'ASC')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',4)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',4)->orderBy('custom_field_id', 'ASC')->findAll();
} else {
	$trainer = $TrainersModel->where('company_id', $user_info['company_id'])->orderBy('trainer_id','ASC')->findAll();
	$training_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','training_type')->orderBy('constants_id', 'ASC')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',4)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',4)->orderBy('custom_field_id', 'ASC')->findAll();
}
?>
<?php if(in_array('training2',staff_role_resource()) || in_array('trainer1',staff_role_resource()) || in_array('training_skill1',staff_role_resource()) || in_array('training_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('training2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/training-sessions');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-target"></span>
      <?= lang('Dashboard.left_training');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_training');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('trainer1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/trainers-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-user-plus"></span>
      <?= lang('Dashboard.left_trainers');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.left_trainers');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('training_skill1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/training-skills');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Dashboard.left_training_skills');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.left_training_skills');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('training_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/training-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Dashboard.left_training_calendar');?>
      </div>
    </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<?php if(in_array('training3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <div class="card mb-2">
    <div id="accordion">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_add_new');?>
          <?= lang('Dashboard.left_training');?>
        </h5>
        <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
          <?= lang('Main.xin_hide');?>
          </a> </div>
      </div>
      <?php $attributes = array('name' => 'add_training', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('_user' => 1);?>
      <?php echo form_open('erp/training/add_training', $attributes, $hidden);?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="trainer">
                <?= lang('Dashboard.left_trainer');?> <span class="text-danger">*</span>
              </label>
              <select class="form-control" name="trainer" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_trainer');?>">
                <option value=""></option>
                <?php foreach($trainer as $staff) {?>
                <option value="<?= $staff['trainer_id']?>">
                <?= $staff['first_name'].' '.$staff['last_name'] ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="training_type">
                <?= lang('Dashboard.left_training_skill');?> <span class="text-danger">*</span>
              </label>
              <select class="form-control" name="training_type" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_training_skill');?>">
                <option value=""></option>
                <?php foreach($training_types as $itraining_type):?>
                <option value="<?= $itraining_type['constants_id'];?>">
                <?= $itraining_type['category_name'];?>
                </option>
                <?php endforeach;?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="training_cost">
                <?= lang('Main.xin_training_cost');?>
              </label>
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">
                  <?= $xin_system['default_currency'];?>
                  </span></div>
                <input class="form-control" placeholder="<?= lang('Main.xin_training_cost');?>" name="training_cost" type="text" value="">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <?php if($user_info['user_type'] == 'company'){?>
          <?php $istaff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
          <input type="hidden" value="0" name="employee_id[]" />
          <div class="col-md-6">
            <div class="form-group">
              <label for="employee" class="control-label">
                <?= lang('Dashboard.dashboard_employees');?>
              </label>
              <select multiple class="form-control" name="employee_id[]" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employees');?>">
                <option value=""></option>
                <?php foreach($istaff_info as $istaff) {?>
                <option value="<?= $istaff['user_id']?>">
                <?= $istaff['first_name'].' '.$istaff['last_name'] ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <?php } ?>
          <div class="col-md-3">
            <div class="form-group">
              <label for="start_date">
                <?= lang('Projects.xin_start_date');?> <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <input class="form-control date" placeholder="<?= lang('Projects.xin_start_date');?>" name="start_date" type="text" value="">
                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="end_date">
                <?= lang('Projects.xin_end_date');?> <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <input class="form-control date" placeholder="<?= lang('Projects.xin_end_date');?>" name="end_date" type="text" value="">
                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="description">
                <?= lang('Main.xin_description');?>
              </label>
              <textarea class="form-control editor" placeholder="<?= lang('Main.xin_description');?>" name="description" rows="3" id="description"></textarea>
            </div>
          </div>
        </div>
        <?php if($count_module_attributes > 0):?>
            <div class="row">
              <?php foreach($module_attributes as $mattribute):?>
              <?php if($mattribute['attribute_type'] == 'date'){?>
              <?php
                if($mattribute['validation']==1):
                    $validate_opt = '<span class="text-danger">*</span>';
                else:
                    $validate_opt = '';
                endif;
              ?>
              <div class="<?= $mattribute['col_width'];?>">
                <div class="form-group">
                  <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                  <input class="form-control date" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text">
                </div>
              </div>
              <?php } else if($mattribute['attribute_type'] == 'select'){?>
              <?php
                if($mattribute['validation']==1):
                    $validate_opt = '<span class="text-danger">*</span>';
                else:
                    $validate_opt = '';
                endif;
              ?>
              <div class="col-md-4">
                <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id',$mattribute['custom_field_id'])->findAll();?>
                <div class="form-group">
                  <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                  <select class="form-control" name="<?php echo $mattribute['attribute'];?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute['attribute_label'];?>">
                    <?php foreach($iselc_val as $selc_val) {?>
                    <option value="<?php echo $selc_val['attributes_select_value_id']?>"><?php echo $selc_val['select_label']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } else if($mattribute['attribute_type'] == 'textarea'){?>
              <?php
                if($mattribute['validation']==1):
                    $validate_opt = '<span class="text-danger">*</span>';
                else:
                    $validate_opt = '';
                endif;
              ?>
              <div class="<?= $mattribute['col_width'];?>">
                <div class="form-group">
                  <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                  <textarea class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text"></textarea>
                </div>
              </div>
              <?php } else { ?>
              <?php
                if($mattribute['validation']==1):
                    $validate_opt = '<span class="text-danger">*</span>';
                else:
                    $validate_opt = '';
                endif;
              ?>
              <div class="<?= $mattribute['col_width'];?>">
                <div class="form-group">
                  <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                  <input class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text">
                </div>
              </div>
              <?php }	?>
              <?php endforeach;?>
            </div>
            <?php endif;?>
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
      <?= form_close(); ?>
    </div>
  </div>
</div>
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Dashboard.left_training');?>
    </h5>
    <?php if(in_array('training3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
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
            <th><?= lang('Dashboard.left_training_skill');?></th>
            <th><?= lang('Dashboard.left_trainer');?></th>
            <th><i class="far fa-calendar-alt small"></i>
              <?= lang('Projects.xin_start_date');?></th>
            <th><i class="far fa-calendar-alt small"></i>
              <?= lang('Projects.xin_end_date');?></th>
            <th><i class="fa fa-user small"></i>
              <?= lang('Dashboard.dashboard_employees');?></th>
            <th><?= lang('Main.xin_training_cost');?></th>
            <th><?= lang('Main.dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

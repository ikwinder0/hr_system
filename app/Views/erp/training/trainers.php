<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$CountryModel = new CountryModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'company'){
	$trainer = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','trainer')->findAll();
	$training_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','training_type')->orderBy('constants_id', 'ASC')->findAll();
} else {
	$trainer = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','trainer')->findAll();
	$training_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','training_type')->orderBy('constants_id', 'ASC')->findAll();
}
?>

<?php if(in_array('training2',staff_role_resource()) || in_array('trainer1',staff_role_resource()) || in_array('training_skill1',staff_role_resource()) || in_array('training_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('training2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/training-sessions');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-target"></span>
      <?= lang('Dashboard.left_training');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_training');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('trainer1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/trainers-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-user-plus"></span>
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
<?php if(in_array('trainer2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <div class="card mb-2">
    <div id="accordion">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_add_new');?>
          <?= lang('Dashboard.left_trainer');?>
        </h5>
        <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
          <?= lang('Main.xin_hide');?>
          </a> </div>
      </div>
      <?php $attributes = array('name' => 'add_training', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('_user' => 1);?>
      <?php echo form_open('erp/trainers/add_trainer', $attributes, $hidden);?>
      <div class="card-body">
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="first_name">
                        <?= lang('Main.xin_employee_first_name');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"> <i class="fas fa-user"></i> </span></div>
                        <input class="form-control" placeholder="<?= lang('Main.xin_employee_first_name');?>" name="first_name" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name" class="control-label">
                        <?= lang('Main.xin_employee_last_name');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"> <i class="fas fa-user"></i> </span></div>
                        <input class="form-control" placeholder="<?= lang('Main.xin_employee_last_name');?>" name="last_name" type="text" value="">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        <?= lang('Main.xin_contact_number');?> <span class="text-danger">*</span>
                      </label>
                      <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email" class="control-label">
                        <?= lang('Main.xin_email');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"> <i class="fas fa-envelope"></i> </span></div>
                        <input class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email" type="text" value="">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="expertise">
                    <?= lang('Recruitment.xin_expertise');?> <span class="text-danger">*</span>
                  </label>
                  <textarea class="form-control textarea" placeholder="<?= lang('Recruitment.xin_expertise');?>" name="expertise" cols="30" rows="5" id="expertise"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="address">
                <?= lang('Main.xin_address');?>
              </label>
              <textarea class="form-control" placeholder="<?= lang('Main.xin_address');?>" name="address" cols="30" rows="3" id="address"></textarea>
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
      <?= form_close(); ?>
    </div>
  </div>
</div>
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Dashboard.left_trainers');?>
    </h5>
    <?php if(in_array('trainer2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
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
            <th><?= lang('Dashboard.left_trainer');?></th>
            <th><?= lang('Main.xin_contact_number');?></th>
            <th> <?= lang('Main.xin_email');?></th>
            <th> <?= lang('Recruitment.xin_expertise');?></th>
            <th><i class="fa fa-user small"></i>
              <?= lang('Main.xin_added_by');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

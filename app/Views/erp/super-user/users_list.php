<?php
use App\Models\ConstantsModel;
use App\Models\CountryModel;
use App\Models\SuperroleModel;
use App\Models\UsersModel;
use App\Models\SystemModel;

$ConstantsModel = new ConstantsModel();
$CountryModel = new CountryModel();
$SuperroleModel = new SuperroleModel();
$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$company_types = $ConstantsModel->where('type','company_type')->orderBy('constants_id', 'ASC')->findAll();
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$roles = $SuperroleModel->orderBy('role_id', 'ASC')->findAll();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$xin_system = $SystemModel->where('setting_id', 1)->first();
?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('6',super_user_role_resource())) { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/super-users');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-user-plus"></span>
      <?= lang('Main.xin_super_users');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.xin_super_users');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('7',super_user_role_resource())) { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/users-role');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-unlock"></span>
      <?= lang('Users.xin_hr_report_user_roles');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Users.xin_hr_report_user_roles');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
  <?php $attributes = array('name' => 'add_user', 'id' => 'xin-form', 'autocomplete' => 'off');?>
  <?php $hidden = array('user_id' => 0);?>
  <?= form_open_multipart('erp/users/add_user', $attributes, $hidden);?>
  <div id="accordion">
    <div class="row">
      <div class="col-md-8">
        <div class="card mb-2">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Users.xin_user');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <div class="card-body">
            <div class="form-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="company_name">
                      <?= lang('Main.xin_employee_first_name');?>
                      <span class="text-danger">*</span> </label>
                    <input class="form-control" placeholder="<?= lang('Main.xin_employee_first_name');?>" name="first_name" type="text" value="">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="last_name" class="control-label">
                      <?= lang('Main.xin_employee_last_name');?>
                      <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?= lang('Main.xin_employee_last_name');?>" name="last_name" type="text" value="">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">
                      <?= lang('Main.xin_email');?>
                      <span class="text-danger">*</span> </label>
                    <input class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email" type="email">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">
                      <?= lang('Main.dashboard_username');?>
                      <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?= lang('Main.dashboard_username');?>" name="username" type="text">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="website">
                      <?= lang('Main.xin_employee_password');?>
                      <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?= lang('Main.xin_employee_password');?>" name="password" type="text">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="contact_number">
                      <?= lang('Main.xin_contact_number');?>
                      <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="number">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="gender" class="control-label">
                      <?= lang('Main.xin_employee_gender');?>
                    </label>
                    <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_gender');?>">
                      <option value="1">
                      <?= lang('Main.xin_gender_male');?>
                      </option>
                      <option value="2">
                      <?= lang('Main.xin_gender_female');?>
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="role">
                      <?= lang('Main.xin_employee_role');?>
                      <span class="text-danger">*</span></label>
                    <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_role');?>">
                      <option value=""></option>
                      <?php foreach($roles as $role) {?>
                      <option value="<?php echo $role['role_id']?>"><?php echo $role['role_name']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="address">
                      <?= lang('Main.xin_country');?>
                      <span class="text-danger">*</span> </label>
                    <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_country');?>">
                      <option value="">
                      <?= lang('Main.xin_select_one');?>
                      </option>
                      <?php foreach($all_countries as $country) {?>
                      <option value="<?= $country['country_id'];?>">
                      <?= $country['country_name'];?>
                      </option>
                      <?php } ?>
                    </select>
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
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h5>
              <?= lang('Users.xin_user_photo');?>
            </h5>
          </div>
          <div class="card-body py-2">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="logo">
                    <?= lang('Users.xin_user_photo');?>
                    <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="file">
                    <label class="custom-file-label">
                      <?= lang('Main.xin_choose_file');?>
                    </label>
                    <small>
                    <?= lang('Main.xin_company_file_type');?>
                    </small> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?= form_close(); ?>
</div>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Users.xin_users');?>
    </h5>
    <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
      <?= lang('Main.xin_add_new');?>
      </a> </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?= lang('Main.xin_name');?></th>
            <th><?= lang('Main.xin_contact_number');?></th>
            <th><?= lang('Main.xin_employee_role');?></th>
            <th><?= lang('Main.xin_country');?></th>
            <th><?= lang('Main.dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

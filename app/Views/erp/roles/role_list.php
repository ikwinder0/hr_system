<?php
/* User Roles view
*/
?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('6',super_user_role_resource())) { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/super-users');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-user-plus"></span>
      <?= lang('Main.xin_super_users');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.xin_super_users');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('7',super_user_role_resource())) { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/users-role');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-unlock"></span>
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
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <div id="accordion">
  <?php $attributes = array('name' => 'add_role', 'id' => 'xin-form', 'autocomplete' => 'off');?>
  <?php $hidden = array('_user' => 0);?>
  <?php echo form_open('erp/users/add_role', $attributes, $hidden);?>
    <div class="row">
      <div class="col-md-8">
        <div class="card mb-2">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Main.xin_employee_role');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="role_name">
                    <?= lang('Users.xin_role_name');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Users.xin_role_name');?>" name="role_name" type="text" value="">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="role_name">
                    <?= lang('Users.xin_role_access');?>
                    <span class="text-danger">*</span></label>
                  <select class="form-control custom-select" id="role_access" data-plugin="select_hrm" name="role_access" data-placeholder="<?= lang('Users.xin_role_access');?>">
                    <option value="">&nbsp;</option>
                    <option value="2">
                    <?= lang('Users.xin_role_cmenu');?>
                    </option>
                    <option value="1">
                    <?= lang('Users.xin_role_all_menu');?>
                    </option>
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
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h5>
              <?= lang('Users.xin_roles');?>
            </h5>
          </div>
          <div class="card-body py-2">
            <div class="row">
              <div class="col-md-6">
                <input type="hidden" name="role_resources[0]" value="0" />
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[1]" id="1" value="1">
                    <label class="custom-control-label" for="1">
                      <?= lang('Company.xin_companies');?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[2]" id="2" value="2">
                    <label class="custom-control-label" for="2">
                      <?= lang('Membership.xin_membership');?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[4]" id="4" value="4">
                    <label class="custom-control-label" for="4">
                      <?= lang('Main.xin_multi_language');?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[5]" id="5" value="5">
                    <label class="custom-control-label" for="5">
                      <?= lang('Main.xin_super_users');?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[3]" id="3" value="3">
                    <label class="custom-control-label" for="3">
                      <?= lang('Membership.xin_billing_invoices');?>
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[6]" id="6" value="6">
                    <label class="custom-control-label" for="6">
                      <?= lang('Main.left_settings');?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[7]" id="7" value="7">
                    <label class="custom-control-label" for="7">
                      <?= lang('Main.left_constants');?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[8]" id="8" value="8">
                    <label class="custom-control-label" for="8">
                      <?= lang('Main.header_db_log');?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[9]" id="9" value="9">
                    <label class="custom-control-label" for="9">
                      <?= lang('Main.left_email_templates');?>
                    </label>
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
</div>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Users.xin_roles');?>
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
            <th><?= lang('Users.xin_role_name');?></th>
            <th><?= lang('Users.xin_role_menu_per');?></th>
            <th><i class="fa fa-calendar"></i>
              <?= lang('Users.xin_role_added_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<?php
/* User Roles view
*/
$get_animate ='';
?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item clickable"> <a href="<?= site_url('erp/staff-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-user-friends"></span>
      <?= lang('Dashboard.dashboard_employees');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.dashboard_employees');?>
      </div>
      </a> </li>
    <li class="nav-item active"> <a href="<?= site_url('erp/set-roles');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-user-lock"></span>
      <?= lang('Main.xin_roles_privileges');?>
      <div class="text-muted small">
        <?= lang('Dashboard.left_set_roles');?>
      </div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/office-shifts');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-clock"></span>
      <?= lang('Dashboard.left_office_shifts');?>
      <div class="text-muted small">
        <?= lang('Dashboard.xin_manage_shifts');?>
      </div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-exit');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-log-out"></span>
      <?= lang('Dashboard.left_employees_exit');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_employees_exit');?>
      </div>
      </a> </li>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <div class="card mb-2">
    <div id="accordion">
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
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'add_role', 'id' => 'xin-form', 'autocomplete' => 'off');?>
            <?php $hidden = array('_user' => 0);?>
            <?= form_open('erp/roles/add_role', $attributes, $hidden);?>
            <div class="form-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="role_name">
                          <?= lang('Users.xin_role_name');?>
                          <span class="text-danger">*</span> </label>
                        <input class="form-control" placeholder="<?= lang('Users.xin_role_name');?>" name="role_name" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <input type="checkbox" name="role_resources[]" value="0" checked style="display:none;"/>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="role_access">
                          <?= lang('Users.xin_role_access');?>
                          <span class="text-danger">*</span></label>
                        <select class="form-control custom-select" id="role_access" data-plugin="select_hrm" name="role_access"  data-placeholder="<?= lang('Users.xin_role_access');?>">
                          <option value="">&nbsp;</option>
                          <option value="1">
                          <?= lang('Users.xin_role_all_menu');?>
                          </option>
                          <option value="2">
                          <?= lang('Users.xin_role_cmenu');?>
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="resources">
                          <?= lang('Staff Apps');?>
                        </label>
                        <div id="all_resources">
                          <div class="demo-section k-content">
                            <div>
                              <div id="treeview_r1"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                      <label for="resources"> <?= lang('Company Apps');?></label>
                        <div id="all_resources">
                          <div class="demo-section k-content">
                            <div>
                              <div id="treeview_r2"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
<style type="text/css">
.k-in { display:none !important; }
</style>

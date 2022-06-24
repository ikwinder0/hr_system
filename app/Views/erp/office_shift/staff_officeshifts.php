<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();		
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
/* Office Shift view
*/
?>

<?php if(in_array('staff2',staff_role_resource()) || in_array('shift1',staff_role_resource()) || in_array('staffexit1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('staff2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/staff-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-user-friends"></span>
      <?= lang('Dashboard.dashboard_employees');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.dashboard_employees');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if($user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/set-roles');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-user-lock"></span>
      <?= lang('Main.xin_roles_privileges');?>
      <div class="text-muted small">
        <?= lang('Dashboard.left_set_roles');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('shift1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/office-shifts');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-clock"></span>
      <?= lang('Dashboard.left_office_shifts');?>
      <div class="text-muted small">
        <?= lang('Dashboard.xin_manage_shifts');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('staffexit1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-exit');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-log-out"></span>
      <?= lang('Dashboard.left_employees_exit');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_employees_exit');?>
      </div>
      </a> </li>
     <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<?php if(in_array('shift2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <div class="card">
    <div id="accordion">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_add_new');?>
          <?= lang('Employees.xin_employee_office_shift');?>
        </h5>
        <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
          <?= lang('Main.xin_hide');?>
          </a> </div>
      </div>
      <?php $attributes = array('name' => 'add_office_shift', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 1);?>
      <?php echo form_open('erp/officeshifts/add_office_shift', $attributes, $hidden);?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_shift_name');?>
                <span class="text-danger">*</span> </label>
              <input class="form-control" placeholder="<?= lang('Employees.xin_shift_name');?>" name="shift_name" type="text" value="" id="name">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_monday_in_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-1" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="monday_in_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="1"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_monday_out_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-2" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="monday_out_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="2"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_tuesday_in_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-3" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="tuesday_in_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="3"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_tuesday_out_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-4" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="tuesday_out_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="4"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_wednesday_in_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-5" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="wednesday_in_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="5"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_wednesday_out_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-6" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="wednesday_out_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="6"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_thursday_in_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-7" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="thursday_in_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="7"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_thursday_out_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-8" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="thursday_out_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="8"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_friday_in_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-9" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="friday_in_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="9"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_friday_out_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-10" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="friday_out_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="10"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_saturday_in_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-11" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="saturday_in_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="11"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_saturday_out_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-12" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="saturday_out_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="12"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_sunday_in_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-13" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="sunday_in_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="13"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="shift_name">
                <?= lang('Employees.xin_sunday_out_time');?>
                <span class="text-danger">*</span> </label>
              <div class="input-group">
                <input class="form-control timepicker clear-14" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="sunday_out_time" type="text" value="">
                <div class="input-group-append clear-time" data-clear-id="14"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
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
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Employees.xin_employee_office_shifts');?>
    </h5>
    <?php if(in_array('shift2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
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
            <th><?= lang('Employees.xin_e_details_shift');?></th>
            <th><?= lang('Employees.xin_monday');?></th>
            <th><?= lang('Employees.xin_tuesday');?></th>
            <th><?= lang('Employees.xin_wednesday');?></th>
            <th><?= lang('Employees.xin_thursday');?></th>
            <th><?= lang('Employees.xin_friday');?></th>
            <th><?= lang('Employees.xin_saturday');?></th>
            <th><?= lang('Employees.xin_sunday');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

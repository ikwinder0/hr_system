<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\DepartmentModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$DepartmentModel = new DepartmentModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
   $main_department = $DepartmentModel->where('company_id', $user_info['company_id'])->findAll();
} else {
	$main_department = $DepartmentModel->where('company_id', $usession['sup_user_id'])->findAll();
}
$get_animate = '';
?>
<?php if(in_array('visitor2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <div class="card mb-2">
    <div id="accordion">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_add_new');?>
          <?= lang('Main.xin_visitor');?>
        </h5>
        <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
          <?= lang('Main.xin_hide');?>
          </a> </div>
      </div>
      <?php $attributes = array('name' => 'add_visitor', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 1);?>
      <?php echo form_open('erp/visitors/add_visitor', $attributes, $hidden);?>
      <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="title">
                  <?= lang('Dashboard.left_department');?> <span class="text-danger">*</span>
                </label>
                <select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_department');?>">
                  <option value=""></option>
                  <?php foreach($main_department as $idepartment) {?>
                  <option value="<?= $idepartment['department_id']?>">
                  <?= $idepartment['department_name']?>
                  </option>
                  <?php } ?>
                </select>
              </div>
             </div> 
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="start_date">
                      <?= lang('Employees.xin_visit_purpose');?> <span class="text-danger">*</span>
                    </label>
                    <input class="form-control" placeholder="<?= lang('Employees.xin_visit_purpose');?>" name="visit_purpose" type="text" value="">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="end_date">
                      <?= lang('Main.xin_visitor_name');?> <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                    	<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                      <input class="form-control" placeholder="<?= lang('Main.xin_visitor_name');?>" name="visitor_name" type="text" value="">
                    </div>
                  </div>
                </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="end_date">
                  <?= lang('Main.xin_visit_date');?> <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <input class="form-control date" placeholder="<?= lang('Main.xin_visit_date');?>" name="visit_date" type="text" value="">
                  <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="summary">
                  <?= lang('Employees.xin_shift_in_time');?> <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <input type="text" class="form-control timepicker" placeholder="<?= lang('Employees.xin_shift_in_time');?>" name="check_in" id="check_in">
                  <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
                  <div class="form-group">
                    <label for="description">
                      <?= lang('Main.xin_phone');?> <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" placeholder="<?= lang('Main.xin_phone');?>" name="phone" id="phone">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="description">
                      <?= lang('Main.xin_email');?> <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                    	<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                      <input type="text" class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="description">
                      <?= lang('Main.xin_description');?>
                    </label>
                    <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="8" rows="2" id="description"></textarea>
                  </div>
                </div>
                
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="address">
                      <?= lang('Main.xin_address');?> <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_address');?>" name="address" cols="8" rows="2" id="address"></textarea>
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
      <?= lang('Main.xin_visitors');?>
    </h5>
    <?php if(in_array('visitor2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
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
            <th width="200"><?= lang('Main.xin_visitor_name');?></th>
            <th><?= lang('Dashboard.left_department');?></th>
            <th><i class="fa fa-calendar small"></i>
              <?= lang('Employees.xin_visit_purpose');?></th>
            <th><?= lang('Main.xin_phone');?></th>  
            <th><i class="fa fa-calendar small"></i>
              <?= lang('Main.xin_visit_date');?></th>
             <th><?= lang('Employees.xin_shift_in_time');?></th>
             <th><?= lang('Employees.xin_shift_out_time');?></th> 
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

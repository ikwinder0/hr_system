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
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_id!=', $usession['sup_user_id'])->where('user_type','staff')->findAll();
} else {
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
}
/* Assets view
*/
$get_animate = '';
?>
<?php if(in_array('complaint2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <?php $attributes = array('name' => 'add_complaint', 'id' => 'xin-form', 'autocomplete' => 'off');?>
  <?php $hidden = array('user_id' =>1);?>
  <?php echo form_open('erp/complaints/add_complaint', $attributes, $hidden);?>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div id="accordion">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Dashboard.left_complaint');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="title">
                    <?= lang('Employees.xin_complaint_title');?> <span class="text-danger">*</span>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_complaint_title');?>" name="title" type="text">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="complaint_date">
                    <?= lang('Employees.xin_complaint_date');?> <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?= lang('Employees.xin_complaint_date');?>" name="complaint_date" type="text">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <input type="hidden" value="0" name="complaint_against[]" />
                  <label for="complaint_against">
                    <?= lang('Employees.xin_complaint_against');?>
                  </label>
                  <select multiple class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_complaint_employees');?>" name="complaint_against[]">
                    <option value="">
                    <?= lang('Employees.xin_complaint_employees');?>
                    </option>
                    <?php foreach($staff_info as $staff) {?>
                    <option value="<?= $staff['user_id']?>">
                    <?= $staff['first_name'].' '.$staff['last_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description">
                    <?= lang('Main.xin_description');?> <span class="text-danger">*</span>
                  </label>
                  <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="3"></textarea>
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
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Dashboard.left_complaints');?>
    </h5>
    <?php if(in_array('complaint2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
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
            <th><?= lang('Employees.xin_complaint_title');?></th>
            <th><i class="fa fa-user small"></i>
              <?= lang('Employees.xin_complaint_against');?></th>
            <th><i class="fa fa-calendar small"></i>
              <?= lang('Employees.xin_complaint_date');?></th>
            <th><?= lang('Main.dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

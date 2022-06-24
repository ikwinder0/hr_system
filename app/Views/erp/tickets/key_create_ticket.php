<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\DepartmentModel;
use App\Models\StaffdetailsModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$DepartmentModel = new DepartmentModel();
$StaffdetailsModel = new StaffdetailsModel();
$Moduleattributes = new Moduleattributes();
$Moduleattributesval = new Moduleattributesval();
$Moduleattributesvalsel = new Moduleattributesvalsel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$staff_details = $StaffdetailsModel->where('user_id', $user_info['user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$main_department = $DepartmentModel->where('company_id', $user_info['company_id'])->where('department_id', $staff_details['department_id'])->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',3)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',3)->orderBy('custom_field_id', 'ASC')->findAll();
} else {
	$main_department = $DepartmentModel->where('company_id', $usession['sup_user_id'])->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',3)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',3)->orderBy('custom_field_id', 'ASC')->findAll();
}
?>
<?php $attributes = array('name' => 'add_ticket', 'id' => 'xin-form', 'autocomplete' => 'off');?>
<?php $hidden = array('user_id' => 1);?>
<?php echo form_open('erp/tickets/add_ticket', $attributes, $hidden);?>
<hr class="border-light m-0 mb-3">
<div class="row justify-content-md-center">
  <div class="col-md-12">
    <div class="card">
      <div id="accordion">
        <div class="card-header">
          <h5>
            <?= lang('Dashboard.left_create_ticket');?>
          </h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="task_name">
                  <?= lang('Main.xin_subject');?> <span class="text-danger">*</span>
                </label>
                <input class="form-control" placeholder="<?= lang('Main.xin_subject');?>" name="subject" type="text" value="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="ticket_priority" class="control-label">
                  <?= lang('Projects.xin_p_priority');?> <span class="text-danger">*</span>
                </label>
                <select name="ticket_priority" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Projects.xin_p_priority');?>">
                  <option value=""></option>
                  <option value="1">
                  <?= lang('Projects.xin_low');?>
                  </option>
                  <option value="2">
                  <?= lang('Main.xin_medium');?>
                  </option>
                  <option value="3">
                  <?= lang('Projects.xin_high');?>
                  </option>
                  <option value="4">
                  <?= lang('Main.xin_critical');?>
                  </option>
                </select>
              </div>
            </div>
            <?php if($user_info['user_type'] == 'company'){?>
            <div class="col-md-6">
              <div class="form-group">
                <label for="department">
                  <?= lang('Dashboard.left_department');?> <span class="text-danger">*</span>
                </label>
                <select class="form-control" name="department_id" id="department_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_department');?>">
                  <option value=""></option>
                  <?php foreach($main_department as $idepartment) {?>
                  <option value="<?= $idepartment['department_id']?>">
                  <?= $idepartment['department_name']?>
                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
            <div class="col-md-6" id="staff_ajax">
              <div class="form-group">
                <label for="first_name">
                  <?= lang('Dashboard.dashboard_employee');?> <span class="text-danger">*</span>
                </label>
                <select class="form-control" disabled="disabled" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_choose_an_employee');?>">
                </select>
              </div>
            </div>
            <?php } ?>
            
            <div class="col-md-12">
              <div class="form-group">
                <label for="description">
                  <?= lang('Main.xin_description');?>
                </label>
                <textarea class="form-control editor" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="5"></textarea>
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
          <button type="submit" class="btn btn-primary btn-lg">
          <?= lang('Dashboard.left_create_ticket');?>
          </button>
        </div>
      </div>
    </div>
  </div>
  <!--<div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h5>
          <?= lang('Dashboard.left_ticket_attachment');?>
        </h5>
      </div>
      <div class="card-body py-2">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="logo">
                <?= lang('Main.xin_attachment');?>
                <span class="text-danger">*</span> </label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="attachment">
                <label class="custom-file-label">
                  <?= lang('Main.xin_attachment');?>
                </label>
                <small>
                <?= lang('Main.xin_company_file_type');?>
                </small> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>-->
</div>
<?= form_close(); ?>

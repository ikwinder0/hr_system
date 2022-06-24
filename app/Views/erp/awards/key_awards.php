<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AssetsModel;
use App\Models\ConstantsModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();	
$SystemModel = new SystemModel();		
$ConstantsModel = new ConstantsModel();
$Moduleattributes = new Moduleattributes();
$Moduleattributesval = new Moduleattributesval();
$Moduleattributesvalsel = new Moduleattributesvalsel();
$xin_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','award_type')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',1)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',1)->orderBy('custom_field_id', 'ASC')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','award_type')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',1)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',1)->orderBy('custom_field_id', 'ASC')->findAll();
}
/* Awards view
*/
$get_animate = '';
?>
<?php if(in_array('award1',staff_role_resource()) || in_array('award_type1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('award1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/awards-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-award"></span>
      <?= lang('Dashboard.left_awards');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.left_awards');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('award_type1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/award-type');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Employees.xin_award_type');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Employees.xin_award_type');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-12">
    <?php if(in_array('award2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <?php $attributes = array('name' => 'add_award', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('_user' => 1);?>
      <?php echo form_open_multipart('erp/awards/add_awards', $attributes, $hidden);?>
      <div class="row">
        <div class="col-md-8">
          <div class="card mb-2">
            <div id="accordion">
              <div class="card-header">
                <h5>
                  <?= lang('Main.xin_add_new');?>
                  <?= lang('Dashboard.left_award');?>
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
                  <?php $colmd = 'col-md-6'?>
                  <?php } else {?>
                  <?php $colmd = 'col-md-12'?>
                  <?php } ?>
                  <div class="<?= $colmd?>">
                    <div class="form-group">
                      <label for="award_type">
                        <?= lang('Employees.xin_award_type');?> <span class="text-danger">*</span>
                      </label>
                      <select name="award_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_award_type');?>">
                        <option value=""></option>
                        <?php foreach($category_info as $assets_category) {?>
                        <option value="<?= $assets_category['constants_id']?>">
                        <?= $assets_category['category_name']?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="award_date">
                        <?= lang('Main.xin_e_details_date');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input class="form-control date" placeholder="<?= lang('Employees.xin_award_date');?>" name="award_date" type="text" value="">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="gift">
                        <?= lang('Employees.xin_gift');?>
                      </label>
                      <div class="input-group">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-gift"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Employees.xin_award_gift');?>" name="gift" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cash">
                        <?= lang('Employees.xin_cash');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <div class="input-group-append"><span class="input-group-text">
                          <?= $xin_system['default_currency'];?>
                          </span></div>
                        <input class="form-control" placeholder="<?= lang('Employees.xin_award_cash');?>" name="cash" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="month_year">
                        <?= lang('Employees.xin_award_month_year');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input class="form-control hr_month_year" placeholder="<?= lang('Employees.xin_award_month_year');?>" name="month_year" type="text">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="award_information">
                        <?= lang('Employees.xin_award_info');?> <span class="text-danger">*</span>
                      </label>
                      <textarea class="form-control" placeholder="<?= lang('Employees.xin_award_info');?>" name="award_information" cols="30" rows="2" id="award_information"></textarea>
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
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h5>
                <?= lang('Employees.xin_award_attachment');?>
              </h5>
            </div>
            <div class="card-body py-2">
              <div class="row">
                <div class="col-md-12">
                  <label for="logo">
                    <?= lang('Main.xin_attachment');?>
                    <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="award_picture">
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
      <?= form_close(); ?>
    </div>
    <?php } ?>
    <div class="card user-profile-list <?php echo $get_animate;?>">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_list_all');?>
          <?= lang('Dashboard.left_awards');?>
        </h5>
        <?php if(in_array('award2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
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
                <th width="200">
                  <?= lang('Employees.xin_award_type');?></th>
                <th><i class="fa fa-user small"></i>
                  <?= lang('Dashboard.dashboard_employee');?></th>
                <th> <?= lang('Employees.xin_award_gift');?></th>
                <th> <?= lang('Employees.xin_award_cash');?></th>
                <th> <?= lang('Employees.xin_award_month_year');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>

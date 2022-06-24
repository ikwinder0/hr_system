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
$ConstantsModel = new ConstantsModel();
$Moduleattributes = new Moduleattributes();
$Moduleattributesval = new Moduleattributesval();
$Moduleattributesvalsel = new Moduleattributesvalsel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','assets_category')->findAll();
	$brand_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','assets_brand')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',2)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',2)->orderBy('custom_field_id', 'ASC')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','assets_category')->findAll();
	$brand_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','assets_brand')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',2)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',2)->orderBy('custom_field_id', 'ASC')->findAll();
}
/* Assets view
*/
$get_animate = '';
?>
<?php if(in_array('asset1',staff_role_resource()) || in_array('asset_cat1',staff_role_resource()) || in_array('asset_brand1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('asset1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/assets-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-command"></span>
      <?= lang('Dashboard.xin_assets');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.xin_assets');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('asset_cat1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/assets-category');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-clipboard-list"></span>
      <?= lang('Dashboard.xin_category');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Asset.xin_asset_categories');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('asset_brand1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/assets-brand');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-list-ul"></span>
      <?= lang('Asset.xin_brands');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Asset.xin_asset_brands');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-12">
    <?php if(in_array('asset2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <div id="add_form" class="collapse add-form <?= $get_animate;?>" data-parent="#accordion" style="">
      <?php $attributes = array('name' => 'add_assets', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
      <?php $hidden = array('user_id' => 0);?>
      <?= form_open_multipart('erp/assets/add_asset', $attributes, $hidden);?>
      <div class="row">
        <div class="col-md-8">
          <div class="card mb-2">
            <div id="accordion">
              <div class="card-header">
                <h5>
                  <?= lang('Main.xin_add_new');?>
                  <?= lang('Dashboard.xin_asset');?>
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
                        <label for="asset_name" class="control-label">
                          <?= lang('Asset.xin_asset_name');?>
                          <span class="text-danger">*</span> </label>
                        <input class="form-control" placeholder="<?= lang('Asset.xin_asset_name');?>" name="asset_name" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="first_name">
                          <?= lang('Dashboard.xin_category');?>
                          <span class="text-danger">*</span> </label>
                        <select class="form-control" name="category_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_category');?>">
                          <option value=""></option>
                          <?php foreach($category_info as $assets_category) {?>
                          <option value="<?= $assets_category['constants_id']?>">
                          <?= $assets_category['category_name']?>
                          </option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="first_name">
                          <?= lang('Asset.xin_brand');?>
                          <span class="text-danger">*</span> </label>
                        <select class="form-control" name="brand_id" data-plugin="select_hrm" data-placeholder="<?= lang('Asset.xin_brand');?>">
                          <option value=""></option>
                          <?php foreach($brand_info as $assets_brand) {?>
                          <option value="<?= $assets_brand['constants_id']?>">
                          <?= $assets_brand['category_name']?>
                          </option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <?php if($user_info['user_type'] == 'company'){?>
                    <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="first_name">
                          <?= lang('Dashboard.dashboard_employee');?>
                        </label>
                        <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_choose_an_employee');?>">
                          <?php foreach($staff_info as $staff) {?>
                          <option value="<?= $staff['user_id']?>">
                          <?= $staff['first_name'].' '.$staff['last_name'] ?>
                          </option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <?php } ?>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="manufacturer">
                          <?= lang('Asset.xin_manufacturer');?>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Asset.xin_manufacturer');?>" name="manufacturer" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="xin_serial_number" class="control-label">
                          <?= lang('Asset.xin_serial_number');?>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Asset.xin_serial_number');?>" name="serial_number" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="company_asset_code">
                          <?= lang('Asset.xin_company_asset_code');?>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Asset.xin_company_asset_code');?>" name="company_asset_code" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="is_working" class="control-label">
                          <?= lang('Asset.xin_is_working');?>
                        </label>
                        <select class="form-control" name="is_working" data-plugin="select_hrm" data-placeholder="<?= lang('Asset.xin_is_working');?>">
                          <option value="1">
                          <?= lang('Main.xin_yes');?>
                          </option>
                          <option value="0">
                          <?= lang('Main.xin_no');?>
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="purchase_date">
                          <?= lang('Asset.xin_purchase_date');?>
                        </label>
                        <div class="input-group">
                          <input class="form-control date" placeholder="<?= lang('Asset.xin_purchase_date');?>" name="purchase_date" type="text" value="">
                          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="role">
                          <?= lang('Main.xin_invoice_number');?>
                        </label>
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-file-invoice"></i></span></div>
                          <input class="form-control" placeholder="<?= lang('Main.xin_invoice_number');?>" name="invoice_number" type="text" value="">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="warranty_end_date" class="control-label">
                          <?= lang('Asset.xin_warranty_end_date');?>
                        </label>
                        <div class="input-group">
                          <input class="form-control date" placeholder="<?= lang('Asset.xin_warranty_end_date');?>" name="warranty_end_date" type="text" value="">
                          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="award_information">
                          <?= lang('Asset.xin_asset_note');?>
                        </label>
                        <textarea class="form-control editor" placeholder="<?= lang('Asset.xin_asset_note');?>" name="asset_note" cols="30" rows="2" id="asset_note"></textarea>
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
                <?= lang('Asset.xin_asset_image');?>
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
                      <input type="file" class="custom-file-input" name="asset_image">
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
      <?= form_close(); ?>
    </div>
    <?php } ?>
    <div class="card user-profile-list">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_list_all');?>
          <?= lang('Dashboard.xin_assets');?>
        </h5>
        <?php if(in_array('asset2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
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
                <th><i class="ion ion-md-today small"></i>
                  <?= lang('Asset.xin_asset_name');?></th>
                <th><?= lang('Dashboard.xin_category');?></th>
                <th><?= lang('Asset.xin_brand');?></th>  
                <th><?= lang('Asset.xin_company_asset_code');?></th>
                <th><?= lang('Asset.xin_is_working');?></th>
                <th><i class="fa fa-user small"></i>
                  <?= lang('Dashboard.dashboard_employee');?></th>
                <th><i class="far fa-calendar-alt small"></i>
                  <?= lang('Main.xin_created_at');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

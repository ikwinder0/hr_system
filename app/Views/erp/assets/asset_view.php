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
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$AssetsModel = new AssetsModel();	
$SystemModel = new SystemModel();
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
$xin_system = erp_company_settings();

$segment_id = $request->uri->getSegment(3);
$assets_id = udecode($segment_id);
$result = $AssetsModel->where('assets_id', $assets_id)->first();	
?>

<div class="row">
  <div class="col-lg-4">
    <div class="card hdd-right-inner">
      <div class="card-header">
        <h5>
          <?= lang('Asset.xin_view_asset');?>
        </h5>
      </div>
      <div class="card-body task-details">
        <table class="table">
          <tbody>
            <tr>
              <td><i class="fas fa-adjust m-r-5"></i> <?php echo lang('Asset.xin_asset_name');?>:</td>
              <td class="text-right"><span class="float-right">
                <?= $result['name'];?>
                </span></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Dashboard.xin_category');?>:</td>
              <td class="text-right"><?php foreach($category_info as $assets_category) {?>
                <?php if($result['assets_category_id']==$assets_category['constants_id']):?>
                <?= $assets_category['category_name'];?>
                <?php endif;?>
                <?php } ?></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Asset.xin_brand');?>:</td>
              <td class="text-right"><?php foreach($brand_info as $_brand) {?>
                <?php if($result['brand_id']==$_brand['constants_id']):?>
                <?= $_brand['category_name'];?>
                <?php endif;?>
                <?php } ?></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Main.xin_created_at');?>:</td>
              <td class="text-right"><?= set_date_format($result['created_at']);?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="bg-light card mb-2">
      <div class="card-body">
        <ul class="nav nav-pills mb-0">
          <li class="nav-item m-r-5"> <a href="#pills-overview" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Main.xin_overview');?>
            </button>
            </a> </li>
          <?php if(in_array('asset3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item m-r-5"> <a href="#pills-edit" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Main.xin_edit');?>
            </button>
            </a> </li>
          <li class="nav-item m-r-5"> <a href="#pills-image" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Asset.xin_asset_image');?>
            </button>
            </a> </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h5><i class="feather icon-lock mr-1"></i>
          <?= lang('Dashboard.xin_asset');?>
          :
          <?= $result['name'];?>
        </h5>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table m-b-0 f-14 b-solid requid-table">
                <tbody class="text-muted">
                  <tr>
                    <td><?php echo lang('Asset.xin_company_asset_code');?></td>
                    <td><?= $result['company_asset_code'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Dashboard.dashboard_employee');?></td>
                    <td><?php
                    	$staff_info = $UsersModel->where('user_id', $result['employee_id'])->first();
						if($staff_info){
							$user_detail = $staff_info['first_name'].' '.$staff_info['last_name'];
						} else {
							$user_detail = lang('Users.xin_user_data_removed');
						}
						echo $user_detail;
						?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Asset.xin_is_working');?></td>
                    <td><?php
						if($result['is_working']==1){
							echo $working = lang('Main.xin_yes');
						} else {
							echo $working = lang('Main.xin_no');
						}
					  ?></td>
                  </tr>
                  <tr>
                    <td><?= lang('Asset.xin_purchase_date');?></td>
                    <td><?= set_date_format($result['purchase_date']);?></td>
                  </tr>
                  <tr>
                    <td><?= lang('Main.xin_invoice_number');?></td>
                    <td><?= $result['invoice_number'];?></td>
                  </tr>
                  <tr>
                    <td><?= lang('Asset.xin_manufacturer');?></td>
                    <td style="display: table-cell;"><?= $result['manufacturer'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Asset.xin_serial_number');?></td>
                    <td class="text-success"><?= $result['serial_number'];?></td>
                  </tr>
                  <tr>
                    <td><?= lang('Asset.xin_warranty_end_date');?></td>
                    <td class="text-warning"><?= set_date_format($result['warranty_end_date']);?></td>
                  </tr>
                  <tr>
                    <td><?= lang('Asset.xin_asset_image');?></td>
                    <td class="text-warning"><?php if($result['asset_image']!='' && $result['asset_image']!='no file') {?>
                      <a href="<?= site_url()?>download?type=asset_image&filename=<?= uencode($result['asset_image']);?>">
                      <?= lang('Main.xin_download');?>
                      </a>
                      <?php } ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="m-b-30 m-t-15">
              <h6><?php echo lang('Asset.xin_asset_note');?></h6>
              <hr>
              <?= html_entity_decode($result['asset_note']);?>
            </div>
          </div>
        </div>
        <?php if(in_array('asset3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade" id="pills-edit" role="tabpanel" aria-labelledby="pills-edit-tab">
          <?php $attributes = array('name' => 'update_asset', 'id' => 'update_asset', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
          <?php $hidden = array('_method' => 'EDIT', 'token' => $segment_id);?>
          <?= form_open_multipart('erp/assets/update_asset', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="asset_name" class="control-label">
                    <?= lang('Asset.xin_asset_name');?>
                    <span class="text-danger">*</span> </label>
                  <input class="form-control" placeholder="<?= lang('Asset.xin_asset_name');?>" name="asset_name" type="text" value="<?= $result['name'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="first_name">
                    <?= lang('Dashboard.xin_category');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="category_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_category');?>">
                    <option value=""></option>
                    <?php foreach($category_info as $as_category) {?>
                    <option value="<?= $as_category['constants_id']?>" <?php if($as_category['constants_id']==$result['assets_category_id']):?> selected="selected"<?php endif;?>>
                    <?= $as_category['category_name']?>
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
                    <option value="<?= $assets_brand['constants_id']?>" <?php if($assets_brand['constants_id']==$result['brand_id']):?> selected="selected"<?php endif;?>>
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
                    <option value="<?= $staff['user_id']?>" <?php if($staff['user_id']==$result['employee_id']):?> selected="selected"<?php endif;?>>
                    <?= $staff['first_name'].' '.$staff['last_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } ?>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="manufacturer">
                    <?= lang('Asset.xin_manufacturer');?>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Asset.xin_manufacturer');?>" name="manufacturer" type="text" value="<?= $result['manufacturer'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="xin_serial_number" class="control-label">
                    <?= lang('Asset.xin_serial_number');?>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Asset.xin_serial_number');?>" name="serial_number" type="text" value="<?= $result['serial_number'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="company_asset_code">
                    <?= lang('Asset.xin_company_asset_code');?>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Asset.xin_company_asset_code');?>" name="company_asset_code" type="text" value="<?= $result['company_asset_code'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="is_working" class="control-label">
                    <?= lang('Asset.xin_is_working');?>
                  </label>
                  <select class="form-control" name="is_working" data-plugin="select_hrm" data-placeholder="<?= lang('Asset.xin_is_working');?>">
                    <option value="1" <?php if($result['is_working']==1):?> selected="selected"<?php endif;?>>
                    <?= lang('Main.xin_yes');?>
                    </option>
                    <option value="0" <?php if($result['is_working']==0):?> selected="selected"<?php endif;?>>
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
                    <input class="form-control date" placeholder="<?= lang('Asset.xin_purchase_date');?>" name="purchase_date" type="text" value="<?= $result['purchase_date'];?>">
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
                    <input class="form-control" placeholder="<?= lang('Main.xin_invoice_number');?>" name="invoice_number" type="text" value="<?= $result['invoice_number'];?>">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="warranty_end_date" class="control-label">
                    <?= lang('Asset.xin_warranty_end_date');?>
                  </label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?= lang('Asset.xin_warranty_end_date');?>" name="warranty_end_date" type="text" value="<?= $result['warranty_end_date'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>              
              <div class="col-md-12">
                <div class="form-group">
                  <label for="award_information">
                    <?= lang('Asset.xin_asset_note');?>
                  </label>
                  <textarea class="form-control editor" placeholder="<?= lang('Asset.xin_asset_note');?>" name="asset_note" cols="30" rows="2" id="asset_note"><?= $result['asset_note'];?>
            </textarea>
                </div>
              </div>
            </div>
            <?php if($count_module_attributes > 0):?>
            <div class="row">
              <?php foreach($module_attributes as $mattribute):?>
              <?php $attribute_info = $Moduleattributesval->where('user_id',$assets_id)->where('module_attributes_id', $mattribute['custom_field_id'])->first();?>
              <?php
				if($attribute_info){
					$attr_val = $attribute_info['attribute_value'];
				} else {
					$attr_val = '';
				}
				?>
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
                  <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?>
                    <?= $validate_opt;?>
                  </label>
                  <input class="form-control date" 
                      placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                </div>
              </div>
              <?php } else if($mattribute['attribute_type'] == 'select'){?>
              <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id', $mattribute['custom_field_id'])->first();?>
              <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
              <div class="<?= $mattribute['col_width'];?>">
                <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id',$mattribute['custom_field_id'])->findAll();?>
                <div class="form-group">
                  <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?>
                    <?= $validate_opt;?>
                  </label>
                  <select class="form-control" name="<?php echo $mattribute['attribute'];?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute['attribute_label'];?>">
                    <?php foreach($iselc_val as $selc_val) {?>
                    <option value="<?php echo $selc_val['attributes_select_value_id']?>" <?php if($attr_val==$selc_val['attributes_select_value_id']):?> selected="selected"<?php endif;?>><?php echo $selc_val['select_label']?></option>
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
                  <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?>
                    <?= $validate_opt;?>
                  </label>
                  <textarea class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text"><?= $attr_val;?>
</textarea>
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
                  <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?>
                    <?= $validate_opt;?>
                  </label>
                  <input class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                </div>
              </div>
              <?php }	?>
              <?php endforeach;?>
            </div>
            <?php endif;?>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_update');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
        <div class="tab-pane fade" id="pills-image" role="tabpanel" aria-labelledby="pills-image-tab">
          <div class="card-body pb-2">
            <div class="box-body">
              <?php $attributes = array('name' => 'edit_image', 'id' => 'edit_image', 'autocomplete' => 'off');?>
              <?php $hidden = array('token' => $segment_id);?>
              <?= form_open('erp/assets/update_asset_image', $attributes, $hidden);?>
              <div class="form-body">
              <div class="row">
                  <div class="col-md-12">
                  	<img src="<?= base_url('public/uploads/asset_image').'/'.$result['asset_image'];?>" class="d-block ui-w-50 rounded-circle" width="50" height="50" />
                  </div>
               </div>   
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="logo">
                        <?= lang('Asset.xin_asset_image');?>
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
          <div class="card-footer text-right">
            <button  type="submit" class="btn btn-primary">
            <?= lang('Employees.xin_update_pic');?>
            </button>
          </div>
          <?= form_close(); ?>
      </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

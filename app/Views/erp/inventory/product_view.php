<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\WarehouseModel;
use App\Models\ConstantsModel;
use App\Models\ProductsModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$WarehouseModel = new WarehouseModel();	
$SystemModel = new SystemModel();
$ConstantsModel = new ConstantsModel();
$ProductsModel = new ProductsModel();
$Moduleattributes = new Moduleattributes();
$Moduleattributesval = new Moduleattributesval();
$Moduleattributesvalsel = new Moduleattributesvalsel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$icategory_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','product_category')->findAll();
	$result = $ProductsModel->where('company_id',$user_info['company_id'])->orderBy('product_id', 'ASC')->findAll();
	$warehouse_info = $WarehouseModel->where('company_id',$user_info['company_id'])->orderBy('warehouse_id', 'ASC')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',7)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$user_info['company_id'])->where('module_id',7)->orderBy('custom_field_id', 'ASC')->findAll();
} else {
	$icategory_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','product_category')->findAll();
	$result = $ProductsModel->where('company_id',$usession['sup_user_id'])->orderBy('product_id', 'ASC')->findAll();
	$warehouse_info = $WarehouseModel->where('company_id',$usession['sup_user_id'])->orderBy('warehouse_id', 'ASC')->findAll();
	$count_module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',7)->orderBy('custom_field_id', 'ASC')->countAllResults();
	$module_attributes = $Moduleattributes->where('company_id',$usession['sup_user_id'])->where('module_id',7)->orderBy('custom_field_id', 'ASC')->findAll();
}
$xin_system = erp_company_settings();

$segment_id = $request->uri->getSegment(3);
$product_id = udecode($segment_id);
$result = $ProductsModel->where('product_id', $product_id)->first();	
?>

<div class="row"> 
  <!-- [ trackgoal-detail-left ] start -->
  <div class="col-xl-4 col-lg-12 task-detail-right">
    <div class="card">
      <div class="card-header">
        <h5>
          <?= $result['product_name'];?>
        </h5>
      </div>
      <div class="card-body task-details">
        <table class="table">
          <tbody>
            <tr>
              <td><i class="fas fa-adjust m-r-5"></i> <?php echo lang('Dashboard.xin_category');?>:</td>
              <td class="text-right"><span class="float-right">
                <?php $category_info = $ConstantsModel->where('constants_id', $result['category_id'])->where('type','product_category')->first();?>
				<?php
                if($category_info){
					echo $category_name = $category_info['category_name'];
				} else {
					echo $category_name = '--';
				}
				?>
                </span></td>
            </tr> 
            <tr>
              <td><i class="fas fa-warehouse m-r-5"></i> <?php echo lang('Inventory.xin_warehouse');?>:</td>
              <td class="text-right"><span class="float-right">
                <?php $iwarehouse = $WarehouseModel->where('warehouse_id', $result['warehouse_id'])->first();?>
				<?php
                if($iwarehouse){
					echo $warehouse_name = $iwarehouse['warehouse_name'];
				} else {
					echo $warehouse_name = '--';
				}
				?>
                </span></td>
            </tr>          
          </tbody>
        </table>
        <?php if(in_array('tracking5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <?php $attributes = array('name' => 'update_rating', 'id' => 'update_rating', 'autocomplete' => 'off');?>
        <?php $hidden = array('token' => $segment_id);?>
        <?= form_open('erp/products/update_rating', $attributes, $hidden);?>
        <div class="row text-center">
          <div class="col-md-12">
            <div class="form-group">
              <label for="goal_rating">
                <?= lang('Inventory.xin_product_review');?>
              </label>
              <select class="star-rating" name="product_rating" autocomplete="off">
                <option value=""></option>
                <option value="1" <?php if($result['product_rating'] == 1):?> selected="selected"<?php endif;?>>1</option>
                <option value="2" <?php if($result['product_rating'] == 2):?> selected="selected"<?php endif;?>>2</option>
                <option value="3" <?php if($result['product_rating'] == 3):?> selected="selected"<?php endif;?>>3</option>
                <option value="4" <?php if($result['product_rating'] == 4):?> selected="selected"<?php endif;?>>4</option>
                <option value="5" <?php if($result['product_rating'] == 5):?> selected="selected"<?php endif;?>>5</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-footer text-center">
          <button type="submit" class="btn btn-success"><?php echo lang('Performance.xin_update_rating');?></button>
        </div>
        <?= form_close(); ?>
        <?php } ?>
      </div>
    </div>
  </div>
  <!-- [ trackgoal-detail-left ] end --> 
  <!-- [ trackgoal-detail-right ] start -->
  <div class="col-lg-8">
   <div class="bg-light card mb-2">
      <div class="card-body">
        <ul class="nav nav-pills mb-0">
          <li class="nav-item m-r-5"> <a href="#pills-edit" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Main.xin_edit');?>
            </button>
            </a> </li>
          <li class="nav-item m-r-5"> <a href="#pills-image" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Inventory.xin_product_image');?>
            </button>
            </a> </li>
        </ul>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h5><i class="feather icon-package mr-1"></i><?php echo lang('Inventory.xin_product_details');?>
        </h5>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <?php if(in_array('tracking3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade show active" id="pills-edit" role="tabpanel" aria-labelledby="pills-edit-tab">
          <?php $attributes = array('name' => 'update_product', 'id' => 'update_product', 'autocomplete' => 'off', 'class' => 'form-hrm');?>
		  <?php $hidden = array('token' => $segment_id);?>
          <?php echo form_open('erp/products/update_product', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="asset_name" class="control-label">
                      <?= lang('Inventory.xin_product_name');?>
                      <span class="text-danger">*</span> </label>
                    <input class="form-control" placeholder="<?= lang('Inventory.xin_product_name');?>" name="name" type="text" value="<?= $result['product_name'];?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="first_name">
                      <?= lang('Dashboard.xin_category');?>
                      <span class="text-danger">*</span> </label>
                    <select class="form-control" name="category" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_category');?>">
                      <option value=""></option>
                      <?php foreach($icategory_info as $pd_category) {?>
                      <option value="<?= $pd_category['constants_id']?>" <?php if($result['category_id']==$pd_category['constants_id']):?> selected="selected"<?php endif;?>>
                      <?= $pd_category['category_name']?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="first_name">
                      <?= lang('Inventory.xin_warehouse');?>
                      <span class="text-danger">*</span> </label>
                    <select class="form-control" name="warehouse" data-plugin="select_hrm" data-placeholder="<?= lang('Inventory.xin_warehouse');?>">
                      <option value=""></option>
                      <?php foreach($warehouse_info as $_warehouse) {?>
                      <option value="<?= $_warehouse['warehouse_id']?>" <?php if($result['warehouse_id']==$_warehouse['warehouse_id']):?> selected="selected"<?php endif;?>>
                      <?= $_warehouse['warehouse_name']?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="barcode_type">
                      <?= lang('Inventory.xin_barcode_type');?>
                    </label>
                    <select class="form-control" name="barcode_type" data-plugin="select_hrm" data-placeholder="<?= lang('Inventory.xin_barcode_type');?>">
                      <option value=""></option>
                      <option value="CODE39" <?php if($result['barcode_type'] == 'CODE39'):?> selected="selected"<?php endif;?>>CODE39</option>
                      <option value="CODE93" <?php if($result['barcode_type'] == 'CODE93'):?> selected="selected"<?php endif;?>>CODE93</option>
                      <option value="CODE128" <?php if($result['barcode_type'] == 'CODE128'):?> selected="selected"<?php endif;?>>CODE128</option>
                      <option value="ISBN" <?php if($result['barcode_type'] == 'ISBN'):?> selected="selected"<?php endif;?>>ISBN</option>
                      <option value="CODABAR" <?php if($result['barcode_type'] == 'CODABAR'):?> selected="selected"<?php endif;?>>CODABAR</option>
                      <option value="POSTNET" <?php if($result['barcode_type'] == 'POSTNET'):?> selected="selected"<?php endif;?>>POSTNET</option>
                      <option value="EAN-8" <?php if($result['barcode_type'] == 'EAN-8'):?> selected="selected"<?php endif;?>>EAN-8</option>
                      <option value="EAN-13" <?php if($result['barcode_type'] == 'EAN-13'):?> selected="selected"<?php endif;?>>EAN-13</option>
                      <option value="UPC-A" <?php if($result['barcode_type'] == 'UPC-A'):?> selected="selected"<?php endif;?>>UPC-A</option>
                      <option value="UPC-E" <?php if($result['barcode_type'] == 'UPC-C'):?> selected="selected"<?php endif;?>>UPC-E</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="barcode">
                      <?= lang('Inventory.xin_barcode');?> <span class="text-danger">*</span>
                    </label>
                    <input class="form-control" placeholder="<?= lang('Inventory.xin_barcode');?>" name="barcode" type="text" value="<?= $result['barcode'];?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="xin_serial_number" class="control-label">
                      <?= lang('Inventory.xin_product_sku');?> <span class="text-danger">*</span>
                    </label>
                    <input class="form-control" placeholder="<?= lang('Inventory.xin_product_sku');?>" name="sku" type="text" value="<?= $result['product_sku'];?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="serial_number">
                      <?= lang('Inventory.xin_product_serial_number');?>
                    </label>
                    <input class="form-control" placeholder="<?= lang('Inventory.xin_product_serial_number');?>" name="serial_number" type="text" value="<?= $result['product_serial_number'];?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_qty">
                      <?= lang('Inventory.xin_product_qty_initial');?>
                    </label>
                    <input class="form-control" readonly="readonly" type="number" value="<?= $result['product_qty'];?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="reorder_stock">
                      <?= lang('Inventory.xin_reorder_stock_amount');?> <span class="text-danger">*</span>
                    </label>
                    <input class="form-control" placeholder="<?= lang('Inventory.xin_reorder_stock_amount');?>" name="reorder_stock" type="number" value="<?= $result['reorder_stock'];?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="expiration_date" class="control-label">
                      <?= lang('Inventory.xin_expiration_date');?> <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <input class="form-control date" placeholder="<?= lang('Inventory.xin_expiration_date');?>" name="expiration_date" type="text" value="<?= $result['expiration_date'];?>">
                      <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="purchase_price">
                      <?= lang('Inventory.xin_product_purchase_price');?> <span class="text-danger">*</span>
                    </label>
                    <input class="form-control" placeholder="<?= lang('Inventory.xin_product_purchase_price');?>" name="purchase_price" type="text" value="<?= $result['purchase_price'];?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="selling_price">
                      <?= lang('Inventory.xin_product_selling_price');?> <span class="text-danger">*</span>
                    </label>
                    <input class="form-control" placeholder="<?= lang('Inventory.xin_product_selling_price');?>" name="selling_price" type="text" value="<?= $result['retail_price'];?>">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="product_details">
                      <?= lang('Inventory.xin_product_details');?>
                    </label>
                    <textarea class="form-control editor" placeholder="<?= lang('Inventory.xin_product_details');?>" name="product_description`" cols="30" rows="2"><?= $result['product_description'];?></textarea>
                  </div>
                </div>
              </div>
              <?php if($count_module_attributes > 0):?>
              <div class="row">
			  <?php foreach($module_attributes as $mattribute):?>
              <?php $attribute_info = $Moduleattributesval->where('user_id',$product_id)->where('module_attributes_id', $mattribute['custom_field_id'])->first();?>
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
                  <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
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
                  <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
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
                  <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                  <textarea class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text"><?= $attr_val;?></textarea>
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
            <?= lang('Inventory.xin_update_product');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
        <?php } ?>
        <div class="tab-pane fade" id="pills-image" role="tabpanel" aria-labelledby="pills-image-tab">
          <div class="card-body pb-2">
            <div class="box-body">
              <?php $attributes = array('name' => 'edit_image', 'id' => 'edit_image', 'autocomplete' => 'off');?>
              <?php $hidden = array('token' => $segment_id);?>
              <?= form_open('erp/products/update_product_image', $attributes, $hidden);?>
              <div class="form-body">
              <div class="row">
                  <div class="col-md-12">
                  	<img src="<?= base_url('public/uploads/products').'/'.$result['product_image'];?>" class="d-block ui-w-50 rounded-circle" width="50" height="50" />
                  </div>
               </div>   
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="logo">
                        <?= lang('Inventory.xin_product_image');?>
                        <span class="text-danger">*</span> </label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="product_image">
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
      </div>
    </div>
  </div>
</div>
</div>

<!-- [ trackgoal-detail-right ] end -->
</div>

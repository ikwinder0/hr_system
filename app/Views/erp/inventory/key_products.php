<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ProductsModel;
use App\Models\WarehouseModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();		
$WarehouseModel = new WarehouseModel();
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','product_category')->findAll();
	$warehouse_info = $WarehouseModel->where('company_id', $user_info['company_id'])->orderBy('warehouse_id', 'ASC')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','product_category')->findAll();
	$warehouse_info = $WarehouseModel->where('company_id', $usession['sup_user_id'])->orderBy('warehouse_id', 'ASC')->findAll();
}
/* Products view
*/
$get_animate = '';
?>
<?php if(in_array('product1',staff_role_resource()) || in_array('out_of_stock',staff_role_resource()) || in_array('expired_product',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('product1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/product-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-command"></span>
      <?= lang('Inventory.xin_products');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Inventory.xin_products');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('out_of_stock',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/out-of-stock-products');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-clipboard-list"></span>
      <?= lang('Inventory.xin_out_of_stock');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Inventory.xin_out_of_stock');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('expired_product',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/expired-products');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-list-ul"></span>
      <?= lang('Inventory.xin_expired_products');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Inventory.xin_expired_products');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-12">
    <?php if(in_array('product2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <div id="add_form" class="collapse add-form <?= $get_animate;?>" data-parent="#accordion" style="">
      <?php $attributes = array('name' => 'add_product', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
      <?php $hidden = array('user_id' => 0);?>
      <?= form_open_multipart('erp/products/add_product', $attributes, $hidden);?>
      <div class="row">
        <div class="col-md-8">
          <div class="card mb-2">
            <div id="accordion">
              <div class="card-header">
                <h5>
                  <?= lang('Main.xin_add_new');?>
                  <?= lang('Inventory.xin_product');?>
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
                          <?= lang('Inventory.xin_product_name');?>
                          <span class="text-danger">*</span> </label>
                        <input class="form-control" placeholder="<?= lang('Inventory.xin_product_name');?>" name="name" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="first_name">
                          <?= lang('Dashboard.xin_category');?>
                          <span class="text-danger">*</span> </label>
                        <select class="form-control" name="category" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_category');?>">
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
                          <?= lang('Inventory.xin_warehouse');?>
                          <span class="text-danger">*</span> </label>
                        <select class="form-control" name="warehouse" data-plugin="select_hrm" data-placeholder="<?= lang('Inventory.xin_warehouse');?>">
                          <option value=""></option>
                          <?php foreach($warehouse_info as $_warehouse) {?>
                          <option value="<?= $_warehouse['warehouse_id']?>">
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
                          <option value="CODE39">CODE39</option>
                          <option value="CODE93">CODE93</option>
                          <option value="CODE128">CODE128</option>
                          <option value="ISBN">ISBN</option>
                          <option value="CODABAR">CODABAR</option>
                          <option value="POSTNET">POSTNET</option>
                          <option value="EAN-8">EAN-8</option>
                          <option value="EAN-13">EAN-13</option>
                          <option value="UPC-A">UPC-A</option>
                          <option value="UPC-E">UPC-E</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="barcode">
                          <?= lang('Inventory.xin_barcode');?>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Inventory.xin_barcode');?>" name="barcode" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="xin_serial_number" class="control-label">
                          <?= lang('Inventory.xin_product_sku');?> <span class="text-danger">*</span>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Inventory.xin_product_sku');?>" name="sku" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="serial_number">
                          <?= lang('Inventory.xin_product_serial_number');?>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Inventory.xin_product_serial_number');?>" name="serial_number" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="product_qty">
                          <?= lang('Inventory.xin_product_qty_initial');?> <span class="text-danger">*</span>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Inventory.xin_product_qty_initial');?>" name="qty" type="number" value="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="reorder_stock">
                          <?= lang('Inventory.xin_reorder_stock_amount');?>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Inventory.xin_reorder_stock_amount');?>" name="reorder_stock" type="number" value="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="expiration_date" class="control-label">
                          <?= lang('Inventory.xin_expiration_date');?> <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                          <input class="form-control date" placeholder="<?= lang('Inventory.xin_expiration_date');?>" name="expiration_date" type="text" value="">
                          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="purchase_price">
                          <?= lang('Inventory.xin_product_purchase_price');?> <span class="text-danger">*</span>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Inventory.xin_product_purchase_price');?>" name="purchase_price" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="selling_price">
                          <?= lang('Inventory.xin_product_selling_price');?> <span class="text-danger">*</span>
                        </label>
                        <input class="form-control" placeholder="<?= lang('Inventory.xin_product_selling_price');?>" name="selling_price" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="product_details">
                          <?= lang('Inventory.xin_product_details');?>
                        </label>
                        <textarea class="form-control editor" placeholder="<?= lang('Inventory.xin_product_details');?>" name="product_description" cols="30" rows="2"></textarea>
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
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h5>
                <?= lang('Inventory.xin_product_image');?>
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
      </div>
      <?= form_close(); ?>
    </div>
    <?php } ?>
    <div class="card user-profile-list">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_list_all');?>
          <?= lang('Inventory.xin_products');?>
        </h5>
        <?php if(in_array('product2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
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
                <th width="220"><?= lang('Inventory.xin_product_name');?></th>
                <th><?= lang('Inventory.xin_warehouse');?></th>
                <th><?= lang('Dashboard.xin_category');?></th>  
                <th><?= lang('Inventory.xin_qty');?></th>
                <th><?= lang('Inventory.xin_product_purchase_price');?></th>
                <th><?= lang('Inventory.xin_product_selling_price');?></th>
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

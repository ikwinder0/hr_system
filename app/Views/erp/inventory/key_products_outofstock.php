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
    <li class="nav-item clickable"> <a href="<?= site_url('erp/product-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-command"></span>
      <?= lang('Inventory.xin_products');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Inventory.xin_products');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('out_of_stock',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/out-of-stock-products');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-clipboard-list"></span>
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
    <div class="card user-profile-list">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_list_all');?>
          <?= lang('Inventory.xin_out_of_stock_products');?>
        </h5>
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

<?php
use App\Models\UsersModel;
use App\Models\ProductsModel;

$UsersModel = new UsersModel();
$ProductsModel = new ProductsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$products = $ProductsModel->where('company_id',$user_info['company_id'])->orderBy('product_id', 'ASC')->findAll();
} else {
	$products = $ProductsModel->where('company_id',$usession['sup_user_id'])->orderBy('product_id', 'ASC')->findAll();
}
?>
<div class="row item-row">
  <div class="form-group mb-1 col-sm-12 col-md-5">
    <label for="item_name">
      <?= lang('Invoices.xin_title_item');?>
    </label>
    <br>
    <select class="form-control item_name" name="item_name[]" data-plugin="select_hrms" data-placeholder="<?= lang('Inventory.xin_choose_item');?>">
    <option value=""></option>
    <?php foreach($products as $product) {?>
    <option value="<?php echo $product['product_id']?>" item-price="<?php echo $product['purchase_price']?>"><?php echo $product['product_name']?></option>
    <?php } ?>
  </select>
  </div>
  <div class="form-group mb-1 col-sm-12 col-md-2">
    <label for="qty_hrs" class="cursor-pointer">
      <?= lang('Inventory.xin_product_qty');?>
    </label>
    <br>
    <input type="text" class="form-control qty_hrs" name="qty_hrs[]" id="qty_hrs" value="1">
  </div>
  <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
    <label for="unit_price">
      <?= lang('Invoices.xin_title_unit_price');?>
    </label>
    <br>
    <input class="form-control unit_price" type="text" name="unit_price[]" value="0" id="unit_price" />
  </div>
  <div class="form-group mb-1 col-sm-12 col-md-2">
    <label for="profession">
      <?= lang('Invoices.xin_subtotal');?>
    </label>
    <input type="text" class="form-control sub-total-item" readonly="readonly" name="sub_total_item[]" value="0" />
    <!-- <br>-->
    <p style="display:none" class="form-control-static"><span class="amount-html">0</span></p>
  </div>
  <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">
    <label for="profession">&nbsp;</label>
    <br>
    <button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){		
    $('[data-plugin="select_hrms"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrms"]').select2({ width:'100%' }); 
});
</script>
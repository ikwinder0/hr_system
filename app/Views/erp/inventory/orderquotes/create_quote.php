<?php
use App\Models\SystemModel;
use App\Models\UsersModel;

use App\Models\LanguageModel;
use App\Models\SuppliersModel;
use App\Models\ProductsModel;
use App\Models\ConstantsModel;

$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$LanguageModel = new LanguageModel();
$SuppliersModel = new SuppliersModel();
$ConstantsModel = new ConstantsModel();
$ProductsModel = new ProductsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$xin_system = erp_company_settings();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$customers = $UsersModel->where('company_id',$user_info['company_id'])->where('user_type','customer')->orderBy('user_id', 'ASC')->findAll();
	$products = $ProductsModel->where('company_id',$user_info['company_id'])->orderBy('product_id', 'ASC')->findAll();
	$tax_types = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','tax_type')->findAll();
} else {
	$customers = $UsersModel->where('company_id',$usession['sup_user_id'])->where('user_type','customer')->orderBy('user_id', 'ASC')->findAll();
	$products = $ProductsModel->where('company_id',$usession['sup_user_id'])->orderBy('product_id', 'ASC')->findAll();
	$tax_types = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','tax_type')->findAll();
}
$xin_system = erp_company_settings();
?>
<?php
// Create Invoice Page
?>
<?php $get_animate = '';?>
<?php if(in_array('quote_order1',staff_role_resource()) || in_array('quote_order2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('quote_order1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/order-quotes');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Inventory.xin_quote_orders');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Inventory.xin_quote_orders');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('quote_order2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/create-quote');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calendar-plus"></span>
      <?= lang('Inventory.xin_create_quote');?>
      <div class="text-muted small">
        <?= lang('Inventory.xin_create_quote');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Inventory.xin_create_quote');?>
        </strong></span> </div>
      <div class="card-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'new_quote', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
            <?php $hidden = array('user_id' => 0);?>
            <?php echo form_open('erp/orderquotes/create_new_quote', $attributes, $hidden);?>
            <?php $inv_info = generate_random_employeeid();?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="order_number">
                        <?= lang('Inventory.xin_quote_number');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-file-invoice"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Inventory.xin_quote_number');?>" name="quote_number" type="text" value="<?= $inv_info;?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="project">
                        <?= lang('Inventory.xin_customer');?> <span class="text-danger">*</span>
                      </label>
                      <select class="form-control" name="customer" data-plugin="select_hrm" data-placeholder="<?= lang('Inventory.xin_choose_customer');?>">
                        <option value=""><?= lang('Inventory.xin_choose_customer');?></option>
						<?php foreach($customers as $customer) {?>
                        <option value="<?php echo $customer['user_id']?>"><?php echo $customer['first_name'].' '.$customer['last_name'];?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date">
                        <?= lang('Inventory.xin_quote_date');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input class="form-control date" placeholder="<?= lang('Inventory.xin_quote_date');?>" name="quote_date" type="text" value="">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_due_date">
                        <?= lang('Inventory.xin_quote_due_date');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input class="form-control date" placeholder="<?= lang('Inventory.xin_quote_due_date');?>" name="quote_due_date" type="text" value="">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="ci-item-values">
                        <div data-repeater-list="items">
                          <div data-repeater-item="">
                            <div class="row item-row">
                              <div class="form-group mb-1 col-sm-12 col-md-5">
                                <label for="item_name">
                                  <?= lang('Invoices.xin_title_item');?>
                                </label>
                                <br>
                                <select class="form-control item_name" name="item_name[]" data-plugin="select_hrm" data-placeholder="<?= lang('Inventory.xin_choose_item');?>">
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
                                <button type="button" disabled="disabled" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-repeater-delete=""> <span class="fa fa-trash"></span></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="item-list"></div>
                      <div class="form-group overflow-hidden1">
                        <div class="col-xs-12">
                          <button type="button" data-repeater-create="" class="btn btn-sm btn-primary" id="add-invoice-item">
                          <?= lang('Invoices.xin_title_add_item');?>
                          </button>
                        </div>
                      </div>
                      <?php $sc_show = $xin_system['default_currency_symbol']; ?>
                      <input type="hidden" class="items-sub-total" name="items_sub_total" value="0" />
                      <div class="row">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">&nbsp; </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <td><?= lang('Invoices.xin_subtotal');?></td>
                                  <td class="text-xs-right"><?php echo $sc_show;?><span class="sub_total">0</span></td>
                                </tr>
                                <tr>
                                  <td colspan="2" style="border-bottom:1px solid #dddddd; padding:0px !important; text-align:left"><table class="table table-bordered">
                                      <thead>
                                        <tr>
                                          <th width="30%" style="border-bottom:1px solid #dddddd; text-align:left"><?= lang('Invoices.xin_discount_type');?></th>
                                          <th style="border-bottom:1px solid #dddddd; text-align:center"><?= lang('Invoices.xin_discount');?></th>
                                          <th style="border-bottom:1px solid #dddddd; text-align:left"><?= lang('Invoices.xin_discount_amount');?></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td><div class="form-group">
                                              <select name="discount_type" class="form-control discount_type">
                                                <option value="1">
                                                <?= lang('Invoices.xin_flat');?>
                                                </option>
                                                <option value="2">
                                                <?= lang('Invoices.xin_percent');?>
                                                </option>
                                              </select>
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input style="text-align:right" type="text" name="discount_figure" class="form-control discount_figure" value="0" data-valid-num="required">
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" name="discount_amount" value="0" class="discount_amount form-control">
                                            </div></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                </tr>
                                <tr>
                                  <td colspan="2" style="border-bottom:1px solid #dddddd; padding:0px !important; text-align:left"><table class="table table-bordered">
                                      <thead>
                                        <tr>
                                          <th width="50%" style="border-bottom:1px solid #dddddd; text-align:left"><?= lang('Dashboard.xin_invoice_tax_type');?></th>
                                          <th style="border-bottom:1px solid #dddddd; text-align:left"><?= lang('Invoices.xin_tax_rate');?></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td><div class="form-group">
                                              <select name="tax_type" class="form-control tax_type">
                                                <?php foreach($tax_types as $_tax):?>
                                                <?php
											   if($_tax['field_two']=='percentage') {
													$_tax_type = $_tax['field_one'].'%';
												} else {
													$_tax_type = number_to_currency($_tax['field_one'], $xin_system['default_currency'],null,2);
												}
												?>
                                                <option tax-type="<?php echo $_tax['field_two'];?>" tax-rate="<?php echo $_tax['field_one'];?>" value="<?php echo $_tax['constants_id'];?>"> <?php echo $_tax['category_name'];?> (<?php echo $_tax_type;?>)</option>
                                                <?php endforeach;?>
                                              </select>
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" name="tax_rate" value="0" class="tax_rate form-control">
                                            </div></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                </tr>
                              <input type="hidden" class="fgrand_total" name="fgrand_total" value="0" />
                              <tr>
                                <td><?= lang('Invoices.xin_grand_total');?></td>
                                <td class="text-xs-right"><?php echo $sc_show;?> <span class="grand_total">0</span></td>
                              </tr>
                                </tbody>
                              
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-xs-12 mb-2 file-repeaters"> </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <label for="invoice_note">
                            <?= lang('Inventory.xin_quote_note');?>
                          </label>
                          <textarea name="quote_note" class="form-control"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="invoice-footer">
                  <div class="row">
                    <div class="col-md-7 col-sm-12">
                      <h6>
                        <?= lang('Invoices.xin_terms_condition');?>
                      </h6>
                      <p>
                        <?= $xin_system['invoice_terms_condition'];?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="submit" name="invoice_submit" class="btn btn-primary pull-right my-1" style="margin-right: 5px;">
        <?= lang('Inventory.xin_create_quote_order');?>
        </button>
      </div>
      <?php echo form_close(); ?> </div>
  </div>
</div>

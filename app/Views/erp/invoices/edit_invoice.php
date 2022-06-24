<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\ProjectsModel;
use App\Models\ConstantsModel;
use App\Models\InvoicesModel;
use App\Models\InvoiceitemsModel;

$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$ProjectsModel = new ProjectsModel();
$InvoicesModel = new InvoicesModel();
$LanguageModel = new LanguageModel();
$ConstantsModel = new ConstantsModel();
$InvoiceitemsModel = new InvoiceitemsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$request = \Config\Services::request();
///
$segment_id = $request->uri->getSegment(3);
$invoice_id = udecode($segment_id);

$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$projects = $ProjectsModel->where('company_id',$user_info['company_id'])->orderBy('project_id', 'ASC')->findAll();
	$tax_types = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','tax_type')->findAll();
	$get_invoice = $InvoicesModel->where('company_id',$user_info['company_id'])->where('invoice_id', $invoice_id)->first();
	$invoice_items = $InvoiceitemsModel->where('invoice_id', $invoice_id)->findAll();
} else {
	$projects = $ProjectsModel->where('company_id',$usession['sup_user_id'])->orderBy('project_id', 'ASC')->findAll();
	$tax_types = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','tax_type')->findAll();
	$get_invoice = $InvoicesModel->where('company_id',$usession['sup_user_id'])->where('invoice_id', $invoice_id)->first();
	$invoice_items = $InvoiceitemsModel->where('invoice_id', $invoice_id)->findAll();
}
$xin_system = erp_company_settings();
?>
<?php
// Edit Invoice Page
?>
<?php $get_animate = '';?>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Invoices.xin_edit_invoice');?>
        </strong></span> </div>
      <div class="card-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'update_invoice', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
            <?php $hidden = array('token' => $segment_id);?>
            <?php echo form_open('erp/invoices/update_invoice', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date">
                        <?= lang('Invoices.xin_invoice_number');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-file-invoice"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Invoices.xin_invoice_number');?>" name="invoice_number" type="text" value="<?= $get_invoice['invoice_number'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="project">
                        <?= lang('Projects.xin_project');?> <span class="text-danger">*</span>
                      </label>
                      <select class="form-control" name="project" data-plugin="select_hrm" data-placeholder="<?= lang('Projects.xin_project');?>">
                        <?php foreach($projects as $project) {?>
                        <option value="<?php echo $project['project_id']?>" <?php if($project['project_id']==$get_invoice['project_id']):?> selected="selected"<?php endif;?>><?php echo $project['title']?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_date">
                        <?= lang('Invoices.xin_invoice_date');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input class="form-control date" placeholder="<?= lang('Invoices.xin_invoice_date');?>" name="invoice_date" type="text" value="<?= $get_invoice['invoice_date'];?>">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="invoice_due_date">
                        <?= lang('Invoices.xin_invoice_due_date');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input class="form-control date" placeholder="<?= lang('Invoices.xin_invoice_due_date');?>" name="invoice_due_date" type="text" value="<?= $get_invoice['invoice_due_date'];?>">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <?php $iv = 1; foreach($invoice_items as $item){?>
                      <div class="ci-item-values">
                        <div data-repeater-list="items">
                          <div data-repeater-item="">
                            <div class="row item-row">
                              <div class="form-group mb-1 col-sm-12 col-md-5">
                                <input type="hidden" name="item[<?php echo $item['invoice_item_id'];?>]" value="<?php echo $item['invoice_item_id'];?>" />
                                <label for="item_name">
                                  <?= lang('Invoices.xin_title_item');?>
                                </label>
                                <br>
                                <input type="text" class="form-control item_name" name="eitem_name[<?php echo $item['invoice_item_id'];?>]" id="item_name" placeholder="Item Name" value="<?= $item['item_name'];?>">
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="qty_hrs" class="cursor-pointer">
                                  <?= lang('Invoices.xin_title_qty_hrs');?>
                                </label>
                                <br>
                                <input type="text" class="form-control qty_hrs" name="eqty_hrs[<?php echo $item['invoice_item_id'];?>]" id="qty_hrs" value="<?= $item['item_qty'];?>">
                              </div>
                              <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                <label for="unit_price">
                                  <?= lang('Invoices.xin_title_unit_price');?>
                                </label>
                                <br>
                                <input class="form-control unit_price" type="text" name="eunit_price[<?php echo $item['invoice_item_id'];?>]" value="<?= $item['item_unit_price'];?>" id="unit_price" />
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="profession">
                                  <?= lang('Invoices.xin_subtotal');?>
                                </label>
                                <input type="text" class="form-control sub-total-item" readonly="readonly" name="esub_total_item[<?php echo $item['invoice_item_id'];?>]" value="<?= $item['item_sub_total'];?>" />
                                <!-- <br>-->
                                <p style="display:none" class="form-control-static"><span class="amount-html">0</span></p>
                              </div>
                              <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">
                                <label for="profession">&nbsp;</label>
                                <br>
                                <?php if($iv == 1):?>
                                <button type="button" disabled="disabled" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-repeater-delete=""> <span class="fa fa-trash"></span></button>
                                <?php else:?>
                                <button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light remove-invoice-item-ol" data-repeater-delete="" data-record-id="<?= uencode($item['invoice_item_id']);?>"> <span class="fa fa-trash"></span></button>
                                <?php endif;?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php $iv++; } ?>
                      <div id="item-list"></div>
                      <div class="form-group overflow-hidden1">
                        <div class="col-xs-12">
                          <button type="button" data-repeater-create="" class="btn btn-sm btn-primary" id="add-invoice-item">
                          <?= lang('Invoices.xin_title_add_item');?>
                          </button>
                        </div>
                      </div>
                      <?php $sc_show = $xin_system['default_currency_symbol']; ?>
                      <input type="hidden" class="items-sub-total" name="items_sub_total" value="<?= $get_invoice['sub_total_amount'];?>" />
                      <div class="row">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">&nbsp; </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <td><?= lang('Invoices.xin_subtotal');?></td>
                                  <td class="text-xs-right"><?php echo $sc_show;?><span class="sub_total">
                                    <?= $get_invoice['sub_total_amount'];?>
                                    </span></td>
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
                                                <option value="1" <?php if($get_invoice['discount_type'] == 1):?> selected="selected"<?php endif;?>>
                                                <?= lang('Invoices.xin_flat');?>
                                                </option>
                                                <option value="2" <?php if($get_invoice['discount_type'] == 2):?> selected="selected"<?php endif;?>>
                                                <?= lang('Invoices.xin_percent');?>
                                                </option>
                                              </select>
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input style="text-align:right" type="text" name="discount_figure" class="form-control discount_figure" value="<?= $get_invoice['discount_figure'];?>" data-valid-num="required">
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" name="discount_amount" value="<?= $get_invoice['total_discount'];?>" class="discount_amount form-control">
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
                                                <option tax-type="<?php echo $_tax['field_two'];?>" tax-rate="<?php echo $_tax['field_one'];?>" value="<?php echo $_tax['constants_id'];?>" <?php if($_tax['constants_id'] == $get_invoice['tax_type']):?> selected="selected"<?php endif;?>> <?php echo $_tax['category_name'];?> (<?php echo $_tax_type;?>)</option>
                                                <?php endforeach;?>
                                              </select>
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" name="tax_rate" value="<?= $get_invoice['total_tax'];?>" class="tax_rate form-control">
                                            </div></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                </tr>
                              <input type="hidden" class="fgrand_total" name="fgrand_total" value="<?= $get_invoice['grand_total'];?>" />
                              <tr>
                                <td><?= lang('Invoices.xin_grand_total');?></td>
                                <td class="text-xs-right"><?php echo $sc_show;?> <span class="grand_total">
                                  <?= $get_invoice['grand_total'];?>
                                  </span></td>
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
                            <?= lang('Invoices.xin_invoice_note');?>
                          </label>
                          <textarea name="invoice_note" class="form-control"><?= $get_invoice['invoice_note'];?>
</textarea>
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
        <?= lang('Invoices.xin_update_invoice');?>
        </button>
      </div>
      <?php echo form_close(); ?> </div>
  </div>
</div>

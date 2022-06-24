<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\EstimatesModel;
use App\Models\ProjectsModel;
use App\Models\ConstantsModel;
use App\Models\EstimatesitemsModel;


$request = \Config\Services::request();
$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$EstimatesModel = new EstimatesModel();
$ProjectsModel = new ProjectsModel();
$ConstantsModel = new ConstantsModel();
$EstimatesitemsModel = new EstimatesitemsModel();

/* Company Details view
*/		
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$segment_id = $request->uri->getSegment(3);
/////
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$invoice_id = udecode($segment_id);
$xin_system = erp_company_settings();
$inv_company_info = $UsersModel->where('user_id', $xin_system['company_id'])->first();
$result = $EstimatesModel->where('estimate_id', $invoice_id)->first();
$company_info = $UsersModel->where('user_id', $result['client_id'])->where('user_type', 'customer')->first();
if($company_info){
	$company_contact = $company_info['first_name'].' '.$company_info['last_name'];
	$address_1 = $company_info['address_1'].' '.$company_info['address_2'];
	$cemail = $company_info['email'];
	$ccontact_number = $company_info['contact_number'];
	$csz = $company_info['city'].', '.$company_info['state'].' '.$company_info['zipcode'];
} else {
	$csz = '--';
	$cemail = '--';
	$address_1 = '--';
	$ccontact_number = '--';
	$company_contact = '--';
}
$invoice_items = $EstimatesitemsModel->where('estimate_id', $invoice_id)->findAll();

$ci_erp_settings = $SystemModel->where('setting_id', 1)->first();

$address_1 = $company_info['address_1'].' '.$company_info['address_2'];
$csz = $company_info['city'].', '.$company_info['state'].' '.$company_info['zipcode'];
if($result['status'] == 0){
	$status = '<span class="badge badge-light-primary">'.lang('Main.xin_estimated').'</span>';
} else if($result['status'] == 1) {
	$status = '<span class="badge badge-light-success">'.lang('Main.xin_invoiced').'</span>';
} else if($result['status'] == 2) {
	$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_cancelled').'</span>';
}
$_payment_method = $ConstantsModel->where('type','payment_method')->where('constants_id', $result['payment_method'])->first();
if($_payment_method){
	$ipayment_method = $_payment_method['category_name'];
} else {
	$ipayment_method = '--';
}
?>

<div class="row justify-content-md-center print-invoice"> 
  <!-- [ basic-alert ] start -->
  <div class="col-md-10"> 
    <!-- [ Estimate ] start -->
    <div class="container">
      <div>
        <div class="card" id="printTable">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_view_estimate').' #'.$result['estimate_number'];?>
            </h5>
            <div class="card-header-right"> <a href="<?= site_url('erp/print-estimate/').$segment_id;?>" target="_blank" class="collapsed btn btn-sm waves-effect waves-light btn-success m-0">
              <?= lang('Invoices.xin_print_download_invoice');?>
              </a>
              <?php if($user_info['user_type'] != 'customer'){ ?>
				  	<?php if($result['status'] == 0) { ?>
                      <?php if(in_array('estimate6',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-field_id="<?php echo $segment_id; ?>" data-target=".payroll-modal-data">
                          <?= lang('Main.xin_convert_estimate_to_invoice');?>
                          </button>
                      <?php } ?>
                      <?php if(in_array('estimate7',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-field_id="<?php echo $segment_id; ?>" data-target=".view-modal-data">
                          <?= lang('Main.xin_cancel_estimate');?>
                          </button>
                      <?php } ?>
                      <?php if(in_array('estimate4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                          <a href="<?= site_url('erp/edit-estimate/').$segment_id;?>" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0">
                          <?= lang('Main.xin_edit');?>
                          </a>
                      <?php } ?>
                  <?php } ?>
              <?php } ?>
            </div>
          </div>
          <div class="card-body">
            <div class="row ">
              <div class="col-md-8 invoice-contact">
                <div class="invoice-box row">
                  <div class="col-sm-12">
                    <table class="table table-responsive invoice-table table-borderless">
                      <tbody>
                        <tr>
                          <td><a href="#!"><img class="img-fluid" width="171" height="30" src="<?= base_url();?>/public/uploads/logo/other/<?= $ci_erp_settings['other_logo'];?>" alt="<?= $inv_company_info['company_name'];?>"></a></td>
                        </tr>
                        <tr>
                          <td><?= $inv_company_info['company_name'];?></td>
                        </tr>
                        <tr>
                          <td><?= $inv_company_info['address_1'];?>
                            , <br>
                            <?= $inv_company_info['address_2'];?></td>
                        </tr>
                        <tr>
                          <td><a class="text-secondary" href="mailto:<?= $inv_company_info['email'];?>" target="_top">
                            <?= $inv_company_info['email'];?>
                            </a></td>
                        </tr>
                        <tr>
                          <td><?= $inv_company_info['contact_number'];?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-4"></div>
            </div>
            <div class="row invoive-info d-print-inline-flex">
              <div class="col-sm-4 invoice-client-info">
                <h6>
                  <?= lang('Main.xin_client_info');?>
                  :</h6>
                <h6 class="m-0">
                  <?= $company_contact;?>
                </h6>
                <p class="m-0 m-t-10">
                  <?= $address_1;?>
                  <br>
                  <?= $csz;?>
                </p>
                <p class="m-0">
                  <?= $ccontact_number;?>
                </p>
                <p><a class="text-secondary" href="mailto:<?= $cemail;?>" target="_top">
                  <?= $cemail;?>
                  </a></p>
              </div>
              <div class="col-sm-4">
                <h6>
                  <?= lang('Main.xin_order_info');?>
                  :</h6>
                <table class="table table-responsive invoice-table invoice-order table-borderless">
                  <tbody>
                    <tr>
                      <th><?= lang('Main.xin_e_details_date');?>
                        :</th>
                      <td><?= $result['created_at'];?></td>
                    </tr>
                    <tr>
                      <th><?= lang('Main.dashboard_xin_status');?>
                        :</th>
                      <td><?= $status;?></td>
                    </tr>
                    <?php if($result['status'] == 1) { ?>
                    <tr>
                      <th><?= lang('Invoices.xin_payment');?>
                        :</th>
                      <td><?= $ipayment_method;?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="col-sm-4">
                <h6 class="m-b-20">
                  <?= lang('Main.xin_estimate_number');?>
                  <span>#
                  <?= $result['estimate_number'];?>
                  </span></h6>
                <h6 class="text-uppercase text-primary">
                  <?= lang('Main.xin_total');?>
                  : <span>
                  <?= number_to_currency($result['grand_total'],$xin_system['default_currency'],null,2);?>
                  </span> </h6>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table invoice-detail-table">
                    <thead>
                      <tr class="thead-default">
                        <th><?= lang('Main.xin_description');?></th>
                        <th><?= lang('Main.xin_qty');?></th>
                        <th><?= lang('Invoices.xin_amount');?></th>
                        <th><?= lang('Main.xin_total');?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($invoice_items as $item){?>
                      <tr>
                        <td><h6>
                            <?= $item['item_name'];?>
                          </h6></td>
                        <td><?= $item['item_qty'];?></td>
                        <td><?= number_to_currency($item['item_unit_price'],$xin_system['default_currency'],null,2);?></td>
                        <td><?= number_to_currency($item['item_sub_total'],$xin_system['default_currency'],null,2);?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-responsive invoice-table invoice-total">
                  <tbody>
                    <tr>
                      <th><?= lang('Invoices.xin_subtotal');?>
                        :</th>
                      <td><?= number_to_currency($result['sub_total_amount'],$xin_system['default_currency'],null,2);?></td>
                    </tr>
                    <tr>
                      <th><?= lang('Invoices.xin_tax');?>
                        (0%) :</th>
                      <td><?= number_to_currency($result['total_tax'],$xin_system['default_currency'],null,2);?></td>
                    </tr>
                    <tr>
                      <th><?= lang('Invoices.xin_discount');?>
                        (0%) :</th>
                      <td><?= number_to_currency($result['total_discount'],$xin_system['default_currency'],null,2);?></td>
                    </tr>
                    <tr class="text-info">
                      <td><hr />
                        <h5 class="text-primary m-r-10">
                          <?= lang('Main.xin_total');?>
                          :</h5></td>
                      <td><hr />
                        <h5 class="text-primary">
                          <?= number_to_currency($result['grand_total'],$xin_system['default_currency'],null,2);?>
                        </h5></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <h6>
                  <?= lang('Invoices.xin_terms_condition');?>
                  :</h6>
                <p>
                  <?= $xin_system['invoice_terms_condition'];?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- [ Estimate ] end --> 
  </div>
  <!-- [ basic-alert ] end --> 
</div>

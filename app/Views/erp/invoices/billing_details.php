<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\MembershipModel;
use App\Models\InvoicepaymentsModel;
use App\Models\CompanymembershipModel;


$request = \Config\Services::request();
$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$MembershipModel = new MembershipModel();
$InvoicepaymentsModel = new InvoicepaymentsModel();
$CompanymembershipModel = new CompanymembershipModel();

/* Company Details view
*/		
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$segment_id = $request->uri->getSegment(3);
/////
$xin_system = $SystemModel->where('setting_id', 1)->first();
$invoice_id = udecode($segment_id);
$result = $InvoicepaymentsModel->where('membership_invoice_id', $invoice_id)->first();
$company_info = $UsersModel->where('user_id', $result['company_id'])->first();
$ci_erp_settings = $SystemModel->where('setting_id', 1)->first();

$address_1 = $company_info['address_1'].' '.$company_info['address_2'];
$csz = $company_info['city'].', '.$company_info['state'].' '.$company_info['zipcode'];
?>

<div class="row"> 
  <!-- [ basic-alert ] start -->
  <div class="col-md-12"> 
    <!-- [ Invoice ] start -->
    <div class="container">
      <div>
        <div class="card" id="printTable">
          <div class="card-body">
            <div class="row ">
              <div class="col-md-8 invoice-contact">
                <div class="invoice-box row">
                  <div class="col-sm-12">
                    <table class="table table-responsive invoice-table table-borderless">
                      <tbody>
                        <tr>
                          <td><a href="#!"><img class="img-fluid" width="171" height="30" src="<?= base_url();?>/public/uploads/logo/other/<?= $ci_erp_settings['other_logo'];?>" alt="<?= $xin_system['company_name'];?>"></a></td>
                        </tr>
                        <tr>
                          <td><?= $xin_system['company_name'];?></td>
                        </tr>
                        <tr>
                          <td><?= $xin_system['address_1'];?>
                            ,<br>
                            <?= $xin_system['address_2'];?></td>
                        </tr>
                        <tr>
                          <td><a class="text-secondary" href="mailto:<?= $xin_system['email'];?>" target="_top">
                            <?= $xin_system['email'];?>
                            </a></td>
                        </tr>
                        <tr>
                          <td><?= $xin_system['contact_number'];?></td>
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
                  <?= $company_info['first_name'].' '.$company_info['last_name'];?>
                </h6>
                <p class="m-0 m-t-10">
                  <?= $address_1;?>
                  <br>
                  <?= $csz;?>
                </p>
                <p class="m-0">
                  <?= $company_info['contact_number'];?>
                </p>
                <p><a class="text-secondary" href="mailto:<?= $company_info['email'];?>" target="_top">
                  <?= $company_info['email'];?>
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
                      <td><span class="label label-warning">
                        <?= lang('Invoices.xin_paid');?>
                        </span></td>
                    </tr>
                    <tr>
                      <th><?= lang('Invoices.xin_payment');?>
                        :</th>
                      <td><?= $result['payment_method'];?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-sm-4">
                <h6 class="m-b-20">
                  <?= lang('Invoices.xin_invoice_number');?>
                  <span>#
                  <?= $result['invoice_number'];?>
                  </span></h6>
                <h6 class="text-uppercase text-primary"><?= lang('Main.xin_total');?> : <span>
                  <?= number_to_currency($result['membership_price'],$xin_system['default_currency'],null,2);?>
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
                      <tr>
                        <td><h6>
                            <?= $result['membership_type'];?>
                          </h6>
                          <p class="m-0">
                            <?= lang('Membership.xin_subscription_id');?>
                            :
                            <?= $result['subscription_id'];?>
                          </p></td>
                        <td>1</td>
                        <td><?= number_to_currency($result['membership_price'],$xin_system['default_currency'],null,2);?></td>
                        <td><?= number_to_currency($result['membership_price'],$xin_system['default_currency'],null,2);?></td>
                      </tr>
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
                      <td><?= number_to_currency($result['membership_price'],$xin_system['default_currency'],null,2);?></td>
                    </tr>
                    <tr>
                      <th><?= lang('Invoices.xin_tax');?>
                        (0%) :</th>
                      <td>$0.00</td>
                    </tr>
                    <tr>
                      <th><?= lang('Invoices.xin_discount');?>
                        (0%) :</th>
                      <td>$0.00</td>
                    </tr>
                    <tr class="text-info">
                      <td><hr />
                        <h5 class="text-primary m-r-10">
                          <?= lang('Main.xin_total');?>
                          :</h5></td>
                      <td><hr />
                        <h5 class="text-primary">
                          <?= number_to_currency($result['membership_price'],$xin_system['default_currency'],null,2);?>
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
        <div class="row text-center d-print-none">
          <div class="col-sm-12 invoice-btn-group text-center">
            <button type="button" class="btn btn-print-invoice waves-effect waves-light btn-success m-b-10">
            <?= lang('Invoices.xin_print_download_invoice');?>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- [ Invoice ] end --> 
  </div>
  <!-- [ basic-alert ] end --> 
</div>

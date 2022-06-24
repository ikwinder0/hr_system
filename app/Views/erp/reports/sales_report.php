<?php
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\OrdersModel;

$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$MainModel = new MainModel();
$OrdersModel = new OrdersModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$status = $_REQUEST['P'];
$start_date = $_REQUEST['S'];
$end_date = $_REQUEST['E'];

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$xin_system = erp_company_settings();
$invoice_report = sales_report($start_date,$end_date,$status);
$ci_erp_settings = $SystemModel->where('setting_id', 1)->first();
?>
<div class="row justify-content-md-center"> 
  <div class="col-md-10"> 
    <!-- [ Invoice view ] start -->
    <div class="container">
      <div>
        <div class="card" id="printTable">
          <div class="card-header">
            <h5><img class="img-fluid" width="171" height="30" src="<?= base_url();?>/public/uploads/logo/other/<?= $ci_erp_settings['other_logo'];?>" alt=""></h5>
          </div>
          <div class="card-body pb-0">
            <div class="row invoive-info d-pdrint-inline-flex ">
              <div class="col-md-8">
                    <h6 class="text-primary"><?= lang('Inventory.xin_sales_order_report');?> :</h6>
                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                        <tbody>
                            <tr class="text-primary">
                                <th>From :</th>
                                <td><?= set_date_format($start_date);?></td>
                            </tr>
                            <tr class="text-primary">
                                <th>To :</th>
                                <td><?= set_date_format($end_date);?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <div class="table-responsive">
                  <table class="table m-b-0 f-14 b-solid requid-table">
                    <thead>
                      <tr class="text-uppercase">
                        <th>Customer</th>
                        <th>Invoice#</th>
                        <th><?= lang('Main.xin_total');?></th>
                        <th>Invoice Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($invoice_report as $_invoice) { ?>
                      <?php $_customer = $UsersModel->where('user_id', $_invoice->customer_id)->where('user_type', 'customer')->first();?>
                      <?php
					    if($_customer){
							$customer_name = $_customer['first_name'].' '.$_customer['last_name'];
						} else {
							$customer_name = '';
						}
					   // status
						if($_invoice->status == 0){
							$status = '<span class="badge badge-light-warning">'.lang('Invoices.xin_unpaid').'</span>';
						} else if($_invoice->status == 1) {
							$status = '<span class="badge badge-light-primary">'.lang('Invoices.xin_paid').'</span>';
						} else if($_invoice->status == 2) {
							$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_cancelled').'</span>';
						} else if($_invoice->status == 3) {
							$status = '<span class="badge badge-light-info">'.lang('Inventory.xin_packed_orders_text').'</span>';
						} else {
							$status = '<span class="badge badge-light-success">'.lang('Inventory.xin_delivered_orders_text').'</span>';
						}?>
                      <tr>
                        <td width="150"><?= $customer_name;?></td>
                        <td width="200"><?= $_invoice->order_number;?></td>
                        <td><?= number_to_currency($_invoice->grand_total,$xin_system['default_currency'],null,2);?></td>
                        <td><?= set_date_format($_invoice->invoice_date);?></td>
                        <td><?= $status;?></td>
                      </tr>
                    <?php } ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row text-center d-print-none">
          <div class="col-sm-12 invoice-btn-group text-center">
            <button type="button" class="btn btn-print-invoice waves-effect waves-light btn-success m-b-10">
            <?= lang('Main.xin_print');?>
            </button>
           </div>
        </div>
      </div>
    </div>
    <!-- [ Invoice view ] end --> 
  </div>
</div>

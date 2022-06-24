<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\OrdersModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$SystemModel = new SystemModel();
$OrdersModel = new OrdersModel();
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$xin_system = erp_company_settings();
if($user_info['user_type'] == 'staff'){
	$get_invoices = $OrdersModel->where('company_id',$user_info['company_id'])->where('status',2)->orderBy('order_id', 'ASC')->paginate(8);
	$count_invoices = $OrdersModel->where('company_id',$user_info['company_id'])->orderBy('order_id', 'ASC')->countAllResults();
	$pager = $OrdersModel->pager;
	$company_id = $user_info['company_id'];
} else {
	$get_invoices = $OrdersModel->where('company_id',$usession['sup_user_id'])->where('status',2)->orderBy('order_id', 'ASC')->paginate(8);
	$count_invoices = $OrdersModel->where('company_id',$usession['sup_user_id'])->orderBy('order_id', 'ASC')->countAllResults();
	$company_id = $usession['sup_user_id'];
	$pager = $OrdersModel->pager;
}
?>
<?php if(in_array('cancelled_orders',staff_role_resource()) || in_array('sales_order2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('cancelled_orders',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/cancelled-orders');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Inventory.xin_cancelled_orders');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Inventory.xin_cancelled_orders');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('sales_order2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/create-order');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calendar-plus"></span>
      <?= lang('Inventory.xin_create_new_order');?>
      <div class="text-muted small">
        <?= lang('Inventory.xin_create_new_order');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row"> 
  <!-- [ invoice-list ] start -->
  <!-- [ left ] end --> 
  <!-- [ right ] start -->
  <div class="col-xl-12 col-lg-12 filter-bar invoice-list">
    <nav class="navbar m-b-30 p-10">
      <ul class="nav">
        <li class="nav-item f-text active">
          <?= lang('Main.xin_list_all');?>
          <?= lang('Inventory.xin_cancelled_orders');?>
        </li>
      </ul>
      <?php if(in_array('sales_order2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="nav-item nav-grid f-view"> <a href="<?= site_url().'erp/create-order';?>" class="btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
        <?= lang('Inventory.xin_create_new_order');?>
        </a> </div>
      <?php } ?>
    </nav>
    <div class="row">
      <?php foreach($get_invoices as $r) {?>
      <?php
		$invoice_date = set_date_format($r['invoice_date']);
		$invoice_due_date = set_date_format($r['invoice_due_date']);
		// status
		if($r['status'] == 0){
			$status = '<span class="badge badge-light-warning">'.lang('Invoices.xin_unpaid').'</span>';
		} else if($r['status'] == 1) {
			$status = '<span class="badge badge-light-primary">'.lang('Invoices.xin_paid').'</span>';
		} else if($r['status'] == 2) {
			$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_cancelled').'</span>';
		} else if($r['status'] == 3) {
			$status = '<span class="badge badge-light-info">'.lang('Inventory.xin_packed_orders_text').'</span>';
		} else {
			$status = '<span class="badge badge-light-success">'.lang('Inventory.xin_delivered_orders_text').'</span>';
		}
		$invoice_total = number_to_currency($r['grand_total'], $xin_system['default_currency'],null,2);
		$client_info = $UsersModel->where('user_id',$r['customer_id'])->where('user_type','customer')->first();
		if($client_info){
			$iclient_info = $client_info['first_name'].' '.$client_info['last_name'];
		} else {
			$iclient_info = '--';
		}
		$_payment_method = $ConstantsModel->where('type','payment_method')->where('constants_id', $r['payment_method'])->first();
		if($_payment_method){
			$ipayment_method = $_payment_method['category_name'];
		} else {
			$ipayment_method = '--';
		}
		?>
      <div class="col-lg-4 col-md-12">
        <div class="card card-border-c-blue">
          <div class="card-body">
            <div class="mb-3">
              <h5 class="d-inline-block m-b-10">
                <?= $iclient_info;?>
              </h5>
              <div class="dropdown-secondary dropdown float-right">
                <?= $status;?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <ul class="list list-unstyled">
                  <li>
                    <?= lang('Invoices.xin_invoice_no');?>
                    :
                    <?= $r['order_number']?>
                  </li>
                  <li>
                    <?= lang('Invoices.xin_created');?>
                    : <span class="text-semibold">
                    <?= $invoice_due_date;?>
                    </span></li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="list list-unstyled text-right">
                  <li>
                    <?= $invoice_total;?>
                  </li>
                  <?php if($r['status']==1){ ?>
                  <li>
                    <?= lang('Invoices.xin_method');?>
                    : <span class="text-semibold"><?= $ipayment_method;?></span></li>
                  <?php } ?>  
                </ul>
              </div>
            </div>
            <div class="m-t-30">
              <div class="task-list-table">
                <p class="task-due"><strong>
                  <?= lang('Invoices.xin_due');?>
                  : </strong><strong class="label label-primary">
                  <?= $invoice_due_date;?>
                  </strong></p>
              </div>
              <div class="task-board m-0 float-right"> <a href="<?= site_url().'erp/order-detail/'.uencode($r['order_id']);?>" class="btn btn-primary"><i class="fas fa-eye m-0"></i></a> <a href="<?= site_url().'erp/print-order/'.uencode($r['order_id']);?>" class="btn btn-primary" target="_blank"><i class="fas fa-download mr-0"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
  <!-- [ invoice-list ] end --> 
</div>
<hr>
<div class="p-2">
<?= $pager->links() ?>
</div>
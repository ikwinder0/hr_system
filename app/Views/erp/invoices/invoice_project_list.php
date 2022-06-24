<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\InvoicesModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$SystemModel = new SystemModel();
$InvoicesModel = new InvoicesModel();
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$xin_system = erp_company_settings();
if($user_info['user_type'] == 'staff'){
	$get_invoices = $InvoicesModel->where('company_id',$user_info['company_id'])->orderBy('invoice_id', 'ASC')->paginate(8);
	$count_invoices = $InvoicesModel->where('company_id',$user_info['company_id'])->orderBy('invoice_id', 'ASC')->countAllResults();
	$pager = $InvoicesModel->pager;
	$company_id = $user_info['company_id'];
} else {
	$get_invoices = $InvoicesModel->where('company_id',$usession['sup_user_id'])->orderBy('invoice_id', 'ASC')->paginate(8);
	$count_invoices = $InvoicesModel->where('company_id',$usession['sup_user_id'])->orderBy('invoice_id', 'ASC')->countAllResults();
	$company_id = $usession['sup_user_id'];
	$pager = $InvoicesModel->pager;
}
$unpaid = $InvoicesModel->where('company_id',$company_id)->where('status', 0)->countAllResults();
$paid = $InvoicesModel->where('company_id',$company_id)->where('status', 1)->countAllResults();
/*
* All Project Invoices View
*/
if($count_invoices < 1): $unpaid = 0;
else: $unpaid = $unpaid / $count_invoices * 100; endif;
$unpaid = number_format((float)$unpaid, 1, '.', '');

if($count_invoices < 1): $paid = 0;
else: $paid = $paid / $count_invoices * 100; endif;
$paid = number_format((float)$paid, 1, '.', '');
?>
<?php if(in_array('invoice2',staff_role_resource()) || in_array('invoice_payments',staff_role_resource()) || in_array('invoice_calendar',staff_role_resource()) || in_array('tax_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('invoice2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/invoices-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Invoices.xin_billing_invoices');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.xin_invoices_title');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('invoice_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/invoice-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calendar-plus"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Dashboard.xin_invoice_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('invoice_payments',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/invoice-payments-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-money-check-alt"></span>
      <?= lang('Dashboard.xin_acc_invoice_payments');?>
      <div class="text-muted small">
        <?= lang('Main.xin_view');?>
        <?= lang('Dashboard.xin_acc_invoice_payments');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('tax_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/tax-type');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Dashboard.xin_invoice_tax_type');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.xin_invoice_tax_type');?>
      </div>
      </a> </li>
   <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row"> 
  <!-- [ invoice-list ] start -->
  <?php if($count_invoices > 0) { ?>
  <div class="col-xl-3 col-lg-12">
    <div class="card task-board-left">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_summary');?>
        </h5>
      </div>
      <div class="card-body">
        <div class="task-right">
          <div class="taskboard-right-progress">
            <p class="m-b-10">
              <?= lang('Invoices.xin_unpaid');?>
              <span class="float-right"><i class="fa fa-caret-down m-r-10"></i>
              <?= $unpaid;?>
              %</span></p>
            <div class="progress blue">
              <div class="progress-bar bg-primary" style="width:<?= $unpaid;?>%"></div>
            </div>
            <p class="m-b-10 m-t-30">
              <?= lang('Invoices.xin_paid');?>
              <span class="float-right"><i class="fa fa-caret-up m-r-10"></i>
              <?= $paid;?>
              %</span></p>
            <div class="progress green">
              <div class="progress-bar bg-success" style="width:<?= $paid;?>%"></div>
            </div>
            <p class="m-b-10 m-t-30">
              <?= lang('Invoices.xin_due');?>
              <span class="float-right"><i class="fa fa-caret-down m-r-10"></i>
              <?= number_to_currency(erp_total_unpaid_invoices(), $xin_system['default_currency'],null,2);?>
              </span></p>
            <div class="progress red">
              <div class="progress-bar bg-danger" style="width:<?= $unpaid;?>%"></div>
            </div>
            <p class="m-b-10 m-t-30">
              <?= lang('Invoices.xin_paid_amount');?>
              <span class="float-right"><i class="fa fa-caret-up m-r-10"></i>
              <?= number_to_currency(erp_total_paid_invoices(), $xin_system['default_currency'],null,2);?>
              </span></p>
            <div class="progress">
              <div class="progress-bar bg-info" style="width:<?= $paid;?>%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-12 col-md-12">
        <div class="card">
          <div class="card-body">
            <h6>
              <?= lang('Invoices.xin_invoice_status');?>
            </h6>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id="invoice-status-chart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php $col_md = 'col-xl-9'; ?>
  <?php } else {?>
  <?php $col_md = 'col-xl-12'; ?>
  <?php } ?>
  <!-- [ left ] end --> 
  <!-- [ right ] start -->
  <div class="<?= $col_md;?> col-lg-12 filter-bar invoice-list">
    <nav class="navbar m-b-30 p-10">
      <ul class="nav">
        <li class="nav-item f-text active">
          <?= lang('Main.xin_list_all');?>
          <?= lang('Dashboard.xin_invoices_title');?>
        </li>
      </ul>
      <?php if(in_array('invoice3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="nav-item nav-grid f-view"> <a href="<?= site_url().'erp/create-new-invoice';?>" class="btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
        <?= lang('Invoices.xin_create_new_invoices');?>
        </a> </div>
      <?php } ?>
    </nav>
    <div class="row">
      <?php foreach($get_invoices as $r) {?>
      <?php
		$invoice_date = set_date_format($r['invoice_date']);
		$invoice_due_date = set_date_format($r['invoice_due_date']);
		// status
		if($r['status']==1){
			$status = '<span class="badge badge-light-success">'.lang('Invoices.xin_paid').'</span>';
		} else {
			$status = '<span class="badge badge-light-danger">'.lang('Invoices.xin_unpaid').'</span>';
		}
		$invoice_total = number_to_currency($r['grand_total'], $xin_system['default_currency'],null,2);
		$client_info = $UsersModel->where('user_id',$r['client_id'])->where('user_type','customer')->first();
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
      <div class="col-lg-6 col-md-12">
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
                    <?= $r['invoice_number']?>
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
              <div class="task-board m-0 float-right"> <a href="<?= site_url().'erp/invoice-detail/'.uencode($r['invoice_id']);?>" class="btn btn-primary"><i class="fas fa-eye m-0"></i></a>
                <div class="dropdown-secondary dropdown d-inline">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
                  <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"> <a class="dropdown-item" href="<?= site_url().'erp/print-invoice/'.uencode($r['invoice_id']);?>"><i class="fas fa-download mr-2"></i>
                    <?= lang('Invoices.xin_download_invoice');?>
                    </a>
                    <div class="dropdown-divider"></div>
                    <?php if($r['status']==0){ ?>
						<?php if(in_array('invoice4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                            <a class="dropdown-item" href="<?= site_url().'erp/edit-invoice/'.uencode($r['invoice_id']);?>"><i class="fas fa-edit mr-2"></i>
                            <?= lang('Invoices.xin_edit_invoice');?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if(in_array('invoice5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                    <a href="#!" class="dropdown-item delete" data-toggle="modal" data-target=".delete-modal" data-record-id="<?= uencode($r['invoice_id']);?>"><i class="feather icon-trash-2"></i>
                    <?= lang('Invoices.xin_remove_invoice');?>
                    </a>
                    <?php } ?>
                    </div>
                </div>
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
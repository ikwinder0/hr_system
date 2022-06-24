<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SuppliersModel;
use App\Models\PurchasesModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$SystemModel = new SystemModel();
$PurchasesModel = new PurchasesModel();
$ConstantsModel = new ConstantsModel();
$SuppliersModel = new SuppliersModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$xin_system = erp_company_settings();
if($user_info['user_type'] == 'staff'){
	$get_purchases = $PurchasesModel->where('company_id',$user_info['company_id'])->orderBy('purchase_id', 'ASC')->paginate(8);
	$count_purchase = $PurchasesModel->where('company_id',$user_info['company_id'])->orderBy('purchase_id', 'ASC')->countAllResults();
	$pager = $PurchasesModel->pager;
	$company_id = $user_info['company_id'];
} else {
	$get_purchases = $PurchasesModel->where('company_id',$usession['sup_user_id'])->orderBy('purchase_id', 'ASC')->paginate(8);
	$count_purchase = $PurchasesModel->where('company_id',$usession['sup_user_id'])->orderBy('purchase_id', 'ASC')->countAllResults();
	$company_id = $usession['sup_user_id'];
	$pager = $PurchasesModel->pager;
}
$unpaid = $PurchasesModel->where('company_id',$company_id)->where('status', 0)->countAllResults();
$paid = $PurchasesModel->where('company_id',$company_id)->where('status', 1)->countAllResults();
/*
* All Project Estimates View
*/
?>
<?php if(in_array('purchases1',staff_role_resource()) || in_array('purchases2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('purchases1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/stock-purchases');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Inventory.xin_purchases');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Inventory.xin_purchases');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('purchases2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/create-purchase');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calendar-plus"></span>
      <?= lang('Inventory.xin_new_purchase');?>
      <div class="text-muted small">
        <?= lang('Inventory.xin_new_purchase');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row"> 
  <!-- [ invoice-list ] start -->
  <!-- [ right ] start -->
  <div class="col-xl-12 col-lg-12 filter-bar invoice-list">
    <nav class="navbar m-b-30 p-10">
      <ul class="nav">
        <li class="nav-item f-text active">
          <?= lang('Main.xin_list_all');?>
          <?= lang('Inventory.xin_purchases');?>
        </li>
      </ul>
      <?php if(in_array('purchases2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="nav-item nav-grid f-view"> <a href="<?= site_url().'erp/create-purchase';?>" class="btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
        <?= lang('Inventory.xin_new_purchase');?>
        </a> </div>
      <?php } ?>
    </nav>
    <div class="row">
      <?php foreach($get_purchases as $r) {?>
      <?php
		$purchase_date = set_date_format($r['purchase_date']);
		// status
		if($r['status']==1){
			$status = '<span class="badge badge-light-success">'.lang('Inventory.xin_delivered').'</span>';
		} else if($r['status']==2){
			$status = '<span class="badge badge-light-danger">'.lang('Main.xin_cancelled').'</span>';
		} else {
			$status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>';
		}
		$invoice_total = number_to_currency($r['grand_total'], $xin_system['default_currency'],null,2);
		$supplier_info = $SuppliersModel->where('supplier_id',$r['supplier_id'])->first();
		if($supplier_info){
			$supplier_name = $supplier_info['supplier_name'];
		} else {
			$supplier_name = '--';
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
                <?= $supplier_name;?>
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
                    <?= $r['purchase_number']?>
                  </li>
                  <li>
                    <?= lang('Invoices.xin_created');?>
                    : <span class="text-semibold">
                    <?= $purchase_date;?>
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
                  <?= lang('Invoices.xin_payment');?>
                  : </strong><strong class="label label-primary">
                  <?= $ipayment_method;?>
                  </strong></p>
              </div>
              <div class="task-board m-0 float-right"> <a href="<?= site_url().'erp/purchase-detail/'.uencode($r['purchase_id']);?>" class="btn btn-primary"><i class="fas fa-eye m-0"></i></a>
                <div class="dropdown-secondary dropdown d-inline">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
                  <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"> <a target="_blank" class="dropdown-item" href="<?= site_url().'erp/print-purchase/'.uencode($r['purchase_id']);?>"><i class="fas fa-download mr-2"></i>
                    <?= lang('Inventory.xin_download_purchase');?>
                    </a>
                    <div class="dropdown-divider"></div>
                    <?php if($r['status']==0){ ?>
						<?php if(in_array('purchases3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                            <a class="dropdown-item" href="<?= site_url().'erp/edit-purchase/'.uencode($r['purchase_id']);?>"><i class="fas fa-edit mr-2"></i>
                            <?= lang('Inventory.xin_edit_purchase');?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if(in_array('purchases4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                    <a href="#!" class="dropdown-item delete" data-toggle="modal" data-target=".delete-modal" data-record-id="<?= uencode($r['purchase_id']);?>"><i class="feather icon-trash-2"></i>
                    <?= lang('Inventory.xin_remove_purchase');?>
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
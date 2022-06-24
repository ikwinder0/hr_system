<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\EstimatesModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$SystemModel = new SystemModel();
$EstimatesModel = new EstimatesModel();
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$xin_system = erp_company_settings();
if($user_info['user_type'] == 'staff'){
	$get_invoices = $EstimatesModel->where('company_id',$user_info['company_id'])->orderBy('estimate_id', 'ASC')->paginate(8);
	$count_invoices = $EstimatesModel->where('company_id',$user_info['company_id'])->orderBy('estimate_id', 'ASC')->countAllResults();
	$pager = $EstimatesModel->pager;
	$company_id = $user_info['company_id'];
} else {
	$get_invoices = $EstimatesModel->where('company_id',$usession['sup_user_id'])->orderBy('estimate_id', 'ASC')->paginate(8);
	$count_invoices = $EstimatesModel->where('company_id',$usession['sup_user_id'])->orderBy('estimate_id', 'ASC')->countAllResults();
	$company_id = $usession['sup_user_id'];
	$pager = $EstimatesModel->pager;
}
$unpaid = $EstimatesModel->where('company_id',$company_id)->where('status', 0)->countAllResults();
$paid = $EstimatesModel->where('company_id',$company_id)->where('status', 1)->countAllResults();
/*
* All Project Estimates View
*/
?>
<?php if(in_array('invoice2',staff_role_resource()) || in_array('invoice_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('invoice2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/estimates-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_estimates');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.xin_estimates');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('estimates_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/estimates-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calendar-plus"></span>
      <?= lang('Dashboard.xin_quote_calendar');?>
      <div class="text-muted small">
        <?= lang('Dashboard.xin_quote_calendar');?>
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
          <?= lang('Dashboard.xin_estimates');?>
        </li>
      </ul>
      <?php if(in_array('estimate3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="nav-item nav-grid f-view"> <a href="<?= site_url().'erp/create-new-estimate';?>" class="btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
        <?= lang('Main.xin_create_new_estimate');?>
        </a> </div>
      <?php } ?>
    </nav>
    <div class="row">
      <?php foreach($get_invoices as $r) {?>
      <?php
		$invoice_date = set_date_format($r['estimate_date']);
		$invoice_due_date = set_date_format($r['estimate_due_date']);
		// status
		if($r['status']==1){
			$status = '<span class="badge badge-light-success">'.lang('Main.xin_invoiced').'</span>';
		} else if($r['status']==0){
			$status = '<span class="badge badge-light-primary">'.lang('Main.xin_estimated').'</span>';
		} else if($r['status'] == 2) {
			$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_cancelled').'</span>';
		}
		$invoice_total = number_to_currency($r['grand_total'], $xin_system['default_currency'],null,2);
		$client_info = $UsersModel->where('user_id',$r['client_id'])->where('user_type','customer')->first();
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
                <?= $client_info['first_name'].' '.$client_info['last_name'];?>
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
                    <?= $r['estimate_number']?>
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
              <div class="task-board m-0 float-right"> <a href="<?= site_url().'erp/estimate-detail/'.uencode($r['estimate_id']);?>" class="btn btn-primary"><i class="fas fa-eye m-0"></i></a>
                <div class="dropdown-secondary dropdown d-inline">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
                  <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"> <a class="dropdown-item" href="<?= site_url().'erp/print-estimate/'.uencode($r['estimate_id']);?>"><i class="fas fa-download mr-2"></i>
                    <?= lang('Main.xin_download_estimate');?>
                    </a>
                    <div class="dropdown-divider"></div>
                    <?php if($r['status']==0){ ?>
						<?php if(in_array('estimate4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                            <a class="dropdown-item" href="<?= site_url().'erp/edit-estimate/'.uencode($r['estimate_id']);?>"><i class="fas fa-edit mr-2"></i>
                            <?= lang('Main.xin_edit_estimate');?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if(in_array('estimate5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                    <a href="#!" class="dropdown-item delete" data-toggle="modal" data-target=".delete-modal" data-record-id="<?= uencode($r['estimate_id']);?>"><i class="feather icon-trash-2"></i>
                    <?= lang('Main.xin_remove_estimate');?>
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
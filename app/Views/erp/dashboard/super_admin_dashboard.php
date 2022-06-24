<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\MembershipModel;
use App\Models\InvoicepaymentsModel;
use App\Models\CompanymembershipModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$InvoicepaymentsModel = new InvoicepaymentsModel();
$ProjectsModel = new CompanymembershipModel();
$MembershipModel = new MembershipModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$xin_system = $SystemModel->where('setting_id', 1)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$total_companies = $UsersModel->where('user_type','company')->countAllResults();
$active_companies = $UsersModel->where('user_type','company')->where('is_active',1)->countAllResults();
$inactive_companies = $UsersModel->where('user_type','company')->where('is_active',2)->countAllResults();
$total_membership = $MembershipModel->orderBy('membership_id', 'ASC')->countAllResults();
$get_invoices = $InvoicepaymentsModel->orderBy('membership_invoice_id','DESC')->findAll(10);

?>

<div class="row">
  <div class="col-xl-3 col-md-6">
    <div class="card feed-card">
      <div class="card-body p-t-0 p-b-0">
        <div class="row">
          <div class="col-4 bg-primary border-feed"> <i class="feather icon-user-plus f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">
                <?= $total_companies;?>
              </h2>
              <p class="text-muted m-0">
                <?= lang('Main.xin_total');?>
                <span class="text-primary f-w-400">
                <?= lang('Company.xin_small_text_companies');?>
                </span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="card feed-card">
      <div class="card-body p-t-0 p-b-0">
        <div class="row">
          <div class="col-4 bg-success border-feed"> <i class="feather icon-user-check f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">
                <?= $active_companies;?>
              </h2>
              <p class="text-muted m-0"><?= lang('Main.xin_employees_active');?> <span class="text-success f-w-400">
                <?= lang('Company.xin_small_text_companies');?>
                </span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="card feed-card">
      <div class="card-body p-t-0 p-b-0">
        <div class="row">
          <div class="col-4 bg-danger border-feed"> <i class="feather icon-user-minus f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">
                <?= $inactive_companies;?>
              </h2>
              <p class="text-muted m-0"><?= lang('Main.xin_employees_inactive');?> <span class="text-danger f-w-400">
                <?= lang('Company.xin_small_text_companies');?>
                </span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="card feed-card">
      <div class="card-body p-t-0 p-b-0">
        <div class="row">
          <div class="col-4 bg-warning border-feed"> <i class="feather icon-users f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">
                <?= $total_membership;?>
              </h2>
              <p class="text-muted m-0">
                <?= lang('Main.xin_total');?>
                <span class="text-warning f-w-400">
                <?= lang('Membership.xin_small_text_memberships');?>
                </span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xl-6 col-md-6">
    <div class="card">
      <div class="card-body">
        <h6>
          <?= lang('Membership.xin_membership_report');?>
        </h6>
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col">
            <div id="membership-type-chart"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <h6>
          <?= lang('Membership.xin_membership_by_country');?>
        </h6>
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col">
            <div id="membership-by-country-chart"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-6 col-md-12">
    <div class="card">
      <div class="card-header">
        <h5>
          <?= lang('Membership.xin_subscription_invoice_report');?>
        </h5>
      </div>
      <div class="card-body">
        <div class="row pb-2">
          <div class="col-auto m-b-10">
            <h3 class="mb-1">
              <?= number_to_currency(total_membership_payments(), $xin_system['default_currency'],null,2);?>
            </h3>
            <span>
            <?= lang('Invoices.xin_total_amount');?>
            </span> </div>
        </div>
        <div id="company-invoice-chart"></div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h5>
          <?= lang('Invoices.xin_last_invoices');?>
        </h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <div class="sale-scroll" style="height:215px;position:relative;">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?= lang('Membership.xin_subscription');?></th>
                  <th><?= lang('Main.xin_price');?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($get_invoices as $r){ ?>
                <?php $membership = $MembershipModel->where('membership_id', $r['membership_id'])->first(); ?>
                <?php
				if($r['payment_method'] == 'Stripe'){
					$invoice_url = '<a target="_blank" href="'.$r['receipt_url'].'"><span>'.$r['invoice_id'].'</span></a>';
				} else {
					$invoice_url = '<a target="_blank" href="'.site_url('erp/billing-detail').'/'.uencode($r['membership_invoice_id']).'"><span>'.$r['invoice_id'].'</span></a>';
				}
				?>
                <tr>
                  <td><h6 class="mb-1 text-success">
                      <?= $invoice_url;?>
                    </h6></td>
                  <td><?= $membership['membership_type'];?></td>
                  <td><h6 class="mb-1 text-success">
                      <?= number_to_currency($r['membership_price'], $xin_system['default_currency'],null,2);?>
                    </h6></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

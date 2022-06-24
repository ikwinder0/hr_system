<?php
use App\Models\ConstantsModel;
use App\Models\CountryModel;
use App\Models\MembershipModel;
use App\Models\CompanymembershipModel;
use App\Models\MainModel;
use App\Models\UsersModel;
use App\Models\SystemModel;

$ConstantsModel = new ConstantsModel();
$CountryModel = new CountryModel();
$MembershipModel = new MembershipModel();
$MainModel = new MainModel();
$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$CompanymembershipModel = new CompanymembershipModel();

$company_types = $ConstantsModel->where('type','company_type')->orderBy('constants_id', 'ASC')->findAll();
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$membership_plans = $MembershipModel->orderBy('membership_id', 'ASC')->findAll();
/* Company Details view
*/		
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
//$segment_id = $request->uri->getSegment(3);
$field_id = $usession['sup_user_id'];//udecode($segment_id);
/////
$xin_system = erp_company_settings();
$xin_super_system = $SystemModel->where('setting_id', 1)->first();
$result = $UsersModel->where('user_id', $field_id)->first();
$company_membership = $CompanymembershipModel->where('company_id', $field_id)->first();
if($result['is_active'] == 1){
	$status = '<span class="text-success"><em class="fas fa-check-circle"></em> '.lang('Main.xin_employees_active').'</span>';
} else {
	$status = '<span class="text-danger"><em class="fas fa-check-circle"></em> '.lang('Main.xin_employees_inactive').'</span>';
}
?>
<?php $subs_plan = $MembershipModel->where('membership_id', $company_membership['membership_id'])->first(); ?>
<?php
$membership = $MembershipModel->orderBy('membership_id', 'ASC')->paginate(8);
$pager = $MembershipModel->pager;

/*$converted = currency_converter($xin_super_system['default_currency'],$xin_system['default_currency'],2);	
		
echo $converted;*/
//echo $url;
//echo $url['sites']['rates']['AED'];
?>
<?php if($session->get('paypal_payment_error_status')){?>

<div class="alert alert-danger alert-dismissible fade show">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?= $session->get('paypal_payment_error_status');?>
</div>
<?php } ?>
<?php /*?><div class="card">
  <div class="card-body">
    <nav class="navbar justify-content-between p-0 align-items-center">
      <h5>
        <?= lang('Membership.xin_subscription_list');?>
      </h5>
    </nav>
  </div>
</div><?php */?>
<div class="row">
    <div class="col-sm-12">
        <div class="row justify-content-center text-center">
            <div class="col-xl-8 col-md-10">
                <h2 class="mt-2">
                    <?= lang('Membership.xin_membership_plans');?>
                </h2>
                <p class="my-4">
                <?= lang('Membership.xin_subscription_list_text1');?></p>                        
            </div>
        </div>
    </div>
</div>
<div class="row"> 
  <!-- membership list  start -->
  <div class="col-12">
    <?php foreach($membership as $r) { ?>
    <?php
	if($r['plan_duration']==1){
		$plan_duration = lang('Membership.xin_per_month');
	} else if($r['plan_duration']==2) {
		$plan_duration = lang('Membership.xin_per_year');
	} else {
		$plan_duration = lang('Membership.xin_subscription_unlimit');
	}
	$converted = currency_converter($r['price']);
	?>
    <div class="card">
      <div class="card-body">
        <div class="row align-items-center justify-contact-between">
          <div class="col">
            <div class="btn btn-primary"> <a href="#!" class="text-white" data-toggle="modal" data-target=".view-modal-data" data-field_id="<?= uencode($r['membership_id']);?>">
              <?= $r['membership_type']?>
              </a> </div>
          </div>
          <?php if($company_membership['membership_id'] == $r['membership_id']){ ?>
          <h6 class="my-0 text-success"> <a  href="#!" class="btn btn-success">
            <?= lang('Membership.xin_current_plan');?>
            </a> </h6>
          <?php } else if($r['membership_id'] == 1) {?>
          <strong>
          <?= lang('Membership.xin_trial_version_text');?>
          </strong>
          <?php } else { ?>
          <div class="col text-right"> <a  href="<?= site_url('erp/upgrade-subscription/').uencode($r['membership_id']);?>"class="btn btn-outline-primary">
            <?= lang('Dashboard.dashboard_upgrade');?>
            </a> </div>
          <?php } ?>
        </div>
        <div class="table-responsive">
          <table class="table m-0 mt-3">
            <tbody>
              <tr>
                <td class="align-middle" width="300"><div class="m-0 d-inline-block align-middle font-16"> <a href="#!" class="text-body">
                    <h6 class="my-0">
                      <?= lang('Main.xin_id');?>
                      :
                      <?= $r['subscription_id']?>
                    </h6>
                    <small class="text-muted">
                    <?= lang('Dashboard.xin_total_employees');?>
                    <?= $r['total_employees']?>
                    </small> </a> </div></td>
                <td width="350"><h5>
                    <?= number_to_currency($converted, $xin_system['default_currency'],null,2);?>
                  </h5></td>
                <td class="text-left"><div class="text-left d-inline-block">
                    <h6 class="my-0">
                      <?= lang('Membership.xin_plan_duration');?>
                    </h6>
                    <small class="text-muted">
                    <?= $plan_duration?>
                    </small> </div></td>
              </tr>
            </tbody>
          </table>
        </div>
        <hr class="mt-0">
        <div class="row align-items-center justify-contact-between">
          <div class="col">
            <?= $r['description']?>
          </div>
          <div class="col text-right"> <span class="text-muted"><span class="text-muted"><a href="#!" class="btn btn-outline-success btn-sm delete" data-toggle="modal" data-target=".view-modal-data" data-field_id="<?= uencode($r['membership_id']);?>"><i class="feather icon-eye mr-1"></i>
            <?= lang('Main.xin_view_details');?>
            </a></span></span> </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
  <!-- membership list  end --> 
</div>
<hr>
<div class="p-2">
  <?= $pager->links() ?>
</div>

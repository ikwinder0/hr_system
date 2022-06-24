<?php
use CodeIgniter\I18n\Time;
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
$result = $UsersModel->where('user_id', $field_id)->first();
$company_membership = $CompanymembershipModel->where('company_id', $field_id)->first();
if($result['is_active'] == 1){
	$status = '<span class="text-success"><em class="fas fa-check-circle"></em> '.lang('Main.xin_employees_active').'</span>';
} else {
	$status = '<span class="text-danger"><em class="fas fa-check-circle"></em> '.lang('Main.xin_employees_inactive').'</span>';
}
?>
<?php $subs_plan = $MembershipModel->where('membership_id', $company_membership['membership_id'])->first(); ?>
<?php if($session->get('payment_made_successfully')){?>

<div class="alert alert-success alert-dismissible fade show">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?= $session->get('payment_made_successfully');?>
</div>
<?php } ?>
<?php
if($company_membership['subscription_type']==1):
	$subs_time = lang('Membership.xin_subscription_monthly');
	$subs_price = $subs_plan['price'];
elseif($company_membership['subscription_type']==2):
	$subs_time = lang('Membership.xin_subscription_monthly');
	$subs_price = $subs_plan['price'];
elseif($company_membership['subscription_type']==3):
	$subs_time = lang('Membership.xin_subscription_unlimit');
	$subs_price = $subs_plan['price'];
else:
	$subs_time = lang('Membership.xin_subscription_monthly');
	$subs_price = $subs_plan['price'];
endif;
$subs_price = currency_converter($subs_price);
$company_membership_details = company_membership_details($usession['sup_user_id']);
?>
<div class="row"> 
  <!-- current membership start -->
  <div class="col-12">
    <div class="card">
    <div class="card-header">
          <h5><?= lang('Membership.xin_current_plan');?></h5>
        </div>
      <div class="card-body">
        <div class="row align-items-center justify-contact-between">
          <div class="col">
            <div class="btn btn-primary"> <a href="#!" data-toggle="modal" data-target=".view-modal-data" data-field_id="<?= uencode($subs_plan['membership_id']);?>" class="text-white">
              <?= $subs_plan['membership_type']?>
              </a> </div>
          </div>
          <div class="col text-right"> <strong>
            <?= $company_membership_details['plan_msg'];?>
            </strong> </div>
        </div>
        <div class="table-responsive">
          <table class="table m-0 mt-3">
            <tbody>
              <tr>
                <td class="align-middle"><div class="m-0 d-inline-block align-middle font-16"> <a href="#!" class="text-body" data-toggle="modal" data-target=".view-modal-data" data-field_id="<?= uencode($subs_plan['membership_id']);?>">
                    <h6 class="my-0">
                      <?= lang('Main.xin_id');?>
                      :
                      <?= $subs_plan['subscription_id']?>
                    </h6>
                    <small class="text-muted">
                    <?= lang('Dashboard.xin_total_employees');?>
                    <?= $subs_plan['total_employees']?>
                    </small> </a> </div></td>
                <td><h5>
                    <?= number_to_currency($subs_price, $xin_system['default_currency'],null,2);?>
                  </h5></td>
                <td class="text-left"><div class="text-left d-inline-block">
                    <h6 class="my-0">
                      <?= lang('Membership.xin_plan_duration');?>
                    </h6>
                    <small class="text-muted">
                    <?= $company_membership_details['plan_duration'];?>
                    </small> </div></td>
              </tr>
            </tbody>
          </table>
        </div>
        <hr class="mt-0">
        <div class="row align-items-center justify-contact-between">
          <div class="col">
            <?= $subs_plan['description']?>
          </div>
          <div class="col text-right"> <span class="text-muted"><span class="text-muted"> <a href="<?= site_url('erp/subscription-list');?>" class="btn btn-outline-primary">
            <?= lang('Dashboard.dashboard_upgrade');?>
            </a></span></span> </div>
        </div>
      </div>
    </div>
  </div>
  <!-- current membership  end --> 
</div>
<div class="nk-block">
  <div class="card card-bordered">
    <div class="card-body">
      <div class="nk-help">
        <div class="nk-help-text">
          <h5>
            <?= lang('Membership.xin_we_are_here_to_help_you_text');?>
          </h5>
          <p class="text-soft">
            <?= lang('Membership.xin_ask_a_question_text');?>
          </p>
        </div>
        <div class="nk-help-action"> <a target="_blank" href="<?= site_url('contact');?>" class="btn btn-lg btn-outline-primary">
          <?= lang('Membership.xin_get_support_now');?>
          </a> </div>
      </div>
    </div>
  </div>
</div>

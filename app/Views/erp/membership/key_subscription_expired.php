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


/* Company Details view
*/		
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$xin_system = $SystemModel->where('setting_id', 1)->first();
$field_id = $request->uri->getSegment(3);
$membership_id = udecode($field_id);

$company_types = $ConstantsModel->where('type','company_type')->orderBy('constants_id', 'ASC')->findAll();
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
/////
//$result = $UsersModel->where('user_id', $field_id)->first();
//$company_membership = $CompanymembershipModel->where('membership_id', $result['membership_id'])->first();

$result = $UsersModel->where('user_id', $usession['sup_user_id'])->where('user_type','company')->first();
$membership = $MembershipModel->where('membership_id', $membership_id)->first();
?>

<div class="auth-wrapper maintance">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class=""> <img src="<?= base_url();?>/public/assets/images/maintance/maintance.png" alt="" class="img-fluid">
          <div class="alert alert-danger alert-dismissible" role="alert">
            <h5 class="alert-heading"><i class="feather icon-alert-circle mr-2"></i>
              <?= lang('Membership.xin_membership_plan');?>
            </h5>
            <p class="mb-0">
              <?= lang('Membership.company_plan_expired_msg');?>
            </p>
          </div>
        </div>
        <div class="">
          <p class="my-4">
            <?= lang('Membership.xin_thank_you_for_using_our_services');?>
          </p>
          <p class="my-4">
            <?= lang('Membership.renew_your_current_subscription');?>
            <strong>
            <?= $xin_system['email'];?>
            </strong></p>
            <p class="my-4 text-center">
          <a href="<?= site_url('erp/login');?>" class="btn waves-effect waves-light btn-primary mb-4 text-white"><i class="fas fa-user-lock d-blockd mr-2"></i>
          <?= lang('Login.xin_login');?></a>
          </a> </div>
      </div>
    </div>
  </div>
</div>

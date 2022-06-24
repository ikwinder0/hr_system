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

$xin_system = erp_company_settings();
$field_id = $request->uri->getSegment(3);
$membership_id = udecode($field_id);
$xin_super_system = $SystemModel->where('setting_id', 1)->first();

$company_types = $ConstantsModel->where('type','company_type')->orderBy('constants_id', 'ASC')->findAll();
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();

$result = $UsersModel->where('user_id', $usession['sup_user_id'])->where('user_type','company')->first();
$membership = $MembershipModel->where('membership_id', $membership_id)->first();
$converted = currency_converter($membership['price']);
?>
<div class="row">
    <div class="col-md-8">
        <div class="tab-content">
            <div class="tab-pane show active" id="payment-information">
                <div class="card">
                    <div class="card mb-0 shadow-none">
                        <div class="card-header">
                            <h5 class="mb-2"><?= lang('Membership.xin_payment_selection');?></h5>
                            <p class="text-muted mb-0"><?= lang('Membership.xin_one_payment_selection');?></p>
                        </div>
                    </div>
                    <div class="accordion" id="accordionExample">
                       <?php if($xin_super_system['paypal_active'] == 'yes'):?>
                        <div class="card mb-0 shadow-none border-top">
                            <div class="card-header" id="headingOne">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="BillingPaypal" name="billingOptions" class="custom-control-input" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" checked>
                                    <label class="custom-control-label font-weight-bold" for="BillingPaypal"><?= lang('Membership.xin_pay_with_paypal');?></label>
                                </div>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <?php $attributes = array('name' => 'paypal_process', 'id' => 'paypal_process', 'autocomplete' => 'off');?>
								<?php $hidden = array('paypal_info' => uencode($usession['sup_user_id']), 'token' => $field_id);?>
                                <?= form_open('erp/pay/paypal_process', $attributes, $hidden);?> 
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <p class="mb-0 pl-3 pt-1"><?= lang('Membership.xin_pay_with_paypal_text');?></p>
                                        </div>
                                        <div class="col-sm-4 text-sm-right mt-3 mt-sm-0">
                                            <img src="<?= base_url();?>/public/assets/images/product/paypal.png" class="hei-25" alt="payment-images">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                  <button type="submit" class="btn btn-danger text-sm-right mt-md-0 mt-2">
                                  <?= lang('Membership.xin_complete_order');?>
                                  </button>
                                </div>
                               <?= form_close(); ?> 
                            </div>
                        </div>
                        <?php endif;?>
                        <?php if($xin_super_system['stripe_active'] == 'yes'):?>
                        <div class="card mb-0 shadow-none border-top">
                            <div class="card-header" id="headingTwo">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="BillingCard" name="billingOptions" class="custom-control-input collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <label class="custom-control-label font-weight-bold" for="BillingCard"><?= lang('Membership.xin_pay_with_stripe');?></label>
                                </div>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <?php $attributes = array('name' => 'stripe_payment', 'id' => 'stripe_payment', 'autocomplete' => 'off');?>
							<?php $hidden = array('stripe_info' => uencode($usession['sup_user_id']), 'token' => $field_id);?>
                            <?= form_open('erp/stripe/payment', $attributes, $hidden);?>                            
                                <div class="card-body bg-light">
                                <span class="payment-errors alert"></span>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <p class="mb-0 pl-3 pt-1"><?= lang('Membership.xin_safe_money_transfer_options');?></p>
                                        </div>
                                        <div class="col-sm-4 text-sm-right mt-3 mt-sm-0">
                                            <img src="<?= base_url();?>/public/assets/images/product/card.png" height="24" alt="payment-images">
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="card-number"><?= lang('Membership.xin_card_number');?></label>
                                                <input type="text" id="card_number" class="form-control bg-transparent card-number" data-toggle="input-mask" data-mask-format="0000 0000 0000 0000" placeholder="4242 4242 4242 4242" name="card_number" value="4242 4242 4242 4242">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="card-name-on"><?= lang('Membership.xin_name_on_card');?></label>
                                                <input type="text" name="name" id="name" class="form-control bg-transparent" placeholder="Master Shreyu" value="TIME">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="card-expiry-date"><?= lang('Membership.xin_expiry_month');?></label>
                                                <input type="text" id="card_expiry" class="form-control bg-transparent card-expiry-month" data-toggle="input-mask" data-mask-format="00/00" placeholder="MM" name="card_exp_month" value="11">
                                            </div>
                                      </div>
                                      <div class="col-md-2">      
                                            <div class="form-group">
                                                <label for="card-expiry-date"><?= lang('Membership.xin_expiry_year');?></label>
                                                <input type="text" id="card_expiry" class="form-control bg-transparent card-expiry-year" data-toggle="input-mask" data-mask-format="00/00" placeholder="YYYY" name="card_exp_year" value="2022">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="card-cvv"><?= lang('Membership.xin_cvv_code');?></label>
                                                <input type="text" name="card_cvc" id="card_cvc" class="form-control bg-transparent card-cvc" data-toggle="input-mask" data-mask-format="000" placeholder="012" value="012">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                  <button id="payBtn" type="submit" class="btn btn-danger text-sm-right mt-md-0 mt-2">
                                  <?= lang('Membership.xin_complete_order');?>
                                  </button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
    if($membership['plan_duration']==1){
    	$plan_duration = lang('Membership.xin_subscription_monthly');
    } else if($membership['plan_duration']==2){
    	$plan_duration = lang('Membership.xin_subscription_yearly');
    } else {
    	$plan_duration = lang('Membership.xin_subscription_unlimit');
    }
    ?>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><?= lang('Membership.xin_complete_summary');?></h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item py-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="m-0 d-inline-block align-middle">
                                            <a href="#!" class="text-body font-weight-semibold"><?= $membership['membership_type'];?></a>
                                            <br>
                                            <small><?= lang('Membership.xin_subscription_id');?>: <?= $membership['subscription_id'];?></small>
                                        </p>
                                    </td>
                                    <td class="text-right">
                                        <?= number_to_currency($converted, $xin_system['default_currency'],null,2);?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
                <li class="list-group-item py-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="m-0 d-inline-block align-middle">
                                            <a href="#!" class="text-body font-weight-semibold"><?= lang('Main.xin_description');?></a>
                                            
                                            <br>
                                            <small><?= lang('Employees.xin_total_employees');?>: <?= $membership['total_employees'];?></small>
                                            <br>
                                            <small><?= lang('Membership.xin_plan_duration');?>: <?= $plan_duration;?></small>
                                            <br>
                                            <small><?= html_entity_decode($membership['description']);?></small>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>
            <div class="card-body py-2">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0 w-auto table-sm float-right text-right">
                        <tbody>
                            <tr>
                                <td>
                                    <h6 class="m-0"><?= lang('Invoices.xin_subtotal');?>:</h6>
                                </td>
                                <td>
                                    <?= number_to_currency($converted, $xin_system['default_currency'],null,2);?>
                                </td>
                            </tr>
                            <tr class="border-top">
                                <td>
                                    <h5 class="m-0"><?= lang('Main.xin_total');?>:</h5>
                                </td>
                                <td class="font-weight-semibold">
                                    <?= number_to_currency($converted, $xin_system['default_currency'],null,2);?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/*
* Profile View
*/
use CodeIgniter\I18n\Time;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\LanguageModel;
use App\Models\ConstantsModel;
use App\Models\MembershipModel;
use App\Models\CurrenciesModel;
use App\Models\CompanymembershipModel;

$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$CountryModel = new CountryModel();
$LanguageModel = new LanguageModel();
$ConstantsModel = new ConstantsModel();
$MembershipModel = new MembershipModel();
$CurrenciesModel = new CurrenciesModel();
$CompanymembershipModel = new CompanymembershipModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$result = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$company_types = $ConstantsModel->where('type','company_type')->orderBy('constants_id', 'ASC')->findAll();
$membership_plans = $MembershipModel->orderBy('membership_id', 'ASC')->findAll();
$company_membership = $CompanymembershipModel->where('company_id', $usession['sup_user_id'])->first();
$status = '<span class="badge badge-light-success"><em class="icon ni ni-check-circle"></em> '.lang('Main.xin_employees_active').'</span>';
$status_label = '<i class="fas fa-certificate text-success bg-icon"></i><i class="fas fa-check front-icon text-white"></i>';

$currency = $ConstantsModel->where('type','currency_type')->orderBy('constants_id', 'ASC')->findAll();
$language = $LanguageModel->where('is_active', 1)->orderBy('language_id', 'ASC')->findAll();
$currency_list = $CurrenciesModel->orderBy('currency_id', 'ASC')->findAll();
$xin_system = erp_company_settings();
?>

<div class="row">
  <div class="col-lg-4">
    <div class="card user-card user-card-1">
      <div class="card-body pb-0">
        <div class="float-right">
          <?= $status;?>
        </div>
        <div class="media user-about-block align-items-center mt-0 mb-3">
          <div class="position-relative d-inline-block">
            <img src="<?= staff_profile_photo($result['user_id']);?>" alt="" class="d-block img-radius img-fluid wid-80">
            <div class="certificated-badge">
              <?= $status_label;?>
            </div>
          </div>
          <div class="media-body ml-3">
            <h6 class="mb-1">
              <?= $result['first_name'].' '.$result['last_name'];?>
            </h6>
            <p class="mb-0 text-muted">@
              <?= $result['username'];?>
            </p>
          </div>
        </div>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"> <span class="f-w-500"><i class="feather icon-mail m-r-10"></i>
          <?= lang('Main.xin_email');?>
          </span> <a href="mailto:<?= $result['email'];?>" class="float-right text-body">
          <?= $result['email'];?>
          </a> </li>
        <li class="list-group-item"> <span class="f-w-500"><i class="feather icon-phone-call m-r-10"></i>
          <?= lang('Main.xin_phone');?>
          </span> <a href="#" class="float-right text-body">
          <?= $result['contact_number'];?>
          </a> </li>
      </ul>
      <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical"> <a class="nav-link list-group-item list-group-item-action active" id="account-settings-tab" data-toggle="pill" href="#account-settings" role="tab" aria-controls="account-settings" aria-selected="true"> <span class="f-w-500"><i class="feather icon-disc m-r-10 h5 "></i>
      <?= lang('Main.xin_account_settings');?>
      </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-edit-account-tab" data-toggle="pill" href="#user-edit-account" role="tab" aria-controls="user-edit-account" aria-selected="true"> <span class="f-w-500"><i class="feather icon-user m-r-10 h5 "></i>
        <?= lang('Main.xin_personal_info');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-profile-logo-tab" data-toggle="pill" href="#user-profile-logo" role="tab" aria-controls="user-profile-logo" aria-selected="false"> <span class="f-w-500"><i class="feather icon-image m-r-10 h5 "></i>
        <?= lang('Main.xin_e_details_profile_picture');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-companyinfo-tab" data-toggle="pill" href="#user-companyinfo" role="tab" aria-controls="user-companyinfo" aria-selected="false"> <span class="f-w-500"><i class="feather icon-file-text m-r-10 h5 "></i>
        <?= lang('Main.xin_company_info');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-password-tab" data-toggle="pill" href="#user-password" role="tab" aria-controls="user-password" aria-selected="false"> <span class="f-w-500"><i class="feather icon-shield m-r-10 h5 "></i>
        <?= lang('Main.header_change_password');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> </div>
    </div>
  </div>
  <div class="col-xl-8 col-lg-12">
    <div class="card tab-content">
      <div class="tab-pane fade active show" id="account-settings" role="tabpanel" aria-labelledby="account-settings-tab">
        <div class="card-header">
          <h5><i data-feather="disc" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_account_settings');?>
            </span></h5>
        </div>
        <div class="card-body">
          <?php $attributes = array('name' => 'system_info', 'id' => 'system_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => uencode($usession['sup_user_id']));?>
          <?= form_open('erp/profile/system_info', $attributes, $hidden);?>
          <div class="bg-white">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_ci_default_language');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="default_language" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_ci_default_language');?>">
                    <?php foreach($language as $lang):?>
                    <option value="<?= $lang['language_code'];?>" <?php if($xin_system['default_language']==$lang['language_code']){?> selected <?php }?>>
                    <?= $lang['language_name'];?>
                    </option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_date_format');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="date_format" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_date_format');?>">
                    <option value="">
                    <?= lang('Main.xin_select_one');?>
                    </option>
                    <option value="Y-m-d" <?php if($xin_system['date_format_xi']=='Y-m-d'){?> selected <?php }?>>Format: <?= date('Y-m-d');?></option>
                    <option value="Y-d-m" <?php if($xin_system['date_format_xi']=='Y-d-m'){?> selected <?php }?>>Format: <?= date('Y-d-m');?></option>
                    <option value="d-m-Y" <?php if($xin_system['date_format_xi']=='d-m-Y'){?> selected <?php }?>>Format: <?= date('d-m-Y');?></option>
                    <option value="m-d-Y" <?php if($xin_system['date_format_xi']=='m-d-Y'){?> selected <?php }?>>Format: <?= date('m-d-Y');?></option>
                    <option value="Y/m/d" <?php if($xin_system['date_format_xi']=='Y/m/d'){?> selected <?php }?>>Format: <?= date('Y/m/d');?></option>
                    <option value="Y/d/m" <?php if($xin_system['date_format_xi']=='Y/d/m'){?> selected <?php }?>>Format: <?= date('Y/d/m');?></option>
                    <option value="d/m/Y" <?php if($xin_system['date_format_xi']=='d/m/Y'){?> selected <?php }?>>Format: <?= date('d/m/Y');?></option>
                    <option value="m/d/Y" <?php if($xin_system['date_format_xi']=='m/d/Y'){?> selected <?php }?>>Format: <?= date('m/d/Y');?></option>
                    <option value="Y.m.d" <?php if($xin_system['date_format_xi']=='Y.m.d'){?> selected <?php }?>>Format: <?= date('Y.m.d');?></option>
                    <option value="Y.d.m" <?php if($xin_system['date_format_xi']=='Y.d.m'){?> selected <?php }?>>Format: <?= date('Y.d.m');?></option>
                    <option value="d.m.Y" <?php if($xin_system['date_format_xi']=='d.m.Y'){?> selected <?php }?>>Format: <?= date('d.m.Y');?></option>
                    <option value="m.d.Y" <?php if($xin_system['date_format_xi']=='m.d.Y'){?> selected <?php }?>>Format: <?= date('m.d.Y');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_default_currency');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="default_currency" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_default_currency');?>">
                   <?php foreach($currency_list as $_currency):?>
   					<option value="<?= $_currency['currency_code'];?>" <?php if($xin_system['default_currency']==$_currency['currency_code']):?> selected="selected"<?php endif;?>>
					<?= $_currency['currency_name'].' - '.$_currency['currency_code'];?></option>
                	<?php endforeach;?>
                </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_setting_timezone');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="system_timezone" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_setting_timezone');?>">
                    <option value="">
                    <?= lang('Main.xin_select_one');?>
                    </option>
                    <?php foreach(generate_timezone_list() as $tval=>$labels):?>
                    <option value="<?= $tval;?>" <?php if($xin_system['system_timezone']==$tval){?> selected <?php }?>>
                    <?= $labels;?>
                    </option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
            </div> 
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_invoice_terms_condition');?>
                    <span class="text-danger">*</span> </label>
                  <textarea class="form-control" name="invoice_terms_condition" rows="3"><?= $xin_system['invoice_terms_condition'];?>
</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary">
          <?= lang('Main.xin_save');?>
          </button>
        </div>
        <?= form_close(); ?>
    </div>
    <div class="tab-pane fade" id="user-edit-account">
      <div class="card-header">
          <h5><i data-feather="user" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_personal_info');?>
            </span></h5>
        </div>
        <?php $attributes = array('name' => 'edit_user', 'id' => 'edit_user', 'autocomplete' => 'off');?>
        <?php $hidden = array('token' => uencode($usession['sup_user_id']));?>
        <?= form_open('erp/profile/update_profile', $attributes, $hidden);?>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="company_name">
                  <?= lang('Main.xin_employee_first_name');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Main.xin_employee_first_name');?>" name="first_name" type="text" value="<?= $result['first_name'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="last_name" class="control-label">
                  <?= lang('Main.xin_employee_last_name');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_employee_last_name');?>" name="last_name" type="text" value="<?= $result['last_name'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="email">
                  <?= lang('Main.xin_email');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email" type="email" value="<?= $result['email'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="email">
                  <?= lang('Main.dashboard_username');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.dashboard_username');?>" name="username" type="text" value="<?= $result['username'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="contact_number">
                  <?= lang('Main.xin_contact_number');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text" value="<?= $result['contact_number'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="gender" class="control-label">
                  <?= lang('Main.xin_employee_gender');?>
                </label>
                <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_gender');?>">
                  <option value="1" <?php if('1'==$result['gender']):?> selected="selected"<?php endif;?>>
                  <?= lang('Main.xin_gender_male');?>
                  </option>
                  <option value="2"<?php if('2'==$result['gender']):?> selected="selected"<?php endif;?>>
                  <?= lang('Main.xin_gender_female');?>
                  </option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="country">
                  <?= lang('Main.xin_country');?>
                  <span class="text-danger">*</span> </label>
                <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_country');?>">
                  <option value="">
                  <?= lang('Main.xin_select_one');?>
                  </option>
                  <?php foreach($all_countries as $country) {?>
                  <option value="<?= $country['country_id'];?>" <?php if($country['country_id']==$result['country']):?> selected="selected"<?php endif;?>>
                  <?= $country['country_name'];?>
                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="address_1">
                  <?= lang('Main.xin_address');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_address');?>" name="address_1" type="text" value="<?= $result['address_1'];?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="address_2"> &nbsp;</label>
                <input class="form-control" placeholder="<?= lang('Main.xin_address_2');?>" name="address_2" type="text" value="<?= $result['address_2'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="city">
                  <?= lang('Main.xin_city');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_city');?>" name="city" type="text" value="<?= $result['city'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="state">
                  <?= lang('Main.xin_state');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_state');?>" name="state" type="text" value="<?= $result['state'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="zipcode">
                  <?= lang('Main.xin_zipcode');?>
                  <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_zipcode');?>" name="zipcode" type="text" value="<?= $result['zipcode'];?>">
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
        </div>
        <?= form_close(); ?>
      </div>
      <div class="tab-pane fade" id="user-profile-logo">
      <div class="card-header">
          <h5><i data-feather="image" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_e_details_profile_picture');?>
            </span></h5>
        </div>
        <?php $attributes = array('name' => 'edit_user_photo', 'id' => 'edit_user_photo', 'autocomplete' => 'off');?>
        <?php $hidden = array('token' => uencode($usession['sup_user_id']));?>
        <?= form_open('erp/profile/update_profile_photo', $attributes, $hidden);?>
        <div class="card-body pb-2">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="logo">
                  <?= lang('Company.xin_company_logo');?>
                  <span class="text-danger">*</span> </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="file">
                  <label class="custom-file-label">
                    <?= lang('Main.xin_choose_file');?>
                  </label>
                  <small>
                  <?= lang('Main.xin_company_file_type');?>
                  </small> </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
        </div>
        <?= form_close(); ?>
      </div>
      <div class="tab-pane fade" id="user-password" role="tabpanel" aria-labelledby="user-password-tab">
        <div class="alert alert-warning" role="alert">
          <h5 class="alert-heading"><i class="feather icon-alert-circle mr-2"></i><?= lang('Main.xin_alert');?></h5>
          <p><?= lang('Main.xin_dont_share_password');?></p>
        </div>
        <div class="card-header">
          <h5><i data-feather="shield" class="icon-svg-primary wid-20"></i><span class="p-l-5"><?= lang('Main.header_change_password');?></span></h5>
        </div>
        <?php $attributes = array('name' => 'change_password', 'id' => 'change_password', 'autocomplete' => 'off');?>
        <?php $hidden = array('token' => uencode($usession['sup_user_id']));?>
        <?= form_open('erp/profile/update_password', $attributes, $hidden);?>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>
                  <?= lang('Main.xin_current_password');?>
                </label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                  <input type="password" readonly="readonly" class="form-control" name="pass" placeholder="<?= lang('Main.xin_current_password');?>" value="********">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>
                  <?= lang('Main.xin_new_password');?>
                  <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                  <input type="password" class="form-control" name="new_password" placeholder="<?= lang('Main.xin_new_password');?>">
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>
                  <?= lang('Main.xin_repeat_new_password');?>
                  <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye"></i></span></div>
                  <input type="password" class="form-control" name="confirm_password" placeholder="<?= lang('Main.xin_repeat_new_password');?>">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-danger"><?= lang('Main.header_change_password');?></button>
        </div>
        <?= form_close(); ?>
      </div>
      <div class="tab-pane fade" id="user-companyinfo">
      <div class="card-header">
          <h5><i data-feather="file-text" class="icon-svg-primary wid-20"></i><span class="p-l-5">
            <?= lang('Main.xin_company_info');?>
            </span></h5>
        </div>
        <div class="card-body pb-2">
          <?php $attributes = array('name' => 'company_info', 'id' => 'company_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => uencode($usession['sup_user_id']));?>
          <?= form_open('erp/profile/update_company_info', $attributes, $hidden);?>
          <div class="form-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="company_name">
                    <?= lang('Company.xin_company_name');?>
                    <span class="text-danger">*</span> </label>
                  <input class="form-control" placeholder="<?= lang('Company.xin_company_name');?>" name="company_name" type="text" value="<?= $user_info['company_name'];?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">
                    <?= lang('Company.xin_company_type');?>
                    <span class="text-danger">*</span> </label>
                  <select class="form-control" name="company_type" data-plugin="select_hrm" data-placeholder="<?= lang('Company.xin_company_type');?>">
                    <option value="">
                    <?= lang('Main.xin_select_one');?>
                    </option>
                    <?php foreach($company_types as $ctype) {?>
                    <option value="<?= $ctype['constants_id'];?>" <?php if($user_info['company_type_id']==$ctype['constants_id']){?> selected="selected" <?php } ?>>
                    <?= $ctype['category_name'];?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="trading_name">
                    <?= lang('Company.xin_company_trading');?>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Company.xin_company_trading');?>" name="trading_name" type="text" value="<?= $user_info['trading_name'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="xin_gtax">
                    <?= lang('Company.xin_gtax');?>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Company.xin_gtax');?>" name="xin_gtax" type="text" value="<?= $user_info['government_tax'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="registration_no">
                    <?= lang('Company.xin_company_registration');?>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Company.xin_company_registration');?>" name="registration_no" type="text" value="<?= $user_info['registration_no'];?>">
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

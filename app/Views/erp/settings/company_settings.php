<?php
/*
* System Settings - Settings View
*/
?>
<?php
use App\Models\LanguageModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;
$LanguageModel = new LanguageModel();
$SystemModel = new SystemModel();
$ConstantsModel = new ConstantsModel();

$currency = $ConstantsModel->where('type','currency_type')->orderBy('constants_id', 'ASC')->findAll();
$language = $LanguageModel->where('is_active', 1)->orderBy('language_id', 'ASC')->findAll();
$xin_system = erp_company_settings();
$company_types = $ConstantsModel->where('type','company_type')->orderBy('constants_id', 'ASC')->findAll();
?>

<div id="smarsdstwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item active"> <a href="<?= site_url('erp/company-settings');?>" class="mb-3 nav-link ci-link"><span class="sw-icon fas fa-cog"></span>
      <?= lang('Main.left_settings');?>
      <div class="text-muted small">
        <?= lang('Main.header_configuration');?>
      </div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/company-constants');?>" class="mb-3 nav-link ci-link"> <span class="sw-icon fas fa-adjust"></span>
      <?= lang('Main.left_constants');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up_all_types');?>
      </div>
      </a> </li>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card overflow-hidden">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links"> <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-settings"><i class="ion ion-ios-heart text-lightest"></i>
        <?= lang('Main.xin_system');?>
        </a> </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane fade show active" id="account-settings">
          <div class="card-body pb-2">
            <div class="card-block">
              <?php $attributes = array('name' => 'system_info', 'id' => 'system_info', 'autocomplete' => 'off');?>
              <?php $hidden = array('u_basic_info' => 'UPDATE');?>
              <?= form_open('erp/settings/system_info', $attributes, $hidden);?>
              <div class="bg-white">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label">
                        <?= lang('Main.xin_date_format');?>
                        <span class="text-danger">*</span> </label>
                      <select class="form-control" name="date_format" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_date_format');?>">
                        <option value="">
                        <?= lang('Main.xin_select_one');?>
                        </option>
                        <option value="d-m-Y" <?php if($xin_system['date_format_xi']=='d-m-Y'){?> selected <?php }?>>dd-mm-YYYY (
                        <?= date('d-m-Y');?>
                        )</option>
                        <option value="m-d-Y" <?php if($xin_system['date_format_xi']=='m-d-Y'){?> selected <?php }?>>mm-dd-YYYY (
                        <?= date('m-d-Y');?>
                        )</option>
                        <option value="d-M-Y" <?php if($xin_system['date_format_xi']=='d-M-Y'){?> selected <?php }?>>dd-MM-YYYY (
                        <?= date('d-M-Y');?>
                        )</option>
                        <option value="M-d-Y" <?php if($xin_system['date_format_xi']=='M-d-Y'){?> selected <?php }?>>MM-dd-YYYY (
                        <?= date('M-d-Y');?>
                        )</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label">
                        <?= lang('Main.xin_setting_timezone');?>
                        <span class="text-danger">*</span> </label>
                      <select class="form-control" name="system_timezone" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_setting_timezone');?>">
                        <option value="">
                        <?= lang('Main.xin_select_one');?>
                        </option>
                        <?php foreach(all_timezones() as $tval=>$labels):?>
                        <option value="<?= $tval;?>" <?php if($xin_system['system_timezone']==$tval){?> selected <?php }?>>
                        <?= $labels;?>
                        </option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label">
                        <?= lang('Main.xin_default_currency');?>
                        <span class="text-danger">*</span> </label>
                      <?php /*?><select class="form-control" name="default_currency" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_default_currency');?>" tabindex="-1" aria-hidden="true">
                        <option value="">
                        <?= lang('Main.xin_select_one');?>
                        </option>
                        <?php foreach($currency as $icurrency){?>
                        <?php $_currency = $icurrency['field_one'].' - '.$icurrency['field_two'];?>
                        <option value="<?= $icurrency['field_one'];?>" <?php if($xin_system['default_currency']==$icurrency['field_one']):?> selected="selected"<?php endif;?>>
                        <?= $_currency;?>
                        </option>
                        <?php } ?>
                      </select><?php */?>
                      <select class="form-control" name="default_currency" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_default_currency');?>">
    			<option value="USD" <?php if($xin_system['default_currency']=='USD'):?> selected="selected"<?php endif;?>>United States Dollars</option>
                <option value="EUR" <?php if($xin_system['default_currency']=='EUR'):?> selected="selected"<?php endif;?>>Euro</option>
                <option value="GBP" <?php if($xin_system['default_currency']=='GBP'):?> selected="selected"<?php endif;?>>United Kingdom Pounds</option>
                <option value="DZD" <?php if($xin_system['default_currency']=='DZD'):?> selected="selected"<?php endif;?>>Algeria Dinars</option>
                <option value="ARP" <?php if($xin_system['default_currency']=='ARP'):?> selected="selected"<?php endif;?>>Argentina Pesos</option>
                <option value="AUD" <?php if($xin_system['default_currency']=='AUD'):?> selected="selected"<?php endif;?>>Australia Dollars</option>
                <option value="ATS" <?php if($xin_system['default_currency']=='ATS'):?> selected="selected"<?php endif;?>>Austria Schillings</option>
                <option value="BSD" <?php if($xin_system['default_currency']=='BSD'):?> selected="selected"<?php endif;?>>Bahamas Dollars</option>
                <option value="BBD" <?php if($xin_system['default_currency']=='BBD'):?> selected="selected"<?php endif;?>>Barbados Dollars</option>
                <option value="BEF" <?php if($xin_system['default_currency']=='BEF'):?> selected="selected"<?php endif;?>>Belgium Francs</option>
                <option value="BMD" <?php if($xin_system['default_currency']=='BMD'):?> selected="selected"<?php endif;?>>Bermuda Dollars</option>
                <option value="BRR" <?php if($xin_system['default_currency']=='BRR'):?> selected="selected"<?php endif;?>>Brazil Real</option>
                <option value="BGL" <?php if($xin_system['default_currency']=='BGL'):?> selected="selected"<?php endif;?>>Bulgaria Lev</option>
                <option value="CAD" <?php if($xin_system['default_currency']=='CAD'):?> selected="selected"<?php endif;?>>Canada Dollars</option>
                <option value="CLP" <?php if($xin_system['default_currency']=='CLP'):?> selected="selected"<?php endif;?>>Chile Pesos</option>
                <option value="CNY" <?php if($xin_system['default_currency']=='CNY'):?> selected="selected"<?php endif;?>>China Yuan Renmimbi</option>
                <option value="CYP" <?php if($xin_system['default_currency']=='CYP'):?> selected="selected"<?php endif;?>>Cyprus Pounds</option>
                <option value="CSK" <?php if($xin_system['default_currency']=='CSK'):?> selected="selected"<?php endif;?>>Czech Republic Koruna</option>
                <option value="DKK" <?php if($xin_system['default_currency']=='DKK'):?> selected="selected"<?php endif;?>>Denmark Kroner</option>
                <option value="NLG" <?php if($xin_system['default_currency']=='NLG'):?> selected="selected"<?php endif;?>>Dutch Guilders</option>
                <option value="XCD" <?php if($xin_system['default_currency']=='XCD'):?> selected="selected"<?php endif;?>>Eastern Caribbean Dollars</option>
                <option value="EGP" <?php if($xin_system['default_currency']=='EGP'):?> selected="selected"<?php endif;?>>Egypt Pounds</option>
                <option value="FJD" <?php if($xin_system['default_currency']=='FJD'):?> selected="selected"<?php endif;?>>Fiji Dollars</option>
                <option value="FIM" <?php if($xin_system['default_currency']=='FIM'):?> selected="selected"<?php endif;?>>Finland Markka</option>
                <option value="FRF" <?php if($xin_system['default_currency']=='FRF'):?> selected="selected"<?php endif;?>>France Francs</option>
                <option value="DEM" <?php if($xin_system['default_currency']=='DEM'):?> selected="selected"<?php endif;?>>Germany Deutsche Marks</option>
                <option value="XAU" <?php if($xin_system['default_currency']=='XAU'):?> selected="selected"<?php endif;?>>Gold Ounces</option>
                <option value="GRD" <?php if($xin_system['default_currency']=='GRD'):?> selected="selected"<?php endif;?>>Greece Drachmas</option>
                <option value="HKD" <?php if($xin_system['default_currency']=='HKD'):?> selected="selected"<?php endif;?>>Hong Kong Dollars</option>
                <option value="HUF" <?php if($xin_system['default_currency']=='HUF'):?> selected="selected"<?php endif;?>>Hungary Forint</option>
                <option value="ISK" <?php if($xin_system['default_currency']=='ISK'):?> selected="selected"<?php endif;?>>Iceland Krona</option>
                <option value="INR" <?php if($xin_system['default_currency']=='INR'):?> selected="selected"<?php endif;?>>India Rupees</option>
                <option value="IDR" <?php if($xin_system['default_currency']=='IDR'):?> selected="selected"<?php endif;?>>Indonesia Rupiah</option>
                <option value="IEP" <?php if($xin_system['default_currency']=='IEP'):?> selected="selected"<?php endif;?>>Ireland Punt</option>
                <option value="ILS" <?php if($xin_system['default_currency']=='ILS'):?> selected="selected"<?php endif;?>>Israel New Shekels</option>
                <option value="ITL" <?php if($xin_system['default_currency']=='ITL'):?> selected="selected"<?php endif;?>>Italy Lira</option>
                <option value="JMD" <?php if($xin_system['default_currency']=='JMD'):?> selected="selected"<?php endif;?>>Jamaica Dollars</option>
                <option value="JPY" <?php if($xin_system['default_currency']=='JPY'):?> selected="selected"<?php endif;?>>Japan Yen</option>
                <option value="JOD" <?php if($xin_system['default_currency']=='JOD'):?> selected="selected"<?php endif;?>>Jordan Dinar</option>
                <option value="KRW" <?php if($xin_system['default_currency']=='KRW'):?> selected="selected"<?php endif;?>>Korea (South) Won</option>
                <option value="LBP" <?php if($xin_system['default_currency']=='LBP'):?> selected="selected"<?php endif;?>>Lebanon Pounds</option>
                <option value="LUF" <?php if($xin_system['default_currency']=='LUF'):?> selected="selected"<?php endif;?>>Luxembourg Francs</option>
                <option value="MYR" <?php if($xin_system['default_currency']=='MYR'):?> selected="selected"<?php endif;?>>Malaysia Ringgit</option>
                <option value="MXP" <?php if($xin_system['default_currency']=='MXP'):?> selected="selected"<?php endif;?>>Mexico Pesos</option>
                <option value="NLG" <?php if($xin_system['default_currency']=='NLG'):?> selected="selected"<?php endif;?>>Netherlands Guilders</option>
                <option value="NZD" <?php if($xin_system['default_currency']=='NZD'):?> selected="selected"<?php endif;?>>New Zealand Dollars</option>
                <option value="NOK" <?php if($xin_system['default_currency']=='NOK'):?> selected="selected"<?php endif;?>>Norway Kroner</option>
                <option value="PKR" <?php if($xin_system['default_currency']=='PKR'):?> selected="selected"<?php endif;?>>Pakistan Rupees</option>
                <option value="XPD" <?php if($xin_system['default_currency']=='XPD'):?> selected="selected"<?php endif;?>>Palladium Ounces</option>
                <option value="PHP" <?php if($xin_system['default_currency']=='PHP'):?> selected="selected"<?php endif;?>>Philippines Pesos</option>
                <option value="XPT" <?php if($xin_system['default_currency']=='XPT'):?> selected="selected"<?php endif;?>>Platinum Ounces</option>
                <option value="PLZ" <?php if($xin_system['default_currency']=='PLZ'):?> selected="selected"<?php endif;?>>Poland Zloty</option>
                <option value="PTE" <?php if($xin_system['default_currency']=='PTE'):?> selected="selected"<?php endif;?>>Portugal Escudo</option>
                <option value="ROL" <?php if($xin_system['default_currency']=='ROL'):?> selected="selected"<?php endif;?>>Romania Leu</option>
                <option value="RUR" <?php if($xin_system['default_currency']=='RUR'):?> selected="selected"<?php endif;?>>Russia Rubles</option>
                <option value="SAR" <?php if($xin_system['default_currency']=='SAR'):?> selected="selected"<?php endif;?>>Saudi Arabia Riyal</option>
                <option value="XAG" <?php if($xin_system['default_currency']=='XAG'):?> selected="selected"<?php endif;?>>Silver Ounces</option>
                <option value="SGD" <?php if($xin_system['default_currency']=='SGD'):?> selected="selected"<?php endif;?>>Singapore Dollars</option>
                <option value="SKK" <?php if($xin_system['default_currency']=='SKK'):?> selected="selected"<?php endif;?>>Slovakia Koruna</option>
                <option value="ZAR" <?php if($xin_system['default_currency']=='ZAR'):?> selected="selected"<?php endif;?>>South Africa Rand</option>
                <option value="KRW" <?php if($xin_system['default_currency']=='KRW'):?> selected="selected"<?php endif;?>>South Korea Won</option>
                <option value="ESP" <?php if($xin_system['default_currency']=='ESP'):?> selected="selected"<?php endif;?>>Spain Pesetas</option>
                <option value="XDR" <?php if($xin_system['default_currency']=='XDR'):?> selected="selected"<?php endif;?>>Special Drawing Right (IMF)</option>
                <option value="SDD" <?php if($xin_system['default_currency']=='SDD'):?> selected="selected"<?php endif;?>>Sudan Dinar</option>
                <option value="SEK" <?php if($xin_system['default_currency']=='SEK'):?> selected="selected"<?php endif;?>>Sweden Krona</option>
                <option value="CHF" <?php if($xin_system['default_currency']=='CHF'):?> selected="selected"<?php endif;?>>Switzerland Francs</option>
                <option value="TWD" <?php if($xin_system['default_currency']=='TWD'):?> selected="selected"<?php endif;?>>Taiwan Dollars</option>
                <option value="THB" <?php if($xin_system['default_currency']=='THB'):?> selected="selected"<?php endif;?>>Thailand Baht</option>
                <option value="TTD" <?php if($xin_system['default_currency']=='TTD'):?> selected="selected"<?php endif;?>>Trinidad and Tobago Dollars</option>
                <option value="TRL" <?php if($xin_system['default_currency']=='TRL'):?> selected="selected"<?php endif;?>>Turkey Lira</option>
                <option value="VEB" <?php if($xin_system['default_currency']=='VEB'):?> selected="selected"<?php endif;?>>Venezuela Bolivar</option>
                <option value="ZMK" <?php if($xin_system['default_currency']=='ZMK'):?> selected="selected"<?php endif;?>>Zambia Kwacha</option>
                <option value="XCD" <?php if($xin_system['default_currency']=='XCD'):?> selected="selected"<?php endif;?>>Eastern Caribbean Dollars</option>
                <option value="XDR" <?php if($xin_system['default_currency']=='XDR'):?> selected="selected"<?php endif;?>>Special Drawing Right (IMF)</option>
                <option value="XAG" <?php if($xin_system['default_currency']=='XAG'):?> selected="selected"<?php endif;?>>Silver Ounces</option>
                <option value="XAU" <?php if($xin_system['default_currency']=='XAU'):?> selected="selected"<?php endif;?>>Gold Ounces</option>
                <option value="XPD" <?php if($xin_system['default_currency']=='XPD'):?> selected="selected"<?php endif;?>>Palladium Ounces</option>
                <option value="XPT" <?php if($xin_system['default_currency']=='XPT'):?> selected="selected"<?php endif;?>>Platinum Ounces</option>
                </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  
                  <div class="col-md-4">
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
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label">
                        <?= lang('Main.xin_ci_dashboard_options');?>
                        <span class="text-danger">*</span> </label>
                      <select class="form-control" name="dashboard_option" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_select_one');?>">
                        <option value="">
                        <?= lang('Main.xin_select_one');?>
                        </option>
                        <option value="dashboard_1" <?php if($xin_system['dashboard_option']=='dashboard_1'){?> selected <?php }?>>
                        <?= lang('Main.xin_ci_dashboard_option_1');?>
                        </option>
                        <option value="dashboard_light_2" <?php if($xin_system['dashboard_option']=='dashboard_light_2'){?> selected <?php }?>>
                        <?= lang('Main.xin_ci_dashboard_2light');?>
                        </option>
                        <option value="dashboard_dark_2" <?php if($xin_system['dashboard_option']=='dashboard_dark_2'){?> selected <?php }?>>
                        <?= lang('Main.xin_ci_dashboard_2dark');?>
                        </option>
                        <option value="dashboard_3" <?php if($xin_system['dashboard_option']=='dashboard_3'){?> selected <?php }?>>
                        <?= lang('Main.xin_ci_dashboard_option_3');?>
                        </option>
                      </select>
                      <br />
                      <small class="text-muted"><i class="fas fa-hand-point-up"></i>
                      <?= lang('Main.xin_ci_dashboard_options_details');?>
                      </small> </div>
                  </div>
                </div>
                <div class="row">
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">
                        <?= lang('Main.xin_invoice_terms_condition');?>
                        <span class="text-danger">*</span> </label>
                      <textarea class="form-control" name="invoice_terms_condition" rows="2"><?= $xin_system['invoice_terms_condition'];?>
</textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">
                        <?= lang('Main.xin_login_page_text');?>
                        <span class="text-danger">*</span> </label>
                      <textarea class="form-control" name="login_page_text" id="login_page_text" rows="2"><?= $xin_system['login_page_text'];?>
</textarea>
                      <small class="text-muted"><i class="fas fa-hand-point-up"></i>
                      <?= lang('Main.xin_login_page_text_desc');?>
                      </small> </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="form-actions box-footer">
                        <button type="submit" class="btn btn-primary"> <i class="far fa-check-square"></i>
                        <?= lang('Main.xin_save');?>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?= form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
use App\Models\LanguageModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;

$LanguageModel = new LanguageModel();
$SystemModel = new SystemModel();
$CountryModel = new CountryModel();
$ConstantsModel = new ConstantsModel();
$ci_xin_system = erp_company_settings();
$xin_system = $SystemModel->where('setting_id', 1)->first();
$currency_val = unserialize($xin_system['currency_converter']);

if(!$sock = @fsockopen('www.google.com', 80)) { ?>
<div class="alert alert-danger" role="alert">
    <?= lang('Main.xin_lost_internet_connectivity');?>
</div>
<?php
} else {
?>
<?php $currency_values = currency_converter_values();?>
<div class="container">
  <div class="row justify-content-md-center">
    <div class="card ">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_currency_converter');?><br />
          <small class="text-muted">
    		Your selected currency is <strong class="text-success"><?= $ci_xin_system['default_currency'];?></strong></small>
        </h5>
      </div>
      <?php $attributes = array('name' => 'update_currency', 'id' => 'update_currency', 'autocomplete' => 'off');?>
	  <?php $hidden = array('u_basic_info' => 'UPDATE');?>
      <?= form_open('erp/settings/update_currency', $attributes, $hidden);?>
      <div class="card-body">
        <div class="alert alert-primary">
          <div class="media align-items-center"> <i class="feather icon-link "></i>
            <div class="media-body ml-1">
              <a target="_blank" href="https://api.exchangerate-api.com/v4/latest/<?= $ci_xin_system['default_currency'];?>">https://api.exchangerate-api.com/v4/latest/<?= $ci_xin_system['default_currency'];?></a>
            </div>
          </div>
        </div>
        <div class="row">
          <?php $i=0;foreach($currency_values as $rates=>$val){ ?>
          <div class="col-md-2">
            	<div class="form-group">
                  <label for="demo-tel-input" class="col-form-label">
                    <?= $rates;?>
                  </label>
                  <input class="form-control" type="text" value="<?= $val;?>" name="currency_val[<?= $rates;?>]">
                </div>
          </div>
          <?php $i++; } ?>
        </div>
      </div>
      <div class="card-footer text-right">
        <button class="btn btn-primary" type="submit">
        <?= lang('Main.xin_update_system_currency');?>
        </button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>
<?php } ?>
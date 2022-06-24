<?php
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;
$LanguageModel = new LanguageModel();
$SystemModel = new SystemModel();
$CountryModel = new CountryModel();
$UsersModel = new UsersModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$router = service('router');

$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$language = $LanguageModel->where('is_active', 1)->orderBy('language_id', 'ASC')->findAll();
$xin_system = $SystemModel->where('setting_id', 1)->first();
?>
<?php
/*
* System Constants - Constants View
*/
?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('settings1',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/system-settings');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-settings"></span>
      <?= lang('Main.left_settings');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.left_settings');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('settings2',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/system-constants');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-activity"></span>
      <?= lang('Main.left_constants');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.left_constants');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('settings3',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/email-templates');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-mail"></span>
      <?= lang('Main.left_email_templates');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.left_email_templates');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('settings7',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/sms-templates');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-message-circle"></span>
      <?= lang('Main.xin_sms_templates');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.xin_sms_templates');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('settings4',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/all-languages');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-flag"></span>
      <?= lang('Main.xin_multi_language');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.xin_multi_language');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row">
<!-- start -->
<div class="col-lg-3">
  <div class="card user-card user-card-1">
    <div class="card-body pb-0">
      <div class="media user-about-block align-items-center mt-0 mb-3">
        <div class="position-relative d-inline-block">
          <div class="certificated-badge"> <a href="javascript:void(0)" class="mb-3 nav-link"><span class="sw-icon fas fa-adjust"></span></a> </div>
        </div>
        <div class="media-body ml-3">
          <h6 class="mb-1">
            <?= lang('Main.left_constants');?>
          </h6>
          <p class="mb-0 text-muted">
            <?= lang('Main.xin_set_up_all_types');?>
          </p>
        </div>
      </div>
    </div>
    <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical"> <a class="nav-link list-group-item list-group-item-action active" id="constant-company-type-tab" data-toggle="pill" href="#constant-company-type" role="tab" aria-controls="constant-company-type" aria-selected="true"> <span class="f-w-500"><i class="feather icon-clipboard m-r-10 h5 "></i>
      <?= lang('Main.xin_company_type');?>
      </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="constant-religion-tab" data-toggle="pill" href="#constant-religion" role="tab" aria-controls="constant-religion" aria-selected="false"> <span class="f-w-500"><i class="feather icon-refresh-cw m-r-10 h5 "></i>
      <?= lang('Main.xin_ethnicity_type_title');?>
      </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="constant-currencies-tab" data-toggle="pill" href="#constant-currencies" role="tab" aria-controls="constant-currencies" aria-selected="false"> <span class="f-w-500"><i class="feather icon-credit-card m-r-10 h5 "></i>
      <?= lang('Main.xin_currencies');?>
      </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> </div>
  </div>
</div>
<div class="col-lg-9">
  <div class="tab-content" id="user-set-tabContent">
    <div class="tab-pane fade show active" id="constant-company-type" role="tabpanel" aria-labelledby="constant-company-type-tab">
      <div class="card user-profile-list">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                <?= lang('Main.xin_add_new');?>
                </strong>
                <?= lang('Main.xin_company_type');?>
                </span> </div>
              <div class="card-body">
                <?php $attributes = array('name' => 'company_type_info', 'id' => 'company_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                <?php $hidden = array('set_company_type' => 'Add');?>
                <?php echo form_open('erp/settings/company_type_info', $attributes, $hidden);?>
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_company_type');?>
                    <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="company_type" placeholder="<?= lang('Main.xin_company_type');?>">
                </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">
                  <?= lang('Main.xin_save');?>
                  </button>
                </div>
                <?php echo form_close(); ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="box">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                <?= lang('Main.xin_list_all');?>
                </strong>
                <?= lang('Main.xin_company_type');?>
                </span> </div>
              <div class="card-body">
                <div class="card-datatable table-responsive">
                  <table class="datatables-demo table table-striped table-bordered" id="xin_table_company_type">
                    <thead>
                      <tr>
                        <th><?= lang('Main.xin_company_type');?></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="constant-religion" role="tabpanel" aria-labelledby="constant-religion-tab">
      <div class="card user-profile-list">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                <?= lang('Main.xin_add_new');?>
                </strong>
                <?= lang('Main.xin_ethnicity_type_title');?>
                </span> </div>
              <div class="card-body">
                <?php $attributes = array('name' => 'religion_info', 'id' => 'religion_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                <?php $hidden = array('set_company_type' => 'Add');?>
                <?php echo form_open('erp/settings/add_religion_info', $attributes, $hidden);?>
                <div class="form-group">
                  <label class="form-label">
                    <?= lang('Main.xin_ethnicity_type_title');?>
                    <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="religion" placeholder="<?= lang('Main.xin_ethnicity_type_title');?>">
                </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">
                  <?= lang('Main.xin_save');?>
                  </button>
                </div>
                <?php echo form_close(); ?> 
            </div>
          </div>
          <div class="col-md-12">
            <div class="box">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                <?= lang('Main.xin_list_all');?>
                </strong>
                <?= lang('Main.xin_ethnicity_type_title');?>
                </span> </div>
              <div class="card-body">
                <div class="card-datatable table-responsive">
                  <table class="datatables-demo table table-striped table-bordered" id="xin_table_religion" style="width:100%;">
                    <thead>
                      <tr>
                        <th><?= lang('Main.xin_ethnicity_type_title');?></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <div class="tab-pane fade" id="constant-currencies" role="tabpanel" aria-labelledby="constant-currencies-tab">
      <div class="card user-profile-list">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                <?= lang('Main.xin_add_new');?>
                </strong>
                <?= lang('Main.xin_currency');?>
                </span> </div>
              <div class="card-body">
                <?php $attributes = array('name' => 'currency_type_info', 'id' => 'currency_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                <?php $hidden = array('set_currency_type' => 'Add');?>
                <?php echo form_open('erp/settings/currency_type_info', $attributes, $hidden);?>
                	<div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">
                            <?= lang('Main.xin_country');?>
                            <span class="text-danger">*</span> </label>
                          <input class="form-control" placeholder="<?= lang('Main.xin_country');?>" name="country" type="text">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">
                            <?= lang('Main.xin_currency_name');?>
                            <span class="text-danger">*</span> </label>
                          <input class="form-control" placeholder="<?= lang('Main.xin_currency_name');?>" name="currency_name" type="text">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">
                            <?= lang('Main.xin_currency_code');?>
                            <span class="text-danger">*</span> </label>
                          <input class="form-control" placeholder="<?= lang('Main.xin_currency_code');?>" name="currency_code" type="text">
                        </div>
                      </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">
                  <?= lang('Main.xin_save');?>
                  </button>
                </div>
                <?php echo form_close(); ?> 
            </div>
          </div>
          <div class="col-md-12">
            <div class="box">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
                <?= lang('Main.xin_list_all');?>
                </strong>
                <?= lang('Main.xin_currencies');?>
                </span> </div>
              <div class="card-body">
                <div class="card-datatable table-responsive">
                  <table class="datatables-demo table table-striped table-bordered" id="xin_table_currencies" style="width:100%;">
                    <thead>
                      <tr>
                        <th><?= lang('Main.xin_country');?></th>
                        <th><?= lang('Main.xin_currency_name');?></th>
                        <th><?= lang('Main.xin_currency_code');?></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

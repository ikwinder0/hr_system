<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\ProjectsModel;
use App\Models\ConstantsModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();
$ProjectsModel = new ProjectsModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$xin_system = erp_company_settings();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$projects = $ProjectsModel->where('company_id',$user_info['company_id'])->orderBy('project_id', 'ASC')->findAll();
	$tax_types = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','tax_type')->findAll();
} else {
	$projects = $ProjectsModel->where('company_id',$usession['sup_user_id'])->orderBy('project_id', 'ASC')->findAll();
	$tax_types = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','tax_type')->findAll();
}
$xin_system = erp_company_settings();
?>
<?php
// Create Invoice Page
?>
<?php $get_animate = '';?>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Agency.xin_create_new_agency');?>
        </strong></span> </div>
      <div class="card-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'create_agency', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form', 'enctype' => 'multipart/form-data');?>
            <?php $hidden = array('user_id' => 0);?>
            <?php echo form_open('erp/agency/store', $attributes, $hidden);?>
            
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="invoice_date">
                        <?= lang('Agency.xin_agency_name');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input class="form-control" placeholder="<?= lang('Agency.xin_agency_name');?>" name="agency_name" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="project">
                        <?= lang('Agency.xin_logo');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
					    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-image"></i></span></div>
                        <input class="form-control agency_logo" placeholder="<?= lang('Agency.xin_logo');?>" name="agency_logo" type="file" value="">
                      </div>
                    </div>
                  </div>
                </div>
				<div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="invoice_date">
                        <?= lang('Agency.xin_country');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input class="form-control" placeholder="<?= lang('Agency.xin_country');?>" name="country" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="project">
                        <?= lang('Agency.xin_phone_no');?> <span class="text-danger">*</span>
                      </label>
					  
                      <div class="input-group">
					    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Agency.xin_phone_no');?>" name="phone_no" type="text" value="">
                      </div>
                    </div>
                  </div>
                </div>
				<div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="invoice_date">
                        <?= lang('Agency.xin_email_address');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
					    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Agency.xin_email_address');?>" name="email" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="project">
                        <?= lang('Agency.xin_agency_website');?> <span class="text-danger">*</span>
                      </label>
					  
                      <div class="input-group">
					    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-link"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Agency.xin_agency_website');?>" name="website" type="text" value="">
                      </div>
                    </div>
                  </div>
                </div>
				<hr>
				<div class="row mb-3">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="invoice_date">
                        <?= lang('Agency.xin_contact_person');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
					    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Agency.xin_contact_person');?>" name="contact_person" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="project">
                        <?= lang('Agency.xin_contact_person_phone');?> <span class="text-danger">*</span>
                      </label>
					  
                      <div class="input-group">
					    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Agency.xin_contact_person_phone');?>" name="contact_person_phone" type="text" value="">
                      </div>
                    </div>
                  </div>
                </div>
				<h3><?= lang('Agency.xin_attachments'); ?></h3>
				<hr>
				<div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="invoice_date">
                        <?= lang('Agency.xin_cr_and_tax_card');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
					    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-address-card"></i></span></div>
                        <input class="form-control cr_tax_card" name="cr_tax_card" type="file" >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="project">
                        <?= lang('Agency.xin_beneficiary_and_bank_account');?> <span class="text-danger">*</span>
                      </label>
					  
                      <div class="input-group">
					    <div class="input-group-prepend"><span class="input-group-text"><i class="fad fa-book-user"></i></span></div>
                        <input class="form-control bank_account" name="bank_account" type="file" value="">
                      </div>
                    </div>
                  </div>
                </div>
				<div class="row">
                  
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="project">
                        <?= lang('Agency.xin_bank_account_with_seal');?> <span class="text-danger">*</span>
                      </label>
					  
                      <div class="input-group">
					    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-stamp"></i></span></div>
                        <input class="form-control bank_account_with_seal" name="bank_account_with_seal" type="file" value="">
                      </div>
                    </div>
                  </div>
                </div>
				<div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="invoice_date">
                        <?= lang('Agency.xin_bank_certificate');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
					    <div class="input-group-prepend"><span class="input-group-text"><i class="fad fa-file-certificate"></i></span></div>
                        <input class="form-control bank_certificate" name="bank_certificate" type="file" >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="submit" name="agency_submit" class="btn btn-primary pull-right my-1" style="margin-right: 5px;">
        <?= lang('Agency.xin_register');?>
        </button>
      </div>
      <?php echo form_close(); ?> </div>
  </div>
</div>

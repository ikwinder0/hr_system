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
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
/* Company Details view
*/		
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$segment_id = $request->uri->getSegment(3);
$field_id = udecode($segment_id);
$xin_system = $SystemModel->where('setting_id', 1)->first();
$result = $UsersModel->where('user_id', $field_id)->first();
if($result['is_active'] == 1){
	$status = '<span class="badge badge-light-success"><em class="icon ni ni-check-circle"></em> '.lang('Main.xin_employees_active').'</span>';
	$status_label = '<i class="fas fa-certificate text-success bg-icon"></i><i class="fas fa-check front-icon text-white"></i>';
} else {
	$status = '<span class="badge badge-light-danger"><em class="icon ni ni-cross-circle"></em> '.lang('Main.xin_employees_inactive').'</span>';
	$status_label = '<i class="fas fa-certificate text-danger bg-icon"></i><i class="fas fa-times-circle front-icon text-white"></i>';
}
?>
<?php $subs_plan = '' ?>;

<div class="row">
  <div class="col-lg-4">
    <div class="card user-card user-card-1">
      <div class="card-body pb-0">
        <div class="float-right">
          <?= $status;?>
        </div>
        <input type="hidden" id="client_id" value="<?= $segment_id;?>" />
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
        <li class="list-group-item"> <span class="f-w-500"><i class="feather icon-mail m-r-10"></i><?= lang('Main.xin_email');?></span> <a href="mailto:<?= $result['email'];?>" class="float-right text-body">
          <?= $result['email'];?>
          </a> </li>
        <li class="list-group-item"> <span class="f-w-500"><i class="feather icon-phone-call m-r-10"></i><?= lang('Main.xin_phone');?></span> <a href="#" class="float-right text-body">
          <?= $result['contact_number'];?>
          </a> </li>
      </ul>
      <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical"> <a class="nav-link list-group-item list-group-item-action active" id="user-edit-account-tab" data-toggle="pill" href="#user-edit-account" role="tab" aria-controls="user-edit-account" aria-selected="true"> <span class="f-w-500"><i class="feather icon-user m-r-10 h5 "></i><?= lang('Main.xin_company_info');?></span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="company-document-tab" data-toggle="pill" href="#company-document" role="tab" aria-controls="company-document" aria-selected="false"> <span class="f-w-500"><i class="feather icon-mail m-r-10 h5 "></i>
        <?= lang('Main.xin_company_dicument');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> <a class="nav-link list-group-item list-group-item-action" id="user-profile-logo-tab" data-toggle="pill" href="#user-profile-logo" role="tab" aria-controls="user-profile-logo" aria-selected="false"> <span class="f-w-500"><i class="feather icon-mail m-r-10 h5 "></i><?= lang('Main.xin_e_details_profile_picture');?></span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a> </div>
    </div>
  </div>
  <div class="col-xl-8 col-lg-12">
    <div class="card tab-content">
      <div class="tab-pane fade active show" id="user-edit-account">
        <?php $attributes = array('name' => 'basic_info', 'id' => 'cibasic_info', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0, 'token' => $segment_id);?>
        <?= form_open('erp/companies/update_basic_info', $attributes, $hidden);?>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="company_name">
                  <?= lang('Company.xin_company_name');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Company.xin_company_name');?>" name="company_name" type="text" value="<?= $result['company_name']?>">
              </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="address">
                  <?= lang('Main.xin_country');?>
                  <span class="text-danger">*</span> </label>
                <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_country');?>">
                  <option value="">
                  <?= lang('Main.xin_select_one');?>
                  </option>
                  <?php foreach($all_countries as $country) {?>
                  <option value="<?= $country['country_id'];?>" <?php if($result['country']==$country['country_id']):?> selected="selected"<?php endif;?>>
                  <?= $country['country_name'];?>
                  </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="company_name">
                  <?= lang('Company.xin_company_website');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Company.xin_company_website');?>" name="website" type="text" value="<?= $result['website']?>"> 
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="membership_type">
                  <?= lang('Main.dashboard_xin_status');?>
                  <span class="text-danger">*</span> </label>
                <select class="form-select form-control" name="status" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
                  <option value="1" <?php if($result['is_active']=='1'):?> selected="selected"<?php endif;?>>
                  <?= lang('Main.xin_employees_active');?>
                  </option>
                  <option value="2" <?php if($result['is_active']=='2'):?> selected="selected"<?php endif;?>>
                  <?= lang('Main.xin_employees_inactive');?>
                  </option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="company_name">
                  <?= lang('Company.xin_company_address');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Company.xin_company_address');?>" name="address_1" type="text" value="<?= $result['address_1']?>">
              </div>
            </div>
          </div>
          <hr class="m-0 mb-3">
          <span class="preview-title-lg"><?= lang('Main.xin_employee_other_info');?></span>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="email">
                  <?= lang('Main.xin_email');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email" type="text" value="<?= $result['email']?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="username">
                  <?= lang('Main.dashboard_username');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Main.dashboard_username');?>" name="username" type="text" value="<?= $result['username']?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="contact_number">
                  <?= lang('Main.xin_contact_number');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text" value="<?= $result['contact_number']?>">
              </div>
            </div>
          </div>
          <hr class="m-0 mb-3">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="company_name">
                  <?= lang('Company.xin_contact_person');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Company.xin_contact_person');?>" name="contact_person" type="text" value="<?= $result['contact_persong']?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="company_name">
                  <?= lang('Company.xin_contact_person_phone');?>
                  <span class="text-danger">*</span> </label>
                <input class="form-control" placeholder="<?= lang('Company.xin_contact_person_phone');?>" name="contact_person_phone" type="text" value="<?= $result['contact_person_phone']?>">
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
      <div class="tab-pane fade" id="user-profile-logo">
        <?php $attributes = array('name' => 'add_company', 'id' => 'ci_logo', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0, 'token' => $segment_id);?>
        <?= form_open_multipart('erp/companies/update_company_photo', $attributes, $hidden);?>
        <div class="card-body pb-2">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="logo">
                  <?= lang('Company.xin_company_logo');?>
                  <span class="text-danger">*</span> </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="cifile">
                  <label class="custom-file-label"><?= lang('Main.xin_choose_file');?></label>
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
      <div class="tab-pane fade" id="company-document">
        <div class="card-body pb-2">
          <?php $attributes = array('name' => 'company_info', 'id' => 'company_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open('erp/companies/update_company_info', $attributes, $hidden);?>
          <div class="form-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="company_name">
                    <?= lang('Agency.xin_cr_and_tax_card');?>
                   </label>
                   <div class="custom-file">
                      <input class="custom-file-input cr_tax_card" name="cr_tax_card" type="file" >
                      <label class="custom-file-label">
                        <?= lang('Main.xin_choose_file');?>
                      </label>
                      <small>
                      <?= lang('Main.xin_company_file_type');?>
                      </small>
                   </div>
                </div>
              </div>
              <div class="col-md-6">
              <img src="<?= company_document($result['user_id'],'cr_tax_card');?>" alt="" class="d-block  img-fluid wid-80">
              </div>
            </div>  
            <hr class="m-0 mb-3">
            <div class="row">
            <div class="col-md-6">
					<div class="form-group">
						<label for="project">
							<?= lang('Agency.xin_beneficiary_and_bank_account');?>
						</label>
						<div class="custom-file">
							<input class="custom-file-input bank_account" name="bank_account" type="file" value="">
							<label class="custom-file-label">
							  <?= lang('Main.xin_choose_file');?>
							</label>
							<small>
							<?= lang('Main.xin_company_file_type');?>
							</small>
						</div>
					</div>
				</div>
        <div class="col-md-6">
        <img src="<?= company_document($result['user_id'],'bank_account');?>" alt="" class="d-block  img-fluid wid-80">
        </div>
        </div>
        <hr class="m-0 mb-3">
        <div class="row">
				<div class="col-md-6">
					<div class="form-group">
					  <label for="project">
						<?= lang('Agency.xin_bank_account_with_seal');?>
					  </label>
								<div class="custom-file">
						<input class="custom-file-input bank_account_with_seal" name="bank_account_with_seal" type="file" value="">
						<label class="custom-file-label">
						  <?= lang('Main.xin_choose_file');?>
						</label>
						<small>
						<?= lang('Main.xin_company_file_type');?>
						</small>
					  </div>
					</div>
				</div>
				<div class="col-md-6">
        <img src="<?= company_document($result['user_id'],'bank_account_with_seal');?>" alt="" class="d-block img-fluid wid-80">
				</div>
        </div>
        <hr class="m-0 mb-3">
        <div class="row">
				<div class="col-md-6">
					<div class="form-group">
					  <label for="invoice_date">
						<?= lang('Agency.xin_bank_certificate');?>
					  </label>
					  <div class="custom-file">
						<input class="custom-file-input bank_certificate" name="bank_certificate" type="file" >
					  <label class="custom-file-label">
						<?= lang('Main.xin_choose_file');?>
					  </label>
					  <small>
					  <?= lang('Main.xin_company_file_type');?>
					  </small>
					  </div>
					</div>
				</div>
				<div class="col-md-6">
        <img src="<?= company_document($result['user_id'],'bank_certificate');?>" alt="" class="d-block  img-fluid wid-80">
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

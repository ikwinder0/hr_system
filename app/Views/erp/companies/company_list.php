<?php
use App\Models\ConstantsModel;
use App\Models\CountryModel;
use App\Models\MembershipModel;
use App\Models\CompanymembershipModel;
use App\Models\MainModel;
$ConstantsModel = new ConstantsModel();
$CountryModel = new CountryModel();
$MembershipModel = new MembershipModel();
$MainModel = new MainModel();
$CompanymembershipModel = new CompanymembershipModel();
$company_types = $ConstantsModel->where('type','company_type')->orderBy('constants_id', 'ASC')->findAll();
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
/* Company list
*/		
?>
<?php $get_animate = '';?>
<div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
  <?php $attributes = array('name' => 'add_company', 'id' => 'xin-form', 'autocomplete' => 'off');?>
  <?php $hidden = array('user_id' => 0);?>
  <?= form_open_multipart('erp/companies/add_company', $attributes, $hidden);?>
  <div id="accordion">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-2">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Company.module_company_title');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <div class="card-body">
            <div class="form-body"> <span class="preview-title-lg">
              <?= lang('Main.xin_employee_basic_title');?>
              </span>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="company_name">
                      <?= lang('Company.xin_company_name');?>
                      <span class="text-danger">*</span> </label>
                    <input class="form-control" placeholder="<?= lang('Company.xin_company_name');?>" name="company_name" type="text">
                  </div>
                </div>
				<div class="col-md-6">
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
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="address">
                      <?= lang('Main.xin_country');?>
                      <span class="text-danger">*</span> </label>
                    <select class="form-control form-select" name="country" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_country');?>">
                      <option value="">
                      <?= lang('Main.xin_select_one');?>
                      </option>
                      <?php foreach($all_countries as $country) {?>
                      <option value="<?= $country['country_id'];?>">
                      <?= $country['country_name'];?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
				<div class="col-md-6">
					<div class="form-group">
                    <label for="company_name">
                      <?= lang('Company.xin_company_address');?>
                      <span class="text-danger">*</span> </label>
                    <input class="form-control" placeholder="<?= lang('Company.xin_company_address');?>" name="address_1" type="text">
                  </div>
				</div>
              </div>
              <div class="row">
			     <div class="col-md-6">
					<div class="form-group">
                    <label for="company_name">
                      <?= lang('Main.dashboard_username');?>
                      <span class="text-danger">*</span> </label>
                    <input class="form-control" placeholder="<?= lang('Main.dashboard_username');?>" name="username" type="text">
                  </div>
				</div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">
                      <?= lang('Main.xin_email');?>
                      <span class="text-danger">*</span> </label>
                    <input class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email" type="text">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">
                      <?= lang('Main.xin_employee_password');?>
                      <span class="text-danger">*</span> </label>
                    <input class="form-control" placeholder="<?= lang('Main.xin_employee_password');?>" name="password" type="text">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="contact_number">
                      <?= lang('Main.xin_contact_number');?>
                      <span class="text-danger">*</span> </label>
                    <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text">
                  </div>
                </div>
				<div class="col-md-6">
					<div class="form-group">
                    <label for="company_name">
                      <?= lang('Company.xin_company_website');?>
                      <span class="text-danger">*</span> </label>
                    <input class="form-control" placeholder="<?= lang('Company.xin_company_website');?>" name="website" type="text"> 
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
                    <input class="form-control" placeholder="<?= lang('Company.xin_contact_person');?>" name="contact_person" type="text">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="company_name">
                      <?= lang('Company.xin_contact_person_phone');?>
                      <span class="text-danger">*</span> </label>
                    <input class="form-control" placeholder="<?= lang('Company.xin_contact_person_phone');?>" name="contact_person_phone" type="text">
                  </div>
                </div>
              </div>
            </div>
			<hr class="m-0 mb-3">
			<span class="preview-title-lg">
			<?= lang('Company.xin_company_attachments');?>
			</span>
			<div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="invoice_date">
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
                </div>
				<div class="row">
                  
                  <div class="col-md-12">
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
                </div>
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
                </div>
            <div class="card-footer text-right">
              <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false">
              <?= lang('Main.xin_reset');?>
              </button>
              &nbsp;
              <button type="submit" class="btn btn-primary">
              <?= lang('Main.xin_save');?>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?= form_close(); ?>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="card user-profile-list">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_list_all');?>
          <?= lang('Company.xin_companies');?>
        </h5>
        <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
          <?= lang('Main.xin_add_new');?>
          </a> </div>
      </div>
      <div class="card-body">
        <div class="dt-responsive table-responsive">
          <table id="xin_table" class="table nowrap">
            <thead>
              <tr>
                <th><?= lang('Company.xin_company_name');?></th>
                <th><?= lang('Company.xin_company_type');?></th>
                <th><?= lang('Membership.xin_membership_type');?></th>
                <th><?= lang('Main.xin_country');?></th>
                <th><?= lang('Main.dashboard_xin_status');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ShiftModel;
use App\Models\VisadetailModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;
use App\Models\JobcandidatesModel;
use App\Models\JobinterviewsModel;
use CodeIgniter\HTTP\RequestInterface;

//$encrypter = \Config\Services::encrypter();
$ShiftModel = new ShiftModel();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$CountryModel = new CountryModel();
$ConstantsModel = new ConstantsModel();
$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$StaffdetailsModel = new StaffdetailsModel();
$Moduleattributes = new Moduleattributes();
$Moduleattributesval = new Moduleattributesval();
$Moduleattributesvalsel = new Moduleattributesvalsel();
$JobcandidatesModel = new JobcandidatesModel();
$JobinterviewsModel = new JobinterviewsModel();
$VisadetailModel = new VisadetailModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
///
$segment_id = $request->uri->getSegment(3);
$user_id = udecode($segment_id);
$result = $UsersModel->where('user_id', $user_id)->first();
$employee_detail = $StaffdetailsModel->where('user_id', $result['user_id'])->first();
$visa_detail = $VisadetailModel->where('user_id', $result['user_id'])->first();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'super_user'){
	$departments = $DepartmentModel->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = '';
	$leave_types = '';
	$roles = '';
} else {
	$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$usession['sup_user_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$roles = $RolesModel->where('company_id',$usession['sup_user_id'])->orderBy('role_id', 'ASC')->findAll();
}

$company_id = $usession['sup_user_id'];


$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$religion = $ConstantsModel->where('type','religion')->orderBy('constants_id', 'ASC')->findAll();

$selected_shift = $ShiftModel->where('office_shift_id', $employee_detail['office_shift_id'])->first();
$xin_system = erp_company_settings();
// department head
$idepartment = $DepartmentModel->where('department_id',$employee_detail['department_id'])->first();
$dep_user = $UsersModel->where('user_id', $idepartment['department_head'])->first();
// user designation
$idesignations = $DesignationModel->where('designation_id',$employee_detail['designation_id'])->first();
$application = $JobcandidatesModel->where('candidate_id', $result['user_id'])->first();
$app_status = $application['application_status'];
$interview = $JobinterviewsModel->where('candidate_id', $result['user_id'])->first();
?>
<?php if($app_status=='0'): $_status = '<span class="badge badge-light-info">Pending</span>'; endif; ?>
<?php if($app_status=='1'): $_status = '<span class="badge badge-light-success">Selected</span>'; endif; ?>
<?php if($app_status=='3'): $_status = '<span class="badge badge-light-danger">Rejected</span>'; endif; ?>

<?php 
// if($result['is_active']=='0'): $_status = '<span class="badge badge-light-danger">'.lang('Main.xin_employees_inactive').'</span>'; endif; 
?>
<?php 
// if($result['is_active']=='1'): $_status = '<span class="badge badge-light-success">'.lang('Main.xin_employees_active').'</span>'; endif; ?>
<?php 
// if($result['is_active']=='2'): $_status = '<span class="badge badge-light-info">'.lang('Main.xin_employees_new').'</span>'; endif; ?> 

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
  <?php if(in_array('staff2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/employee-details/'.$segment_id);?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-user"></span>
      Basic Info
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        Basic Info
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('staff2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/profile-picture/'.$segment_id);?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-image"></span>
      Profile Picture
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        Profile Picture
      </div>
      </a> </li>
    <?php } ?>
	<?php if($user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/update-documents/'.$segment_id);?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file"></span>
      Documents
      <div class="text-muted small">
       Set Documents
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('shift1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <!--li class="nav-item clickable"> <a href="<?= site_url('erp/candidate-other-info/'.$segment_id);?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-info"></span>
      Other Info
      <div class="text-muted small">
        Set up other info
      </div>
      </a> </li-->
    <?php } ?>
	
  </ul>
</div>
<hr class="border-light m-0 mb-3">

<div class="row"> 
  <!-- [] start -->
  <input type="hidden" id="user_id" value="<?= udecode($segment_id);?>" />
  <div class="col-lg-12">
    <div class="tab-content" id="user-set-tabContent">
      
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade show active" id="user-set-basicinfo" role="tabpanel" aria-labelledby="user-set-basicinfo-tab">
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="file-text" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_employee_basic_title');?>
              </span></h5>
          </div>
          <div class="card-body pb-2">
            <div class="box-body">
              <?php $attributes = array('name' => 'edit_user', 'id' => 'edit_user', 'autocomplete' => 'off');?>
              <?php $hidden = array('token' => $segment_id);?>
              <?= form_open('erp/employees/update_basic_info', $attributes, $hidden);?>
              <div class="form-body">
			    <div class="row">
                  <div class="col-md-6">
				    <div class="form-group">
						<label for="logo">
							Job Title ( Designation)
							<span class="text-danger">*</span>
						</label>
						<div class="input-group">
							<select
								class="form-control"
								name="applied_for"
								data-plugin="select_hrm">
								<option value="">
									<?= lang('Employees.xin_select');?>
								</option>
								<?php foreach($designations as $job){  ?>
								<option value="<?= $job['designation_id']; ?>" <?= ($job['designation_id'] == $employee_detail['designation_id']) ? 'selected':''; ?> >
									<?= $job['designation_name']; ?>
								</option>
								<?php }  ?>
							</select>
						</div>
						</div>
					</div>
					<div class="col-md-6">
						<label for="logo">
							Profile Picture
							<span class="text-danger">*</span>
						</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" name="file">
							<label class="custom-file-label">
								<?= lang('Main.xin_choose_file');?>
							</label>
							<small>
								<?= lang('Main.xin_company_file_type');?>
							</small>
						</div>
					</div>
				</div>
			
                <div class="row">
				  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company_name">
                        First name
                        <span class="text-danger">*</span> </label>
                      <div class="input-group">
              
                        <input class="form-control" placeholder="First name" name="first_name" type="text" value="<?= $result['first_name'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name" class="control-label">
                        Last name
                        <span class="text-danger">*</span></label>
                      <div class="input-group">
                        
                        <input class="form-control" placeholder="Last name" name="last_name" type="text" value="<?= $result['last_name'];?>">
                      </div>
                    </div>
                  </div>
				  <div class="col-md-6">
				    <div class="form-group">
						<label for="logo">
							Family name/Last name
							<span class="text-danger">*</span>
						</label>
						<div class="input-group">
							 <input class="form-control" placeholder="Family name/Last name" name="family_name" type="text" value="<?= $result['family_name'];?>">
						</div>
						</div>
				  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company_name">
                        First given name
                        <span class="text-danger">*</span> </label>
                      <div class="input-group">
              
                        <input class="form-control" placeholder="First given name" name="first_given_name" type="text" value="<?= $result['first_given_name'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name" class="control-label">
                        Second given name
                        <span class="text-danger">*</span></label>
                      <div class="input-group">
                        
                        <input class="form-control" placeholder="Second given name" name="second_given_name" type="text" value="<?= $result['second_given_name'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Third given name
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Third given name" name="third_given_name" type="text" value="<?= $result['third_given_name'];?>">
                    </div>
                  </div>
				  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Fourth & any other given name(s)
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Fourth & any other given name(s)" name="fourth_given_name" type="text" value="<?= $result['fourth_given_name'];?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Given name (in Arabic characters)
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Given name (in Arabic characters)" name="given_name_arabic" type="text" value="<?= $result['given_name_arabic'];?>">
                    </div>
                  </div>
				  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Father's name (in Arabic characters)
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Father's name (in Arabic characters)" name="father_name_arabic" type="text" value="<?= $result['father_name_arabic'];?>">
                    </div>
                  </div>
				  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Grandfather's name (in Arabic characters)
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Grandfather's name (in Arabic characters)" name="grandfather_name_arabic" type="text" value="<?= $result['grandfather_name_arabic'];?>">
                    </div>
                  </div>
				  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Great-grandfather's name (in Arabic characters)
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Great-grandfather's name (in Arabic characters)" name="greatfather_name_arabic" type="text" value="<?= $result['greatfather_name_arabic'];?>">
                    </div>
                  </div>
				  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Preferred family name /last name
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Preferred family name /last name" name="preferred_family_name" type="text" value="<?= $result['preferred_family_name'];?>">
                    </div>
                  </div>
				  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Preferred given name(s)
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Preferred given name(s)" name="preferred_given_name" type="text" value="<?= $result['preferred_given_name'];?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        <?= lang('Main.xin_contact_number');?>
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text" value="<?= $result['contact_number'];?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="gender" class="control-label">
                        <?= lang('Main.xin_employee_gender');?>
                      </label>
                      <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_gender');?>">
                        <option value="1" <?php if($result['gender']==1):?> selected="selected"<?php endif;?>>
                        <?= lang('Main.xin_gender_male');?>
                        </option>
                        <option value="2" <?php if($result['gender']==2):?> selected="selected"<?php endif;?>>
                        <?= lang('Main.xin_gender_female');?>
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="date_of_birth">
                        <?= lang('Employees.xin_employee_dob');?>
                      </label>
                      <div class="input-group">
                        <input class="form-control date" placeholder="<?= lang('Employees.xin_employee_dob');?>" name="date_of_birth" type="text" value="<?= $employee_detail['date_of_birth'];?>">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="marital_status" class="control-label">
                        <?= lang('Employees.xin_employee_mstatus');?>
                      </label>
                      <select class="form-control" name="marital_status" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_employee_mstatus');?>">
                        <option value="0" <?php if($employee_detail['marital_status']==0):?> selected <?php endif; ?>>
                        <?= lang('Employees.xin_status_single');?>
                        </option>
                        <option value="1" <?php if($employee_detail['marital_status']==1):?> selected <?php endif; ?>>
                        <?= lang('Employees.xin_status_married');?>
                        </option>
                        <option value="2" <?php if($employee_detail['marital_status']==2):?> selected <?php endif; ?>>
                        <?= lang('Employees.xin_status_widowed');?>
                        </option>
                        <option value="3" <?php if($employee_detail['marital_status']==3):?> selected <?php endif; ?>>
                        <?= lang('Employees.xin_status_divorced_separated');?>
                        </option>
                      </select>
                    </div>
                  </div>
				  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Home Country Address
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Home Country Address" name="home_country_address" type="text" value="<?= $employee_detail['home_country_address'];?>">
                    </div>
                  </div>
				  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Emergency Contact Name 
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Emergency Contact Name" name="emergency_contact_name" type="text" value="<?= $employee_detail['emergency_contact_name'];?>">
                    </div>
                  </div>
				  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Emergency Contact number 
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Emergency Contact number" name="emergency_contact_number" type="text" value="<?= $employee_detail['emergency_contact_number'];?>">
                    </div>
                  </div>
				  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number">
                        Preferred Language
                        <span class="text-danger">*</span></label>
                      <input class="form-control" placeholder="Preferred Language" name="preferred_language" type="text" value="<?= $employee_detail['preferred_language'];?>">
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="estate">
                        <?= lang('Main.xin_state');?>
                      </label>
                      <input class="form-control" placeholder="<?= lang('Main.xin_state');?>" name="state" type="text" value="<?= $result['state'];?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="ecity">
                        <?= lang('Main.xin_city');?>
                      </label>
                      <input class="form-control" placeholder="<?= lang('Main.xin_city');?>" name="city" type="text" value="<?= $result['city'];?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="ezipcode" class="control-label">
                        <?= lang('Main.xin_zipcode');?>
                      </label>
                      <input class="form-control" placeholder="<?= lang('Main.xin_zipcode');?>" name="zipcode" type="text" value="<?= $result['zipcode'];?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email" class="control-label">
                        <?= lang('Employees.xin_ethnicity_type_title');?>
                      </label>
                      <select class="form-control" name="religion" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_ethnicity_type_title');?>">
                        <option value=""></option>
                        <?php foreach($religion as $ireligion) {?>
                        <option value="<?= $ireligion['constants_id']?>" <?php if($ireligion['constants_id']==$employee_detail['religion_id']):?> selected="selected"<?php endif;?>>
                        <?= $ireligion['category_name']?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
             
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nationality_id">
                        <?= lang('Employees.xin_nationality');?>
                      </label>
                      <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_nationality');?>">
                        <option value="">
                        <?= lang('Main.xin_select_one');?>
                        </option>
                        <?php foreach($all_countries as $country) {?>
                        <option value="<?= $country['country_id'];?>" <?php if($country['country_id'] == $result['country']):?> selected="selected"<?php endif;?>>
                        <?= $country['country_name'];?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
				<h2>Passport Details</h2>
				<hr>
				<div class="row">
				    <div class="col-md-6">
						<div class="form-group">
						  <label for="estate">
							Document Type
						  </label>
						  <input class="form-control" placeholder="Passport Type" name="document_type" type="text" value="<?= isset($visa_detail['document_type']) ? $visa_detail['document_type'] : '';?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="estate">
							Passport Type
						  </label>
						  <input class="form-control" placeholder="Passport Type" name="passport_type" type="text" value="<?= isset($visa_detail['passport_type']) ? $visa_detail['passport_type'] : '';?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="estate">
							Passport Number
						  </label>
						  <input class="form-control" placeholder="Passport Number" name="passport_number" type="text" value="<?= isset($visa_detail['passport_number']) ? $visa_detail['passport_number'] : '';?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="estate">
							Passport Expiry Date
						  </label>
						  <input class="form-control" placeholder="Passport Expiry Date" name="passport_expiry" type="text" value="<?= isset($visa_detail['passport_expiry']) ? $visa_detail['passport_expiry'] : '' ;?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="estate">
							Issuing Country on Passport
						  </label>
						  <input class="form-control" placeholder="Issuing Country on Passport" name="passport_issue_country" type="text" value="<?= isset($visa_detail['passport_issue_country']) ? $visa_detail['passport_issue_country'] : '';?>">
						</div>
					</div>
				</div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button  type="submit" class="btn btn-primary">
            <?= lang('Employees.xin_update_profile');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <?php } ?>
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-picture" role="tabpanel" aria-labelledby="user-set-picture-tab">
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="image" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_e_details_profile_picture');?>
              </span></h5>
          </div>
          <div class="card-body pb-2">
            <div class="box-body">
              <?php $attributes = array('name' => 'edit_user_photo', 'id' => 'edit_user_photo', 'autocomplete' => 'off');?>
              <?php $hidden = array('token' => $segment_id);?>
              <?= form_open('erp/employees/update_profile_photo', $attributes, $hidden);?>
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="logo">
                        <?= lang('Main.xin_e_details_profile_picture');?>
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
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button  type="submit" class="btn btn-primary">
            <?= lang('Employees.xin_update_pic');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <?php }?>
	  <?php if($application['application_status']=='1' && $interview): ?>
	  <div class="tab-pane fade" id="user-application-status" role="tabpanel" aria-labelledby="user-application-status-tab">
        <div class="card">
			<div class="card-header">
            <h5><i data-feather="image" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_application_status');?>
              </span></h5>
			</div>
				<div class="card-body pb-2">
					<div class="box-body">
					    <div class="row mt-5">
							<div class="col-md-12">
								<h5 class="mb-4"><i class="fas fa-clock wid-20"></i><span class="p-l-5">Interview Scheduled:</span></h5>
								<br>
								<p><b>Date & Time : </b> <?= $interview['interview_date'] .' '. $interview['interview_time']; ?></p>
							</div>
						</div>
						<div class="row bs-wizard" style="border-bottom:0;">
                
							<div class="col-md-3 bs-wizard-step disabled /*complete*/">
							  <div class="text-center bs-wizard-stepnum">Pre-Screening</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center">Pending</div>
							</div>
							
							<div class="col-md-3 bs-wizard-step disabled /*complete*/"><!-- complete -->
							  <div class="text-center bs-wizard-stepnum">Interview</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center">Pending</div>
							</div>
							
							<div class="col-md-3 bs-wizard-step disabled /*active*/"><!-- complete -->
							  <div class="text-center bs-wizard-stepnum">Feedback</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center">N/A</div>
							</div>
							
							<div class="col-md-3 bs-wizard-step disabled"><!-- active -->
							  <div class="text-center bs-wizard-stepnum">Result</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center">N/A</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	  <?php endif; ?>
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-document" role="tabpanel" aria-labelledby="user-set-document-tab">
        <div class="card user-profile-list">
          <div class="card-header">
            <h5><i data-feather="file-plus" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Employees.xin_documents');?>
              </span></h5>
          </div>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_table_document" style="width:100%;">
                <thead>
                  <tr>
                    <th><?= lang('Employees.xin_document_name');?></th>
                    <th><?= lang('Employees.xin_document_type');?></th>
                    <th><?= lang('Employees.xin_document_file');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
  <!-- [] end --> 
</div>

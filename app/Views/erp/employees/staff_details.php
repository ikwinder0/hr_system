<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ShiftModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;
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

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
///
$segment_id = $request->uri->getSegment(3);
$user_id = udecode($segment_id);
$result = $UsersModel->where('user_id', $user_id)->first();
$employee_detail = $StaffdetailsModel->where('user_id', $result['user_id'])->first();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$departments = $DepartmentModel->where('company_id',$user_info['company_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$user_info['company_id'])->where('department_id',$employee_detail['department_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$user_info['company_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$roles = $RolesModel->where('company_id',$user_info['company_id'])->orderBy('role_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$company_id = $user_info['company_id'];
} else {
	$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$usession['sup_user_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$roles = $RolesModel->where('company_id',$usession['sup_user_id'])->orderBy('role_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$company_id = $usession['sup_user_id'];
}

$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$religion = $ConstantsModel->where('type','religion')->orderBy('constants_id', 'ASC')->findAll();

$selected_shift = $ShiftModel->where('office_shift_id', $employee_detail['office_shift_id'])->first();
$xin_system = erp_company_settings();
// department head
$idepartment = $DepartmentModel->where('department_id',$employee_detail['department_id'])->first();
$dep_user = $UsersModel->where('user_id', $idepartment['department_head'])->first();
// user designation
$idesignations = $DesignationModel->where('designation_id',$employee_detail['designation_id'])->first();
$get_animate='';
//contract custom fields
$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',5)->orderBy('custom_field_id', 'ASC')->countAllResults();
$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',5)->orderBy('custom_field_id', 'ASC')->findAll();
//basic info custom fields
$bcount_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',8)->orderBy('custom_field_id', 'ASC')->countAllResults();
$bmodule_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',8)->orderBy('custom_field_id', 'ASC')->findAll();
//personal info custom fields
$ccount_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',9)->orderBy('custom_field_id', 'ASC')->countAllResults();
$cmodule_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',9)->orderBy('custom_field_id', 'ASC')->findAll();
?>
<?php if($result['is_active']=='0'): $_status = '<span class="badge badge-light-danger">'.lang('Main.xin_employees_inactive').'</span>'; endif; ?>
<?php if($result['is_active']=='1'): $_status = '<span class="badge badge-light-success">'.lang('Main.xin_employees_active').'</span>'; endif; ?>

<div class="row"> 
  <!-- [] start -->
  <div class="col-lg-4">
    <div class="card user-card user-card-1">
      <div class="card-body pb-0">
        <div class="float-right">
          <?= $_status?>
        </div>
        <div class="media user-about-block align-items-center mt-0 mb-3">
          <div class="position-relative d-inline-block"> <img class="img-radius img-fluid wid-80" src="<?= base_url().'/public/uploads/users/'.$result['profile_photo'];?>" alt="<?= $result['first_name'].' '.$result['last_name']; ?>">
            <div class="certificated-badge"> <i class="fas fa-certificate text-primary bg-icon"></i> <i class="fas fa-check front-icon text-white"></i> </div>
          </div>
          <div class="media-body ml-3">
            <h6 class="mb-1">
              <?= $result['first_name'].' '.$result['last_name']; ?>
            </h6>
            <p class="mb-0 text-muted">
              <?= $idesignations['designation_name'];?>
            </p>
          </div>
        </div>
      </div>
      
      <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical">
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action active" id="user-set-basicinfo-tab" data-toggle="pill" href="#user-set-basicinfo" role="tab" aria-controls="user-set-basicinfo" aria-selected="false"> <span class="f-w-500"><i class="feather icon-file-text m-r-10 h5 "></i>
        <?= lang('Main.xin_employee_basic_title');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-picture-tab" data-toggle="pill" href="#user-set-picture" role="tab" aria-controls="user-set-picture" aria-selected="false"> <span class="f-w-500"><i class="feather icon-image m-r-10 h5 "></i>
        <?= lang('Main.xin_e_details_profile_picture');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-account-tab" data-toggle="pill" href="#user-set-account" role="tab" aria-controls="user-set-account" aria-selected="false"> <span class="f-w-500"><i class="feather icon-book m-r-10 h5 "></i>
        <?= lang('Main.xin_account_info');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-document-tab" data-toggle="pill" href="#user-set-document" role="tab" aria-controls="user-set-document" aria-selected="false"> <span class="f-w-500"><i class="feather icon-file-plus m-r-10 h5 "></i>
        <?= lang('Employees.xin_documents');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-agenda-tab" data-toggle="pill" href="#user-set-agenda" role="tab" aria-controls="user-set-agenda" aria-selected="false"> <span class="f-w-500"><i class="feather icon-package m-r-10 h5 "></i>
        <?= lang('Employees.xin_timesheet_agenda');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
        <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-password-tab" data-toggle="pill" href="#user-set-password" role="tab" aria-controls="user-set-password" aria-selected="false"> <span class="f-w-500"><i class="feather icon-shield m-r-10 h5 "></i>
        <?= lang('Main.header_change_password');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
      </div>
    </div>
  </div>
  <input type="hidden" id="user_id" value="<?= udecode($segment_id);?>" />
  <div class="col-lg-8">
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
                      <label for="company_name">
                        <?= lang('Main.xin_employee_first_name');?>
                        <span class="text-danger">*</span> </label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Main.xin_employee_first_name');?>" name="first_name" type="text" value="<?= $result['first_name'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name" class="control-label">
                        <?= lang('Main.xin_employee_last_name');?>
                        <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                        <input class="form-control" placeholder="<?= lang('Main.xin_employee_last_name');?>" name="last_name" type="text" value="<?= $result['last_name'];?>">
                      </div>
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
                      <label for="status" class="control-label">
                        <?= lang('Main.dashboard_xin_status');?>
                      </label>
                      <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
                        <option value="0" <?php if($result['is_active']=='0'):?> selected <?php endif; ?>>
                        <?= lang('Main.xin_employees_inactive');?>
                        </option>
                        <option value="1" <?php if($result['is_active']=='1'):?> selected <?php endif; ?>>
                        <?= lang('Main.xin_employees_active');?>
                        </option>
                      </select>
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
                      <label for="estate">
                        <?= lang('Main.xin_state');?>
                      </label>
                      <input class="form-control" placeholder="<?= lang('Main.xin_state');?>" name="state" type="text" value="<?= $result['state'];?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="ecity">
                        <?= lang('Main.xin_city');?>
                      </label>
                      <input class="form-control" placeholder="<?= lang('Main.xin_city');?>" name="city" type="text" value="<?= $result['city'];?>">
                    </div>
                  </div>
                  <div class="col-md-6">
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
                <?php if($bcount_module_attributes > 0):?>
                <div class="row">
                  <?php foreach($bmodule_attributes as $mattribute):?>
                  <?php $attribute_info = $Moduleattributesval->where('user_id',$user_id)->where('module_attributes_id', $mattribute['custom_field_id'])->first();?>
                  <?php
						if($attribute_info){
							$attr_val = $attribute_info['attribute_value'];
						} else {
							$attr_val = '';
						}
					?>
                  <?php if($mattribute['attribute_type'] == 'date'){?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <input class="form-control date" 
                      placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                    </div>
                  </div>
                  <?php } else if($mattribute['attribute_type'] == 'select'){?>
                  <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id', $mattribute['custom_field_id'])->first();?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <?php $iselc_val = $Moduleattributesvalsel->where('custom_field_id',$mattribute['custom_field_id'])->findAll();?>
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <select class="form-control" name="<?php echo $mattribute['attribute'];?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute['attribute_label'];?>">
                        <?php foreach($iselc_val as $selc_val) {?>
                        <option value="<?php echo $selc_val['attributes_select_value_id']?>" <?php if($attr_val==$selc_val['attributes_select_value_id']):?> selected="selected"<?php endif;?>><?php echo $selc_val['select_label']?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } else if($mattribute['attribute_type'] == 'textarea'){?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <textarea class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text"><?= $attr_val;?></textarea>
                    </div>
                  </div>
                  <?php } else { ?>
                  <?php
				  	if($mattribute['validation']==1):
						$validate_opt = '<span class="text-danger">*</span>';
					else:
						$validate_opt = '';
					endif;
				  ?>
                  <div class="<?= $mattribute['col_width'];?>">
                    <div class="form-group">
                      <label for="<?php echo $mattribute['attribute'];?>"><?php echo $mattribute['attribute_label'];?> <?= $validate_opt;?></label>
                      <input class="form-control" placeholder="<?php echo $mattribute['attribute_label'];?>" name="<?php echo $mattribute['attribute'];?>" type="text" value="<?= $attr_val;?>">
                    </div>
                  </div>
                  <?php }	?>
                  <?php endforeach;?>
                </div>
                <?php endif;?>
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
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-account" role="tabpanel" aria-labelledby="user-set-account-tab">
        <div class="card">
          <div class="card-header">
            <h5> <i data-feather="book" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_account_info');?>
              </span> <small class="text-muted d-block m-l-25 m-t-5">
              <?= lang('Employees.xin_change_account_info');?>
              </small> </h5>
          </div>
          <?php $attributes = array('name' => 'edit_user', 'id' => 'edit_account', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open('erp/employees/update_account_info', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>
                    <?= lang('Main.dashboard_username');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Main.dashboard_username');?>" name="username" type="text" value="<?= $result['username'];?>">
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>
                    <?= lang('Employees.xin_account_email');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Employees.xin_account_email');?>" name="email" type="text" value="<?= $result['email'];?>">
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
      </div>
      <?php } ?>
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-password" role="tabpanel" aria-labelledby="user-set-password-tab">
        <div class="alert alert-warning" role="alert">
          <h5 class="alert-heading"><i class="feather icon-alert-circle mr-2"></i>
            <?= lang('Main.xin_alert');?>
          </h5>
          <p>
            <?= lang('Main.xin_dont_share_password');?>
          </p>
        </div>
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="shield" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.header_change_password');?>
              </span></h5>
          </div>
          <?php $attributes = array('name' => 'change_password', 'id' => 'change_password', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open('erp/employees/update_password', $attributes, $hidden);?>
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
            <button type="submit" class="btn btn-danger">
            <?= lang('Main.header_change_password');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <?php } ?>
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
          <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>
            <?= lang('Main.xin_add_new');?>
            </strong>
            <?= lang('Employees.xin_document');?>
            </span> </div>
          <?php $attributes = array('name' => 'user_document', 'id' => 'user_document', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open_multipart('erp/employees/add_document', $attributes, $hidden);?>
          <div class="card-body pb-2">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="date_of_expiry" class="control-label">
                    <?= lang('Employees.xin_document_name');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_document_name');?>" name="document_name" type="text">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="title" class="control-label">
                    <?= lang('Employees.xin_document_type');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_document_eg_payslip_etc');?>" name="document_type" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="logo">
                    <?= lang('Employees.xin_document_file');?>
                    <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="document_file">
                    <label class="custom-file-label">
                      <?= lang('Main.xin_choose_file');?>
                    </label>
                    <small>
                    <?= lang('Employees.xin_e_details_d_type_file');?>
                    </small> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button  type="submit" class="btn btn-primary">
            <?= lang('Employees.xin_add_document');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <?php } ?>
      <?php if(in_array('staff4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="tab-pane fade" id="user-set-agenda" role="tabpanel" aria-labelledby="user-set-agenda-tab">
        <div class="card">
          <div class="card-header">
            <h5><i data-feather="package" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Employees.xin_timesheet_agenda');?>
              </span></h5>
          </div>
          <div class="card-body">
            <ul class="nav nav-tabs  mb-3" id="pills-tab" role="tablist">
              <li class="nav-item"> <a class="nav-link active" id="pills-leave_request-tab" data-toggle="tab" href="#pills-leave_request" role="tab" aria-controls="pills-leave_request" aria-selected="false">
                <?= lang('Leave.left_leave_request');?>
                </a> </li>
              <li class="nav-item"> <a class="nav-link" id="pills-expense_claim-tab" data-toggle="tab" href="#pills-expense_claim" role="tab" aria-controls="pills-expense_claim" aria-selected="true">
                <?= lang('Dashboard.dashboard_expense_claim');?>
                </a> </li>
              <li class="nav-item"> <a class="nav-link" id="pills-loan-tab" data-toggle="tab" href="#pills-loan" role="tab" aria-controls="pills-loan" aria-selected="false">
                <?= lang('Main.xin_request_loan');?>
                </a> </li>
              <li class="nav-item"> <a class="nav-link" id="pills-travel-tab" data-toggle="tab" href="#pills-travel" role="tab" aria-controls="pills-travel" aria-selected="false">
                <?= lang('Dashboard.dashboard_travel_request');?>
                </a> </li>
                <li class="nav-item"> <a class="nav-link" id="pills-advance_salary-tab" data-toggle="tab" href="#pills-advance_salary" role="tab" aria-controls="pills-advance_salary" aria-selected="false">
                <?= lang('Main.xin_advance_salary');?>
                </a> </li>
                <li class="nav-item"> <a class="nav-link" id="pills-overtime-tab" data-toggle="tab" href="#pills-overtime" role="tab" aria-controls="pills-overtime" aria-selected="false">
                <?= lang('Dashboard.xin_overtime_request');?>
                </a> </li>
           
                <li class="nav-item"> <a class="nav-link" id="pills-awards-tab" data-toggle="tab" href="#pills-awards" role="tab" aria-controls="pills-awards" aria-selected="false">
                <?= lang('Dashboard.left_awards');?>
                </a> </li>
               <li class="nav-item"> <a class="nav-link" id="pills-projects-tab" data-toggle="tab" href="#pills-projects" role="tab" aria-controls="pills-projects" aria-selected="false">
                <?= lang('Dashboard.left_projects');?>
                </a> </li>
                <li class="nav-item"> <a class="nav-link" id="pills-tasks-tab" data-toggle="tab" href="#pills-tasks" role="tab" aria-controls="pills-tasks" aria-selected="false">
                <?= lang('Dashboard.left_tasks');?>
                </a> </li>
                <li class="nav-item"> <a class="nav-link" id="pills-payslip-tab" data-toggle="tab" href="#pills-payslip" role="tab" aria-controls="pills-payslip" aria-selected="false">
                <?= lang('Dashboard.xin_payslip_history');?>
                </a> </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade active show" id="pills-leave_request" role="tabpanel" aria-labelledby="pills-leave_request-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Leave.left_leave');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_leave">
                        <thead>
                          <tr>
                            <th><?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Leave.xin_leave_type');?></th>
                            <th><i class="fa fa-calendar"></i>
                              <?= lang('Leave.xin_leave_duration');?></th>
                            <th><?= lang('Leave.xin_leave_days');?></th>
                            <th><i class="fa fa-calendar"></i>
                              <?= lang('Leave.xin_applied_on');?></th>
                            <th><?= lang('Main.dashboard_xin_status');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-expense_claim" role="tabpanel" aria-labelledby="pills-expense_claim-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Dashboard.dashboard_expense_claim');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_expense">
                        <thead>
                          <tr>
                            <th><?= lang('Employees.xin_account_title');?></th>
                            <th><?= lang('Dashboard.xin_acc_payee');?></th>
                            <th><?= lang('Invoices.xin_amount');?></th>
                            <th><?= lang('Dashboard.xin_category');?></th>
                            <th><?= lang('Finance.xin_acc_ref_no');?></th>
                            <th><?= lang('Main.xin_payment_method');?></th>
                            <th><?= lang('Main.xin_e_details_date');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-loan" role="tabpanel" aria-labelledby="pills-loan-tab">
                <div class="<?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Main.xin_request_loan');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_loan">
                        <thead>
                          <tr>
                            <th width="200"><?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Invoices.xin_amount');?></th>
                            <th> <?= lang('Employees.xin_award_month_year');?></th>
                            <th> <?= lang('Main.xin_one_time_deduct');?></th>
                            <th> <?= lang('Main.xin_emi');?></th>
                            <th> <?= lang('Main.xin_created_at');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-travel" role="tabpanel" aria-labelledby="pills-travel-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Dashboard.dashboard_travel_request');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_travel">
                        <thead>
                          <tr>
                            <th><i class="fa fa-user"></i>
                              <?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Employees.xin_visit_place');?></th>
                            <th><?= lang('Employees.xin_visit_purpose');?></th>
                            <th><?= lang('Employees.xin_arragement_type');?></th>
                            <th> <?= lang('Employees.xin_actual_travel_budget');?></th>
                            <th><i class="fa fa-calendar"></i>
                              <?= lang('Projects.xin_end_date');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-advance_salary" role="tabpanel" aria-labelledby="pills-advance_salary-tab">
                <div class="<?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Main.xin_advance_salary');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_ad_salary">
                        <thead>
                          <tr>
                            <th width="200"><?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Invoices.xin_amount');?></th>
                            <th> <?= lang('Employees.xin_award_month_year');?></th>
                            <th> <?= lang('Main.xin_one_time_deduct');?></th>
                            <th> <?= lang('Main.xin_emi');?></th>
                            <th> <?= lang('Main.xin_created_at');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-overtime" role="tabpanel" aria-labelledby="pills-overtime-tab">
                <div class="<?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Main.xin_request_loan');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_overtime" style="width:100%;">
                        <thead>
                          <tr>
                            <th><?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Main.xin_e_details_date');?></th>
                            <th><?= lang('Employees.xin_shift_in_time');?></th>
                            <th><?= lang('Employees.xin_shift_out_time');?></th>
                            <th><?= lang('Attendance.xin_overtime_thours');?></th>
                            <th><?= lang('Main.dashboard_xin_status');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-awards" role="tabpanel" aria-labelledby="pills-awards-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Dashboard.left_awards');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_awards" style="width:100%;">
                        <thead>
                          <tr>
                            <th width="200">
                              <?= lang('Employees.xin_award_type');?></th>
                            <th><i class="fa fa-user small"></i>
                              <?= lang('Dashboard.dashboard_employee');?></th>
                            <th> <?= lang('Employees.xin_award_gift');?></th>
                            <th> <?= lang('Employees.xin_award_cash');?></th>
                            <th> <?= lang('Employees.xin_award_month_year');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-projects" role="tabpanel" aria-labelledby="pills-projects-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Dashboard.left_projects');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_projects" style="width:100%;">
                        <thead>
                          <tr>
                            <th><?php echo lang('Dashboard.left_projects');?></th>
                            <th><?php echo lang('Projects.xin_client');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_start_date');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_end_date');?></th>
                            <th><i class="fa fa-user"></i> <?php echo lang('Projects.xin_project_users');?></th>
                            <th><?php echo lang('Projects.xin_p_priority');?></th>
                            <th><?php echo lang('Projects.dashboard_xin_progress');?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-tasks" role="tabpanel" aria-labelledby="pills-tasks-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Main.xin_list_all');?>
                      <?= lang('Dashboard.left_tasks');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_tasks" style="width:100%;">
                        <thead>
                          <tr>
                            <th><?php echo lang('Dashboard.xin_title');?></th>
                            <th><i class="fa fa-user"></i> <?php echo lang('Projects.xin_project_users');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_start_date');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_end_date');?></th>
                            <th><?php echo lang('Projects.xin_status');?></th>
                            <th>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-payslip" role="tabpanel" aria-labelledby="pills-payslip-tab">
                <div class="user-profile-list <?php echo $get_animate;?>">
                  <div class="card-header">
                    <h5>
                      <?= lang('Dashboard.xin_payslip_history');?>
                    </h5>
                  </div>
                  <div class="m-t-20">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered" id="xin_table_payslip" style="width:100%;">
                        <thead>
                          <tr>
                            <th><?= lang('Dashboard.dashboard_employee');?></th>
                            <th><?= lang('Payroll.xin_net_payable');?></th>
                            <th><?= lang('Payroll.xin_salary_month');?></th>
                            <th><?= lang('Payroll.xin_pay_date');?></th>
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
      <?php } ?>
    </div>
  </div>
  <!-- [] end --> 
</div>

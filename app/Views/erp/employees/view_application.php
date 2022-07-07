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
$get_animate='';
//contract custom fields
$count_module_attributes = '';
$module_attributes = '';
//basic info custom fields
$bcount_module_attributes = '';
$bmodule_attributes = '';
//personal info custom fields
$ccount_module_attributes = '';
$cmodule_attributes = '';
?>
<?php if($result['is_active']=='0'): $_status = '<span class="badge badge-light-danger">'.lang('Main.xin_employees_inactive').'</span>'; endif; ?>
<?php if($result['is_active']=='1'): $_status = '<span class="badge badge-light-success">'.lang('Main.xin_employees_active').'</span>'; endif; ?>
<?php if($result['is_active']=='2'): $_status = '<span class="badge badge-light-info">'.lang('Main.xin_employees_new').'</span>'; endif; ?>

<div class="row"> 
  <!-- [] start -->
  <div class="col-lg-4">
    <div class="card user-card user-card-1">
      <div class="card-body pb-0">
        <div class="user-about-block text-center align-items-center mt-0 mb-3">
          <div class="position-relative d-inline-block mb-3"> <img class="img-fluid wid-100" src="<?= base_url().'/public/uploads/users/'.$result['profile_photo'];?>" alt="<?= $result['first_name'].' '.$result['last_name']; ?>">
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
        <a class="nav-link list-group-item list-group-item-action" id="user-set-document-tab" data-toggle="pill" href="#user-set-document" role="tab" aria-controls="user-set-document" aria-selected="false"> <span class="f-w-500"><i class="feather icon-file-plus m-r-10 h5 "></i>
        <?= lang('Employees.xin_documents');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
		<a class="nav-link list-group-item list-group-item-action" id="user-application-status-tab" data-toggle="pill" href="#user-application-status" role="tab" aria-controls="user-set-document" aria-selected="false"> <span class="f-w-500"><i class="fas fa-file m-r-10 h5"></i>
        <?= lang('Main.xin_application_status');?>
        </span> <span class="float-right"><i class="feather icon-chevron-right"></i></span> </a>
        <?php } ?>
      </div>
    </div>
  </div>
  <input type="hidden" id="user_id" value="<?= udecode($segment_id);?>" />
  <div class="col-lg-8">
    <div class="tab-content" id="user-set-tabContent">
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
					<h6 class="mb-0"><?= lang('Main.xin_position_applied_for');?></h6>
				  </div>
				  <div class="col-md-6">
					<p class="mb-0 text-muted">
					  <?= $idesignations['designation_name'];?>
					</p>
				  </div>
				</div>
			    <hr class="">
                <div class="row">
				  <div class="col-md-6">
					<h6 class="mb-0"><?= lang('Main.xin_employee_first_name');?></h6>
				  </div>
				  <div class="col-md-6">
					<p class="mb-0 text-muted">
					  <?= $result['first_name'];?>
					</p>
				  </div>
                </div>
				<hr class="">
				<div class="row">
				  <div class="col-md-6">
					<h6 class="mb-0"><?= lang('Main.xin_employee_last_name');?></h6>
				  </div>
				  <div class="col-md-6">
					<p class="mb-0 text-muted">
					  <?= $result['last_name'];?>
					</p>
				  </div>
                </div>
				<hr class="">
				<div class="row">
					<div class="col-md-6">
                        <h6 class="mb-0"><?= lang('Main.xin_contact_number');?></h6>
					</div>
					<div class="col-md-6">
					    <p class="mb-0 text-muted">
							<?= $result['contact_number'];?>
						</p>
					</div>
				</div>
				<hr class="">
				<div class="row">
					<div class="col-md-6">
                        <h6 class="mb-0"><?= lang('Main.xin_employee_gender');?></h6>
					</div>
					<div class="col-md-6">
					    <p class="mb-0 text-muted">
							<?= ($result['gender']==1) ? 'Male' : 'Female'; ?>
						</p>
					</div>
				</div>
				<hr class="">
				<div class="row">
					<div class="col-md-6">
                        <h6 class="mb-0"><?= lang('Employees.xin_employee_dob');?></h6>
					</div>
					<div class="col-md-6">
					    <p class="mb-0 text-muted">
							<?= $employee_detail['date_of_birth'];?>
						</p>
					</div>
				</div>
				<hr class="">
				<div class="row">
					<div class="col-md-6">
                        <h6 class="mb-0"><?= lang('Employees.xin_employee_mstatus');?></h6>
					</div>
					<div class="col-md-6">
					    <p class="mb-0 text-muted">
							<?php if($employee_detail['marital_status']==0): echo 'Single';  endif; ?>
							<?php if($employee_detail['marital_status']==1): echo 'Married';  endif; ?>
							<?php if($employee_detail['marital_status']==2): echo 'Widowed';  endif; ?>
							<?php if($employee_detail['marital_status']==3): echo 'Divorced';  endif; ?>
						</p>
					</div>
				</div>
				<hr class="">
				<div class="row">
					<div class="col-md-6">
                        <h6 class="mb-0"><?= lang('Employees.xin_ethnicity_type_title');?></h6>
					</div>
					<div class="col-md-6">
					    <p class="mb-0 text-muted">
						    
							<?php foreach($religion as $ireligion) {
							
								if($ireligion['constants_id']==$employee_detail['religion_id']){
								
									echo $ireligion['category_name'];
								
					
					
						 } } ?>
						</p>
					</div>
				</div>
				<hr class="">
				<div class="row">
					<div class="col-md-6">
                        <h6 class="mb-0"><?= lang('Main.xin_state');?></h6>
					</div>
					<div class="col-md-6">
					    <p class="mb-0 text-muted">
							<?= $result['state'];?>
						</p>
					</div>
				</div>
				<hr class="">
				<div class="row">
					<div class="col-md-6">
                        <h6 class="mb-0"><?= lang('Main.xin_city');?></h6>
					</div>
					<div class="col-md-6">
					    <p class="mb-0 text-muted">
							<?= $result['city'];?>
						</p>
					</div>
				</div>
				<hr class="">
				<div class="row">
					<div class="col-md-6">
                        <h6 class="mb-0"><?= lang('Main.xin_zipcode');?></h6>
					</div>
					<div class="col-md-6">
					    <p class="mb-0 text-muted">
							<?= $result['zipcode'];?>
						</p>
					</div>
				</div>
				<hr class="">
				<div class="row">
					<div class="col-md-6">
                        <h6 class="mb-0"><?= lang('Employees.xin_nationality');?></h6>
					</div>
					<div class="col-md-6">
					    <p class="mb-0 text-muted">
							<?php foreach($all_countries as $country) {
								
								if($country['country_id'] == $result['country']):?> 
								<?= $country['country_name'];?>
								<?php endif;
								
							} ?>
						</p>
					</div>
				</div>
                
               
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            
          </div>
         
        </div>
      </div>
      
	  <div class="tab-pane fade" id="user-application-status" role="tabpanel" aria-labelledby="user-application-status-tab">
        <div class="card">
			<div class="card-header">
            <h5><i data-feather="image" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_application_status');?>
              </span></h5>
				<div class="card-body pb-2">
					<div class="box-body">
						<div class="row bs-wizard" style="border-bottom:0;">
                
							<div class="col-md-3 bs-wizard-step disabled /*complete*/">
							  <div class="text-center bs-wizard-stepnum">Pre-Screening</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center">Lorem ipsum dolor sit amet.</div>
							</div>
							
							<div class="col-md-3 bs-wizard-step disabled /*complete*/"><!-- complete -->
							  <div class="text-center bs-wizard-stepnum">Interview</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center">Nam mollis tristique erat vel tristique. Aliquam erat volutpat. Mauris et vestibulum nisi. Duis molestie nisl sed scelerisque vestibulum. Nam placerat tristique placerat</div>
							</div>
							
							<div class="col-md-3 bs-wizard-step disabled /*active*/"><!-- complete -->
							  <div class="text-center bs-wizard-stepnum">Feedback</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center">Integer semper dolor ac auctor rutrum. Duis porta ipsum vitae mi bibendum bibendum</div>
							</div>
							
							<div class="col-md-3 bs-wizard-step disabled"><!-- active -->
							  <div class="text-center bs-wizard-stepnum">Result</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center"> Curabitur mollis magna at blandit vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	  </div>
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

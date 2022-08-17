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
use App\Models\JobcandidatesModel;
use App\Models\JobinterviewsModel;
use App\Models\VisadetailModel;
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

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$departments = $DepartmentModel->orderBy('department_id', 'ASC')->findAll();
$designations = $DesignationModel->orderBy('designation_id', 'ASC')->findAll();
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
$interview = $JobinterviewsModel->where('candidate_id', $result['user_id'])->first();
$visa_detail = $VisadetailModel->where('user_id', $user_id)->first();

?>
<?php if($result['is_active']=='0'): $_status = '<span class="badge badge-light-danger">'.lang('Main.xin_employees_inactive').'</span>'; endif; ?>
<?php if($result['is_active']=='1'): $_status = '<span class="badge badge-light-success">'.lang('Main.xin_employees_active').'</span>'; endif; ?>
<?php if($result['is_active']=='2'): $_status = '<span class="badge badge-light-info">'.lang('Main.xin_employees_new').'</span>'; endif; ?>
    <style type="text/css">
     
.h5_heading h6:after {
      background: #1f8ebe;
      content: "";
      display: block;
      width: 240px;
      height: 3px;
      margin-top: 10px;
    margin-bottom: 22px;
}
  .color{
    color: #1f8ebe;
  }
  .margin li{
    margin-left: -22px;
  }
  
  .right-div{
    background-color: #014c83;
    color: #fff !important;
  }
  .photo-section{
    text-align: center;
    margin: 30px auto;
	width: 130px;
	
  }
  
  .photo-section img{
	  border: 5px solid;
  }
  .photo{
    border-radius: 50%;
    border: 5px solid #1f8ebe;
  }
  .right-side-color h6, .right-side-color h5{
	  color:#fff;
  }
  .right-side-color h6:after{
      background: white;
      content: "";
      display: block;
      width: 240px;
      height: 3px;
      margin-top: 10px;
    margin-bottom: 22px
 
     
  }
  
  .inner-div{
	  margin: 35px;
  }
  
 
  .line {
    width: 2px;
    background-color: lightgrey !important;
	height: 100px;
  }
   .lead {
        font-size: 14px;
  }
  .p_div .p2{
	  margin-top:-15px;
  }

      
    </style>
 <input type="hidden" id="user_id" value="<?= udecode($segment_id);?>" />
<div class="row">
        <div class="col-md-12">
			<div class="card">
				<div class="card-body p-3">
					<div class="row align-items-center h-100">
						<div class="col-md-4">
							<div class="photo-section">
								<img class="img-radius img-fluid" src="<?= base_url().'/public/uploads/users/'.$result['profile_photo'];?>" alt="<?= $result['first_name'].' '.$result['last_name']; ?>">
							</div>
						</div>
						<div class="col-md-8 mx-auto">
							
							  <h2><?= strtoupper($result['first_name']);?> <span class="color"><?= strtoupper($result['last_name']);?></span></h2> 
							  <h6><span class="color">DESIGNATION : </span><?= $idesignations['designation_name'];?></h6>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-body p-4">
					<div class="row">
						<div class="col-md-4">
							<h4>Name in English</h4>
							<div class="p_div">
								<p class="text-muted">Last name</p>
								<p class="p2"><?= $result['last_name']; ?></p>
							</div>
							<div class="p_div">
								<p class="text-muted">First given name</p>
								<p class="p2"><?= ($result['first_given_name']) ? $result['first_given_name'] :'N/A'  ; ?></p>
							</div>
							<div class="p_div">
								<p class="text-muted">Second given name</p>
								<p class="p2"><?= ($result['second_given_name']) ? $result['second_given_name'] :'N/A'; ?></p>
							</div>
							<div class="p_div">
								<p class="text-muted">Third given name</p>
								<p class="p2"><?= ($result['third_given_name']) ? $result['third_given_name'] :'N/A'; ?></p>
							</div>
							<div class="p_div">
								<p class="text-muted">Fourth given name</p>
								<p class="p2"><?= ($result['fourth_given_name']) ? $result['fourth_given_name'] :'N/A'; ?></p>
							</div>
							
						</div>
						<div class="col-md-4">
							<h4>Name in Arabic</h4>
							<div class="p_div">
								<p class="text-muted">Given name in Arabic</p>
								<p class="p2"><?= ($result['given_name_arabic']) ? $result['given_name_arabic'] :'N/A'; ?></p>
							</div> 
							<div class="p_div">
								<p class="text-muted">Father name in Arabic</p>
								<p class="p2"><?= ($result['father_name_arabic']) ? $result['father_name_arabic'] :'N/A'; ?></p>
							</div> 
							<div class="p_div">
								<p class="text-muted">Grand Father name in Arabic</p>
								<p class="p2"><?= ($result['grandfather_name_arabic']) ? $result['grandfather_name_arabic'] :'N/A'; ?></p>
							</div>
                            <div class="p_div">
								<p class="text-muted">Great Grand Father name in Arabic</p>
								<p class="p2"><?= ($result['greatfather_name_arabic']) ? $result['greatfather_name_arabic'] :'N/A'; ?></p>
							</div>							
							
						</div>
						<div class="col-md-4">
							<h4>Preferred Name</h4>
							<div class="p_div">
								<p class="text-muted">Preferred family name /last name</p>
								<p class="p2"><?= ($result['preferred_family_name']) ? $result['preferred_family_name'] :'N/A'; ?></p>
							</div>
							<div class="p_div">
								<p class="text-muted">Preferred given name(s)</p>
								<p class="p2"><?= ($result['preferred_given_name']) ? $result['preferred_given_name'] :'N/A'; ?></p>
							</div>
							<div class="p_div">
								<p class="text-muted">Preferred Language</p>
								<p class="p2"><?= ($employee_detail['preferred_language']) ? $employee_detail['preferred_language'] :'N/A'; ?></p>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-body p-3">
					<div class="row align-items-center h-100">
					    <div class="col-md-4">
							<div class="p_div">
								<p class="text-muted">Candidate ID</p>
								<p class="p2"><?= $employee_detail['employee_id'];?></p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="p_div">
								<p class="text-muted">Email</p>
								<p class="p2"><?= $result['email'];?></p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="p_div">
								<p class="text-muted">Phone</p>
								<p class="p2"><?= $result['contact_number'];?></p>
							</div>
						</div>
						<div class="col-md-4">
							
							<div class="p_div">
								<p class="text-muted">Marital Status</p>
								<p class="p2">
									<?php if($employee_detail['marital_status']==0): echo 'Single';  endif; ?>
									<?php if($employee_detail['marital_status']==1): echo 'Married';  endif; ?>
									<?php if($employee_detail['marital_status']==2): echo 'Widowed';  endif; ?>
									<?php if($employee_detail['marital_status']==3): echo 'Divorced';  endif; ?>
								</p>
							</div>
							
						</div>
						<div class="col-md-4">
							
							<div class="p_div">
								<p class="text-muted">Religion</p>
								<p class="p2">
									<?php foreach($religion as $ireligion) {
							
											if($ireligion['constants_id']==$employee_detail['religion_id']){
											
												echo $ireligion['category_name'];
											
								
								
									 } } ?>
								</p>
							</div>
							
						</div>
						<div class="col-md-4">
							<div class="p_div">
								<p class="text-muted">Gender</p>
								<p class="p2"><?= ($result['gender']==1) ? 'Male' : 'Female'; ?></p>
							</div>
						</div>
						<div class="col-md-4">
							
							<div class="p_div">
								<p class="text-muted">Date of Birth</p>
								<p class="p2"><?= $employee_detail['date_of_birth'];?></p>
							</div>
							
						</div>
						<div class="col-md-4">
							
							<div class="p_div">
								<p class="text-muted">Nationality</p>
								<p class="p2">
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
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-body p-3">
					<div class="row align-items-center h-100">
						<div class="col-md-4">
							<div class="p_div">
								<p class="text-muted">High School</p>
								<p class="p2"><?= ($employee_detail['high_school']) ? $employee_detail['high_school'] : 'N/A';?></p>
							</div>
						</div>
						<div class="col-md-4">
							
							<div class="p_div">
								<p class="text-muted">Graduation/Degree</p>
								<p class="p2"><?= ($employee_detail['degree']) ? $employee_detail['degree'] : 'N/A';?></p>
							</div>
							
						</div>
						<div class="col-md-4">
							
							<div class="p_div">
								<p class="text-muted">Other</p>
								<p class="p2">
									<?= ($employee_detail['other_education']) ? $employee_detail['other_education'] : 'N/A';?>
								</p>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-body p-3">
					<div class="row align-items-center h-100">
						<div class="col-md-4">
							<div class="p_div">
								<p class="text-muted">Experience 1</p>
								<p class="p2"><?= ($employee_detail['experience_1']) ? $employee_detail['experience_1'] : 'N/A' ; ?></p>
							</div>
						</div>
						<div class="col-md-4">
							
							<div class="p_div">
								<p class="text-muted">Experience 2</p>
								<p class="p2"><?= ($employee_detail['experience_2']) ? $employee_detail['experience_2'] : 'N/A' ; ?></p>
							</div>
							
						</div>
						<div class="col-md-4">
							
							<div class="p_div">
								<p class="text-muted">Experience 3</p>
								<p class="p2">
									<?= ($employee_detail['experience_3']) ? $employee_detail['experience_3'] : 'N/A' ; ?>
								</p>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="card">
				<div class="card-body p-3">
					<div class="row align-items-center h-100">
						<div class="col-md-6">
							<div class="p_div">
								<p class="text-muted">Address</p>
								<p class="p2"><?= $result['city'];?>,<?= $result['state'];?>,<?php foreach($all_countries as $country) {
								
								if($country['country_id'] == $result['country']):?> 
								<?= $country['country_name'];?>
								<?php endif;
								
							} ?> ,<?= $result['zipcode'];?></p>
							</div>
						</div>
			
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-body p-3">
					<div class="row align-items-center h-100">
						<div class="col-md-4">
							<div class="p_div">
								<p class="text-muted">Document Type</p>
								<p class="p2"><?= isset($visa_detail['document_type']) ? $visa_detail['document_type'] : 'N/A' ;?></p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="p_div">
								<p class="text-muted">Passport Type</p>
								<p class="p2"><?= isset($visa_detail['passport_type']) ? $visa_detail['passport_type'] : 'N/A' ;?></p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="p_div">
								<p class="text-muted">Issuing Country</p>
								<p class="p2"><?= isset($visa_detail['passport_issue_country']) ? $visa_detail['passport_issue_country'] : 'N/A' ;?></p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="p_div">
								<p class="text-muted">Passport Expiry</p>
								<p class="p2"><?= isset($visa_detail['passport_expiry']) ? $visa_detail['passport_expiry'] : 'N/A' ;?></p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="p_div">
								<p class="text-muted">Passport Number</p>
								<p class="p2"><?= isset($visa_detail['passport_number']) ? $visa_detail['passport_number'] : 'N/A' ;?></p>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	
	
        <div class="col-md-12">
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
	
	<?php if($user_info['user_type'] == 'super_user'){
		
	?>
	
        <div class="col-md-12">
		        <div class="card">
			<div class="card-header">
            <h5><i data-feather="image" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              Change Status
              </span></h5>
			 </div>
				<div class="card-body pb-2">
					<div class="box-body">
					    <div class="row">
							<div class="col-md-6">
								<select class="form-control app_status form-select" data-plugin="select_hrm">
								
									<option value="0" <?= ($application['application_status'] == 0) ? 'selected' : ''; ?>>Pending</option>
									<option value="1" <?= ($application['application_status'] == 1) ? 'selected' : ''; ?>>Select</option>
									<option value="3"<?= ($application['application_status'] == 3) ? 'selected' : ''; ?>>Reject</option>
									
								</select>
							</div>
						</div>
					
					</div>
				</div>
			</div>
		</div>
		<?php $attributes = array('name' => 'selected_employee', 'id' => 'selected_employee', 'class' => 'selected_employee_form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $segment_id);?>
        <?= form_open_multipart('erp/employees/selected-details', $attributes, $hidden);?>
        <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header">
                        <h5>
                            Add Candidate Info & Accommodation
                        </h5>
                    </div>
                    <div class="card-body"> 
                        <div class="row mb-3">
						    <div class="col-md-6">
                                <label for="logo" class="control-label">
                                    Project Code
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
									<input type="text" name="project_code" class="form-control" placeholder="Project Code">
									<div class="error-project_code"></div> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="logo" class="control-label">
                                    Staff Number
                                    <span class="text-danger">*</span>
                                </label>
                                 <div class="input-group">
									<input type="text" name="staff_number" class="form-control" placeholder="Staff Number">
									<div class="error-staff_number"></div> 
                                </div>
                            </div>
						</div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name" >
                                        Line Manager
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Line Manager"
                                            name="line_manager">
										
                                    </div>
									<div class="error-line_manager"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        Duty Timing
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Duty Timing"
                                            name="duty_timing">
										
                                    </div>
									<div class="error-duty_timing"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">
                                        Division Name (Project team, FOH, BOH, line staff)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Division Name"
                                            name="division_name">
										
                                    </div>
									<div class="error-division_name"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        Stadium Allocation 
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Stadium Allocation "
                                            name="stadium_allocation">
										
                                    </div>
									<div class="error-stadium_allocation"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">
                                        Joining Date ( contract start date)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control date"
                                            placeholder="Joining Date"
                                            name="joining_date">
										
                                    </div>
									<div class="error-joining_date"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        Last working day (contract ends date)
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                
                                        <input
                                            type="text"
                                            class="form-control date"
                                            placeholder="Last working day"
                                            name="last_working_days">
										
                                    </div>
									<div class="error-last_working_day"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">
                                        Employment Type (Temp contract, ABA staff, Agency Staff, Manpower, Secondment)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Employment Type"
                                            name="employment_type">
										
                                    </div>
									<div class="error-employment_type"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        QID Number
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                
                                        <input
                                            type="text"
                                            class="form-control date"
                                            placeholder="QID Number"
                                            name="qid_number">
										
                                    </div>
									<div class="error-qid_number"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">
                                        QID Expiry Date
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control date"
                                            placeholder="QID Expiry Date"
                                            name="qid_expiry_date">
										
                                    </div>
									<div class="error-employment_type"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        CC Email Address ( generic email for the company)
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="CC Email Address"
                                            name="cc_email_address">
										
                                    </div>
									<div class="error-cc_email_address"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">
                                        Local Contact Number (Qatari)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Local Contact Number (Qatari)"
                                            name="local_contact_number">
										
                                    </div>
									<div class="error-local_contact_number"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        Local Address/Company Accommodation (company provided - mention locations) (Own Accommodation give option to write the location as per the national address)
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Local Address"
                                            name="local_address">
										
                                    </div>
									<div class="error-local_address"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">
                                        Person Type
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Person Type"
                                            name="person_type">
										
                                    </div>
									<div class="error-person_type"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        Reject Code
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Reject Code"
                                            name="reject_code">
										
                                    </div>
									<div class="error-reject_code"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">
                                        Reject Message
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Reject Message"
                                            name="reject_message">
										
                                    </div>
									<div class="error-reject_message"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        Remarks
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Remarks"
                                            name="remarks">
										
                                    </div>
									<div class="error-remarks"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
						    <div class="col-md-6">
								<h2>Accommodation</h2>
							</div>
						</div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">
                                        Local Address
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Local Address"
                                            name="acc_local_address">
										
                                    </div>
									<div class="error-acc_local_address"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        Building No
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Building No"
                                            name="building_no">
										
                                    </div>
									<div class="error-building_no"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">
                                        Zone No
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Zone No"
                                            name="zone_no">
										
                                    </div>
									<div class="error-zone_no"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        Street No
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Street No"
                                            name="street_no">
										
                                    </div>
									<div class="error-street_no"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">
                                        Floor No
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Floor No"
                                            name="floor_no">
										
                                    </div>
									<div class="error-floor_no"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        Flat No
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Flat No"
                                            name="flat_no">
										
                                    </div>
									<div class="error-flat_no"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
						    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">
                                        Room No
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                   
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Room No"
                                            name="room_no">
										
                                    </div>
									<div class="error-room_no"></div>
                                </div>
                            </div>
					    </div>
						<div class="row mb-3">
							<div class="col-md-6">
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
							</div>
						</div>
				</div>
			</div>
		</div>
		
        <?= form_close(); ?>
	<?php }else{ ?>
		
		
			<div class="col-md-12 mb-5">
				<a href="<?= site_url('erp/employee-details/'.$segment_id);?>" class="btn btn-success">Edit Candidate</a>
			</div>
		
		
	<?php } ?>
</div>	
  <!-- [] end --> 

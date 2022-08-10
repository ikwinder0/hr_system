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
								<p class="p2">Test</p>
							</div>
							<div class="p_div">
								<p class="text-muted">First given name</p>
								<p class="p2">Test</p>
							</div>
							<div class="p_div">
								<p class="text-muted">Second given name</p>
								<p class="p2">Test</p>
							</div>
							<div class="p_div">
								<p class="text-muted">Third given name</p>
								<p class="p2">Test</p>
							</div>
							<div class="p_div">
								<p class="text-muted">Fourth given name</p>
								<p class="p2">Test</p>
							</div>
							
						</div>
						<div class="col-md-4">
							<h4>Name in Arabic</h4>
							<div class="p_div">
								<p class="text-muted">Given name in Arabic</p>
								<p class="p2">N/A</p>
							</div> 
							<div class="p_div">
								<p class="text-muted">Father name in Arabic</p>
								<p class="p2">N/A</p>
							</div> 
							<div class="p_div">
								<p class="text-muted">Grand Father name in Arabic</p>
								<p class="p2">N/A</p>
							</div>
                            <div class="p_div">
								<p class="text-muted">Great Grand Father name in Arabic</p>
								<p class="p2">N/A</p>
							</div>							
							
						</div>
						<div class="col-md-4">
							<h4>Preferred Name</h4>
							<div class="p_div">
								<p class="text-muted">Preferred Last name</p>
								<p class="p2">N/A</p>
							</div>
							<div class="p_div">
								<p class="text-muted">Preferred Given name</p>
								<p class="p2">N/A</p>
							</div>
							<div class="p_div">
								<p class="text-muted">Preferred Language</p>
								<p class="p2">N/A</p>
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
          <div class="card-body p-0">
            <div class="row">
              <div class="col-md-8">
			  <div class="inner-div">
                <div class="h5_heading">
                  <h1><?= strtoupper($result['first_name']);?> <span class="color"><?= strtoupper($result['last_name']);?></span></h1>
                  <h6><span class="color">APPLIED FOR : </span><?= $idesignations['designation_name'];?></h6>
                </div>
                <div class="second-part">
                <h6>BASIC INFO</h6>
                <hr>
				<h5>Candidate ID</h5>
                  <p><?= $employee_detail['employee_id'];?></p>
                  <hr>
                <h5>Gender</h5>
                  <p><?= ($result['gender']==1) ? 'Male' : 'Female'; ?></p>
                <hr>
				<h5>DOB</h5>
                  <p><?= $employee_detail['date_of_birth'];?></p>
                <hr>
				<h5>Marital Status</h5>
                  <p>
					<?php if($employee_detail['marital_status']==0): echo 'Single';  endif; ?>
					<?php if($employee_detail['marital_status']==1): echo 'Married';  endif; ?>
				    <?php if($employee_detail['marital_status']==2): echo 'Widowed';  endif; ?>
					<?php if($employee_detail['marital_status']==3): echo 'Divorced';  endif; ?>
				  </p>
                <hr>
				<h5>Religion</h5>
                  <p>
					<?php foreach($religion as $ireligion) {
							
								if($ireligion['constants_id']==$employee_detail['religion_id']){
								
									echo $ireligion['category_name'];
								
					
					
						 } } ?>
				  </p>
                <hr>
                </div>
                
                  <div class="h5_heading">
                  <h6>WORK EXPERIENCE</h6>
				  
                  <div class="row">
				  <?php if($employee_detail['experience_1']){ ?>
                    <div class="col-md-4">
                      <p>Experience 1</p>

                    </div>
                    <div class="col-md-8">
                      <h5><?= $employee_detail['experience_1']; ?></h5>
                      
                      
                    </div>
				  <?php } ?>
				  <?php if($employee_detail['experience_2']){ ?>
                    <div class="col-md-4">
                      <p>Experience 2</p>
                    </div>
                    <div class="col-md-8">
                      <h5><?= $employee_detail['experience_2']; ?></h5>
                      
                    </div>
					<?php } ?>
					<?php if($employee_detail['experience_3']){ ?>
                    <div class="col-md-4">
                      <p>Experience 3</p>
                    </div>
                    <div class="col-md-8">
                      <h5><?= $employee_detail['experience_3']; ?></h5>
                     
                    </div>
					<?php } ?>
                  </div>
                </div>
                <div class="h5_heading">
                  <h6>EDUCATION</h6>
                  <div class="row">
                    <div class="col-md-4">
                      <p>High School</p>

                    </div>
                    <div class="col-md-8">
                      <h5><?= ($employee_detail['high_school']) ? $employee_detail['high_school'] : 'N/A';?></h5>
                   
                      <hr>
                      
                    </div>
                    <div class="col-md-4">
                      <p>Graduation/Degree</p>
                    </div>
                    <div class="col-md-8">
                      <h5><?= ($employee_detail['degree']) ? $employee_detail['degree'] : 'N/A';?></h5>
                      <hr>
                    </div>
					 <div class="col-md-4">
                      <p>Other</p>
                    </div>
                    <div class="col-md-8">
                      <h5><?= ($employee_detail['other_education']) ? $employee_detail['other_education'] : 'N/A';?></h5>
                      
                    </div>
                  </div>
                </div>
               

            
              
            </div>
			</div>
            
            <div class="col-md-4 right-div">
              <div class="photo-section">
                <img class="img-radius img-fluid" src="<?= base_url().'/public/uploads/users/'.$result['profile_photo'];?>" alt="<?= $result['first_name'].' '.$result['last_name']; ?>">
              </div>
                <div class="right-second right-side-color">
                  <h6>CONTACT</h6>
                  <div class="row">

                    <div class="col-md-2 col-sm-6" >

                   <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="col-md-9 col-sm-6">
                    <h5>Address</h5>
                    <p><?= $result['city'];?>,<?= $result['state'];?>,<?php foreach($all_countries as $country) {
								
								if($country['country_id'] == $result['country']):?> 
								<?= $country['country_name'];?>
								<?php endif;
								
							} ?> ,<?= $result['zipcode'];?></p>
                    </div>
                    <div class="col-md-2 " >

                    <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="col-md-9">
                    <h5>Phone</h5>
                    <p><?= $result['contact_number'];?></p>
                    </div>
                     <div class="col-md-2" >
                      <i class="fas fa-envelope"></i>
                    </div>
                    <div class="col-md-9">
                    <h5>Email</h5>
                    <p><?= $result['email'];?></p>
                    </div>
                </div>
                

                
              </div>
              <!--div class="third-left right-side-color px-3">
                  <h6>SKILLS</h6>
                  <h5>Languages</h5>
                  <p>English,Spanish,German,Japanese</p>
                  <hr>
                  <h5>Interpersonal</h5>
                  <p>skill</p>
                  <hr>
                </div-->
           
          </div>
        </div>
      </div>
      
      </div>
    </div>
    </div>
	<div class="row">
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
	</div>
	
	<div class="row">
        <div class="col-md-12">
		        <div class="card">
			<div class="card-header">
            <h5><i data-feather="image" class="icon-svg-primary wid-20"></i><span class="p-l-5">
              <?= lang('Main.xin_application_status');?>
              </span></h5>
			 </div>
				<div class="card-body pb-2">
					<div class="box-body">
					<?php if($user_info['user_type'] == 'super_user'){ ?>
					    <div class="row">
							<div class="col-md-6">
								<select class="form-control app_status form-select" data-plugin="select_hrm">
								
									<option value="0" <?= ($application['application_status'] == 0) ? 'selected' : ''; ?>>Pending</option>
									<option value="1" <?= ($application['application_status'] == 1) ? 'selected' : ''; ?>>Select</option>
									<option value="3"<?= ($application['application_status'] == 3) ? 'selected' : ''; ?>>Reject</option>
									
								</select>
							</div>
						</div>
						
						
						<?php if($application['application_status'] == 1 && !$interview): ?>
						<hr>
						
						<div class="row">
							<div class="col-md-12">
								<h5 class="mb-4"><i class="fas fa-clock wid-20"></i><span class="p-l-5">Schedule Interview</span></h5>
								
								<?php $attributes = array('name' => 'update_candidate_status', 'id' => 'update_candidate_status', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
								<?php $hidden = array('_method' => 'EDIT', 'token' => $segment_id);?>
								<?= form_open('erp/recruitment/update_candidate_status', $attributes, $hidden);?>
								<div class="row">
							        <div class="col-md-6">
								    <div class="form-group">
										<label>Interviewer</label>
										<select class="form-control" name="interviewer_id" data-plugin="select_hrm" data-placeholder="Select Interviewer">
										<option>interviewer 1</option>
										<option>interviewer 2</option>
										<option>interviewer 3</option>
										</select>
									</div>
									</div>
								</div>
								<div class="row">
							        <div class="col-md-6">
								    <div class="form-group">
										<label>Mode of Interview</label>
										<select class="form-control" name="mode_of_interview" data-plugin="select_hrm" data-placeholder="Select Interviewer">
										<option>Only One </option>
										<option>Two</option>
										</select>
									</div>
									</div>
								</div>
								<div class="row">
							        <div class="col-md-6">
								    <div class="form-group">
										<label>Interview Date</label>
										<input type="text" name="interview_date" class="form-control edate" required>
									</div>
									</div>
								</div>
								<div class="row">
							        <div class="col-md-6">
									<div class="form-group">
										<label>Interview Time</label>
										<input type="text" name="interview_time" class="form-control etimepicker" required>
									</div>
									</div>
								</div>
								<div class="row">
							        <div class="col-md-6">
									<div class="form-group">
										
										<input type="submit" class="btn btn-primary" value="Schedule">
									</div>
									</div>
								</div>
								<?= form_close(); ?>
							</div>
						</div>
						<?php 
						endif; 
						}
						?>
						
						
						<?php if($interview): ?>
						<div class="row mt-5">
							<div class="col-md-12">
								<h5 class="mb-4"><i class="fas fa-clock wid-20"></i><span class="p-l-5">Interview Scheduled:</span></h5>
								<br>
								<p><b>Date & Time : </b> <?= $interview['interview_date'] .' '. $interview['interview_time']; ?>  
								<?php if($user_info['user_type'] == 'super_user'){ ?>
								<span><i class="fas fa-edit ml-5 edit_interview" role="button"></i></span>
								<?php } ?>
								</p>
							</div>
						</div>
						
						<hr>
						<?php if($user_info['user_type'] == 'super_user'){ ?>
						
						<div class="row">
							<div class="col-md-12">
								<label class = "checkbox-inline mr-4">
									<input type = "checkbox" class="process_interview" id = "inlineCheckbox2" data-id="<?= $user_id ?>" value = "2" <?php echo($interview && $interview['status'] > 1) ? 'checked disabled' : '';  ?>> Pre-Screening
								 </label>
								 <label class = "checkbox-inline mr-4"> 
									<input type = "checkbox" class="process_interview" id = "inlineCheckbox3" data-id="<?= $user_id ?>" value = "3" <?php echo($interview && $interview['status'] > 2) ? 'checked disabled' : '';  ?>> Interview
								 </label>
								 <label class = "checkbox-inline mr-4">
									<input type = "checkbox" class="process_result" id = "inlineCheckbox5" data-id="<?= $user_id ?>" value = "4" <?php echo($interview && $interview['status'] > 3) ? 'checked disabled' : '';  ?> > Result
								 </label>
								 <label class = "checkbox-inline ">
									<input type = "checkbox" class="process_feedback" id = "inlineCheckbox4" data-id="<?= $user_id ?>" value = "5" <?php echo($interview && $interview['status'] > 4) ? 'checked disabled' : '';  ?> > Feedback
								 </label>
								 
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="result_div" style="display:none">
									 <div class="form-group">
										<label>Select Result</label>
										<select class="form-control result" style="width:150px">
											<option value="pass">Pass</option>
											<option value="fail">Fail</option>
										</select>
									</div>
									<button class="btn btn-primary result_save" data-id="<?= $user_id ?>">Save Result</button>
									 
								</div>
								<div class="feedback_div" style="display:none">
									 <div class="form-group">
										<label>Feedback</label>
										<textarea class="form-control feedback_text" rows="10"></textarea>
									</div>
									<button class="btn btn-primary feedback_save" data-id="<?= $user_id ?>">Save Feedback</button>
									 
								</div>
							</div>
						</div>
						<?php } ?>
						<?php endif; ?>
						
						<?php if($interview): ?>
						<div class="row">
							<div class="col-md-12">
								<div class="stepper d-flex flex-column mt-5 ml-2">
									<div class="d-flex mb-1">
									  <div class="d-flex flex-column pr-4 align-items-center">
										<div class="rounded-circle py-2 px-3 <?php echo($interview['status'] > 1 ) ? 'bg-primary text-white' : 'bg-light text-light';  ?> mb-1"><i class="fas fa-check"></i></div>
										<div class="line"></div>
									  </div>
									  <div>
										<h5 class="text-dark">Pre-Screening</h5>
										<p class="lead text-muted pb-3"><?php echo($interview['status'] > 1 ) ? 'DONE' : 'N/A';  ?></p>
									  </div>
									</div>
									<div class="d-flex mb-1">
									  <div class="d-flex flex-column pr-4 align-items-center">
										<div class="rounded-circle py-2 px-3 <?php echo($interview['status'] > 2 ) ? 'bg-primary text-white' : 'bg-light text-light';  ?> mb-1"><i class="fas fa-check"></i></div>
										<div class="line"></div>
									  </div>
									  <div>
										<h5 class="text-dark">Interview</h5>
										<p class="lead text-muted pb-3"><?php echo($interview['status'] > 2 ) ? 'DONE' : 'N/A';  ?></p>
									  </div>
									</div>
									<div class="d-flex mb-1">
									  <div class="d-flex flex-column pr-4 align-items-center">
										<div class="rounded-circle py-2 px-3 <?php echo($interview['status'] > 3 ) ? 'bg-primary text-white' : 'bg-light text-light';  ?> mb-1"><i class="fas fa-check"></i></div>
										<div class="line "></div>
									  </div>
									  <div>
										<h5 class="text-dark">Result</h5>
										<?php 
										    $class="text-muted";
											if($interview['result']){
											
												if($interview['result'] == 'pass'){
													$class="text-success";
												}elseif($interview['result'] == 'fail'){
													$class="text-danger";
												}else{
													$class="text-muted";
												}
											
											}
									    ?>
										<p class="lead <?php echo $class; ?>  pb-3"><?php echo($interview['status'] > 3 ) ? strtoupper($interview['result']) : 'N/A';  ?></p>
									  </div>
									</div>
									<div class="d-flex mb-1">
									  <div class="d-flex flex-column pr-4 align-items-center">
										<div class="rounded-circle py-2 px-3 <?php echo($interview['status'] > 4 ) ? 'bg-primary text-white' : 'bg-light text-light';  ?> mb-1"><i class="fas fa-check"></i></div>
										<div class="line d-none"></div>
									  </div>
									  <div>
										<h5 class="text-dark">Feedback</h5>
										<p class="lead text-muted pb-3"><?php echo($interview['status'] > 4 ) ? $interview['feedback'] : 'N/A';  ?></p>
									  </div>
									</div>
								  </div>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
    </div>
	
  <!-- [] end --> 

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

      
    </style>
<div class="row">
        <div class="col-md-12 m-2">
        <div class="card">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-md-8">
			  <div class="inner-div">
                <div class="h5_heading">
                  <h1><?= $result['first_name'];?> <span class="color"><?= $result['last_name'];?></span></h1>
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
                <img class="img-radius img-fluid wid-80" src="<?= base_url().'/public/uploads/users/'.$result['profile_photo'];?>" alt="<?= $result['first_name'].' '.$result['last_name']; ?>">
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
  <!-- [] end --> 
</div>

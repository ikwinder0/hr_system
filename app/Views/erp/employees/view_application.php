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

<div class="row">
        <div class="col-md-12 m-2">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                <div class="h5_heading">
                  <h1>AMIT <span class="color">SINHA</span></h1>
                  <h6>ACCOUNTS EXECUTIVE</h6>
                </div>
                <div class="second-part">
                <h6>PROFILE</h6>
                <hr>
                <p>Accurate and immensely motivated Finance student. Highly skilled at generating and analyzing financial reports,leading cash flow analysis,and refining tax plans.</p>
                </div>
                
                  <div class="h5_heading">
                  <h6>WORK EXPERIENCE</h6>
                  <div class="row">
                    <div class="col-md-4">
                      <p>2020-present</p>

                    </div>
                    <div class="col-md-8">
                      <h5>Jr.Accounts Executive</h5>
                      <p>Joy 4 Us Toys, Noida,UP</p>
                      <ul class="margin">
                        <li>Collect,interpret and review financial information</li>
                        <li>Predict financial trends</li>
                        <li>Reports for management and stakeholders</li>
                        <hr>
                      </ul>
                      
                    </div>
                    <div class="col-md-4">
                      <p>May-Dec,2019</p>
                    </div>
                    <div class="col-md-8">
                      <h5>Accounting intership</h5>
                      <p>Tire universe,Muzaffarnagar, UP, india</p>
                      <ul class="margin">
                        <li>Daily report preparation</li>
                        <li>Target analysis and adjudication</li>
                        <li>Department meeting initiations</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="h5_heading">
                  <h6>EDUCATION</h6>
                  <div class="row">
                    <div class="col-md-4">
                      <p>2017 to 2018</p>

                    </div>
                    <div class="col-md-8">
                      <h5>MA in economics</h5>
                      <p>Batch Topper(gold medalist & Rank 1,Northern University.</p>
                      <p>CGPA:9.4/10</p>
                      <hr>
                      
                    </div>
                    <div class="col-md-4">
                      <p>2014 to 2016</p>
                    </div>
                    <div class="col-md-8">
                      <h5>BSc.Mathematics</h5>
                      <p>Batch Topper(Silver medalist & Rank 2,Northern University.</p>
                       <p>CGPA:99%</p>
                    </div>
                  </div>
                </div>
                <div class="h5_heading">
                  <h6>CERTIFICATIONS</h6>
                  <p>Chartered Financial Analyst(CFA)certification Financial Risk Manager(FRM) certification.</p>
                </div>

            
              
            </div>
            
            <div class="col-md-4 right-div">
              <div class="photo-section">
                <img src="stevejobs.jpg" class="photo">
              </div>
                <div class="right-second right-side-color px-3">
                  <h6>CONTACT</h6>
                  <div class="row">

                    <div class="col-md-2 col-sm-6" >

                   <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="col-md-9 col-sm-6">
                    <h5>Address</h5>
                    <p>E2345,cleo country,noida</p>
                    </div>
                    <div class="col-md-2 " >

                    <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="col-md-9">
                    <h5>Phone</h5>
                    <p>909 090 9090</p>
                    </div>
                     <div class="col-md-2" >
                      <i class="fas fa-envelope"></i>
                    </div>
                    <div class="col-md-9">
                    <h5>Email</h5>
                    <p>amritsinha@abc.com</p>
                    </div>
                </div>
                

                
              </div>
              <div class="third-left right-side-color px-3">
                  <h6>SKILLS</h6>
                  <h5>Languages</h5>
                  <p>English,Spanish,German,Japanese</p>
                  <hr>
                  <h5>Interpersonal</h5>
                  <p>skill</p>
                  <hr>
                </div>
           
          </div>
        </div>
      </div>
      
      </div>
    </div>
    </div>
  <!-- [] end --> 
</div>

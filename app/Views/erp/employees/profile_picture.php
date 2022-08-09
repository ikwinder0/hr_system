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

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('staff2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/profile-picture');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-image"></span>
      Profile Picture
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        Profile Picture
      </div>
      </a> </li>
    <?php } ?>
	<?php if($user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/update-documents');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file"></span>
      Documents
      <div class="text-muted small">
       Set Documents
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('shift1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/candidate-other-info');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-info"></span>
      Other Info
      <div class="text-muted small">
        Set up other info
      </div>
      </a> </li>
    <?php } ?>
	
  </ul>
</div>
<hr class="border-light m-0 mb-3">

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
		   <?php if($result['is_active']=='1'): ?>
            <div class="certificated-badge"> <i class="fas fa-certificate text-primary bg-icon"></i> <i class="fas fa-check front-icon text-white"></i> </div>
			<?php endif; ?>
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
    </div>
  </div>
  <input type="hidden" id="user_id" value="<?= udecode($segment_id);?>" />
  <div class="col-lg-8">
    <div class="tab-content" id="user-set-tabContent">
        <div class="tab-pane fade show active" id="user-set-basicinfo" role="tabpanel" aria-labelledby="user-set-basicinfo-tab">
        </div>
    </div>
  </div>
</div>

?>
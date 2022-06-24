<?php
use App\Models\SystemModel;
use App\Models\JobsModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\ConstantsModel;
use App\Models\DesignationModel;
use App\Models\JobcandidatesModel;

$SystemModel = new SystemModel();
$JobsModel = new JobsModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();
$ConstantsModel = new ConstantsModel();
$DesignationModel = new DesignationModel();
$JobcandidatesModel = new JobcandidatesModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$request = \Config\Services::request();
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();

$segment_id = $request->uri->getSegment(3);
$ifield_id = udecode($segment_id);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$job_data = $JobsModel->where('company_id',$user_info['company_id'])->where('job_id',$ifield_id)->first();
	$count_job = $JobcandidatesModel->where('company_id',$user_info['company_id'])->where('staff_id',$usession['sup_user_id'])->where('job_id',$ifield_id)->countAllResults();
	$idesignations = $DesignationModel->where('designation_id',$job_data['designation_id'])->first();
	if($idesignations){
		$designation_name = $idesignations['designation_name'];
	} else {
		$designation_name = '--';
	}
} else {
	$job_data = $JobsModel->where('company_id',$usession['sup_user_id'])->where('job_id', $ifield_id)->first();
	$count_job = $JobcandidatesModel->where('company_id',$usession['sup_user_id'])->where('staff_id',$usession['sup_user_id'])->where('job_id', $ifield_id)->countAllResults();
	$idesignations = $DesignationModel->where('designation_id',$job_data['designation_id'])->first();
	if($idesignations){
		$designation_name = $idesignations['designation_name'];
	} else {
		$designation_name = '--';
	}
}
if($job_data['job_type']==1){
	$job_type = lang('Recruitment.xin_full_time');
} else if($job_data['job_type']==2){
	$job_type = lang('Recruitment.xin_part_time');
} else if($job_data['job_type']==3){
	$job_type = lang('Recruitment.xin_internship');
} else {
	$job_type = lang('Recruitment.xin_freelance');
}
// gender
if($job_data['gender']==0){
	$gender = lang('Main.xin_gender_male');
} else if($job_data['gender']==1){
	$gender = lang('Main.xin_gender_female');
} else {
	$gender = lang('Recruitment.xin_no_reference');
}
// status
if($job_data['status']==1){
	$status = '<span class="badge badge-light-success">'.lang('Recruitment.xin_published').'</span>';
} else {
	$status = '<span class="badge badge-light-danger">'.lang('Recruitment.xin_unpublished').'</span>';
}
?>
<?php if($job_data['minimum_experience'] == 0): $experience = lang('Recruitment.xin_job_fresh'); endif;?>
<?php if($job_data['minimum_experience'] == 1): $experience = lang('Employees.xin_1year'); endif;?>
<?php if($job_data['minimum_experience'] == 2): $experience = lang('Employees.xin_2years'); endif;?>
<?php if($job_data['minimum_experience'] == 3): $experience = lang('Employees.xin_3years'); endif;?>
<?php if($job_data['minimum_experience'] == 4): $experience = lang('Employees.xin_4years'); endif;?>
<?php if($job_data['minimum_experience'] == 5): $experience = lang('Employees.xin_5years'); endif;?>
<?php if($job_data['minimum_experience'] == 6): $experience = lang('Employees.xin_6years'); endif;?>
<?php if($job_data['minimum_experience'] == 7): $experience = lang('Employees.xin_7years'); endif;?>
<?php if($job_data['minimum_experience'] == 8): $experience = lang('Employees.xin_8years'); endif;?>
<?php if($job_data['minimum_experience'] == 9): $experience = lang('Employees.xin_9years'); endif;?>
<?php if($job_data['minimum_experience'] == 10): $experience = lang('Employees.xin_10years'); endif;?>
<?php if($job_data['minimum_experience'] == 11): $experience = lang('Employees.xin_10plus_years'); endif;?>

<div class="row">
  <div class="col-xl-4 col-lg-12 task-detail-right">
    <div class="card">
      <div class="card-header">
        <h5><?php echo lang('Recruitment.xin_job_details');?></h5>
      </div>
      <div class="card-body task-details">
        <table class="table">
          <tbody>
            <tr>
              <td><i class="fas fa-adjust m-r-5"></i> <?php echo lang('Recruitment.xin_job_type');?>:</td>
              <td class="text-right"><span class="float-right">
                <?= $job_type;?>
                </span></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Dashboard.left_designation');?>:</td>
              <td class="text-right"><?= $designation_name;?></td>
            </tr>
            <tr>
              <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Recruitment.xin_job_experience');?>:</td>
              <td class="text-right"><?= $experience;?></td>
            </tr>
            <tr>
              <td><i class="far fa-credit-card m-r-5"></i>
                <?= lang('Recruitment.xin_positions');?>
                :</td>
              <td class="text-right"><?= $job_data['job_vacancy']?></td>
            </tr>
            <tr>
              <td><i class="fas fa-chart-line m-r-5"></i>
                <?= lang('Recruitment.xin_closing_date');?>
                :</td>
              <td class="text-right"><div class="btn-group">
                  <?= set_date_format($job_data['date_of_closing']);?>
                </div></td>
            </tr>
            <tr>
              <td><i class="fas fa-sync-alt m-r-5"></i>
                <?= lang('Main.xin_employee_gender');?>
                :</td>
              <td class="text-right"><?= $gender;?></td>
            </tr>
            <tr>
              <td><i class="fas fa-thermometer-half m-r-5"></i>
                <?= lang('Main.dashboard_xin_status');?>
                :</td>
              <td class="text-right"><?= $status;?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-xl-8 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-3"><i class="fas fa-ticket-alt m-r-5"></i>
          <?= $job_data['job_title'];?>
        </h5>
        <?php if($count_job > 0){?>
        <div class="alert alert-danger" role="alert">
          <?= lang('Recruitment.xin_already_applied');?>
        </div>
        <?php } else { ?>
        <a data-toggle="collapse" href="#apply_form" aria-expanded="false" class="btn waves-effect waves-light btn-primary float-right">
        <?= lang('Recruitment.xin_apply_for_this_job');?>
        </a>
        <?php } ?>
      </div>
      <?php if($count_job == 0){?>
      <div id="apply_form" class="collapse apply-form" data-parent="#accordion" style="">
        <div id="accordion">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
            <?= lang('Recruitment.xin_apply_for_this_job');?>
            </strong> </span> </div>
          <?php $attributes = array('name' => 'apply_job', 'id' => 'apply_job', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open('erp/recruitment/apply_job', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 col-lg-6">
                <div class="form-group">
                  <label for="name">
                    <?= lang('Employees.xin_full_name');?>
                    <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control" name="name" value="<?= $user['first_name'].' '.$user['last_name'];?>" disabled="disabled">
                </div>
              </div>
              <div class="col-md-12 col-lg-6">
                <div class="form-group">
                  <label for="name">
                    <?= lang('Main.xin_email');?>
                    <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control" name="name" value="<?= $user['email'];?>" disabled="disabled">
                </div>
              </div>
              <div class="col-md-12 col-lg-12">
                <div class="form-group">
                  <label for="name">
                    <?= lang('Recruitment.xin_cover_letter');?>
                    <span class="text-danger">*</span> </label>
                  <textarea class="form-control" name="cover_letter" rows="3"></textarea>
                </div>
              </div>
              <div class="col-md-12 col-lg-6">
                <div class="form-group">
                  <label for="logo">
                    <?= lang('Recruitment.xin_upload_cv');?>
                    <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="file_cv">
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
          <div class="card-footer text-right">
            <button type="reset" class="btn btn-light" href="#apply_form" data-toggle="collapse" aria-expanded="false">
            <?= lang('Main.xin_reset');?>
            </button>
            &nbsp;
            <button type="submit" class="btn btn-primary">
            <?= lang('Recruitment.xin_apply');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
      <?php } ?>
      <div class="card-body">
        <div class="m-b-20">
          <h6>
            <?= lang('Recruitment.xin_overview');?>
          </h6>
          <hr>
          <p>
            <?= html_entity_decode($job_data['short_description']);?>
          </p>
        </div>
        <div class="m-b-20">
          <h6>
            <?= lang('Recruitment.xin_job_description');?>
          </h6>
          <hr>
          <p>
            <?= html_entity_decode($job_data['long_description']);?>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

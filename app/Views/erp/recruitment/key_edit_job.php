<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\JobsModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;
use App\Models\JobcandidatesModel;
use App\Models\JobinterviewsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$JobsModel = new JobsModel();
$DesignationModel = new DesignationModel();
$StaffdetailsModel = new StaffdetailsModel();
$JobcandidatesModel = new JobcandidatesModel();
$JobinterviewsModel = new JobinterviewsModel();

$segment_id = $request->uri->getSegment(3);
$job_id = udecode($segment_id);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$employee_detail = $StaffdetailsModel->where('user_id', $user_info['user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$get_job = $JobsModel->where('company_id',$user_info['company_id'])->where('job_id', $job_id)->first();
	$designations = $DesignationModel->where('company_id',$user_info['company_id'])->where('department_id',$employee_detail['department_id'])->orderBy('designation_id', 'ASC')->findAll();
} else {
	$get_job = $JobsModel->where('company_id',$usession['sup_user_id'])->where('job_id', $job_id)->first();
	$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->orderBy('designation_id', 'ASC')->findAll();
}
/*
* Job Create - View Page
*/
?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-12">
    <?php if(in_array('ats4',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <?php $attributes = array('name' => 'update_job', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
    <?php $hidden = array('token' => $segment_id);?>
    <?= form_open('erp/recruitment/update_job', $attributes, $hidden);?>
    <div class="card mb-2">
      <div class="card-header">
        <h5>
          <?= lang('Recruitment.xin_edit_job');?>
        </h5>
        <div class="card-header-right"> <a href="<?= site_url().'erp/jobs-list';?>" class="btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="list"></i>
          <?= lang('Recruitment.xin_jobs_list');?>
          </a> </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title"><?php echo lang('Dashboard.xin_title');?> <span class="text-danger">*</span></label>
              <input class="form-control" placeholder="<?php echo lang('Dashboard.xin_title');?>" name="job_title" type="text" value="<?= $get_job['job_title'];?>">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="job_type"><?php echo lang('Recruitment.xin_job_type');?> <span class="text-danger">*</span></label>
              <select class="form-control" name="job_type" data-plugin="select_hrm" data-placeholder="<?php echo lang('Recruitment.xin_job_type');?>">
                <option value=""></option>
                <option value="1" <?php if($get_job['job_type'] == 1):?> selected="selected"<?php endif;?>><?php echo lang('Recruitment.xin_full_time');?></option>
                <option value="2" <?php if($get_job['job_type'] == 2):?> selected="selected"<?php endif;?>><?php echo lang('Recruitment.xin_part_time');?></option>
                <option value="3" <?php if($get_job['job_type'] == 3):?> selected="selected"<?php endif;?>><?php echo lang('Recruitment.xin_internship');?></option>
                <option value="4" <?php if($get_job['job_type'] == 4):?> selected="selected"<?php endif;?>><?php echo lang('Recruitment.xin_freelance');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="designation"><?php echo lang('Dashboard.left_designation');?> <span class="text-danger">*</span></label>
              <select class="form-control" name="designation_id" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.left_designation');?>">
                <option value=""></option>
                <?php foreach($designations as $idesignation):?>
                <option value="<?= $idesignation['designation_id'];?>" <?php if($get_job['designation_id'] == $idesignation['designation_id']):?> selected="selected"<?php endif;?>>
                <?= $idesignation['designation_name'];?>
                </option>
                <?php endforeach;?>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="vacancy"><?php echo lang('Recruitment.xin_number_of_positions');?> <span class="text-danger">*</span></label>
              <input class="form-control" placeholder="<?php echo lang('Recruitment.xin_number_of_positions');?>" name="vacancy" type="text" value="<?= $get_job['job_vacancy'];?>">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="status"><?php echo lang('Main.dashboard_xin_status');?></label>
              <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo lang('Main.dashboard_xin_status');?>">
                <option value="1" <?php if($get_job['status'] == 1):?> selected="selected"<?php endif;?>><?php echo lang('Recruitment.xin_published');?></option>
                <option value="2" <?php if($get_job['status'] == 2):?> selected="selected"<?php endif;?>><?php echo lang('Recruitment.xin_unpublished');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="date_of_closing" class="control-label"><?php echo lang('Recruitment.xin_date_of_closing');?> <span class="text-danger">*</span></label>
              <input class="form-control date" placeholder="<?php echo lang('Recruitment.xin_date_of_closing');?>" name="date_of_closing" type="text" value="<?= $get_job['date_of_closing'];?>">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="gender"><?php echo lang('Main.xin_employee_gender');?></label>
              <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo lang('Main.xin_employee_gender');?>">
                <option value="0" <?php if($get_job['gender'] == 0):?> selected="selected"<?php endif;?>><?php echo lang('Main.xin_gender_male');?></option>
                <option value="1" <?php if($get_job['gender'] == 1):?> selected="selected"<?php endif;?>><?php echo lang('Main.xin_gender_female');?></option>
                <option value="2" <?php if($get_job['gender'] == 2):?> selected="selected"<?php endif;?>><?php echo lang('Recruitment.xin_no_reference');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="experience" class="control-label"><?php echo lang('Recruitment.xin_job_minimum_experience');?></label>
              <select class="form-control" name="experience" data-plugin="select_hrm" data-placeholder="<?php echo lang('Recruitment.xin_job_minimum_experience');?>">
                <option value="0" <?php if($get_job['minimum_experience'] == 0):?> selected="selected"<?php endif;?>><?php echo lang('Recruitment.xin_job_fresh');?></option>
                <option value="1" <?php if($get_job['minimum_experience'] == 1):?> selected="selected"<?php endif;?>><?php echo lang('Employees.xin_1year');?></option>
                <option value="2" <?php if($get_job['minimum_experience'] == 2):?> selected="selected"<?php endif;?>><?php echo lang('Employees.xin_2years');?></option>
                <option value="3" <?php if($get_job['minimum_experience'] == 3):?> selected="selected"<?php endif;?>><?php echo lang('Employees.xin_3years');?></option>
                <option value="4" <?php if($get_job['minimum_experience'] == 4):?> selected="selected"<?php endif;?>><?php echo lang('Employees.xin_4years');?></option>
                <option value="5" <?php if($get_job['minimum_experience'] == 5):?> selected="selected"<?php endif;?>><?php echo lang('Employees.xin_5years');?></option>
                <option value="6" <?php if($get_job['minimum_experience'] == 6):?> selected="selected"<?php endif;?>><?php echo lang('Employees.xin_6years');?></option>
                <option value="7" <?php if($get_job['minimum_experience'] == 7):?> selected="selected"<?php endif;?>><?php echo lang('Employees.xin_7years');?></option>
                <option value="8" <?php if($get_job['minimum_experience'] == 8):?> selected="selected"<?php endif;?>><?php echo lang('Employees.xin_8years');?></option>
                <option value="9" <?php if($get_job['minimum_experience'] == 9):?> selected="selected"<?php endif;?>><?php echo lang('Employees.xin_9years');?></option>
                <option value="10" <?php if($get_job['minimum_experience'] == 10):?> selected="selected"<?php endif;?>><?php echo lang('Employees.xin_10years');?></option>
                <option value="11" <?php if($get_job['minimum_experience'] == 11):?> selected="selected"<?php endif;?>><?php echo lang('Employees.xin_10plus_years');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="short_description"><?php echo lang('Recruitment.xin_short_description');?> <span class="text-danger">*</span></label>
              <textarea class="form-control editor" placeholder="<?php echo lang('Recruitment.xin_short_description');?>" name="short_description" cols="30" rows="3" id="editor"><?= $get_job['short_description'];?>
</textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="long_description"><?php echo lang('Recruitment.xin_long_description');?> <span class="text-danger">*</span></label>
              <textarea class="form-control editor" placeholder="<?php echo lang('Recruitment.xin_long_description');?>" name="long_description" style="width:100%; height:300px" rows="10" cols="30" id="editor"><?= $get_job['long_description'];?>
</textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary btn-lg">
        <?= lang('Recruitment.xin_edit_job');?>
        </button>
      </div>
      <?php echo form_close(); ?> </div>
    <?php } ?>
  </div>
</div>

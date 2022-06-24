<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\ConstantsModel;
use App\Models\TrackgoalsModel;
use App\Models\TasksModel;
use App\Models\TravelModel;
use App\Models\TrainingModel;
use App\Models\AwardsModel;
use App\Models\ProjectsModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();
$TasksModel = new TasksModel();
$TravelModel = new TravelModel();
$TrainingModel = new TrainingModel();
$AwardsModel = new AwardsModel();
$ProjectsModel = new ProjectsModel();
$ConstantsModel = new ConstantsModel();
$TrackgoalsModel = new TrackgoalsModel();

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
	$training = assigned_staff_training($usession['sup_user_id']);
	$projects = $ProjectsModel->where('company_id', $user_info['company_id'])->findAll();
	$tasks = $TasksModel->where('company_id',$user_info['company_id'])->orderBy('task_id', 'ASC')->findAll();
	$awards = $AwardsModel->where('employee_id',$user_info['user_id'])->orderBy('award_id', 'ASC')->findAll();
	$travel = $TravelModel->where('employee_id',$user_info['user_id'])->orderBy('travel_id', 'ASC')->findAll();
	$all_tracking_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','goal_type')->orderBy('constants_id', 'ASC')->findAll();
	$track_data = $TrackgoalsModel->where('company_id',$user_info['company_id'])->where('tracking_id',$ifield_id)->first();
	$type_data = $ConstantsModel->where('company_id',$user_info['company_id'])->where('constants_id',$track_data['tracking_type_id'])->where('type','goal_type')->first();
	if($type_data){
		$itracking_type = $type_data['category_name'];
	} else {
		$itracking_type = '--';
	}
} else {
	$tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->orderBy('task_id', 'ASC')->findAll();
	$projects = $ProjectsModel->where('company_id', $usession['sup_user_id'])->findAll();
	
	$awards = $AwardsModel->where('company_id',$usession['sup_user_id'])->orderBy('award_id', 'ASC')->findAll();
	$travel = $TravelModel->where('company_id',$usession['sup_user_id'])->orderBy('travel_id', 'ASC')->findAll();
	$training = $TrainingModel->where('company_id',$usession['sup_user_id'])->orderBy('training_id', 'ASC')->findAll();
	$all_tracking_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','goal_type')->orderBy('constants_id', 'ASC')->findAll();
	$track_data = $TrackgoalsModel->where('company_id',$usession['sup_user_id'])->where('tracking_id', $ifield_id)->first();
	$type_data = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('constants_id', $track_data['tracking_type_id'])->where('type','goal_type')->first();
	if($type_data){
		$itracking_type = $type_data['category_name'];
	} else {
		$itracking_type = '--';
	}
}
$goal_work = unserialize($track_data['goal_work']);
//$added_by = $UsersModel->where('user_id',$track_data['added_by'])->first();
?>

<div class="row"> 
  <!-- [ trackgoal-detail-left ] start -->
  <div class="col-xl-4 col-lg-12 task-detail-right">
    <div class="card">
      <div class="card-header">
        <h5>
          <?= lang('Performance.xin_goal_details');?>
        </h5>
      </div>
      <div class="card-body task-details">
        <table class="table">
          <tbody>
            <tr>
              <td><i class="fas fa-adjust m-r-5"></i> <?php echo lang('Dashboard.xin_hr_goal_tracking_type');?>:</td>
              <td class="text-right"><span class="float-right">
                <?= $itracking_type;?>
                </span></td>
            </tr>
            <tr>
              <td><i class="fas fa-chart-line m-r-5"></i> <?php echo lang('Projects.dashboard_xin_progress');?>:</td>
              <td class="text-right"><div class="btn-group"> <?php echo lang('Projects.xin_completed');?>
                  <?= $track_data['goal_progress'];?>
                  % </div></td>
            </tr>
           
          </tbody>
        </table>
        <?php if(in_array('tracking5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <?php $attributes = array('name' => 'update_rating', 'id' => 'update_rating', 'autocomplete' => 'off');?>
        <?php $hidden = array('token' => $segment_id);?>
        <?= form_open('erp/trackgoals/update_rating', $attributes, $hidden);?>
        <div class="row text-center">
          <div class="col-md-12">
            <div class="form-group">
              <label for="goal_rating">
                <?= lang('Performance.xin_goal_rating');?>
              </label>
              <select class="star-rating" name="goal_rating" autocomplete="off">
                <option value=""></option>
                <option value="1" <?php if($track_data['goal_rating'] == 1):?> selected="selected"<?php endif;?>>1</option>
                <option value="2" <?php if($track_data['goal_rating'] == 2):?> selected="selected"<?php endif;?>>2</option>
                <option value="3" <?php if($track_data['goal_rating'] == 3):?> selected="selected"<?php endif;?>>3</option>
                <option value="4" <?php if($track_data['goal_rating'] == 4):?> selected="selected"<?php endif;?>>4</option>
                <option value="5" <?php if($track_data['goal_rating'] == 5):?> selected="selected"<?php endif;?>>5</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-footer text-center">
          <button type="submit" class="btn btn-success"><?php echo lang('Performance.xin_update_rating');?></button>
        </div>
        <?= form_close(); ?>
        <?php } ?>
      </div>
    </div>
  </div>
  <!-- [ trackgoal-detail-left ] end --> 
  <!-- [ trackgoal-detail-right ] start -->
  <div class="col-lg-8">
    <div class="bg-light card mb-2">
      <div class="card-body">
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
          <li class="nav-item"> <a class="nav-link active" id="pills-overview-tab" data-toggle="pill" href="#pills-overview" role="tab" aria-controls="pills-overview" aria-selected="true">
            <?= lang('Main.xin_overview');?>
            </a> </li>
          <?php if(in_array('tracking3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item"> <a class="nav-link" id="pills-edit-tab" data-toggle="pill" href="#pills-edit" role="tab" aria-controls="pills-edit" aria-selected="false">
            <?= lang('Main.xin_edit');?>
            </a> </li>
          <?php } ?>
          <li class="nav-item"> <a class="nav-link" id="pills-work-tab" data-toggle="pill" href="#pills-work" role="tab" aria-controls="pills-work" aria-selected="false">
            <?= lang('Main.xin_add_work');?>
            </a> </li>
        </ul>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h5><i class="feather icon-lock mr-1"></i><?php echo lang('Performance.xin_goal_details');?> :
          <?= $itracking_type;?>
        </h5>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless">
                <tbody class="text-muted">
                  <tr>
                      <td><i class="fas fa-adjust m-r-5"></i> <?php echo lang('Dashboard.xin_hr_goal_tracking_type');?>:</td>
                      <td><span>
                        <?= $itracking_type;?>
                        </span></td>
                    </tr>
                    <tr>
                      <td><i class="far fa-calendar-alt m-r-5"></i> <?php echo lang('Main.xin_subject');?>:</td>
                      <td><?= $track_data['subject'];?></td>
                    </tr>
                    <tr>
                      <td><i class="far fa-credit-card m-r-5"></i>
                        <?= lang('Performance.xin_target');?>
                        :</td>
                      <td><?= $track_data['target_achiement'];?></td>
                    </tr>
                    <tr>
                      <td><i class="fas fa-chart-line m-r-5"></i> <?php echo lang('Projects.dashboard_xin_progress');?>:</td>
                      <td><div class="btn-group"> <?php echo lang('Projects.xin_completed');?>
                          <?= $track_data['goal_progress'];?>
                          % </div></td>
                    </tr>
                    <tr>
                      <td><i class="fas fa-sync-alt m-r-5"></i> <?php echo lang('Projects.xin_start_date');?>:</td>
                      <td><?= $track_data['start_date'];?></td>
                    </tr>
                    <tr>
                      <td><i class="fas fa-sync-alt m-r-5"></i> <?php echo lang('Projects.xin_end_date');?>:</td>
                      <td><?= $track_data['end_date'];?></td>
                    </tr>
                </tbody>
              </table>
            </div>
            <div class="m-b-20 m-t-20">
              <h6><?php echo lang('Main.xin_related_work');?></h6>
              <hr>
              <div class="table-responsive">
              <table class="table table-borderless">
                <tbody class="text-muted">
                    <tr>
                      <td><i class="fas fa-layer-group m-r-5"></i> <?php echo lang('Projects.xin_project');?>:</td>
                      <td>
                        <?php foreach($projects as $iprojects) {?>
                        <?php if($goal_work['project'] == $iprojects['project_id']):?>
                        <?= $iprojects['title'] ?>
                        <?php endif;?>
                        <?php } ?>
                        </td>
                    </tr>
                    <tr>
                      <td><i class="fas fa-edit m-r-5"></i> <?php echo lang('Projects.xin_task');?>:</td>
                      <td>
                      <?php foreach($tasks as $_task) {?>
                        <?php if($goal_work['task'] == $_task['task_id']):?>
                        <?= $_task['task_name'] ?>
                        <?php endif;?>
                        <?php } ?>
                        </td>
                    </tr>
                    <tr>
                      <td><i class="fas fa-award m-r-5"></i> <?php echo lang('Dashboard.left_award');?>:</td>
                      <td>
                      <?php foreach($awards as $_award) {?>
						<?php $award_cat = $ConstantsModel->where('constants_id', $_award['award_type_id'])->where('type','award_type')->first(); ?>
                        <?php if($goal_work['award'] == $award_cat['constants_id']):?>
                        <?= $award_cat['category_name'] ?>
                        <?php endif;?>
                        <?php } ?>
                        </td>
                    </tr>
                    <tr>
                      <td><i class="fas fa-star-of-life m-r-5"></i> <?php echo lang('Dashboard.left_training');?>:</td>
                      <td>
                      <?php foreach($training as $_training) {?>
						<?php $training_cat = $ConstantsModel->where('constants_id', $_training['training_type_id'])->where('type','training_type')->first(); ?>
                        <?php if($goal_work['training'] == $training_cat['constants_id']):?>
                        <?= $training_cat['category_name'] ?>
                        <?php endif;?>
                        <?php } ?>
                        </td>
                    </tr>
                    <tr>
                      <td><i class="fas fa-globe m-r-5"></i> <?php echo lang('Dashboard.left_travel');?>:</td>
                      <td>
                      <?php foreach($travel as $_travel) {?>
						<?php $travel_type = $ConstantsModel->where('constants_id', $_travel['arrangement_type'])->where('type','travel_type')->first(); ?>
                        <?php if($goal_work['travel'] == $travel_type['constants_id']):?>
                        <?= $travel_type['category_name'] ?>
                        <?php endif;?>
                        <?php } ?>
                    </td>
                    </tr>
                </tbody>
              </table>
            </div>
            </div>
            <div class="m-b-20 m-t-20">
              <h6><?php echo lang('Main.xin_description');?></h6>
              <hr>
              <?= html_entity_decode($track_data['description']);?>
            </div>
          </div>
        </div>
        <?php if(in_array('tracking3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade" id="pills-edit" role="tabpanel" aria-labelledby="pills-overview-tab">
          <?php $attributes = array('name' => 'update_goal_tracking', 'id' => 'update_goal_tracking', 'autocomplete' => 'off', 'class' => 'form-hrm');?>
		  <?php $hidden = array('token' => $segment_id);?>
          <?php echo form_open('erp/trackgoals/update_goal_tracking', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tracking_type"><?php echo lang('Dashboard.xin_hr_goal_tracking_type');?> <span class="text-danger">*</span></label>
                  <select class="form-control" name="tracking_type" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.xin_hr_goal_tracking_type');?>">
                    <option value=""></option>
                    <?php foreach($all_tracking_types as $tracking_type) {?>
                    <option value="<?= $tracking_type['constants_id'];?>" <?php if($track_data['tracking_type_id']==$tracking_type['constants_id']):?> selected="selected"<?php endif;?>>
                    <?= $tracking_type['category_name'];?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="xin_subject"><?php echo lang('Main.xin_subject');?> <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?php echo lang('Main.xin_subject');?>" name="subject" type="text" value="<?= $track_data['subject'];?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="target_achiement"><?php echo lang('Performance.xin_hr_target_achiement');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-vector-square"></i></span></div>
                    <input class="form-control" placeholder="<?php echo lang('Performance.xin_hr_target_achiement');?>" name="target_achiement" type="text" value="<?= $track_data['target_achiement'];?>">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="hidden" id="progres_val" name="progres_val" value="<?= $track_data['goal_progress'];?>">
                  <label for="progress">
                    <?= lang('Projects.dashboard_xin_progress');?>
                  </label>
                  <input type="text" id="range_grid">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="status">
                    <?= lang('Main.dashboard_xin_status');?>
                  </label>
                  <select name="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>...">
                    <option value="0" <?php if($track_data['goal_status']=='0'):?> selected <?php endif; ?>>
                    <?= lang('Projects.xin_not_started');?>
                    </option>
                    <option value="1" <?php if($track_data['goal_status']=='1'):?> selected <?php endif; ?>>
                    <?= lang('Projects.xin_in_progress');?>
                    </option>
                    <option value="2" <?php if($track_data['goal_status']=='2'):?> selected <?php endif; ?>>
                    <?= lang('Projects.xin_completed');?>
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="start_date"><?php echo lang('Projects.xin_start_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_start_date');?>" name="start_date" type="text" value="<?= $track_data['start_date'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="end_date"><?php echo lang('Projects.xin_end_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_end_date');?>" name="end_date" type="text" value="<?= $track_data['end_date'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description"><?php echo lang('Main.xin_description');?></label>
                  <textarea class="form-control editor" placeholder="<?php echo lang('Main.xin_description');?>" name="description" rows="4"> <?= $track_data['description'];?>
    </textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Performance.xin_update_goal');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
        <?php } ?>
        <div class="tab-pane fade" id="pills-work" role="tabpanel" aria-labelledby="pills-work-tab">
          <?php $attributes = array('name' => 'add_work', 'id' => 'add_work', 'autocomplete' => 'off', 'class' => 'form-hrm');?>
		  <?php $hidden = array('token' => $segment_id);?>
          <?php echo form_open('erp/trackgoals/add_work', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tracking_type"><?php echo lang('Projects.xin_project');?> <a href="<?= site_url('erp/projects-grid');?>"><i class="fas fa-plus"></i></a> </label>
                  <select class="form-control" name="goal_work[project]" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_project');?>">
                    <option value=""></option>
                    <?php foreach($projects as $iprojects) {?>
                    <?php $associated_goals = explode(',',$iprojects['associated_goals']); ?>
                    <?php if(in_array($track_data['tracking_type_id'],$associated_goals)):?>
                    <option value="<?= $iprojects['project_id']?>" <?php if($goal_work['project'] == $iprojects['project_id']):?> selected="selected"<?php endif;?>>
                    <?= $iprojects['title'] ?>
                    </option>
                    <?php endif;?>
					<?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tracking_type"><?php echo lang('Projects.xin_task');?> <a href="<?= site_url('erp/tasks-grid');?>"><i class="fas fa-plus"></i></a></label>
                  <select class="form-control" name="goal_work[task]" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_task');?>">
                    <option value=""></option>
                    <?php foreach($tasks as $_task) {?>
                    <?php $associated_goals = explode(',',$_task['associated_goals']); ?>
                    <?php if(in_array($track_data['tracking_type_id'],$associated_goals)):?>
                    <option value="<?= $_task['task_id']?>" <?php if($goal_work['task'] == $_task['task_id']):?> selected="selected"<?php endif;?>>
                    <?= $_task['task_name'] ?>
                    </option>
                    <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="tracking_type"><?php echo lang('Dashboard.left_award');?> <a href="<?= site_url('erp/awards-list');?>"><i class="fas fa-plus"></i></a></label>
                  <select class="form-control" name="goal_work[award]" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.left_award');?>">
                    <option value=""></option>
                    <?php foreach($awards as $_award) {?>
                    <?php $associated_goals = explode(',',$_award['associated_goals']); ?>
                    <?php if(in_array($track_data['tracking_type_id'],$associated_goals)):?>
                    <?php $award_cat = $ConstantsModel->where('constants_id', $_award['award_type_id'])->where('type','award_type')->first(); ?>
                    <option value="<?= $award_cat['constants_id']?>" <?php if($goal_work['award'] == $award_cat['constants_id']):?> selected="selected"<?php endif;?>>
                    <?= $award_cat['category_name'] ?>
                    </option>
                    <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="tracking_type"><?php echo lang('Dashboard.left_training');?> <a href="<?= site_url('erp/training-sessions');?>"><i class="fas fa-plus"></i></a></label>
                  <select class="form-control" name="goal_work[training]" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.left_training');?>">
                    <option value=""></option>
                    <?php foreach($training as $_training) {?>
                    <?php $associated_goals = explode(',',$_training['associated_goals']); ?>
                    <?php if(in_array($track_data['tracking_type_id'],$associated_goals)):?>
                    <?php $training_cat = $ConstantsModel->where('constants_id', $_training['training_type_id'])->where('type','training_type')->first(); ?>
                    <option value="<?= $training_cat['constants_id']?>" <?php if($goal_work['training'] == $training_cat['constants_id']):?> selected="selected"<?php endif;?>>
                    <?= $training_cat['category_name'] ?>
                    </option>
                    <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="tracking_type"><?php echo lang('Dashboard.left_travel');?> <a href="<?= site_url('erp/business-travel');?>"><i class="fas fa-plus"></i></a></label>
                  <select class="form-control" name="goal_work[travel]" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.left_travel');?>">
                    <option value=""></option>
                    <?php foreach($travel as $_travel) {?>
                    <?php $associated_goals = explode(',',$_travel['associated_goals']); ?>
                    <?php if(in_array($track_data['tracking_type_id'],$associated_goals)):?>
                    <?php $travel_type = $ConstantsModel->where('constants_id', $_travel['arrangement_type'])->where('type','travel_type')->first(); ?>
                    <option value="<?= $travel_type['constants_id']?>" <?php if($goal_work['travel'] == $travel_type['constants_id']):?> selected="selected"<?php endif;?>>
                    <?= $travel_type['category_name'] ?>
                    </option>
                    <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="alert alert-primary" role="alert">
                <?= lang('Main.xin_add_work_details');?>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_add_work');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- [ trackgoal-detail-right ] end -->
</div>

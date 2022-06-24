<?php
use CodeIgniter\I18n\Time;
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\TasksModel;
use App\Models\LanguageModel;
use App\Models\ConstantsModel;
use App\Models\ProjectsModel;
use App\Models\TrackgoalsModel;
use App\Models\ProjectnotesModel;
use App\Models\ProjectfilesModel;
use App\Models\ProjectbugsModel;
use App\Models\ProjecttimelogsModel;
use App\Models\ProjectdiscussionModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$TasksModel = new TasksModel();
$LanguageModel = new LanguageModel();
$ProjectsModel = new ProjectsModel();
$TrackgoalsModel = new TrackgoalsModel();
$ConstantsModel = new ConstantsModel();
$ProjectnotesModel = new ProjectnotesModel();
$ProjectbugsModel = new ProjectbugsModel();
$ProjectfilesModel = new ProjectfilesModel();
$ProjecttimelogsModel = new ProjecttimelogsModel();
$ProjectdiscussionModel = new ProjectdiscussionModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$xin_system = $SystemModel->where('setting_id', 1)->first();
$locale = service('request')->getLocale();
$request = \Config\Services::request();

$segment_id = $request->uri->getSegment(3);
$project_id = udecode($segment_id);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','staff')->findAll();
	$all_clients = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','customer')->findAll();
	$project_data = $ProjectsModel->where('company_id',$user_info['company_id'])->where('project_id', $project_id)->first();
	$track_goals = $TrackgoalsModel->where('company_id',$user_info['company_id'])->orderBy('tracking_id', 'ASC')->findAll();
	$projects = $ProjectsModel->where('company_id', $user_info['company_id'])->findAll();
	$timelog_data = $ProjecttimelogsModel->where('company_id',$user_info['company_id'])->where('project_id',$project_id)->orderBy('timelogs_id', 'ASC')->findAll();
} else {
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
	$all_clients = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','customer')->findAll();
	$project_data = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('project_id', $project_id)->first();
	$track_goals = $TrackgoalsModel->where('company_id',$usession['sup_user_id'])->orderBy('tracking_id', 'ASC')->findAll();
	$projects = $ProjectsModel->where('company_id', $usession['sup_user_id'])->findAll();
	$timelog_data = $ProjecttimelogsModel->where('company_id',$usession['sup_user_id'])->where('project_id',$project_id)->orderBy('timelogs_id', 'ASC')->findAll();
}
// project bug
$project_bug = $ProjectbugsModel->where('project_id', $project_id)->orderBy('project_bug_id', 'ASC')->findAll();
// project notes
$project_notes = $ProjectnotesModel->where('project_id', $project_id)->orderBy('project_note_id', 'ASC')->findAll();
// project discussion
$project_discussion = $ProjectdiscussionModel->where('project_id', $project_id)->orderBy('project_discussion_id', 'ASC')->findAll();
// project files
$project_files = $ProjectfilesModel->where('project_id', $project_id)->orderBy('project_file_id', 'ASC')->findAll();
// get type||variable
$get_type = $request->getVar('type',FILTER_SANITIZE_STRING);
$get_animate='';
?>

<div class="row">
  <div class="col-lg-4">
    <div class="card hdd-right-inner">
      <div class="card-header">
        <h5><?php echo lang('Projects.xin_project_details');?></h5>
        <?php if(in_array('project2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="card-header-right"> <a href="<?= site_url('erp/projects-grid');?>" data-toggle="tab" aria-expanded="false" class="">
          <button type="button" class="btn btn-shadow btn-secondary btn-sm"><i class="mr-2 feather icon-edit"></i><?php echo lang('Projects.xin_add_project');?></button>
          </a> </div>
        <?php } ?>
      </div>
      <input type="hidden" value="<?= $segment_id;?>" id="project_id" />
      <?php if(in_array('project5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <?php $attributes = array('name' => 'update_project_progress', 'id' => 'update_project_progress', 'autocomplete' => 'off');?>
      <?php $hidden = array('token' => $segment_id);?>
      <?php echo form_open('erp/projects/update_project_progress', $attributes, $hidden);?>
      <?php } ?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="progress">
                <?= lang('Projects.dashboard_xin_progress');?>
              </label>
              <input type="hidden" id="progres_val" name="progres_val" value="<?= $project_data['project_progress'];?>">
              <input type="text" id="range_grid">
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="form-group project-status">
              <label for="status">
                <?= lang('Main.dashboard_xin_status');?> <span class="text-danger">*</span>
              </label>
              <select class="form-control demo-movie" name="status">
                <option value="0" <?php if($project_data['status']=='0'):?> selected <?php endif; ?>>
                <?= lang('Projects.xin_not_started');?>
                </option>
                <option value="1" <?php if($project_data['status']=='1'):?> selected <?php endif; ?>>
                <?= lang('Projects.xin_in_progress');?>
                </option>
                <option value="3" <?php if($project_data['status']=='3'):?> selected <?php endif; ?>>
                <?= lang('Projects.xin_project_cancelled');?>
                </option>
                <option value="4" <?php if($project_data['status']=='4'):?> selected <?php endif; ?>>
                <?= lang('Projects.xin_project_hold');?>
                </option>
                <option value="2" <?php if($project_data['status']=='2'):?> selected <?php endif; ?>>
                <?= lang('Projects.xin_completed');?>
                </option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="status">
                <?= lang('Projects.xin_p_priority');?> <span class="text-danger">*</span>
              </label>
              <select name="priority" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_p_priority');?>">
                <option value="1" <?php if(1==$project_data['priority']):?> selected="selected"<?php endif;?>><?php echo lang('Projects.xin_highest');?></option>
                <option value="2" <?php if(2==$project_data['priority']):?> selected="selected"<?php endif;?>><?php echo lang('Projects.xin_high');?></option>
                <option value="3" <?php if(3==$project_data['priority']):?> selected="selected"<?php endif;?>><?php echo lang('Projects.xin_normal');?></option>
                <option value="4" <?php if(4==$project_data['priority']):?> selected="selected"<?php endif;?>><?php echo lang('Projects.xin_low');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <?php if(in_array('project5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">
        <?= lang('Main.xin_update_status');?>
        </button>
      </div>
      <?= form_close(); ?>
      <?php } ?>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="bg-light card mb-2">
      <div class="card-body">
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
          <li class="nav-item"> <a class="nav-link active" id="pills-overview-tab" data-toggle="pill" href="#pills-overview" role="tab" aria-controls="pills-overview" aria-selected="true">
            <?= lang('Main.xin_overview');?>
            </a> </li>
          <?php if(in_array('project3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item"> <a class="nav-link" id="pills-edit-tab" data-toggle="pill" href="#pills-edit" role="tab" aria-controls="pills-edit" aria-selected="false">
            <?= lang('Main.xin_edit');?>
            </a> </li>
          <?php } ?>
          <?php if(in_array('project6',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item"> <a class="nav-link" id="pills-discussion-tab" data-toggle="pill" href="#pills-discussion" role="tab" aria-controls="pills-discussion" aria-selected="false">
            <?= lang('Projects.xin_discussion');?>
            </a> </li>
          <?php } ?>
          <?php if(in_array('project11',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item"> <a class="nav-link" id="pills-timelogs-tab" data-toggle="pill" href="#pills-timelogs" role="tab" aria-controls="pills-timelogs" aria-selected="false">
            <?= lang('Dashboard.xin_project_timelogs');?>
            </a> </li>
          <?php } ?>
          <?php if(in_array('project7',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item"> <a class="nav-link" id="pills-bugs-tab" data-toggle="pill" href="#pills-bugs" role="tab" aria-controls="pills-bugs" aria-selected="false">
            <?= lang('Projects.xin_bugs');?>
            </a> </li>
          <?php } ?>
          <?php if(in_array('project8',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item"> <a class="nav-link" id="pills-tasks-tab" data-toggle="pill" href="#pills-tasks" role="tab" aria-controls="pills-tasks" aria-selected="false">
            <?= lang('Dashboard.left_tasks');?>
            </a> </li>
          <?php } ?>
          <?php if(in_array('project9',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item"> <a class="nav-link" id="pills-files-tab" data-toggle="pill" href="#pills-files" role="tab" aria-controls="pills-files" aria-selected="false">
            <?= lang('Projects.xin_attach_files');?>
            </a> </li>
          <?php } ?>
          <?php if(in_array('project10',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item"> <a class="nav-link" id="pills-notes-tab" data-toggle="pill" href="#pills-notes" role="tab" aria-controls="pills-notes" aria-selected="false">
            <?= lang('Projects.xin_note');?>
            </a> </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h5><i class="feather icon-lock mr-1"></i><?php echo lang('Projects.xin_project');?> :
          <?= $project_data['title'];?>
        </h5>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade <?php if($get_type==''):?>show active<?php endif;?>" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table m-b-0 f-14 b-solid requid-table">
                <tbody class="text-muted">
                  <tr>
                    <td><?php echo lang('Dashboard.xin_title');?></td>
                    <td><?= $project_data['title'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Projects.xin_client');?></td>
                    <td><?php foreach($all_clients as $client) {?>
                      <?php if($client['user_id']==$project_data['client_id']):?>
                      <?= $client['first_name'].' '.$client['last_name'] ?>
                      <?php endif;?>
                      <?php } ?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Projects.xin_estimated_hour');?></td>
                    <td><?= $project_data['budget_hours'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Projects.xin_p_priority');?></td>
                    <td><?php if(1==$project_data['priority']):?>
                      <?php echo lang('Projects.xin_highest');?>
                      <?php endif;?>
                      <?php if(2==$project_data['priority']):?>
                      <?php echo lang('Projects.xin_high');?>
                      <?php endif;?>
                      <?php if(3==$project_data['priority']):?>
                      <?php echo lang('Projects.xin_normal');?>
                      <?php endif;?>
                      <?php if(4==$project_data['priority']):?>
                      <?php echo lang('Projects.xin_low');?>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Projects.xin_start_date');?></td>
                    <td><i class="far fa-calendar-alt"></i>&nbsp;
                      <?= $project_data['start_date'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Projects.xin_end_date');?></td>
                    <td><i class="far fa-calendar-alt"></i>&nbsp;
                      <?= $project_data['end_date'];?></td>
                  </tr>
                  <?php $assigned_to = explode(',',$project_data['assigned_to']); ?>
                  <tr>
                    <td><?php echo lang('Projects.xin_project_users');?></td>
                    <td><?= multi_user_profile_photo($assigned_to);?></td>
                  </tr>
                  <?php
				 	$hrs_old_int1 = 0;
					$Total = '';
					$Trest = '';
					$total_time_rs = '';
					$hrs_old_int_res1 = '';
                  foreach($timelog_data as $_timelog){
					  // total work			
					$timee = $_timelog['total_hours'].':00';
					$str_time =$timee;
		
					$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
					
					sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
					
					$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
					
					$hrs_old_int1 += $hrs_old_seconds;
					
					$Total = gmdate("H:i", $hrs_old_int1);	
				  }
				  if($Total=='') {
						$total_work = '00:00';
					} else {
						$total_work = $Total;
					}
				  ?>
                  <tr>
                    <td><?php echo lang('Projects.xin_total_hours');?></td>
                    <td><?= $total_work;?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <?php $associated_goals = explode(',',$project_data['associated_goals']); ?>
            <div class="m-b-20 m-t-20">
              <h6><?php echo lang('Main.xin_associated_goals');?></h6>
              <hr>
              <div class="table-responsive">
              <table class="table table-borderless">
                <tbody class="text-muted">
                <?php $gi =1;foreach($track_goals as $track_goal) {?>
				<?php $tracking_type = $ConstantsModel->where('constants_id',$track_goal['tracking_type_id'])->first(); ?>
                <?php if(in_array($tracking_type['constants_id'],$associated_goals)):?>
                <tr>
                  <td><a target="_blank" href="<?= site_url('erp/goal-details/').uencode($track_goal['tracking_id']);?>"><?= $tracking_type['category_name'] ?></a></td>
                </tr>
                <?php endif;?>
                <?php $gi++; } ?>
                </tbody>
              </table>
            </div>
            </div>
            <div class="m-b-30 m-t-15">
              <h6><?php echo lang('Main.xin_summary');?></h6>
              <hr>
              <?= $project_data['summary'];?>
            </div>
            <div class="m-b-20">
              <h6><?php echo lang('Main.xin_description');?></h6>
              <hr>
              <?= html_entity_decode($project_data['description']);?>
            </div>
          </div>
        </div>
        <?php if(in_array('project3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade <?php if($get_type=='edit'):?>show active<?php endif;?>" id="pills-edit" role="tabpanel" aria-labelledby="pills-overview-tab">
          <?php $attributes = array('name' => 'update_project', 'id' => 'update_project', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open('erp/projects/update_project', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="title"><?php echo lang('Dashboard.xin_title');?> <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?php echo lang('Dashboard.xin_title');?>" name="title" type="text" value="<?= $project_data['title'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="client_id"><?php echo lang('Projects.xin_client');?> <span class="text-danger">*</span></label>
                  <select name="client_id" id="client_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_client');?>">
                    <option value=""></option>
                    <?php foreach($all_clients as $client) {?>
                    <option value="<?= $client['user_id']?>" <?php if($client['user_id']==$project_data['client_id']):?> selected="selected"<?php endif;?>>
                    <?= $client['first_name'].' '.$client['last_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <input type="hidden" value="0" name="assigned_to[]" />
              <div class="col-md-4">
                <div class="form-group">
                  <label for="budget_hours"><?php echo lang('Projects.xin_estimated_hour');?></label>
                  <div class="input-group">
                    <input class="form-control" placeholder="<?php echo lang('Projects.xin_estimated_hour');?>" name="budget_hours" type="text" value="<?= $project_data['budget_hours'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="start_date"><?php echo lang('Projects.xin_start_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_start_date');?>" name="start_date" type="text" value="<?= $project_data['start_date'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end_date"><?php echo lang('Projects.xin_end_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_end_date');?>" name="end_date" type="text" value="<?= $project_data['end_date'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="summary"><?php echo lang('Main.xin_summary');?> <span class="text-danger">*</span></label>
                  <textarea class="form-control" placeholder="<?php echo lang('Main.xin_summary');?>" name="summary" cols="30" rows="3"><?= $project_data['summary'];?>
</textarea>
                </div>
              </div>
              <?php $assigned_to = explode(',',$project_data['assigned_to']); ?>
              <div class="col-md-12">
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?php echo lang('Projects.xin_project_users');?></label>
                  <select multiple name="assigned_to[]" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_project_users');?>">
                    <option value=""></option>
                    <?php foreach($staff_info as $staff) {?>
                    <option value="<?= $staff['user_id']?>" <?php if(in_array($staff['user_id'],$assigned_to)):?> selected="selected"<?php endif;?>>
                    <?= $staff['first_name'].' '.$staff['last_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <input type="hidden" value="0" name="associated_goals[]" />
              <?php $associated_goals = explode(',',$project_data['associated_goals']); ?>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="employee"><?php echo lang('Main.xin_associated_goals');?></label>
                  <select multiple name="associated_goals[]" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo lang('Main.xin_associated_goals');?>">
                    <option value=""></option>
                    <?php foreach($track_goals as $track_goal) {?>
                    <?php $tracking_type = $ConstantsModel->where('constants_id',$track_goal['tracking_type_id'])->first(); ?>
                    <option value="<?= $tracking_type['constants_id']?>" <?php if(in_array($tracking_type['constants_id'],$associated_goals)):?> selected="selected"<?php endif;?>>
                    <?= $tracking_type['category_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description"><?php echo lang('Main.xin_description');?></label>
                  <textarea class="form-control editor" placeholder="<?php echo lang('Main.xin_description');?>" name="description" cols="30" rows="5"><?= $project_data['description'];?>
</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Projects.xin_update_project');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
        <?php } ?>
        <div class="tab-pane fade" id="pills-discussion" role="tabpanel" aria-labelledby="pills-discussion-tab">
          <div class="card-body task-comment">
            <ul class="media-list p-0">
              <?php $tn=0; foreach($project_discussion as $_discussion){ ?>
              <?php $time = Time::parse($_discussion['created_at']); ?>
              <?php $disc_user = $UsersModel->where('user_id', $_discussion['employee_id'])->first();?>
              <li class="media" id="discussion_option_id_<?= $_discussion['project_discussion_id'];?>">
                <div class="media-left mr-3"> <a href="#!"> <img class="img-fluid media-object img-radius comment-img" src="<?= staff_profile_photo($_discussion['employee_id']);?>" alt=""> </a> </div>
                <div class="media-body">
                  <h6 class="media-heading txt-primary">
                    <?= $disc_user['first_name'].' '.$disc_user['last_name'];?>
                    <span class="f-12 text-muted ml-1">
                    <?= time_ago($_discussion['created_at']);?>
                    </span></h6>
                  <?= html_entity_decode($_discussion['discussion_text']);?>
                  <div class="mt-2"><a href="#!" data-field="<?= $_discussion['project_discussion_id'];?>" class="delete_discussion m-r-10 text-secondary"><i class="fas fa-trash-alt text-danger mr-2"></i>
                    <?= lang('Main.xin_delete');?>
                    </a></div>
                </div>
              </li>
              <hr class="discussion_option_id_<?= $_discussion['project_discussion_id'];?>">
              <?php } ?>
            </ul>
            <?php $attributes = array('name' => 'add_discussion', 'id' => 'add_discussion', 'autocomplete' => 'off');?>
            <?php $hidden = array('token' => $segment_id);?>
            <?= form_open('erp/projects/add_discussion', $attributes, $hidden);?>
            <div class="input-group mb-3">
              <textarea class="form-control editor" name="description"><?= lang('Projects.xin_enter_discussion_msg');?>...</textarea>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">
              <?= lang('Main.xin_add');?>
              </button>
            </div>
            <?= form_close(); ?>
          </div>
        </div>
        <?php if(in_array('project11',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade" id="pills-timelogs" role="tabpanel" aria-labelledby="pills-timelogs-tab">
          <?php $attributes = array('name' => 'add_timelogs', 'id' => 'add_timelogs', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?= form_open('erp/projects/add_timelogs', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
             <?php if($user_info['user_type'] == 'company'){?>
              <?php $assigned_to = explode(',',$project_data['assigned_to']); ?>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="employee"><?php echo lang('Dashboard.dashboard_employee');?></label>
                  <select name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.dashboard_employee');?>">
                    <?php foreach($staff_info as $staff) {?>
                    <?php if(in_array($staff['user_id'],$assigned_to)):?>
                    <option value="<?= $staff['user_id']?>">
                    <?= $staff['first_name'].' '.$staff['last_name'] ?>
                    </option>
                    <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } ?>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="budget_hours"><?php echo lang('Projects.xin_start_time');?></label>
                  <div class="input-group">
                    <input class="form-control timepicker" placeholder="<?php echo lang('Projects.xin_start_time');?>" name="start_time" type="text">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="budget_hours"><?php echo lang('Projects.xin_end_time');?></label>
                  <div class="input-group">
                    <input class="form-control timepicker" placeholder="<?php echo lang('Projects.xin_end_time');?>" name="end_time" type="text">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="start_date"><?php echo lang('Projects.xin_start_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_start_date');?>" name="start_date" type="text">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end_date"><?php echo lang('Projects.xin_end_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_end_date');?>" name="end_date" type="text">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="summary"><?php echo lang('Projects.xin_memo');?> <span class="text-danger">*</span></label>
                  <textarea class="form-control" placeholder="<?php echo lang('Projects.xin_memo');?>" name="memo" cols="30" rows="2"></textarea>
                </div>
              </div>
              
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Projects.xin_add_timelog');?>
            </button>
          </div>
          <?= form_close(); ?>
          <div class="card user-profile-list">
                <div class="card-header">
                  <h5>
                    <?= lang('Main.xin_list_all');?>
                    <?= lang('Dashboard.xin_project_timelogs');?>
                  </h5>
                </div>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_timelogs_table" style="width:100%;">
                      <thead>
                        <tr>
                          <th><?php echo lang('Dashboard.dashboard_employee');?></th>
                          <th><?php echo lang('Projects.xin_start_date');?></th>
                          <th><?php echo lang('Projects.xin_end_date');?></th>
                          <th><?php echo lang('Projects.xin_total_hours');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
        </div>
        <?php } ?>
        <div class="tab-pane fade" id="pills-bugs" role="tabpanel" aria-labelledby="pills-bugs-tab">
          <div class="card-body task-comment">
            <ul class="media-list p-0">
              <?php $tn=0; foreach($project_bug as $_bug){ ?>
              <?php $time = Time::parse($_bug['created_at']); ?>
              <?php $bug_user = $UsersModel->where('user_id', $_bug['employee_id'])->first();?>
              <li class="media" id="bug_option_id_<?= $_bug['project_bug_id'];?>">
                <div class="media-left mr-3"> <a href="#!"> <img class="img-fluid media-object img-radius comment-img" src="<?= staff_profile_photo($_bug['employee_id']);?>" alt=""> </a> </div>
                <div class="media-body">
                  <h6 class="media-heading txt-primary">
                    <?= $bug_user['first_name'].' '.$bug_user['last_name'];?>
                    <span class="f-12 text-muted ml-1">
                    <?= time_ago($_bug['created_at']);?>
                    </span></h6>
                    <?= html_entity_decode($_bug['bug_note']);?>
                  <div class="mt-2"><a href="#!" data-field="<?= $_bug['project_bug_id'];?>" class="delete_bug m-r-10 text-secondary"><i class="fas fa-trash-alt text-danger mr-2"></i>
                    <?= lang('Main.xin_delete');?>
                    </a></div>
                </div>
              </li>
              <hr class="bug_option_id_<?= $_bug['project_bug_id'];?>">
              <?php } ?>
            </ul>
            <?php $attributes = array('name' => 'add_bug', 'id' => 'add_bug', 'autocomplete' => 'off');?>
            <?php $hidden = array('token' => $segment_id);?>
            <?= form_open('erp/projects/add_bug', $attributes, $hidden);?>
            <div class="input-group mb-3">
              <textarea class="form-control editor" name="description"><?= lang('Projects.xin_post_a_bug');?>...</textarea>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">
              <?= lang('Main.xin_add');?>
              </button>
            </div>
            <?= form_close(); ?>
          </div>
        </div>
        <div class="tab-pane fade" id="pills-tasks" role="tabpanel" aria-labelledby="pills-tasks-tab">
          <div class="row m-b-1 animated fadeInRight">
            <div class="col-md-12">
              <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
              <div id="add_form" class="collapse add-form <?= $get_animate;?>" data-parent="#accordion" style="">
                <div class="card">
                  <div id="accordion">
                    <div class="card-header">
                      <h5>
                        <?= lang('Main.xin_add_new');?>
                        <?= lang('Projects.xin_task');?>
                      </h5>
                      <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
                        <?= lang('Main.xin_hide');?>
                        </a> </div>
                    </div>
                    <?php $attributes = array('name' => 'add_task', 'id' => 'add_task', 'autocomplete' => 'off');?>
                    <?php $hidden = array('token' => $segment_id);?>
                    <?php echo form_open('erp/tasks/add_task', $attributes, $hidden);?>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="task_name"><?php echo lang('Dashboard.xin_title');?> <span class="text-danger">*</span></label>
                            <input class="form-control" placeholder="<?php echo lang('Dashboard.xin_title');?>" name="task_name" type="text" value="">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="start_date"><?php echo lang('Projects.xin_start_date');?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <input class="form-control date" placeholder="<?php echo lang('Projects.xin_start_date');?>" name="start_date" type="text" value="">
                              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="end_date"><?php echo lang('Projects.xin_end_date');?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <input class="form-control date" placeholder="<?php echo lang('Projects.xin_end_date');?>" name="end_date" type="text" value="">
                              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="task_hour" class="control-label"><?php echo lang('Projects.xin_estimated_hour');?></label>
                            <div class="input-group">
                              <input class="form-control" placeholder="<?php echo lang('Projects.xin_estimated_hour');?>" name="task_hour" type="text" value="">
                              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group" id="project_ajax">
                            <label for="project_ajax" class="control-label"><?php echo lang('Projects.xin_project');?> <span class="text-danger">*</span></label>
                            <select class="form-control" name="project_id" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_project');?>">
                              <option value=""></option>
                              <?php foreach($projects as $iprojects) {?>
                              <?php if($iprojects['project_id'] == $project_data['project_id']):?>
                              <option value="<?= $iprojects['project_id']?>" <?php if($iprojects['project_id'] == $project_data['project_id']):?> selected="selected"<?php endif;?>>
                              <?= $iprojects['title'] ?>
                              </option>
                              <?php endif;?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="summary"><?php echo lang('Main.xin_summary');?> <span class="text-danger">*</span></label>
                              <textarea class="form-control" placeholder="<?php echo lang('Main.xin_summary');?>" name="summary" cols="30" rows="2" id="summary"></textarea>
                            </div>
                          </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="description"><?php echo lang('Projects.xin_description');?></label>
                            <textarea class="form-control editor" placeholder="<?php echo lang('Projects.xin_description');?>" name="description" id="description"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false">
                      <?= lang('Main.xin_reset');?>
                      </button>
                      &nbsp;
                      <button type="submit" class="btn btn-primary">
                      <?= lang('Main.xin_save');?>
                      </button>
                    </div>
                    <?= form_close(); ?>
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="card user-profile-list">
                <div class="card-header">
                  <h5>
                    <?= lang('Main.xin_list_all');?>
                    <?= lang('Projects.xin_tasks');?>
                  </h5>
                  <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
                    <?= lang('Main.xin_add_new');?>
                    </a> </div>
                </div>
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin_table" style="width:100%;">
                      <thead>
                        <tr>
                          <th><?php echo lang('Dashboard.xin_title');?></th>
                          <th><?php echo lang('Projects.xin_project_users');?></th>
                          <th><?php echo lang('Projects.xin_start_date');?></th>
                          <th><?php echo lang('Projects.xin_end_date');?></th>
                          <th><?php echo lang('Projects.dashboard_xin_progress');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="pills-files" role="tabpanel" aria-labelledby="pills-files-tab">
          <div class="card-body">
            <div class="list-group list-group-flush list-pills border-bottom">
              <?php foreach($project_files as $_files){ ?>
              <?php $file_user = $UsersModel->where('user_id', $_files['employee_id'])->first();?>
              <div class="list-group-item list-group-item-action d-block py-3 file_option_id_<?= $_files['project_file_id'];?>">
                <div class="row" id="file_option_id_<?= $_files['project_file_id'];?>">
                  <div class="col-auto pr-0"> <img src="<?= staff_profile_photo($_files['employee_id']);?>" class="img-radius wid-40" alt="User-Profile-Image"> </div>
                  <div class="col"> <a href="#!">
                    <h6 class="mb-0">
                      <?= $_files['file_title'];?>
                      <span class="f-12 text-muted ml-1">
                      <?= time_ago($_files['created_at']);?>
                      </span> </h6>
                    </a> <small class="mb-0 text-muted"> <?php echo lang('Main.xin_by');?>: <a href="#!" class="text-muted font-weight-bold text-h-primary">
                    <?= $file_user['first_name'].' '.$file_user['last_name'];?>
                    </a> </small>
                    <div class="row justify-content-between">
                      <div class="col-auto mt-2"> <a href="<?php echo site_url('download')?>?type=project_files&filename=<?php echo uencode($_files['attachment_file']);?>" class="text-secondary"><i class="fas fa-download m-r-5"></i> <?php echo lang('Main.xin_download');?></a> </div>
                      <div class="col-auto mt-2">
                        <ul class="list-inline mb-0">
                          <li class="list-inline-item"><a href="#!" data-field="<?= $_files['project_file_id'];?>" class="delete_file text-body text-h-primary"><i class="fas fa-trash-alt text-danger mr-2"></i><span><?php echo lang('Main.xin_delete');?></span></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <?php $attributes = array('name' => 'add_attachment', 'id' => 'add_attachment', 'autocomplete' => 'off');?>
            <?php $hidden = array('token' => $segment_id);?>
            <?= form_open('erp/projects/add_attachment', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="row mt-4">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="task_name"><?php echo lang('Dashboard.xin_title');?> <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?php echo lang('Dashboard.xin_title');?>" name="file_name" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <fieldset class="form-group">
                      <label for="logo"><?php echo lang('Main.xin_attachment');?> <span class="text-danger">*</span></label>
                      <input type="file" class="form-control-file" id="attachment_file" name="attachment_file">
                      <small>
                      <?= lang('Main.xin_company_file_type');?>
                      </small>
                    </fieldset>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Projects.xin_add_file');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
        <div class="tab-pane fade" id="pills-notes" role="tabpanel" aria-labelledby="pills-notes-tab">
          <div class="card-body task-comment">
            <ul class="media-list p-0">
              <?php $tn=0; foreach($project_notes as $_note){ ?>
              <?php $time = Time::parse($_note['created_at']); ?>
              <?php $note_user = $UsersModel->where('user_id', $_note['employee_id'])->first();?>
              <li class="media" id="note_option_id_<?= $_note['project_note_id'];?>">
                <div class="media-left mr-3"> <a href="#!"> <img class="img-fluid media-object img-radius comment-img" src="<?= staff_profile_photo($_note['employee_id']);?>" alt=""> </a> </div>
                <div class="media-body">
                  <h6 class="media-heading txt-primary">
                    <?= $note_user['first_name'].' '.$note_user['last_name'];?>
                    <span class="f-12 text-muted ml-1">
                    <?= time_ago($_note['created_at']);?>
                    </span></h6>
                  <p>
                    <?= $_note['project_note'];?>
                  </p>
                  <div class="m-t-10"> <span><a href="#!" data-field="<?= $_note['project_note_id'];?>" class="delete_note m-r-10 text-secondary"><i class="fas fa-trash-alt text-danger mr-2"></i>
                    <?= lang('Main.xin_delete');?>
                    </a></span><span></span> </div>
                </div>
              </li>
              <hr class="note_option_id_<?= $_note['project_note_id'];?>">
              <?php } ?>
            </ul>
            <?php $attributes = array('name' => 'add_note', 'id' => 'add_note', 'autocomplete' => 'off');?>
            <?php $hidden = array('token' => $segment_id);?>
            <?= form_open('erp/projects/add_note', $attributes, $hidden);?>
            <div class="input-group mb-3">
              <input type="text" name="description" class="form-control" placeholder="<?= lang('Projects.xin_post_a_note');?>...">
              <div class="input-group-append">
                <button class="btn waves-effect waves-light btn-primary btn-icon" type="submit"><i class="fa fa-plus"></i></button>
              </div>
            </div>
            <?= form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

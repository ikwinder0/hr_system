<?php
use CodeIgniter\I18n\Time;
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\TasksModel;
use App\Models\LanguageModel;
use App\Models\ConstantsModel;
use App\Models\ProjectsModel;
use App\Models\TasknotesModel;
use App\Models\TaskfilesModel;
use App\Models\TrackgoalsModel;
use App\Models\TaskdiscussionModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$TasksModel = new TasksModel();
$LanguageModel = new LanguageModel();
$ProjectsModel = new ProjectsModel();
$TasknotesModel = new TasknotesModel();
$ConstantsModel = new ConstantsModel();
$TaskfilesModel = new TaskfilesModel();
$TrackgoalsModel = new TrackgoalsModel();
$TaskdiscussionModel = new TaskdiscussionModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$request = \Config\Services::request();
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();
$request = \Config\Services::request();

$segment_id = $request->uri->getSegment(3);
$task_id = udecode($segment_id);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$projects = $ProjectsModel->where('company_id', $user_info['company_id'])->findAll();
	$task_data = $TasksModel->where('company_id',$user_info['company_id'])->where('task_id', $task_id)->first();
	$staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','staff')->findAll();
	$track_goals = $TrackgoalsModel->where('company_id',$user_info['company_id'])->orderBy('tracking_id', 'ASC')->findAll();
} else {
	$projects = $ProjectsModel->where('company_id', $usession['sup_user_id'])->findAll();
	$task_data = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_id', $task_id)->first();
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
	$track_goals = $TrackgoalsModel->where('company_id',$usession['sup_user_id'])->orderBy('tracking_id', 'ASC')->findAll();
}
// task notes
$task_notes = $TasknotesModel->where('task_id', $task_id)->orderBy('task_note_id', 'ASC')->findAll();
// task discussion
$task_discussion = $TaskdiscussionModel->where('task_id', $task_id)->orderBy('task_discussion_id', 'ASC')->findAll();
// task files
$task_files = $TaskfilesModel->where('task_id', $task_id)->orderBy('task_file_id', 'ASC')->findAll();
// get type||variable
$get_type = $request->getVar('type',FILTER_SANITIZE_STRING);
?>

<div class="row">
  <div class="col-lg-4">
    <div class="card hdd-right-inner">
      <div class="card-header">
        <h5>
          <?= lang('Projects.xin_task_details');?>
        </h5>
        <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="card-header-right"> <a href="<?= site_url('erp/tasks-grid');?>">
          <button type="button" class="btn btn-shadow btn-secondary btn-sm"><i class="mr-2 feather icon-edit"></i>
          <?= lang('Projects.xin_add_task');?>
          </button>
          </a> </div>
        <?php } ?>
      </div>
      <?php if(in_array('task5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <?php $attributes = array('name' => 'update_task_progress', 'id' => 'update_task_progress', 'autocomplete' => 'off');?>
      <?php $hidden = array('token' => $segment_id);?>
      <?php echo form_open('erp/tasks/update_task_progress', $attributes, $hidden);?>
      <?php } ?>
      <div class="card-body">
        <div class="row justify-content-md-center">
          <div class="col-md-12">
            <div class="form-group">
              <label for="status"><?php echo lang('Projects.dashboard_xin_progress');?></label>
              <input type="hidden" id="progres_val" name="progres_val" value="<?= $task_data['task_progress'];?>">
              <input type="text" id="range_grid">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group task-status">
              <label for="status">
                <?= lang('Main.dashboard_xin_status');?>
                <span class="text-danger">*</span> </label>
              <select class="form-control demo-movie" name="status">
                <option value="0" <?php if($task_data['task_status']=='0'):?> selected <?php endif; ?>>
                <?= lang('Projects.xin_not_started');?>
                </option>
                <option value="1" <?php if($task_data['task_status']=='1'):?> selected <?php endif; ?>>
                <?= lang('Projects.xin_in_progress');?>
                </option>
                <option value="3" <?php if($task_data['task_status']=='3'):?> selected <?php endif; ?>>
                <?= lang('Projects.xin_project_cancelled');?>
                </option>
                <option value="4" <?php if($task_data['task_status']=='4'):?> selected <?php endif; ?>>
                <?= lang('Projects.xin_project_hold');?>
                </option>
                <option value="2" <?php if($task_data['task_status']=='2'):?> selected <?php endif; ?>>
                <?= lang('Projects.xin_completed');?>
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <?php if(in_array('task5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
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
        <ul class="nav nav-pills mb-0">
          <li class="nav-item m-r-5"> <a href="#pills-overview" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Main.xin_overview');?>
            </button>
            </a> </li>
          <?php if(in_array('task3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item m-r-5"> <a href="#pills-edit" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Main.xin_edit');?>
            </button>
            </a> </li>
          <?php } ?>
          <?php if(in_array('task6',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item m-r-5"> <a href="#pills-discussion" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Projects.xin_task_discussion');?>
            </button>
            </a> </li>
          <?php } ?>
          <?php if(in_array('task8',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item m-r-5"> <a href="#pills-notes" data-toggle="tab" aria-expanded="true" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Projects.xin_post_a_note');?>
            </button>
            </a> </li>
          <?php } ?>
          <?php if(in_array('task7',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item m-r-5"> <a href="#pills-files" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-shadow btn-secondary text-uppercase">
            <?= lang('Projects.xin_task_files');?>
            </button>
            </a> </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h5><i class="feather icon-lock mr-1"></i>
          <?= lang('Projects.xin_task');?>
          :
          <?= $task_data['task_name'];?>
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
                    <td><?= $task_data['task_name'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Projects.xin_start_date');?></td>
                    <td><i class="far fa-calendar-alt"></i>&nbsp;
                      <?= $task_data['start_date'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Projects.xin_end_date');?></td>
                    <td><i class="far fa-calendar-alt"></i>&nbsp;
                      <?= $task_data['end_date'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Projects.xin_estimated_hour');?></td>
                    <td><?= $task_data['task_hour'];?></td>
                  </tr>
                  <tr>
                    <td><?php echo lang('Projects.xin_project');?></td>
                    <td><?php foreach($projects as $iprojects):?>
                      <?php if($iprojects['project_id']==$task_data['project_id']):?>
                      <?= $iprojects['title'];?>
                      <?php endif;?>
                      <?php endforeach;?></td>
                  </tr>
                  <?php $assigned_to = explode(',',$task_data['assigned_to']); ?>
                  <tr>
                    <td><?php echo lang('Projects.xin_project_users');?></td>
                    <td><?= multi_user_profile_photo($assigned_to);?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <?php $associated_goals = explode(',',$task_data['associated_goals']); ?>
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
              <?= $task_data['summary'];?>
            </div>
            <div class="m-b-30 m-t-15">
              <h6><?php echo lang('Main.xin_description');?></h6>
              <hr>
              <?= html_entity_decode($task_data['description']);?>
            </div>
          </div>
        </div>
        <?php if(in_array('task3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade <?php if($get_type=='edit'):?>show active<?php endif;?>" id="pills-edit" role="tabpanel" aria-labelledby="pills-edit-tab">
          <?php $attributes = array('name' => 'update_task', 'id' => 'update_task', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => $segment_id);?>
          <?php echo form_open('erp/tasks/update_task', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="task_name"><?php echo lang('Dashboard.xin_title');?> <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?php echo lang('Dashboard.xin_title');?>" name="task_name" type="text" value="<?= $task_data['task_name'];?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="start_date"><?php echo lang('Projects.xin_start_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_start_date');?>" name="start_date" type="text" value="<?= $task_data['start_date'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="end_date"><?php echo lang('Projects.xin_end_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_end_date');?>" name="end_date" type="text" value="<?= $task_data['end_date'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <input type="hidden" value="0" name="assigned_to[]" />
              <div class="col-md-4">
                <div class="form-group">
                  <label for="task_hour" class="control-label"><?php echo lang('Projects.xin_estimated_hour');?></label>
                  <div class="input-group">
                    <input class="form-control" placeholder="<?php echo lang('Projects.xin_estimated_hour');?>" name="task_hour" type="text" value="<?= $task_data['task_hour'];?>">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group" id="project_ajax">
                  <label for="project_ajax" class="control-label"><?php echo lang('Projects.xin_project');?> <span class="text-danger">*</span></label>
                  <select class="form-control" name="project_id" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_project');?>">
                    <option value=""></option>
                    <?php foreach($projects as $iprojects) {?>
                    <option value="<?= $iprojects['project_id']?>" <?php if($iprojects['project_id']==$task_data['project_id']):?> selected="selected"<?php endif;?>>
                    <?= $iprojects['title'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php $assigned_to = explode(',',$task_data['assigned_to']); ?>
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
              <?php $associated_goals = explode(',',$task_data['associated_goals']); ?>
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
                  <label for="summary"><?php echo lang('Main.xin_summary');?> <span class="text-danger">*</span></label>
                  <textarea class="form-control" placeholder="<?php echo lang('Main.xin_summary');?>" name="summary" cols="30" rows="2"><?= $task_data['summary'];?></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description"><?php echo lang('Main.xin_description');?></label>
                  <textarea class="form-control editor" placeholder="<?php echo lang('Main.xin_description');?>" rows="5" name="description"><?= $task_data['description'];?>
</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Projects.xin_update_task');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
        <?php } ?>
        <?php if(in_array('task6',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade <?php if($get_type=='discussion'):?>show active<?php endif;?>" id="pills-discussion" role="tabpanel" aria-labelledby="pills-discussion-tab">
          <div class="card-body task-comment">
            <ul class="media-list p-0">
              <?php $tn=0; foreach($task_discussion as $_discussion){ ?>
              <?php $time = Time::parse($_discussion['created_at']); ?>
              <?php $disc_user = $UsersModel->where('user_id', $_discussion['employee_id'])->first();?>
              <li class="media" id="discussion_option_id_<?= $_discussion['task_discussion_id'];?>">
                <div class="media-left mr-3"> <a href="#!"> <img class="img-fluid media-object img-radius comment-img" src="<?= staff_profile_photo($_discussion['employee_id']);?>" alt=""> </a> </div>
                <div class="media-body">
                  <h6 class="media-heading txt-primary">
                    <?= $disc_user['first_name'].' '.$disc_user['last_name'];?>
                    <span class="f-12 text-muted ml-1">
                    <?= time_ago($_discussion['created_at']);?>
                    </span></h6>
                  <?= html_entity_decode($_discussion['discussion_text']);?>
                  <div class="mt-2"><a href="#!" data-field="<?= $_discussion['task_discussion_id'];?>" class="delete_discussion m-r-10 text-secondary"><i class="fas fa-trash-alt text-danger mr-2"></i>
                    <?= lang('Main.xin_delete');?>
                    </a></div>
                </div>
              </li>
              <hr class="discussion_option_id_<?= $_discussion['task_discussion_id'];?>">
              <?php } ?>
            </ul>
            <?php $attributes = array('name' => 'add_discussion', 'id' => 'add_discussion', 'autocomplete' => 'off');?>
            <?php $hidden = array('token' => $segment_id);?>
            <?= form_open('erp/tasks/add_discussion', $attributes, $hidden);?>
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
        <?php } ?>
        <?php if(in_array('task8',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade <?php if($get_type=='notes'):?>show active<?php endif;?>" id="pills-notes" role="tabpanel" aria-labelledby="pills-notes-tab">
          <div class="card-body task-comment">
            <ul class="media-list p-0">
              <?php $tn=0; foreach($task_notes as $_note){ ?>
              <?php $time = Time::parse($_note['created_at']); ?>
              <?php $note_user = $UsersModel->where('user_id', $_note['employee_id'])->first();?>
              <li class="media" id="note_option_id_<?= $_note['task_note_id'];?>">
                <div class="media-left mr-3"> <a href="#!"> <img class="img-fluid media-object img-radius comment-img" src="<?= staff_profile_photo($_note['employee_id']);?>" alt=""> </a> </div>
                <div class="media-body">
                  <h6 class="media-heading txt-primary">
                    <?= $note_user['first_name'].' '.$note_user['last_name'];?>
                    <span class="f-12 text-muted ml-1">
                    <?= time_ago($_note['created_at']);?>
                    </span></h6>
                  <p>
                    <?= $_note['task_note'];?>
                  </p>
                  <div class="m-t-10"> <span><a href="#!" data-field="<?= $_note['task_note_id'];?>" class="delete_note m-r-10 text-secondary"><i class="fas fa-trash-alt text-danger mr-2"></i>
                    <?= lang('Main.xin_delete');?>
                    </a></span><span></span> </div>
                </div>
              </li>
              <hr class="note_option_id_<?= $_note['task_note_id'];?>">
              <?php } ?>
            </ul>
            <?php $attributes = array('name' => 'add_note', 'id' => 'add_note', 'autocomplete' => 'off');?>
            <?php $hidden = array('token' => $segment_id);?>
            <?= form_open('erp/tasks/add_note', $attributes, $hidden);?>
            <div class="input-group mb-3">
              <input type="text" name="description" class="form-control" placeholder="<?= lang('Projects.xin_post_a_note');?>...">
              <div class="input-group-append">
                <button class="btn waves-effect waves-light btn-primary btn-icon" type="submit"><i class="fa fa-plus"></i></button>
              </div>
            </div>
            <?= form_close(); ?>
          </div>
        </div>
        <?php } ?>
        <?php if(in_array('task7',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <div class="tab-pane fade <?php if($get_type=='files'):?>show active<?php endif;?>" id="pills-files" role="tabpanel" aria-labelledby="pills-files-tab">
          <div class="card-body">
            <div class="list-group list-group-flush list-pills border-bottom">
              <?php foreach($task_files as $_files){ ?>
              <?php $file_user = $UsersModel->where('user_id', $_files['employee_id'])->first();?>
              <div class="list-group-item list-group-item-action d-block py-3 file_option_id_<?= $_files['task_file_id'];?>">
                <div class="row" id="file_option_id_<?= $_files['task_file_id'];?>">
                  <div class="col-auto pr-0"> <img src="<?= staff_profile_photo($_files['employee_id']);?>" class="img-radius wid-40" alt=""> </div>
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
                      <div class="col-auto mt-2"> <a href="<?php echo site_url('download')?>?type=task_files&filename=<?php echo uencode($_files['attachment_file']);?>" class="text-secondary"><i class="fas fa-download m-r-5"></i> <?php echo lang('Main.xin_download');?></a> </div>
                      <div class="col-auto mt-2">
                        <ul class="list-inline mb-0">
                          <li class="list-inline-item"><a href="#!" data-field="<?= $_files['task_file_id'];?>" class="delete_file text-body text-h-primary"><i class="fas fa-trash-alt text-danger mr-2"></i><span><?php echo lang('Main.xin_delete');?></span></a></li>
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
            <?= form_open('erp/tasks/add_attachment', $attributes, $hidden);?>
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
        <?php } ?>
      </div>
    </div>
  </div>
</div>

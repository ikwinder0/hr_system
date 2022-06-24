<?php
use CodeIgniter\I18n\Time;
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\TrainingModel;
use App\Models\TrainersModel;
use App\Models\ConstantsModel;
use App\Models\TrackgoalsModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;
use App\Models\TrainingnotesModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();
$SystemModel = new SystemModel();			
$TrainingModel = new TrainingModel();
$TrainersModel = new TrainersModel();
$ConstantsModel = new ConstantsModel();
$TrackgoalsModel = new TrackgoalsModel();
$DesignationModel = new DesignationModel();
$StaffdetailsModel = new StaffdetailsModel();
$TrainingnotesModel = new TrainingnotesModel();
$get_animate = '';
$segment_id = $request->uri->getSegment(3);
$ifield_id = udecode($segment_id);
$result = $TrainingModel->where('training_id', $ifield_id)->first();
$xin_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'company'){
	$trainer = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','trainer')->findAll();
	$track_goals = $TrackgoalsModel->where('company_id',$usession['sup_user_id'])->orderBy('tracking_id', 'ASC')->findAll();
	$training_type = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','training_type')->orderBy('constants_id', 'ASC')->findAll();
} else {
	$trainer = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','trainer')->findAll();
	$track_goals = $TrackgoalsModel->where('company_id',$user_info['company_id'])->orderBy('tracking_id', 'ASC')->findAll();
	$training_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','training_type')->orderBy('constants_id', 'ASC')->findAll();
}
// training notes
$training_notes = $TrainingnotesModel->where('training_id', $ifield_id)->orderBy('training_note_id', 'ASC')->findAll();
// training type
$training_type = $ConstantsModel->where('constants_id',$result['training_type_id'])->where('type','training_type')->first();
if($training_type){
	$itype = $training_type['category_name'];
} else {
	$itype = '';
}
// trainer
$trainer = $TrainersModel->where('trainer_id',$result['trainer_id'])->first();
if($trainer){
	$trainer_name = $trainer['first_name'].' '.$trainer['last_name'];
} else {
	$trainer_name = '';
}
// status
if($result['training_status']==0):
	$_status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'<span>';
elseif($result['training_status']==1):
	$_status = '<span class="badge badge-light-primary">'.lang('Projects.xin_started').'<span>';
elseif($result['training_status']==2):
	$_status = '<span class="badge badge-light-success">'.lang('Projects.xin_completed').'<span>';
elseif($result['training_status']==3):
	$_status = '<span class="badge badge-light-danger">'.lang('Main.xin_rejected').'<span>';
endif;
?>

<div class="row"> 
  <!-- [ training-detail-left ] start -->
  <div class="col-xl-4 col-lg-12 task-detail-right">
    <?php if(in_array('training7',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <div class="card">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_update_status');?>
        </h5>
      </div>
      <?php $attributes = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
      <?php $hidden = array('token' => $segment_id);?>
      <?php echo form_open('erp/training/update_training_status', $attributes, $hidden);?>
      <div class="card-body">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="status">
                  <?= lang('Dashboard.left_performance');?> <span class="text-danger">*</span>
                </label>
                <select class="form-control" name="performance" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_performance');?>">
                  <option value="0" <?php if($result['performance']=='0'):?> selected <?php endif;?>>
                  <?= lang('Main.xin_not_included');?>
                  </option>
                  <option value="1" <?php if($result['performance']=='1'):?> selected <?php endif;?>>
                  <?= lang('Main.xin_satisfactory');?>
                  </option>
                  <option value="2" <?php if($result['performance']=='2'):?> selected <?php endif;?>>
                  <?= lang('Main.xin_average');?>
                  </option>
                  <option value="3" <?php if($result['performance']=='3'):?> selected <?php endif;?>>
                  <?= lang('Main.xin_poor');?>
                  </option>
                  <option value="4" <?php if($result['performance']=='4'):?> selected <?php endif;?>>
                  <?= lang('Main.xin_excellent');?>
                  </option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="status">
                  <?= lang('Main.dashboard_xin_status');?> <span class="text-danger">*</span>
                </label>
                <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
                  <option value="0" <?php if($result['training_status']=='0'):?> selected <?php endif;?>>
                  <?= lang('Main.xin_pending');?>
                  </option>
                  <option value="1" <?php if($result['training_status']=='1'):?> selected <?php endif;?>>
                  <?= lang('Projects.xin_started');?>
                  </option>
                  <option value="2" <?php if($result['training_status']=='2'):?> selected <?php endif;?>>
                  <?= lang('Projects.xin_completed');?>
                  </option>
                  <option value="3" <?php if($result['training_status']=='3'):?> selected <?php endif;?>>
                  <?= lang('Main.xin_rejected');?>
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="status">
                  <?= lang('Recruitment.xin_remarks');?> <span class="text-danger">*</span>
                </label>
                <textarea class="form-control" name="remarks" rows="4" cols="15" placeholder="<?= lang('Recruitment.xin_remarks');?>"><?= $result['remarks'];?>
</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">
        <?= lang('Main.xin_update_status');?>
        </button>
      </div>
      <?php echo form_close(); ?> </div>
    <?php } ?>
    <div class="card">
      <div class="card-header">
        <h5>
          <?= lang('Projects.xin_assigned_users');?>
        </h5>
      </div>
      <div class="card-body user-box assign-user">
        <?php $user_assigned = explode(',',$result['employee_id']);?>
        <?php foreach($user_assigned as $assign_id){?>
        <?php if($assign_id!=0){?>
        <?php $user_assign_info = $UsersModel->where('user_id', $assign_id)->first(); ?>
        <div class="media">
          <div class="media-left media-middle mr-3"> <img class="img-fluid img-radius" src="<?= staff_profile_photo($assign_id);?>"> </div>
          <div class="media-body">
            <h6>
              <?= $user_assign_info['first_name'].' '.$user_assign_info['last_name'];?>
            </h6>
            <?php
            // user designation
			$employee_detail = $StaffdetailsModel->where('user_id', $user_assign_info['user_id'])->first();
			$idesignations = $DesignationModel->where('designation_id',$employee_detail['designation_id'])->first();
			?>
            <p>
              <?= $idesignations['designation_name'];?>
            </p>
          </div>
          <div> <a href="#!" class="text-muted"> <i class="icon-options-vertical"></i></a> </div>
        </div>
        <?php } } ?>
      </div>
    </div>
  </div>
  <div class="col-xl-8 col-lg-12">
    <div class="bg-light card mb-2">
      <div class="card-body">
        <ul class="nav nav-pills mb-0">
          <li class="nav-item m-r-5"> <a href="#pills-home" data-toggle="tab" aria-expanded="false" class="">
            <button type="button" class="btn btn-secondary text-uppercase"><i class="mr-2 feather icon-message-square"></i>
            <?= lang('Main.xin_overview');?>
            </button>
            </a> </li>
          <?php if(in_array('training5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <li class="nav-item m-r-5"> <a href="#pills-profile" data-toggle="tab" aria-expanded="true" class="">
            <button type="button" class="btn btn-secondary text-uppercase"><i class="mr-2 feather icon-edit"></i>
            <?= lang('Projects.xin_post_a_note');?>
            </button>
            </a> </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="row mb-4">
              <div class="col-md-12"> <span class=" txt-primary"> <i class="fas fa-chart-line"></i> <strong>
                <?= lang('Main.xin_overview');?>
                </strong> </span> </div>
            </div>
            
            <div class="task-details">
              <table class="table">
                <tbody>
                  <tr>
                    <td><i class="fas fa-adjust m-r-5"></i>
                      <?= lang('Dashboard.left_training_skill');?>
                      :</td>
                    <td class="text-right"><span class="float-right">
                      <?= $itype;?>
                      </span></td>
                  </tr>
                  <tr>
                    <td><i class="fas fa-user m-r-5"></i>
                      <?= lang('Dashboard.left_trainer');?>
                      :</td>
                    <td class="text-right"><?= $trainer_name;?></td>
                  </tr>
                  <tr>
                    <td><i class="far fa-credit-card m-r-5"></i>
                      <?= lang('Main.xin_training_cost');?>
                      :</td>
                    <td class="text-right"><?= number_to_currency($result['training_cost'], $xin_system['default_currency'],null,2);?></td>
                  </tr>
                  <tr>
                    <td><i class="far fa-calendar-alt m-r-5"></i>
                      <?= lang('Projects.xin_start_date');?>
                      :</td>
                    <td class="text-right"><?= set_date_format($result['start_date']);?></td>
                  </tr>
                  <tr>
                    <td><i class="far fa-calendar-alt m-r-5"></i>
                      <?= lang('Projects.xin_end_date');?>
                      :</td>
                    <td class="text-right"><?= set_date_format($result['finish_date']);?></td>
                  </tr>
                  <tr>
                    <td><i class="fas fa-thermometer-half m-r-5"></i>
                      <?= lang('Main.dashboard_xin_status');?>
                      :</td>
                    <td class="text-right"><?= $_status;?></td>
                  </tr>
                  <tr>
                    <td><i class="far fa-calendar-alt m-r-5"></i>
                      <?= lang('Main.xin_created_at');?>
                      :</td>
                    <td class="text-right"><?= set_date_format($result['created_at']);?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <?php $associated_goals = explode(',',$result['associated_goals']); ?>
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
            <div class="row mb-4">
              <div class="col-md-12"> <span class=" txt-primary"> <i class="fas fa-chart-line"></i> <strong>
                <?= lang('Dashboard.left_training_details');?>
                </strong> </span> </div>
            </div>
            <div class="m-b-20">
              <?= html_entity_decode($result['description']);?>
            </div>
            
          </div>
          <?php if(in_array('training5',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="card-body task-comment">
              <ul class="media-list p-0">
                <?php $tn=0; foreach($training_notes as $_note){ ?>
                <?php $time = Time::parse($_note['created_at']); ?>
                <?php $note_user = $UsersModel->where('user_id', $_note['employee_id'])->first();?>
                <li class="media" id="option_id_<?= $_note['training_note_id'];?>">
                  <div class="media-left mr-3"> <a href="#!"> <img class="img-fluid media-object img-radius comment-img" src="<?= staff_profile_photo($_note['employee_id']);?>" alt=""> </a> </div>
                  <div class="media-body">
                    <h6 class="media-heading txt-primary">
                      <?= $note_user['first_name'].' '.$note_user['last_name'];?>
                      <span class="f-12 text-muted ml-1">
                      <?= time_ago($_note['created_at']);?>
                      </span></h6>
                    <p>
                      <?= $_note['training_note'];?>
                    </p>
                    <div class="m-t-10"> <span><a href="#!" data-field="<?= $_note['training_note_id'];?>" data-title="training" class="delete_data m-r-10 text-secondary"><i class="fas fa-trash-alt text-danger mr-2"></i>
                      <?= lang('Main.xin_delete');?>
                      </a></span><span></span> </div>
                  </div>
                </li>
                <hr class="option_id_<?= $_note['training_note_id'];?>">
                <?php } ?>
              </ul>
              <?php $attributes = array('name' => 'add_note', 'id' => 'add_note', 'autocomplete' => 'off');?>
              <?php $hidden = array('token' => $segment_id);?>
              <?= form_open('erp/training/add_note', $attributes, $hidden);?>
              <div class="input-group mb-3">
                <input type="text" name="description" class="form-control" placeholder="<?= lang('Projects.xin_create_note_list');?>">
                <div class="input-group-append">
                  <button class="btn waves-effect waves-light btn-primary btn-icon" type="submit"><i class="fa fa-plus"></i></button>
                </div>
              </div>
              <?= form_close(); ?>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  
  <!-- [ training-detail-right ] end --> 
</div>

<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\JobsModel;
use App\Models\JobcandidatesModel;
use App\Models\JobinterviewsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();	
$JobsModel = new JobsModel();			
$JobcandidatesModel = new JobcandidatesModel();
$JobinterviewsModel = new JobinterviewsModel();
$get_animate = '';
if($request->getGet('data') === 'candidate' && $request->getGet('field_id')){
$candidate_id = udecode($field_id);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$result = $JobcandidatesModel->where('company_id', $user_info['company_id'])->where('candidate_id', $candidate_id)->first();
	$staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_id!=', $usession['sup_user_id'])->where('user_id!=', $result['staff_id'])->where('user_type','staff')->findAll();
} else {
	$result = $JobcandidatesModel->where('company_id', $usession['sup_user_id'])->where('candidate_id', $candidate_id)->first();
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_id!=', $usession['sup_user_id'])->where('user_id!=', $result['staff_id'])->where('user_type','staff')->findAll();
}
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Recruitment.xin_update_candidate_status');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'update_candidate_status', 'id' => 'update_candidate_status', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/recruitment/update_candidate_status', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="name">
          <?= lang('Main.dashboard_xin_status');?>
          <span class="text-danger">*</span> </label>
        <select class="form-control" name="status" id="status" data-plugin="select_hrm" data-placeholder="<?php echo lang('Main.dashboard_xin_status');?>">
          <option value=""><?php echo lang('dashboard_xin_status');?></option>
          <option value="1" <?php if($result['application_status']=='1'):?> selected <?php endif; ?>><?php echo lang('Recruitment.xin_call_for_interview');?></option>
          <option value="3" <?php if($result['application_status']=='3'):?> selected <?php endif; ?>><?php echo lang('Main.xin_rejected');?></option>
        </select>
      </div>
    </div>
    <div class="col-md-6 reject_opt">
      <div class="form-group">
        <label for="interview_date"><?php echo lang('Recruitment.xin_interview_date');?> <span class="text-danger">*</span></label>
        <input class="form-control edate" placeholder="<?php echo lang('Recruitment.xin_interview_date');?>" name="interview_date" type="text" value="">
      </div>
    </div>
    <div class="col-md-6 reject_opt">
      <div class="form-group">
        <label for="interview_time" class="control-label"><?php echo lang('Recruitment.xin_interview_time');?> <span class="text-danger">*</span></label>
        <input class="form-control etimepicker" placeholder="<?php echo lang('Recruitment.xin_interview_time');?>" name="interview_time" type="text" value="">
      </div>
    </div>
    <div class="col-md-6 reject_opt">
      <div class="form-group">
        <label for="interview_place"><?php echo lang('Recruitment.xin_place_of_interview');?> <span class="text-danger">*</span></label>
        <input class="form-control" placeholder="<?php echo lang('Recruitment.xin_place_of_interview');?>" name="interview_place" type="text" value="">
      </div>
    </div>
    <div class="col-md-12 reject_opt">
      <div class="form-group">
        <label for="interview_place"><?php echo lang('Recruitment.xin_interviewer');?> <span class="text-danger">*</span></label>
        <select class="form-control" name="interviewer_id" data-plugin="select_hrm" data-placeholder="<?= lang('Recruitment.xin_interviewer');?>">
          <?php foreach($staff_info as $staff) {?>
          <option value="<?= $staff['user_id']?>">
          <?= $staff['first_name'].' '.$staff['last_name'] ?>
          </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-12 reject_opt">
      <div class="form-group">
        <label for="description"><?php echo lang('Main.xin_description');?> <span class="text-danger">*</span></label>
        <textarea class="form-control textarea" placeholder="<?php echo lang('Main.xin_description');?>" name="description" cols="30" rows="3" id="description"></textarea>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Recruitment.xin_update_status');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){ 

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	 
	Ladda.bind('button[type=submit]');
	$('.edate').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD',
		cancelText: 'Cancelll', okText: 'Okk',clearText: 'Clearr',nowText: 'Noww'
	});
	// Clock
	$('.etimepicker').bootstrapMaterialDatePicker({
		date: false,
		shortTime: true,
		format: 'HH:mm'
	});
	$("#status").change(function(){
		var status = $(this).val();
		if(status == 3) {
			$('.reject_opt').hide();
		} else {
			$('.reject_opt').show();
		}
	});
	/* Edit data */
	$("#update_candidate_status").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/recruitment/candidates_list") ?>",
							type : 'GET'
						},
						"language": {
							"lengthMenu": dt_lengthMenu,
							"zeroRecords": dt_zeroRecords,
							"info": dt_info,
							"infoEmpty": dt_infoEmpty,
							"infoFiltered": dt_infoFiltered,
							"search": dt_search,
							"paginate": {
								"first": dt_first,
								"previous": dt_previous,
								"next": dt_next,
								"last": dt_last
							},
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.view-modal-data').modal('toggle');
					Ladda.stopAll();
				}
			}
		});
	});
});	
  </script>
<?php } else if($request->getGet('data') === 'candidate_cover_letter' && $request->getGet('field_id')){
$candidate_id = udecode($field_id);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$result = $JobcandidatesModel->where('company_id', $user_info['company_id'])->where('candidate_id', $candidate_id)->first();
	$job_data = $JobsModel->where('company_id',$user_info['company_id'])->where('job_id',$result['job_id'])->first();
} else {
	$result = $JobcandidatesModel->where('company_id', $usession['sup_user_id'])->where('candidate_id', $candidate_id)->first();
	$job_data = $JobsModel->where('company_id',$usession['sup_user_id'])->where('job_id', $result['job_id'])->first();
}
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= $job_data['job_title'];?>
    <span class="font-weight-light">
    <?= lang('Recruitment.xin_cover_letter');?>
    </span> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="<?= lang('Main.xin_close');?>"> <span aria-hidden="true">×</span> </button>
</div>
<div class="modal-body">
  <?= $result['message'];?>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
</div>
<?php } else if($request->getGet('data') === 'interview' && $request->getGet('field_id')){
$job_interview_id = udecode($field_id);
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$result = $JobinterviewsModel->where('company_id', $user_info['company_id'])->where('job_interview_id', $job_interview_id)->first();
} else {
	$result = $JobinterviewsModel->where('company_id', $usession['sup_user_id'])->where('job_interview_id', $job_interview_id)->first();
}
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Asset.xin_edit_assets_category');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'update_interview_status', 'id' => 'update_interview_status', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/recruitment/update_interview_status', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="name">
          <?= lang('Main.dashboard_xin_status');?>
          <span class="text-danger">*</span> </label>
        <select class="form-control" name="status" id="status" data-plugin="select_hrm" data-placeholder="<?php echo lang('Main.dashboard_xin_status');?>">
          <option value="1" <?php if($result['status']=='1'):?> selected <?php endif; ?>><?php echo lang('Projects.xin_not_started');?></option>
          <option value="2" <?php if($result['status']=='2'):?> selected <?php endif; ?>><?php echo lang('Recruitment.xin_passed_interview');?></option>
          <option value="3" <?php if($result['status']=='3'):?> selected <?php endif; ?>><?php echo lang('Main.xin_rejected');?></option>
        </select>
      </div>
    </div>
    <div class="col-md-12 reject_opt">
      <div class="form-group">
        <label for="description"><?php echo lang('Recruitment.xin_job_interview_remarks');?></label>
        <textarea class="form-control textarea" placeholder="<?php echo lang('Recruitment.xin_job_interview_remarks');?>" name="description" cols="30" rows="3"><?= $result['interview_remarks'];?>
</textarea>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Recruitment.xin_update_interview_status');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){ 

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	 
	Ladda.bind('button[type=submit]');
	/* Edit data */
	$("#update_interview_status").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/recruitment/interview_list") ?>",
							type : 'GET'
						},
						"language": {
							"lengthMenu": dt_lengthMenu,
							"zeroRecords": dt_zeroRecords,
							"info": dt_info,
							"infoEmpty": dt_infoEmpty,
							"infoFiltered": dt_infoFiltered,
							"search": dt_search,
							"paginate": {
								"first": dt_first,
								"previous": dt_previous,
								"next": dt_next,
								"last": dt_last
							},
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.view-modal-data').modal('toggle');
					Ladda.stopAll();
				}
			}
		});
	});
});	
  </script>
<?php } else if($request->getGet('data') === 'read_interview' && $request->getGet('field_id')){
$interview_id = udecode($field_id);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$result = $JobinterviewsModel->where('company_id', $user_info['company_id'])->where('job_interview_id', $interview_id)->first();
} else {
	$result = $JobinterviewsModel->where('company_id', $usession['sup_user_id'])->where('job_interview_id', $interview_id)->first();
}
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Main.xin_view');?>
    <?= lang('Recruitment.xin_job_interview_remarks');?>
  </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="<?= lang('Main.xin_close');?>"> <span aria-hidden="true">×</span> </button>
</div>
<div class="modal-body">
  <div class="m-b-20">
    <?= $result['interview_remarks'];?>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
</div>
<?php }
?>

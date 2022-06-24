<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ProjectsModel;
use App\Models\ProjecttimelogsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$SystemModel = new SystemModel();
$ProjectsModel = new ProjectsModel();
$ProjecttimelogsModel = new ProjecttimelogsModel();	

$xin_system = $SystemModel->where('setting_id', 1)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();

/* Transfers view
*/
$get_animate = '';
if($request->getGet('data') === 'timelog' && $request->getGet('field_id')){
	$timelogs_id = udecode($field_id);
	$result = $ProjecttimelogsModel->where('timelogs_id', $timelogs_id)->first();
	if($user_info['user_type'] == 'staff'){
		$staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','staff')->findAll();
		$project_data = $ProjectsModel->where('company_id',$user_info['company_id'])->where('project_id', $result['project_id'])->first();
	} else {
		$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
		$project_data = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('project_id', $result['project_id'])->first();
	}
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_transfer');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'update_timelog', 'id' => 'update_timelog', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/projects/update_timelog', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
     <?php if($user_info['user_type'] == 'company'){?>
	  <?php $assigned_to = explode(',',$project_data['assigned_to']); ?>
      <div class="col-md-6">
        <div class="form-group">
          <label for="employee"><?php echo lang('Dashboard.dashboard_employee');?></label>
          <select name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.dashboard_employee');?>">
            <?php foreach($staff_info as $staff) {?>
            <?php if(in_array($staff['user_id'],$assigned_to)):?>
            <option value="<?= $staff['user_id']?>" <?php if($staff['user_id']==$result['employee_id']):?> selected="selected"<?php endif;?>>
            <?= $staff['first_name'].' '.$staff['last_name'] ?>
            </option>
            <?php endif;?>
            <?php } ?>
          </select>
        </div>
      </div>
      <?php } ?>
      <div class="col-md-6">
        <div class="form-group">
          <label for="budget_hours"><?php echo lang('Projects.xin_start_time');?></label>
          <div class="input-group">
            <input class="form-control etimepicker" placeholder="<?php echo lang('Projects.xin_start_time');?>" name="start_time" type="text" value="<?= $result['start_time'];?>">
            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="budget_hours"><?php echo lang('Projects.xin_end_time');?></label>
          <div class="input-group">
            <input class="form-control etimepicker" placeholder="<?php echo lang('Projects.xin_end_time');?>" name="end_time" type="text" value="<?= $result['end_time'];?>">
            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="start_date"><?php echo lang('Projects.xin_start_date');?> <span class="text-danger">*</span></label>
          <div class="input-group">
            <input class="form-control d_date" placeholder="<?php echo lang('Projects.xin_start_date');?>" name="start_date" type="text" value="<?= $result['start_date'];?>">
            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="end_date"><?php echo lang('Projects.xin_end_date');?> <span class="text-danger">*</span></label>
          <div class="input-group">
            <input class="form-control d_date" placeholder="<?php echo lang('Projects.xin_end_date');?>" name="end_date" type="text" value="<?= $result['end_date'];?>">
            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="summary"><?php echo lang('Projects.xin_memo');?> <span class="text-danger">*</span></label>
          <textarea class="form-control" placeholder="<?php echo lang('Projects.xin_memo');?>" name="memo" cols="30" rows="2"><?= $result['timelogs_memo'];?></textarea>
        </div>
      </div>
      
    </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <?php //if($result['status']=='0'):?>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
  <?php //endif;?>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		Ladda.bind('button[type=submit]');		
		$('.d_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});
		$('.etimepicker').bootstrapMaterialDatePicker({
			date: false,
			shortTime: true,
			format: 'HH:mm'
		});
		/* Edit data */
		$("#update_timelog").submit(function(e){
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
						// On page load: datatable
						var xin_timelogs_table = $('#xin_timelogs_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("erp/projects/timelogs_list") ?>?project_val=<?= $result['project_id'];?>",
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
						xin_timelogs_table.api().ajax.reload(function(){ 
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
<?php }
?>

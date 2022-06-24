<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\TimesheetModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$TimesheetModel = new TimesheetModel();
$xin_com_system = erp_company_settings();
$get_animate = '';
if($request->getGet('data') === 'add_attendance' && $request->getGet('field_id')){
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Attendance.xin_add_attendance');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info_add_record');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'add_attendance', 'id' => 'add_attendance', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'ADD');?>
<?php echo form_open('erp/timesheet/add_attendance', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <?php if($user_info['user_type'] == 'company'){?>
      <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="first_name">
              <?= lang('Dashboard.dashboard_employee');?> <span class="text-danger">*</span>
            </label>
            <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>">
              <?php foreach($staff_info as $staff) {?>
              <option value="<?= $staff['user_id']?>">
              <?= $staff['first_name'].' '.$staff['last_name'] ?>
              </option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="date">
              <?= lang('Attendance.xin_attendance_date');?> <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <input class="form-control attendance_date_m" placeholder="<?= lang('Attendance.xin_attendance_date');?>" name="attendance_date_m" type="text">
              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="clock_in">
              <?= lang('Employees.xin_shift_in_time');?> <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <input class="form-control timepicker_m" placeholder="<?= lang('Employees.xin_shift_in_time');?>" name="clock_in_m" type="text">
              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="clock_out">
              <?= lang('Employees.xin_shift_out_time');?> <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <input class="form-control timepicker_m" placeholder="<?= lang('Employees.xin_shift_out_time');?>" name="clock_out_m" type="text">
              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_save');?>
  </button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){
							
		// Clock
		$('.timepicker_m').bootstrapMaterialDatePicker({
			date: false,
			format: 'HH:mm'
		});	 
		Ladda.bind('button[type=submit]');
		// attendance date
		$('.attendance_date_m').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: true,
			format: '<?= js_set_date_format();?>',
			lang: '<?= $xin_com_system['datepicker_locale'];?>'
		});	 
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });		  
		/* Add Attendance*/
		$("#add_attendance").submit(function(e){
			
		/*Form Submit*/
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=4&type=add_record&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					} else {
						$('.view-modal-data').modal('toggle');
							var xin_table = $('#xin_table').dataTable({
								"bDestroy": true,
								"ajax": {
									url : "<?php echo site_url("erp/timesheet/update_attendance_list") ?>",
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
						Ladda.stopAll();
					}
				}
			});
		});
	});	
  </script>
<?php
} elseif($request->getGet('data') === 'edit_attendance' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $TimesheetModel->where('time_attendance_id', $ifield_id)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Attendance.xin_edit_attendance');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_attendance', 'id' => 'edit_attendance', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/timesheet/update_attendance_record', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <?php if($user_info['user_type'] == 'company'){?>
      <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="first_name">
              <?= lang('Dashboard.dashboard_employee');?> <span class="text-danger">*</span>
            </label>
            <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>">
              <?php foreach($staff_info as $staff) {?>
              <option value="<?= $staff['user_id']?>">
              <?= $staff['first_name'].' '.$staff['last_name'] ?>
              </option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="date">
              <?= lang('Attendance.xin_attendance_date');?> <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <input class="form-control attendance_date_e" placeholder="<?= lang('Attendance.xin_attendance_date');?>" name="attendance_date_m" type="text" value="<?php echo $result['attendance_date'];?>">
              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <?php
			$clock_in_time = strtotime($result['clock_in']);
			$fclckIn = date("h:i", $clock_in_time);
			?>
        <div class="col-md-6">
          <div class="form-group">
            <label for="clock_in">
              <?= lang('Employees.xin_shift_in_time');?> <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <input class="form-control timepicker" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly="true" name="clock_in_m" type="text" value="<?php echo $fclckIn;?>">
              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
            </div>
          </div>
        </div>
        <?php
			$clock_out_time = strtotime($result['clock_out']);
			$fclckOut = date("h:i", $clock_out_time);
			?>
        <div class="col-md-6">
          <div class="form-group">
            <label for="clock_out">
              <?= lang('Employees.xin_shift_out_time');?> <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <input class="form-control timepicker" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly="true" name="clock_out_m" type="text" value="<?php echo $fclckOut;?>">
              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
$(document).ready(function(){
	// attendance date
	$('.attendance_date_e').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: true,
		format: '<?= js_set_date_format();?>',
		lang: '<?= $xin_com_system['datepicker_locale'];?>'
	});	 
	Ladda.bind('button[type=submit]'); 
	$('.timepicker').bootstrapMaterialDatePicker({
		date: false,
		format: 'HH:mm'
	});
  	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	/* Edit Attendance*/
	$("#edit_attendance").submit(function(e){
	
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&type=edit_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					$('.edit-modal-data').modal('toggle');
					var xin_table2 = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("erp/timesheet/update_attendance_list") ?>",
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
						xin_table2.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				}
			}
		});
	});
});	
</script>
<?php }
?>

<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\DepartmentModel;
use App\Models\VisitorsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$DepartmentModel = new DepartmentModel();
$VisitorsModel = new VisitorsModel();
$get_animate = '';
if($request->getGet('data') === 'visitor' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $VisitorsModel->where('visitor_id', $ifield_id)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
   $main_department = $DepartmentModel->where('company_id', $user_info['company_id'])->findAll();
} else {
	$main_department = $DepartmentModel->where('company_id', $usession['sup_user_id'])->findAll();
}
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Main.xin_edit_visitor');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_visitor', 'id' => 'edit_visitor', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open_multipart('erp/visitors/update_visitor', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="title">
          <?= lang('Dashboard.left_department');?> <span class="text-danger">*</span>
        </label>
        <select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_department');?>">
          <option value=""></option>
          <?php foreach($main_department as $idepartment) {?>
          <option value="<?= $idepartment['department_id']?>" <?php if($result['department_id']==$idepartment['department_id']):?> selected="selected"<?php endif;?>>
          <?= $idepartment['department_name']?>
          </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="start_date">
          <?= lang('Employees.xin_visit_purpose');?> <span class="text-danger">*</span>
        </label>
        <input class="form-control" placeholder="<?= lang('Employees.xin_visit_purpose');?>" name="visit_purpose" type="text" value="<?= $result['visit_purpose'];?>">
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="end_date">
          <?= lang('Main.xin_visitor_name');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
          <input class="form-control" placeholder="<?= lang('Main.xin_visitor_name');?>" name="visitor_name" type="text" value="<?= $result['visitor_name'];?>">
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="end_date">
          <?= lang('Main.xin_visit_date');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input class="form-control d_date" placeholder="<?= lang('Main.xin_visit_date');?>" name="visit_date" type="text" value="<?= $result['visit_date'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="summary">
          <?= lang('Employees.xin_shift_in_time');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input type="text" class="form-control etimepicker" placeholder="<?= lang('Employees.xin_shift_in_time');?>" name="check_in" value="<?= $result['check_in'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="summary">
          <?= lang('Employees.xin_shift_out_time');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input type="text" class="form-control etimepicker" placeholder="<?= lang('Employees.xin_shift_out_time');?>" name="check_out" value="<?= $result['check_out'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="description">
          <?= lang('Main.xin_phone');?> <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" placeholder="<?= lang('Main.xin_phone');?>" name="phone" value="<?= $result['phone'];?>">
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group">
        <label for="description">
          <?= lang('Main.xin_email');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
          <input type="text" class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email" value="<?= $result['email'];?>">
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="form-group">
        <label for="address">
          <?= lang('Main.xin_address');?> <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" placeholder="<?= lang('Main.xin_address');?>" name="address" value="<?= $result['address'];?>">
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="description">
          <?= lang('Main.xin_description');?>
        </label>
        <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="8" rows="2" id="description"><?= $result['description'];?>
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
  <?= lang('Main.xin_update');?>
  </button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){
									
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
		 Ladda.bind('button[type=submit]');
		
		// Clock
		$('.etimepicker').bootstrapMaterialDatePicker({
			date: false,
			shortTime: true,
			format: 'HH:mm'
		});
		$('.d_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		});

		/* Edit data */
		$("#edit_visitor").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
		fd.append("form", action);
		e.preventDefault();
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("erp/visitors/visitors_list") ?>",
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
					$('.edit-modal-data').modal('toggle');
					Ladda.stopAll();
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} 	        
	   });
	});
});	
</script>
<?php }
?>

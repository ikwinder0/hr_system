<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\TrainersModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$TrainersModel = new TrainersModel();
$ConstantsModel = new ConstantsModel();
$get_animate = '';

if($request->getGet('data') === 'trainer' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $TrainersModel->where('trainer_id', $ifield_id)->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Dashboard.left_edit_trainer');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_trainer', 'id' => 'edit_trainer', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/trainers/update_trainer', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="first_name">
          <?= lang('Main.xin_employee_first_name');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text"> <i class="fas fa-user"></i> </span></div>
          <input class="form-control" placeholder="<?= lang('Main.xin_employee_first_name');?>" name="first_name" type="text" value="<?php echo $result['first_name'];?>">
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="last_name" class="control-label">
          <?= lang('Main.xin_employee_last_name');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text"> <i class="fas fa-user"></i> </span></div>
          <input class="form-control" placeholder="<?= lang('Main.xin_employee_last_name');?>" name="last_name" type="text" value="<?php echo $result['last_name'];?>">
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="form-group">
        <label for="email" class="control-label">
          <?= lang('Main.xin_email');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text"> <i class="fas fa-envelope"></i> </span></div>
          <input class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email" type="text" value="<?php echo $result['email'];?>">
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group">
        <label for="contact_number">
          <?= lang('Main.xin_contact_number');?> <span class="text-danger">*</span>
        </label>
        <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text" value="<?php echo $result['contact_number'];?>">
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="expertise">
          <?= lang('Recruitment.xin_expertise');?> <span class="text-danger">*</span>
        </label>
        <textarea class="form-control textarea" placeholder="<?= lang('Recruitment.xin_expertise');?>" name="expertise" cols="30" rows="2" id="expertise2"><?php echo $result['expertise'];?></textarea>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="address">
          <?= lang('Main.xin_address');?>
        </label>
        <textarea class="form-control" placeholder="<?= lang('Main.xin_address');?>" name="address" cols="30" rows="2" id="address"><?php echo $result['address'];?></textarea>
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
	/* Edit data */
	$("#edit_trainer").submit(function(e){
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
							url : "<?= site_url("erp/trainers/trainer_list") ?>",
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

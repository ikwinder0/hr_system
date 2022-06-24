<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\CountryModel;
use App\Models\Moduleattributes;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$CountryModel = new CountryModel();
$Moduleattributes = new Moduleattributes();
$get_animate = '';
if($request->getGet('data') === 'customfield' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $Moduleattributes->where('custom_field_id', $ifield_id)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Main.xin_edit_custom_field');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_customfield', 'id' => 'edit_customfield', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open_multipart('erp/customfields/update_customfield', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="country">
        <?= lang('Main.xin_module');?>
        <span class="text-danger">*</span> </label>
      <select class="form-control" name="module" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_module');?>">
        <option value="">
        <?= lang('Main.xin_select_one');?>
        </option>
        <option value="1" <?php if($result['module_id']==1):?> selected="selected" <?php endif;?>><?= lang('Dashboard.left_awards');?></option>
        <option value="2" <?php if($result['module_id']==2):?> selected="selected" <?php endif;?>><?= lang('Dashboard.xin_assets');?></option>
        <option value="3" <?php if($result['module_id']==3):?> selected="selected" <?php endif;?>><?= lang('Dashboard.dashboard_helpdesk');?></option>
        <option value="4" <?php if($result['module_id']==4):?> selected="selected" <?php endif;?>><?= lang('Dashboard.left_training');?></option>
        <option value="5" <?php if($result['module_id']==5):?> selected="selected" <?php endif;?>><?= lang('Main.xin_employee_contract');?></option>
        <option value="6" <?php if($result['module_id']==6):?> selected="selected" <?php endif;?>><?= lang('Dashboard.left_announcement_make');?></option>
        <option value="7" <?php if($result['module_id']==7):?> selected="selected" <?php endif;?>><?= lang('Main.xin_inventory_products');?></option>
        <option value="8" <?php if($result['module_id']==8):?> selected="selected" <?php endif;?>><?= lang('Main.xin_employee_bsic_info');?></option>
        <option value="9" <?php if($result['module_id']==9):?> selected="selected" <?php endif;?>><?= lang('Main.xin_employee_personal_info_bio');?></option>
      </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label for="name">
        <?= lang('Dashboard.xin_name');?>
        <span class="text-danger">*</span> </label>
      <input class="form-control" placeholder="<?= lang('Dashboard.xin_name');?>" disabled="disabled" type="text" value="<?= $result['attribute'];?>">
      <small class="text-primary"><?= lang('Main.xin_cannot_update');?></small>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label for="field_label">
        <?= lang('Main.xin_field_label');?> <span class="text-danger">*</span>
      </label>
      <input class="form-control" placeholder="<?= lang('Main.xin_field_label');?>" name="field_label" type="text" value="<?= $result['attribute_label'];?>">
      <small class="text-primary">for example <strong>First Name</strong> </small>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="priority">
        <?= lang('Projects.xin_p_priority');?> <span class="text-danger">*</span>
      </label>
      <input class="form-control" placeholder="<?= lang('Projects.xin_p_priority');?>" name="priority" type="text" value="<?= $result['priority'];?>">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="validation">
        <?= lang('Main.xin_validation');?>
        <span class="text-danger">*</span> </label>
      <select class="form-control" name="validation" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_validation');?>">
        <option value="0" <?php if($result['validation']==0):?> selected="selected" <?php endif;?>>None</option>
        <option value="1" <?php if($result['validation']==1):?> selected="selected" <?php endif;?>>Required</option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="field_type">
        <?= lang('Main.xin_column_width');?>
        <span class="text-danger">*</span> </label>
      <select class="form-control" name="column" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_column_width');?>">
        <option value="col-md-2" <?php if($result['col_width']=='col-md-2'):?> selected="selected" <?php endif;?>>Col-md-2</option>
        <option value="col-md-3" <?php if($result['col_width']=='col-md-3'):?> selected="selected" <?php endif;?>>Col-md-3</option>
        <option value="col-md-4" <?php if($result['col_width']=='col-md-4'):?> selected="selected" <?php endif;?>>Col-md-4</option>
        <option value="col-md-5" <?php if($result['col_width']=='col-md-5'):?> selected="selected" <?php endif;?>>Col-md-5</option>
        <option value="col-md-6" <?php if($result['col_width']=='col-md-6'):?> selected="selected" <?php endif;?>>Col-md-6</option>
        <option value="col-md-7" <?php if($result['col_width']=='col-md-7'):?> selected="selected" <?php endif;?>>Col-md-7</option>
        <option value="col-md-8" <?php if($result['col_width']=='col-md-8'):?> selected="selected" <?php endif;?>>Col-md-8</option>
        <option value="col-md-9" <?php if($result['col_width']=='col-md-9'):?> selected="selected" <?php endif;?>>Col-md-9</option>
        <option value="col-md-10" <?php if($result['col_width']=='col-md-10'):?> selected="selected" <?php endif;?>>Col-md-10</option>
        <option value="col-md-12" <?php if($result['col_width']=='col-md-12'):?> selected="selected" <?php endif;?>>Col-md-12</option>
      </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label for="field_type">
        <?= lang('Main.xin_field_type');?>
        <span class="text-danger">*</span> </label>
      <select class="form-control" disabled="disabled" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_field_type');?>">
        <option value="">
        <?= lang('Main.xin_select_one');?>
        </option>
        <option value="text">Text Field</option>
        <option value="textarea">Text Area</option>
        <option value="select">Select</option>
        <option value="date">Date</option>
      </select>
      <small class="text-primary"><?= lang('Main.xin_cannot_update');?></small>
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
		$("#edit_customfield").submit(function(e){
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
							url : "<?php echo site_url("erp/customfields/customfields_list") ?>",
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

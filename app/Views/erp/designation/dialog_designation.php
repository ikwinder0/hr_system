<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$get_animate = '';
if($request->getGet('data') === 'designation' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $DesignationModel->where('designation_id', $ifield_id)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
   $main_department = $DepartmentModel->where('company_id', $user_info['company_id'])->findAll();
} else {
	$main_department = $DepartmentModel->where('company_id', $usession['sup_user_id'])->findAll();
}
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Dashboard.left_edit_designation');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="<?= lang('Main.xin_close');?>"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_designation', 'id' => 'edit_designation', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/designation/update_designation', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="name">
          <?= lang('Dashboard.left_department');?>
          <span class="text-danger">*</span> </label>
        <select class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_department');?>" name="department">
          <option value=""></option>
          <?php foreach($main_department as $idepartment) {?>
          <option value="<?= $idepartment['department_id']?>" <?php if($idepartment['department_id']==$result['department_id']):?> selected="selected"<?php endif;?>>
          <?= $idepartment['department_name']?>
          </option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <label for="name">
          <?= lang('Dashboard.left_designation_name');?> <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" name="designation_name" placeholder="<?= lang('Dashboard.left_designation_name');?>" value="<?= $result['designation_name'];?>">
      </div>
      <div class="form-group">
        <label for="description">
          <?= lang('Main.xin_description');?>
        </label>
        <textarea type="text" class="form-control" name="description" placeholder="<?= lang('Main.xin_description');?>"><?= $result['description'];?>
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
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
	 Ladda.bind('button[type=submit]');
	/* Edit data */
	$("#edit_designation").submit(function(e){
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
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/designation/designation_list") ?>",
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
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
					}, true);
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

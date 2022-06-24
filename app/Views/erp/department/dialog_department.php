<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\DepartmentModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$DepartmentModel = new DepartmentModel();
$get_animate = '';
if($request->getGet('data') === 'department' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $DepartmentModel->where('department_id', $ifield_id)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Dashboard.left_edit_department');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_department', 'id' => 'edit_department', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/department/update_department', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="name">
          <?= lang('Dashboard.xin_name');?>
          <span class="text-danger">*</span> </label>
        <input type="text" class="form-control" name="department_name" placeholder="<?= lang('Dashboard.xin_name');?>" value="<?= $result['department_name'];?>">
      </div>
      <?php if($user_info['user_type'] == 'company'){?>
      <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
      <div class="form-group">
        <label for="first_name">
          <?= lang('Dashboard.xin_department_head');?>
        </label>
        <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_department_head');?>">
          <option value=""><?= lang('Dashboard.xin_department_head');?></option>
		  <?php foreach($staff_info as $staff) {?>
          <option value="<?= $staff['user_id']?>" <?php if($result['department_head']==$staff['user_id']):?> selected="selected"<?php endif;?>>
          <?= $staff['first_name'].' '.$staff['last_name'] ?>
          </option>
          <?php } ?>
        </select>
      </div>
      <?php } ?>
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
	$("#edit_department").submit(function(e){
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
							url : "<?= site_url("erp/department/departments_list") ?>",
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

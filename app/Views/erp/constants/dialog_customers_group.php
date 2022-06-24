asdas<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$ConstantsModel = new ConstantsModel();
$get_animate = '';
if($request->getGet('data') === 'customers_group' && $request->getGet('field_id')){
$category_id = udecode($field_id);
$result = $ConstantsModel->where('constants_id', $category_id)->where('type','customers_group')->first();
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
<?php $attributes = array('name' => 'update_constants_type', 'id' => 'update_constants_type', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/types/update_constants_type', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="name">
          <?= lang('Dashboard.xin_category');?> <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" name="name" placeholder="<?= lang('Dashboard.xin_category');?>" value="<?= $result['category_name'];?>">
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-check-square"></i>
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary"> <i class="fas fa-check-square"></i>
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
	$("#update_constants_type").submit(function(e){
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
							url : "<?= site_url("erp/types/customers_group_list") ?>",
							type : 'GET'
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
<?php }
?>

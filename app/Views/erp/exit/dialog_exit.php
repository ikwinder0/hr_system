<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\OffModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$OffModel = new OffModel();	
$SystemModel = new SystemModel();
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','exit_type')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','exit_type')->findAll();
}
$xin_system = $SystemModel->where('setting_id', 1)->first();
$xin_com_system = erp_company_settings();
/* Assets view
*/
$get_animate = '';
if($request->getGet('data') === 'employee_exit' && $request->getGet('field_id')){
$exit_id = udecode($field_id);
$result = $OffModel->where('exit_id', $exit_id)->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_employee_exit');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_exit', 'id' => 'edit_exit', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/leaving/update_exit', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="exit_date">
          <?= lang('Employees.xin_exit_date');?>
          <span class="text-danger">*</span></label>
        <input class="form-control d_date" placeholder="<?= lang('Employees.xin_exit_date');?>" readonly name="exit_date" type="text" value="<?php echo $result['exit_date'];?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="type">
          <?= lang('Employees.xin_type_of_exit');?>
          <span class="text-danger">*</span></label>
        <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_type_of_exit');?>" name="exit_type">
          <option value=""></option>
          <?php foreach($category_info as $icategory) {?>
          <option value="<?= $icategory['constants_id']?>" <?php if($icategory['constants_id']==$result['exit_type_id']):?> selected="selected"<?php endif;?>>
          <?= $icategory['category_name']?>
          </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exit_interview">
          <?= lang('Employees.xin_exit_interview');?>
          <span class="text-danger">*</span></label>
        <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_exit_interview');?><" name="exit_interview">
          <option value="1" <?php if(1==$result['exit_interview']):?> selected="selected"<?php endif;?>>
          <?= lang('Main.xin_yes');?>
          </option>
          <option value="0" <?php if(0==$result['exit_interview']):?> selected="selected"<?php endif;?>>
          <?= lang('Main.xin_no');?>
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="is_inactivate_account">
          <?= lang('Employees.xin_exit_inactive_employee_account');?>
          <span class="text-danger">*</span></label>
        <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_exit_inactive_employee_account');?>" name="is_inactivate_account">
          <option value="1" <?php if(1==$result['is_inactivate_account']):?> selected="selected"<?php endif;?>>
          <?= lang('Main.xin_yes');?>
          </option>
          <option value="0" <?php if(0==$result['is_inactivate_account']):?> selected="selected"<?php endif;?>>
          <?= lang('Main.xin_no');?>
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="description">
          <?= lang('Main.xin_description');?>
        </label>
        <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="reason" cols="30" rows="5"><?php echo $result['reason'];?></textarea>
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
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	 
	Ladda.bind('button[type=submit]');
	
	$('.d_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: '<?= js_set_date_format();?>',
		lang: '<?= $xin_com_system['datepicker_locale'];?>'
	});

	/* Edit data */
	$("#edit_exit").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
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
						url : "<?php echo site_url("erp/leaving/employee_off_list") ?>",
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
			}
		});
	});
});	
</script>
<?php } elseif($request->getGet('type') === 'view_employee_exit' && $request->getGet('field_id')){
$exit_id = udecode($field_id);
$result = $OffModel->where('exit_id', $exit_id)->first();
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_view_employee_exit');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<form class="m-b-1">
<div class="modal-body">
  <table class="footable-details table table-striped table-hover toggle-circle">
    <tbody>
      <tr>
        <th><?= lang('Employees.xin_employee_to_exit');?></th>
        <td style="display: table-cell;"><?php
		  	$iuser = $UsersModel->where('user_id', $result['employee_id'])->first();
			echo $iuser['first_name'].' '.$iuser['last_name'];
		  ?></td>
      </tr>
      <tr>
        <th><?= lang('Employees.xin_exit_date');?></th>
        <td style="display: table-cell;"><?= set_date_format($result['exit_date']);?></td>
      </tr>
      <?php $category_info = $ConstantsModel->where('constants_id', $result['exit_type_id'])->where('type','exit_type')->first(); ?>
      <tr>
        <th><?= lang('Employees.xin_type_of_exit');?></th>
        <td style="display: table-cell;"><?= $category_info['category_name'];?></td>
      </tr>
      <tr>
        <th><?= lang('Employees.xin_exit_interview');?></th>
        <td style="display: table-cell;"><?php if($result['exit_interview']=='1'): $in_active = lang('Main.xin_yes');?>
          <?php endif; ?>
          <?php if($result['exit_interview']=='0'): $in_active = lang('Main.xin_no');?>
          <?php endif; ?>
          <?php echo $in_active;?></td>
      </tr>
      <tr>
        <th><?= lang('Employees.xin_exit_inactive_employee_account');?></th>
        <td style="display: table-cell;"><?php if($result['is_inactivate_account']=='1'): $account = lang('Main.xin_yes');?>
          <?php endif; ?>
          <?php if($result['is_inactivate_account']=='0'): $account = lang('Main.xin_no');?>
          <?php endif; ?>
          <?php echo $account;?></td>
      </tr>
      <tr>
        <th><?= lang('Main.xin_description');?></th>
        <td style="display: table-cell;"><?php echo html_entity_decode($result['reason']);?></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
</div>
<?php echo form_close(); ?>
<?php }
?>

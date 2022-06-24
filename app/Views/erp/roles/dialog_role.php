<?php
use App\Models\UsersModel;
use App\Models\SuperroleModel;

$SuperroleModel = new SuperroleModel();
$UsersModel = new UsersModel();
$request = \Config\Services::request();

$roles = $SuperroleModel->orderBy('role_id', 'ASC')->findAll();
if($request->getGet('data') === 'role' && $request->getGet('field_id')){
$role_id = udecode($field_id);
$result = $SuperroleModel->where('role_id', $role_id)->first();
$role_resources_ids = explode(',',$result['role_resources']);
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Users.xin_role_editrole');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_role', 'id' => 'edit_role', 'autocomplete' => 'off','class' => '"m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/users/update_role', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-4">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="role_name">
              <?= lang('Users.xin_role_name');?>
              <span class="text-danger">*</span> </label>
            <input class="form-control" placeholder="<?= lang('Users.xin_role_name');?>" name="role_name" type="text" value="<?= $result['role_name'];?>">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="role_access">
              <?= lang('Users.xin_role_access');?>
              <span class="text-danger">*</span> </label>
            <select class="form-control custom-select" id="role_access_modal" name="role_access" data-plugin="select_hrm" data-placeholder="<?= lang('Users.xin_role_access');?>">
              <option value="">&nbsp;</option>
              <option value="2" <?php if($result['role_access']==2):?> selected="selected" <?php endif;?>>
              <?= lang('Users.xin_role_cmenu');?>
              </option>
              <option value="1" <?php if($result['role_access']==1):?> selected="selected" <?php endif;?>>
              <?= lang('Users.xin_role_all_menu');?>
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-6">
          <input type="hidden" name="role_resources[0]" value="0" />
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[1]" value="1" id="11" <?php if(in_array(1,$role_resources_ids)):?> checked <?php endif;?>>
              <label class="custom-control-label" for="11">
                <?= lang('Company.xin_companies');?>
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[2]" value="2" id="22" <?php if(in_array(2,$role_resources_ids)):?> checked <?php endif;?>>
              <label class="custom-control-label" for="22">
                <?= lang('Membership.xin_membership');?>
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[4]" value="4" id="44" <?php if(in_array(4,$role_resources_ids)):?> checked <?php endif;?>>
              <label class="custom-control-label" for="44">
                <?= lang('Main.xin_multi_language');?>
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[5]" value="5" id="55" <?php if(in_array(5,$role_resources_ids)):?> checked <?php endif;?>>
              <label class="custom-control-label" for="55">
                <?= lang('Main.xin_super_users');?>
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[3]" value="3" id="33" <?php if(in_array(3,$role_resources_ids)):?> checked <?php endif;?>>
              <label class="custom-control-label" for="33">
                <?= lang('Membership.xin_billing_invoices');?>
              </label>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[6]" value="6" id="66" <?php if(in_array(6,$role_resources_ids)):?> checked <?php endif;?>>
              <label class="custom-control-label" for="66">
                <?= lang('Main.left_settings');?>
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[7]" value="7" id="77" <?php if(in_array(7,$role_resources_ids)):?> checked <?php endif;?>>
              <label class="custom-control-label" for="77">
                <?= lang('Main.left_constants');?>
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[8]" value="8" id="88" <?php if(in_array(8,$role_resources_ids)):?> checked <?php endif;?>>
              <label class="custom-control-label" for="88">
                <?= lang('Main.header_db_log');?>
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input input-light-primary" name="role_resources[9]" value="9" id="99" <?php if(in_array(9,$role_resources_ids)):?> checked <?php endif;?>>
              <label class="custom-control-label" for="99">
                <?= lang('Main.left_email_templates');?>
              </label>
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
  <button type="submit" class="btn btn-primary save">
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
		$("#edit_role").submit(function(e){
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
							url : "<?= site_url("erp/users/roles_list") ?>",
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
<script>
$(document).ready(function(){
	$("#role_access_modal").change(function(){
		var sel_val = $(this).val();
		if(sel_val=='1') {
			$('.resource-modal').prop('checked', true);
		} else {
			$('.resource-modal').prop("checked", false);
		}
	});
});
</script>
<?php }
?>

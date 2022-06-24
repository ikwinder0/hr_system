<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\TravelModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$TravelModel = new TravelModel();	
$SystemModel = new SystemModel();
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','travel_type')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','travel_type')->findAll();
}
$xin_system = erp_company_settings();
/* Assets view
*/
$get_animate = '';
if($request->getGet('data') === 'travel' && $request->getGet('field_id')){
$travel_id = udecode($field_id);
$result = $TravelModel->where('travel_id', $travel_id)->first();
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
<?php $attributes = array('name' => 'edit_travel', 'id' => 'edit_travel', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('user_id' => 1,'_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/travel/update_travel', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="start_date"><?= lang('xin_start_date');?> <span class="text-danger">*</span></label>
            <div class="input-group">
            <input class="form-control d_date" placeholder="<?= lang('xin_start_date');?>" name="start_date" type="text" value="<?php echo $result['start_date'];?>">
              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="end_date"><?= lang('xin_end_date');?> <span class="text-danger">*</span></label>
            <div class="input-group">
            	<input class="form-control d_date" placeholder="<?= lang('xin_end_date');?>" name="end_date" type="text" value="<?php echo $result['end_date'];?>">
              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="visit_purpose"><?= lang('xin_visit_purpose');?> <span class="text-danger">*</span></label>
            <input class="form-control" placeholder="<?= lang('xin_visit_purpose');?>" name="visit_purpose" type="text" value="<?php echo $result['visit_purpose'];?>">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="visit_place"><?= lang('xin_visit_place');?> <span class="text-danger">*</span></label>
            <input class="form-control" placeholder="<?= lang('xin_visit_place');?>" name="visit_place" type="text" value="<?php echo $result['visit_place'];?>">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="travel_mode"><?= lang('xin_travel_mode');?> <span class="text-danger">*</span></label>
            <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('xin_travel_mode');?>" name="travel_mode">
              <option value="1" <?php if(1==$result['travel_mode']):?> selected="selected"<?php endif;?>><?= lang('xin_by_bus');?></option>
              <option value="2" <?php if(2==$result['travel_mode']):?> selected="selected"<?php endif;?>><?= lang('xin_by_train');?></option>
              <option value="3" <?php if(3==$result['travel_mode']):?> selected="selected"<?php endif;?>><?= lang('xin_by_plane');?></option>
              <option value="4" <?php if(4==$result['travel_mode']):?> selected="selected"<?php endif;?>><?= lang('xin_by_taxi');?></option>
              <option value="5" <?php if(5==$result['travel_mode']):?> selected="selected"<?php endif;?>><?= lang('xin_by_rental_car');?></option>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="arrangement_type"><?= lang('xin_arragement_type');?> <span class="text-danger">*</span></label>
            <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('xin_arragement_type');?>" name="arrangement_type">
              <?php foreach($category_info as $travel_category) {?>
              <option value="<?= $travel_category['constants_id']?>" <?php if($travel_category['constants_id']==$result['arrangement_type']):?> selected="selected"<?php endif;?>>
              <?= $travel_category['category_name']?>
              </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="status"><?= lang('dashboard_xin_status');?> <span class="text-danger">*</span></label>
            <select name="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('dashboard_xin_status');?>">
              <option value="0" <?php if($result['status']=='0'):?> selected <?php endif; ?>><?= lang('xin_pending');?></option>
              <option value="1" <?php if($result['status']=='1'):?> selected <?php endif; ?>><?= lang('xin_accepted');?></option>
              <option value="2" <?php if($result['status']=='2'):?> selected <?php endif; ?>><?= lang('xin_rejected');?></option>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="expected_budget"><?= lang('xin_expected_travel_budget');?> <span class="text-danger">*</span></label>
            <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text">
                    <?= $xin_system['default_currency'];?>
                    </span></div>
                  <input class="form-control" placeholder="<?= lang('xin_expected_travel_budget');?>" name="expected_budget" type="text" value="<?php echo $result['expected_budget'];?>">
                </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="actual_budget"><?= lang('xin_actual_travel_budget');?> <span class="text-danger">*</span></label>
            <div class="input-group">
              <div class="input-group-prepend"><span class="input-group-text">
                <?= $xin_system['default_currency'];?>
                </span></div>
              <input class="form-control" placeholder="<?= lang('xin_actual_travel_budget');?>" name="actual_budget" type="text" value="<?php echo $result['actual_budget'];?>">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="description"><?= lang('xin_description');?></label>
            <textarea class="form-control textarea" placeholder="<?= lang('xin_description');?>" name="description" cols="30" rows="5"><?php echo $result['description'];?></textarea>
          </div>
        </div>
      </div>
    </div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal"><?= lang('Main.xin_close');?></button>
  <button type="submit" class="btn btn-primary"><?= lang('Main.xin_update');?></button>
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
		/* Edit data */
		$("#edit_travel").submit(function(e){
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
							url : "<?php echo site_url("erp/travel/travel_list") ?>",
							type : 'GET'
						},
						dom: 'lBfrtip',
						"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
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
<?php }
?>

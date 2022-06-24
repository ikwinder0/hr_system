<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\CountryModel;
use App\Models\WarehouseModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$CountryModel = new CountryModel();
$WarehouseModel = new WarehouseModel();
$get_animate = '';
if($request->getGet('data') === 'warehouse' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $WarehouseModel->where('warehouse_id', $ifield_id)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Main.xin_edit_warehouse');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_warehouse', 'id' => 'edit_warehouse', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open_multipart('erp/warehouse/update_warehouse', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="start_date">
            <?= lang('Inventory.xin_warehouse_name');?>
            <span class="text-danger">*</span> </label>
          <input class="form-control" placeholder="<?= lang('Inventory.xin_warehouse_name');?>" name="name" type="text" value="<?= $result['warehouse_name'];?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="contact_number">
            <?= lang('Main.xin_contact_number');?>
            <span class="text-danger">*</span></label>
          <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text" value="<?= $result['contact_number'];?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="country">
            <?= lang('Inventory.xin_use_for_pickup');?>
            <span class="text-danger">*</span> </label>
          <select class="form-control" name="pickup_location" data-plugin="select_hrm" data-placeholder="<?= lang('Inventory.xin_use_for_pickup');?>">
            <option value="1" <?php if($result['pickup_location']==1):?> selected="selected"<?php endif;?>>
            <?= lang('Main.xin_yes');?>
            </option>
            <option value="0" <?php if($result['pickup_location']==0):?> selected="selected"<?php endif;?>>
            <?= lang('Main.xin_no');?>
            </option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="country">
            <?= lang('Main.xin_country');?>
            <span class="text-danger">*</span> </label>
          <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_country');?>">
            <option value="">
            <?= lang('Main.xin_select_one');?>
            </option>
            <?php foreach($all_countries as $country) {?>
            <option value="<?= $country['country_id'];?>" <?php if($result['country']==$country['country_id']):?> selected="selected"<?php endif;?>>
            <?= $country['country_name'];?>
            </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="address_1">
            <?= lang('Main.xin_address');?>
          </label>
          <input class="form-control" placeholder="<?= lang('Main.xin_address');?>" name="address_1" type="text" value="<?= $result['address_1'];?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="address_2"> &nbsp;</label>
          <input class="form-control" placeholder="<?= lang('Main.xin_address_2');?>" name="address_2" type="text" value="<?= $result['address_2'];?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="city">
            <?= lang('Main.xin_city');?>
          </label>
          <input class="form-control" placeholder="<?= lang('Main.xin_city');?>" name="city" type="text" value="<?= $result['city'];?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="state">
            <?= lang('Main.xin_state');?>
          </label>
          <input class="form-control" placeholder="<?= lang('Main.xin_state');?>" name="state" type="text" value="<?= $result['state'];?>">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="zipcode">
            <?= lang('Main.xin_zipcode');?>
          </label>
          <input class="form-control" placeholder="<?= lang('Main.xin_zipcode');?>" name="zipcode" type="text" value="<?= $result['zipcode'];?>">
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
		$("#edit_warehouse").submit(function(e){
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
							url : "<?php echo site_url("erp/warehouse/warehouse_list") ?>",
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

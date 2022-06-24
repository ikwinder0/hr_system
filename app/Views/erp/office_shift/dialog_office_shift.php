<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ShiftModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$ShiftModel = new ShiftModel();
$get_animate = '';
if($request->getGet('data') === 'shift' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $ShiftModel->where('office_shift_id', $ifield_id)->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_office_shift');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_office_shift', 'id' => 'edit_office_shift', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/officeshifts/update_office_shift', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_shift_name');?>
          <span class="text-danger">*</span> </label>
        <input class="form-control" placeholder="<?= lang('Employees.xin_shift_name');?>" name="shift_name" type="text" value="<?= $result['shift_name'];?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_monday_in_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-1" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="monday_in_time" type="text" value="<?= $result['monday_in_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="1"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_monday_out_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-2" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="monday_out_time" type="text" value="<?= $result['monday_out_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="2"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_tuesday_in_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-3" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="tuesday_in_time" type="text" value="<?= $result['tuesday_in_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="3"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_tuesday_out_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-4" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="tuesday_out_time" type="text" value="<?= $result['tuesday_out_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="4"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_wednesday_in_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-5" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="wednesday_in_time" type="text" value="<?= $result['wednesday_in_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="5"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_wednesday_out_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-6" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="wednesday_out_time" type="text" value="<?= $result['wednesday_out_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="6"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_thursday_in_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-7" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="thursday_in_time" type="text" value="<?= $result['thursday_in_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="7"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_thursday_out_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-8" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="thursday_out_time" type="text" value="<?= $result['thursday_out_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="8"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_friday_in_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-9" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="friday_in_time" type="text" value="<?= $result['friday_in_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="9"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_friday_out_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-10" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="friday_out_time" type="text" value="<?= $result['friday_out_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="10"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_saturday_in_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-11" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="saturday_in_time" type="text" value="<?= $result['saturday_in_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="11"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_saturday_out_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-12" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="saturday_out_time" type="text" value="<?= $result['saturday_out_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="12"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_sunday_in_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-13" placeholder="<?= lang('Employees.xin_shift_in_time');?>" readonly name="sunday_in_time" type="text" value="<?= $result['sunday_in_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="13"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="shift_name">
          <?= lang('Employees.xin_sunday_out_time');?>
          <span class="text-danger">*</span> </label>
        <div class="input-group">
          <input class="form-control etimepicker clear-14" placeholder="<?= lang('Employees.xin_shift_out_time');?>" readonly name="sunday_out_time" type="text" value="<?= $result['sunday_out_time'];?>">
          <div class="input-group-append clear-time" data-clear-id="14"><span class="input-group-text text-danger"><i class="fas fa-trash-alt"></i></span></div>
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
								
	// Clock
	$('.etimepicker').bootstrapMaterialDatePicker({
		date: false,
		shortTime: true,
		format: 'HH:mm'
	});
	//$('.etimepicker').timepicker();
	
	Ladda.bind('button[type=submit]');
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	/* Edit data */
	$("#edit_office_shift").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&type=edit_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					Ladda.stopAll();
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.edit-modal-data').modal('toggle');
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("erp/Officeshifts/office_shifts_list") ?>",
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
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			}
		});
	});
	$(".clear-time").click(function(){
		var clear_id  = $(this).data('clear-id');
		$(".clear-"+clear_id).val('');
	});
});	
</script>
<?php } ?>

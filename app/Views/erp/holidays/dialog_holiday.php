<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\HolidaysModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$HolidaysModel = new HolidaysModel();
$get_animate = '';
if($request->getGet('data') === 'holiday' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $HolidaysModel->where('holiday_id', $ifield_id)->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_holiday');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_holiday', 'id' => 'edit_holiday', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/holidays/update_holiday', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="title">
          <?= lang('Conference.xin_event_title');?> <span class="text-danger">*</span>
        </label>
        <input class="form-control" placeholder="<?= lang('Conference.xin_event_title');?>" name="event_name" type="text" value="<?php echo $result['event_name'];?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="start_date">
          <?= lang('Projects.xin_start_date');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input class="form-control mdate" name="start_date" type="text" value="<?php echo $result['start_date'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="end_date">
          <?= lang('Projects.xin_end_date');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input class="form-control mdate" name="end_date" type="text" value="<?php echo $result['end_date'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="designation" class="control-label">
          <?= lang('Main.dashboard_xin_status');?> <span class="text-danger">*</span>
        </label>
        <select name="is_publish" class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
          <option value="1" <?php if($result['is_publish']=='1') { ?> selected <?php } ?>>
          <?= lang('Recruitment.xin_published');?>
          </option>
          <option value="0" <?php if($result['is_publish']=='0') { ?> selected <?php } ?>>
          <?= lang('Recruitment.xin_unpublished');?>
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="description">
          <?= lang('Main.xin_description');?> <span class="text-danger">*</span>
        </label>
        <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="3"><?php echo $result['description'];?></textarea>
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
	// Date
	$('.mdate').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
	/* Edit*/
	$("#edit_holiday").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=edit_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					$('.edit-modal-data').modal('toggle');
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("erp/holidays/holidays_list") ?>",
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
					Ladda.stopAll();
				}
			}
		});
	});
});	
</script>
<?php } ?>

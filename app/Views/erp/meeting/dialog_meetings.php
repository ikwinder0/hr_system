<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MeetingModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$MeetingModel = new MeetingModel();
$get_animate = '';
$xin_com_system = erp_company_settings();
if($request->getGet('data') === 'meeting' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $MeetingModel->where('meeting_id', $ifield_id)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Conference.xin_edit_meeting');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_meeting', 'id' => 'edit_meeting', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/conference/update_meeting', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="title">
          <?= lang('Conference.xin_hr_meeting_title');?> <span class="text-danger">*</span>
        </label>
        <input class="form-control" placeholder="<?= lang('Conference.xin_hr_meeting_title');?>" name="conference_title" type="text" value="<?php echo $result['meeting_title'];?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="meeting_room">
          <?= lang('Conference.xin_meeting_room');?> <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" name="conference_room" placeholder="<?= lang('Conference.xin_meeting_room');?>" value="<?php echo $result['meeting_room'];?>">
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="start_date">
          <?= lang('Main.xin_e_details_date');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input class="form-control mdate" name="conference_date" type="text" value="<?php echo $result['meeting_date'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="end_date">
          <?= lang('Conference.xin_hr_meeting_time');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input class="form-control mtimepicker" name="conference_time" type="text" value="<?php echo $result['meeting_time'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="meeting_color">
          <?= lang('Conference.xin_meeting_color');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group mhr_color" title="<?= lang('Conference.xin_meeting_color');?>"> <span class="input-group-append"> <span class="input-group-text colorpicker-input-addon"><i></i></span> </span>
          <input class="form-control mhr_color" type="text" value="<?php echo $result['meeting_color'];?>" name="conference_color">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="description">
          <?= lang('Conference.xin_hr_meeting_note');?> <span class="text-danger">*</span>
        </label>
        <textarea class="form-control textarea" placeholder="<?= lang('Conference.xin_hr_meeting_note');?>" name="conference_note" cols="30" rows="2" id="meeting_note2"><?php echo $result['meeting_note'];?></textarea>
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
	$('.mhr_color').colorpicker();
	// Date
	$('.mdate').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: '<?= js_set_date_format();?>',
		lang: '<?= $xin_com_system['datepicker_locale'];?>'
	});
	$('.mtimepicker').bootstrapMaterialDatePicker({
		date: false,
		shortTime: true,
		format: 'HH:mm'
	});
	/* Edit*/
	$("#edit_meeting").submit(function(e){
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
					Ladda.stopAll();
				} else {
					$('.edit-modal-data').modal('toggle');
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("erp/conference/meetings_list") ?>",
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

<?php
use App\Models\SmstemplatesModel;
$request = \Config\Services::request();
if($request->getGet('data') === 'sms_tempalte' && $request->getGet('field_id')){
$template_id = udecode($field_id);
$SmstemplatesModel = new SmstemplatesModel();
$result = $SmstemplatesModel->where('template_id', $template_id)->first();

?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Main.xin_edit_sms_template');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'update_template', 'id' => 'update_template', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/settings/update_sms_template', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="subject">
          <?= lang('Main.xin_subject');?>
          <span class="text-danger">*</span></label>
        <input class="form-control" name="subject" type="text" value="<?php echo $result['subject'];?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="message">
          <?= lang('Main.xin_message');?> <span class="text-danger">*</span>
        </label>
        <textarea class="form-control" placeholder="<?= lang('Main.xin_message');?>" name="message" rows="4"><?php echo $result['message'];?></textarea>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        
        <?php echo html_entity_decode($result['message']);?>
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
	Ladda.bind('button[type=submit]');	
	/* Edit*/
	$("#update_template").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=edit_template&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					var xin_email_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("erp/settings/sms_template_list") ?>",
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
						"iDisplayLength": 20,
						"aLengthMenu": [[20, 30, 50, 100, -1], [20, 30, 50, 100, "All"]],
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_email_table.api().ajax.reload(function(){ 
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
<?php } ?>

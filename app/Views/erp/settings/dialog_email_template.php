<?php
use App\Models\EmailtemplatesModel;
$request = \Config\Services::request();
if($request->getGet('data') === 'email_template' && $request->getGet('field_id')){
$template_id = udecode($field_id);
$EmailtemplatesModel = new EmailtemplatesModel();
$result = $EmailtemplatesModel->where('template_id', $template_id)->first();

?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Main.xin_edit_email_template');?>
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
<?php echo form_open('erp/settings/update_template', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="name">
          <?= lang('Main.xin_template_name');?>
          <span class="text-danger">*</span></label>
        <input class="form-control" name="name" type="text" value="<?php echo $result['name'];?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="subject">
          <?= lang('Main.xin_subject');?>
          <span class="text-danger">*</span></label>
        <input class="form-control" name="subject" type="text" value="<?php echo $result['subject'];?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="status">
          <?= lang('Main.dashboard_xin_status');?>
          <span class="text-danger">*</span></label>
        <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
          <option value=""></option>
          <option value="1" <?php if($result['status']==1):?> selected="selected"<?php endif;?>>
          <?= lang('Main.xin_employees_active');?>
          </option>
          <option value="0" <?php if($result['status']==0):?> selected="selected"<?php endif;?>>
          <?= lang('Main.xin_employees_inactive');?>
          </option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="message">
          <?= lang('Main.xin_message');?>
        </label>
        <textarea class="form-control meditor" placeholder="<?= lang('Main.xin_message');?>" name="message" rows="10" style="height:350px;">
		  <?php echo $result['message'];?></textarea>
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
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	//$('#summernote').trumbowyg();	 
	Ladda.bind('button[type=submit]');
	$(".meditor").kendoEditor({
		
		tools: [
			"bold",
			"italic",
			"underline",
			"justifyLeft",
			"justifyCenter",
			"justifyRight",
			"insertUnorderedList",
			"createLink",
			"unlink",
			"tableWizard",
			"createTable",
			"addRowAbove",
			"addRowBelow",
			"addColumnLeft",
			"addColumnRight",
			"deleteRow",
			"deleteColumn",
			"mergeCellsHorizontally",
			"mergeCellsVertically",
			"splitCellHorizontally",
			"splitCellVertically",
			"tableAlignLeft",
			"tableAlignCenter",
			"tableAlignRight",
			"formatting",
			{
				name: "fontName",
				items: [
					{ text: "Andale Mono", value: "Andale Mono" },
					{ text: "Arial", value: "Arial" },
					{ text: "Arial Black", value: "Arial Black" },
					{ text: "Book Antiqua", value: "Book Antiqua" },
					{ text: "Comic Sans MS", value: "Comic Sans MS" },
					{ text: "Courier New", value: "Courier New" },
					{ text: "Georgia", value: "Georgia" },
					{ text: "Helvetica", value: "Helvetica" },
					{ text: "Impact", value: "Impact" },
					{ text: "Symbol", value: "Symbol" },
					{ text: "Tahoma", value: "Tahoma" },
					{ text: "Terminal", value: "Terminal" },
					{ text: "Times New Roman", value: "Times New Roman" },
					{ text: "Trebuchet MS", value: "Trebuchet MS" },
					{ text: "Verdana", value: "Verdana" },
				]
			},
			"fontSize",
			"foreColor",
			"backColor",
		]
	});
	
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
							url : "<?php echo site_url("erp/settings/email_template_list") ?>",
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

<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\TicketsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$TicketsModel = new TicketsModel();
$get_animate = '';
if($request->getGet('type') === 'ticket' && $request->getGet('field_id')){
$ticket_id = udecode($field_id);
$result = $TicketsModel->where('ticket_id', $ticket_id)->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Dashboard.left_edit_ticket');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'update_ticket', 'id' => 'update_ticket', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/tickets/update_ticket', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="task_name">
          <?= lang('Main.xin_subject');?> <span class="text-danger">*</span>
        </label>
        <input class="form-control" placeholder="<?= lang('Main.xin_subject');?>" name="subject" type="text" value="<?= $result['subject'];?>">
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="ticket_priority" class="control-label">
          <?= lang('Projects.xin_p_priority');?>
        </label>
        <select name="ticket_priority" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Projects.xin_p_priority');?>">
          <option value=""></option>
          <option value="1" <?php if($result['ticket_priority'] == 1):?> selected="selected"<?php endif;?>>
          <?= lang('Projects.xin_low');?>
          </option>
          <option value="2" <?php if($result['ticket_priority'] == 2):?> selected="selected"<?php endif;?>>
          <?= lang('Main.xin_medium');?>
          </option>
          <option value="3" <?php if($result['ticket_priority'] == 3):?> selected="selected"<?php endif;?>>
          <?= lang('Projects.xin_high');?>
          </option>
          <option value="4" <?php if($result['ticket_priority'] == 4):?> selected="selected"<?php endif;?>>
          <?= lang('Main.xin_critical');?>
          </option>
        </select>
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
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){ 

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	 
	Ladda.bind('button[type=submit]');
	$(".meditor").kendoEditor({
		resizable: {
			content: true,
			toolbar: true
		}
	});
	/* Edit data */
	$("#update_ticket").submit(function(e){
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
					$('.view-modal-data').modal('toggle');
					Swal.fire({
					title:JSON.result,
					timer:2000,
					icon: "success",
					showConfirmButton: false,
					timerProgressBar: true,
					onBeforeOpen:function(){
						Swal.showLoading(),
						t=setInterval(function(){
							},100)}
						,onClose:function(){clearInterval(t);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
						Ladda.stopAll();
						window.location = '';
						}})
					.then(function(t){
							t.dismiss===Swal.DismissReason.timer&&console.log("I was closed by the timer")});
						e.preventDefault();	
				}
			}
		});
	});
});	
  </script>
<?php }
?>

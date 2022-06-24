<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();
$SystemModel = new SystemModel();

$xin_system = $SystemModel->where('setting_id', 1)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();



/* Transfers view
*/
$get_animate = '';
if($request->getGet('type') === 'view_lead' && $request->getGet('field_id')){
$transfer_id = udecode($field_id);
//$result = $TransfersModel->where('transfer_id', $transfer_id)->first();

?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Main.xin_change_lead_to_client_text');?>
 </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'convert_lead', 'id' => 'convert_lead', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/clients/convert_lead', $attributes, $hidden);?>
<div class="modal-body">
<div class="alert alert-danger" role="alert">
    <?= lang('Main.xin_change_lead_not_restored');?>
</div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_confirm_convert');?>
  </button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		Ladda.bind('button[type=submit]');		
		/* Edit data */
		$("#convert_lead").submit(function(e){
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
							url : "<?php echo site_url("erp/clients/leads_list") ?>",
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
						$('.view-modal-data').modal('toggle');
						Ladda.stopAll();
					}
				}
			});
		});
	});	
  </script>
<?php }
?>

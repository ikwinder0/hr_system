<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\LeadsfollowupModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$LeadsfollowupModel = new LeadsfollowupModel();
$get_animate = '';
$xin_com_system = erp_company_settings();
if($request->getGet('data') === 'followup' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $LeadsfollowupModel->where('followup_id', $ifield_id)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Dashboard.left_edit_department');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_followup', 'id' => 'edit_followup', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/clients/update_followup', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="company_name">
            <?= lang('Main.xin_next_follow_up');?>
            <span class="text-danger">*</span> </label>
            <div class="input-group">
                <input class="form-control d_date" placeholder="<?= lang('Main.xin_next_follow_up');?>" name="next_follow_up" type="text" value="<?= $result['next_followup'];?>">
                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
              </div>
        </div>
      </div>
      
      <div class="col-md-12">
        <div class="form-group">
          <label for="address_1">
            <?= lang('Main.xin_description');?> <span class="text-danger">*</span>
            </label>
          <textarea class="form-control" placeholder="<?= lang('Main.xin_description');?>" name="description" rows="3"><?= $result['description'];?></textarea>
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
	 $('.d_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: '<?= js_set_date_format();?>',
		lang: '<?= $xin_com_system['datepicker_locale'];?>'
	});
	/* Edit data */
	$("#edit_followup").submit(function(e){
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
							url : "<?= site_url("erp/clients/leads_followup_list") ?>?xlead_id=<?= uencode($result['lead_id']);?>",
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
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
					}, true);
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

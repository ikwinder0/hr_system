<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ContractModel;
use App\Models\OfficialdocumentsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$ContractModel = new ContractModel();
$OfficialdocumentsModel = new OfficialdocumentsModel();
$get_animate = '';
$xin_com_system = erp_company_settings();
if($request->getGet('data') === 'official_document' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $OfficialdocumentsModel->where('document_id', $ifield_id)->first();
//$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_documents');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_document', 'id' => 'edit_document', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open_multipart('erp/documents/update_official_document', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label for="date_of_expiry" class="control-label">
          <?= lang('Employees.xin_license_name');?>
          <span class="text-danger">*</span></label>
        <input class="form-control" placeholder="<?= lang('Employees.xin_license_name');?>" name="license_name" type="text" value="<?= $result['license_name'];?>">
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label for="title" class="control-label">
          <?= lang('Employees.xin_document_type');?>
          <span class="text-danger">*</span></label>
        <input class="form-control" placeholder="<?= lang('Employees.xin_document_eg_payslip_etc');?>" name="document_type" type="text" value="<?= $result['document_type'];?>">
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="expiry_date">
          <?= lang('Employees.xin_document_doe');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input class="form-control d_date" placeholder="<?= lang('Employees.xin_document_doe');?>" name="expiry_date" type="text" value="<?= $result['expiry_date'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="license_number">
          <?= lang('Employees.xin_license_number');?> <span class="text-danger">*</span>
        </label>
        <input class="form-control" placeholder="<?= lang('Employees.xin_license_number');?>" name="license_number" type="text" value="<?= $result['license_no'];?>">
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label for="logo">
          <?= lang('Employees.xin_document_file');?>
          <span class="text-danger">*</span> </label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" name="document_file">
          <label class="custom-file-label">
            <?= lang('Main.xin_choose_file');?>
          </label>
          <small>
          <?= lang('Main.xin_company_file_type');?>
          </small> </div>
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
	$("#edit_document").submit(function(e){
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
					var xin_table_document = $('#xin_table_document').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/documents/official_documents_list"); ?>",
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
					xin_table_document.api().ajax.reload(function(){ 
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

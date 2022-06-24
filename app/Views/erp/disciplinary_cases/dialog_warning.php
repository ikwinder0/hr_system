<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\WarningModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$WarningModel = new WarningModel();	
$SystemModel = new SystemModel();
$ConstantsModel = new ConstantsModel();
$xin_com_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','warning_type')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','warning_type')->findAll();
}
$xin_system = $SystemModel->where('setting_id', 1)->first();
/* Assets view
*/
$get_animate = '';
if($request->getGet('data') === 'warning' && $request->getGet('field_id')){
$warning_id = udecode($field_id);
$result = $WarningModel->where('warning_id', $warning_id)->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_case');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_warning', 'id' => 'edit_warning', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/warning/update_warning', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="subject">
              <?= lang('Main.xin_subject');?> <span class="text-danger">*</span>
            </label>
            <input class="form-control" placeholder="<?= lang('Main.xin_subject');?>" name="subject" type="text" value="<?php echo $result['subject'];?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="warning_date">
              <?= lang('Employees.xin_case_date');?> <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <input class="form-control d_date" placeholder="<?= lang('Employees.xin_case_date');?>" name="warning_date" type="text" value="<?php echo $result['warning_date'];?>">
              <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
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
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 	
	
	$('.d_date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: '<?= js_set_date_format();?>',
		lang: '<?= $xin_com_system['datepicker_locale'];?>'
	});	
	/* Edit data */
	$("#edit_warning").submit(function(e){
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
						url : "<?php echo site_url("erp/warning/warning_list") ?>",
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
			}
		});
	});
});	
</script>
<?php } elseif($request->getGet('type') === 'view_warning' && $request->getGet('field_id')){
$warning_id = udecode($field_id);
$result = $WarningModel->where('warning_id', $warning_id)->first();
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_view_case');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<form class="m-b-1">
<div class="modal-body">
  <table class="footable-details table table-striped table-hover toggle-circle">
    <tbody>
      <tr>
        <th><?= lang('Dashboard.dashboard_employee');?></th>
        <td style="display: table-cell;" class="text-danger"><?php
		$warning_to = $UsersModel->where('user_id', $result['warning_to'])->first();
		echo $warning_to['first_name'].' '.$warning_to['last_name'];
        ?></td>
      </tr>
      <tr>
        <?php $category_info = $ConstantsModel->where('constants_id', $result['warning_type_id'])->where('type','warning_type')->first(); ?>
        <th><?= lang('Employees.xin_case_type');?></th>
        <td style="display: table-cell;"><?= $category_info['category_name'];?></td>
      </tr>
      <tr>
        <th><?= lang('Main.xin_subject');?></th>
        <td style="display: table-cell;"><?php echo $result['subject'];?></td>
      </tr>
      <tr>
        <th><?= lang('Employees.xin_case_by');?></th>
        <td style="display: table-cell;" class="text-success"><?php
        	$warning_by = $UsersModel->where('user_id', $result['warning_by'])->first();
			echo $warning_by['first_name'].' '.$warning_by['last_name'];
		?></td>
      </tr>
      <tr>
        <th><?= lang('Employees.xin_case_date');?></th>
        <td style="display: table-cell;"><?= set_date_format($result['warning_date']);?></td>
      </tr>
      <tr>
        <th><?= lang('Main.xin_attachment');?></th>
        <td style="display: table-cell;"><?php if($result['attachment']!='' && $result['attachment']!='no file') {?>
          <img src="<?php echo base_url().'/public/uploads/warning/'.$result['attachment'];?>" width="70px" id="u_file">&nbsp; <a href="<?= site_url()?>download?type=warning&filename=<?php echo uencode($result['attachment']);?>">
          <?= lang('Main.xin_download');?>
          </a>
          <?php } ?></td>
      </tr>
      <tr>
        <th><?= lang('Main.xin_description');?></th>
        <td style="display: table-cell;"><?php echo html_entity_decode($result['description']);?></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
</div>
<?php echo form_close(); ?>
<?php }
?>

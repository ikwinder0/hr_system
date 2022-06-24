<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\TransfersModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$TransfersModel = new TransfersModel();	
$SystemModel = new SystemModel();
$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$StaffdetailsModel = new StaffdetailsModel();

$xin_system = $SystemModel->where('setting_id', 1)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_id!=', $usession['sup_user_id'])->where('user_type','staff')->findAll();
} else {
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
}
/* Transfers view
*/
$get_animate = '';
$xin_com_system = erp_company_settings();
if($request->getGet('data') === 'transfer' && $request->getGet('field_id')){
$transfer_id = udecode($field_id);
$result = $TransfersModel->where('transfer_id', $transfer_id)->first();

if($user_info['user_type'] == 'staff'){
	$departments = $DepartmentModel->where('company_id',$user_info['company_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$user_info['company_id'])->where('department_id',$result['transfer_department'])->orderBy('designation_id', 'ASC')->findAll();
} else {
	$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->where('department_id',$result['transfer_department'])->orderBy('designation_id', 'ASC')->findAll();
}
//$result = $UsersModel->where('user_id', $result['employee_id'])->first();
$employee_detail = $StaffdetailsModel->where('user_id', $result['employee_id'])->first();

?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_transfer');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_transfer', 'id' => 'edit_transfer', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/transfers/update_transfer', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
  <?php //if($user_info['user_type'] == 'company'){?>
  <?php //$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
  <div class="col-md-6">
    <div class="form-group">
      <label for="first_name">
        <?= lang('Dashboard.dashboard_employee');?> <span class="text-danger">*</span>
      </label>
      <select class="form-control" name="employee" id="memployee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_choose_an_employee');?>">
        <?php foreach($staff_info as $staff) {?>
        <option value="<?= $staff['user_id']?>" <?php if($staff['user_id']==$result['employee_id']):?> selected="selected"<?php endif;?>>
        <?= $staff['first_name'].' '.$staff['last_name'] ?>
        </option>
        <?php } ?>
      </select>
    </div>
  </div>  
  <div class="col-md-6">
    <div class="form-group" id="mdepartment_ajax">
      <label for="transfer_department">
        <?= lang('Employees.xin_transfer_department');?> <span class="text-danger">*</span>
      </label>
      <select class="form-control" name="department" id="mdepartment_id" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_transfer_department');?>">
        <?php foreach($departments as $idepartment) {?>
		<?php if($employee_detail['department_id'] != $idepartment['department_id']){?>
        <option value="<?= $idepartment['department_id']?>" <?php if($idepartment['department_id']==$result['transfer_department']):?> selected="selected"<?php endif;?>>
        <?= $idepartment['department_name']?>
        </option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group" id="mdesignation_ajax">
      <label for="transfer_designation">
        <?= lang('Employees.xin_transfer_designation');?> <span class="text-danger">*</span>
      </label>
      <select class="form-control" name="designation" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_transfer_designation');?>">
        <?php foreach($designations as $idesignation) {?>
        <option value="<?= $idesignation['designation_id']?>" <?php if($idesignation['designation_id']==$result['transfer_designation']):?> selected="selected"<?php endif;?>>
        <?= $idesignation['designation_name']?>
        </option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="notice_date">
        <?= lang('Employees.xin_transfer_date');?> <span class="text-danger">*</span>
      </label>
      <div class="input-group">
        <input class="form-control d_date" placeholder="<?= lang('Employees.xin_transfer_date');?>" name="transfer_date" type="text" value="<?= $result['transfer_date'];?>">
        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
      <div class="form-group">
        <label for="notice_date">
          <?= lang('Main.dashboard_xin_status');?> <span class="text-danger">*</span>
        </label>
        <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
          <option value="">
          <?= lang('dashboard_xin_status');?>
          </option>
          <option value="0" <?php if($result['status']=='0'):?> selected <?php endif; ?>>
          <?= lang('Main.xin_pending');?>
          </option>
          <option value="1" <?php if($result['status']=='1'):?> selected <?php endif; ?>>
          <?= lang('Main.xin_accepted');?>
          </option>
          <option value="2" <?php if($result['status']=='2'):?> selected <?php endif; ?>>
          <?= lang('Main.xin_rejected');?>
          </option>
        </select>
      </div>
    </div>
  <div class="col-md-12">
    <div class="form-group">
      <label for="reason"> 
        <?= lang('Employees.xin_transfer_reason');?> <span class="text-danger">*</span>
      </label>
      <textarea class="form-control textarea" placeholder="<?= lang('Employees.xin_transfer_reason');?>" name="reason" cols="30" rows="3"><?= $result['reason'];?></textarea>
    </div>
  </div>
</div>
<?php if($result['status']=='1'):?>
<div class="alert alert-success" role="alert">
    <?= lang('Employees.xin_transfer_accepted_msg');?>
</div>
<?php endif;?>
<?php if($result['status']=='2'):?>
<div class="alert alert-danger" role="alert">
    <?= lang('Employees.xin_transfer_rejected_msg');?>
</div>
<?php endif;?>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <?php if($result['status']=='0'):?>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
  <?php endif;?>
</div>
<?php echo form_close(); ?> 
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
		jQuery("#memployee_id").change(function(){
			jQuery.get(main_url+"transfers/is_departmentajx/"+jQuery(this).val(), function(data, status){
				jQuery('#mdepartment_ajax').html(data);
			});
		});
		jQuery("#mdepartment_id").change(function(){
			jQuery.get(main_url+"transfers/is_designationajx/"+jQuery(this).val(), function(data, status){
				jQuery('#mdesignation_ajax').html(data);
			});
		});
		/* Edit data */
		$("#edit_transfer").submit(function(e){
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
							url : "<?php echo site_url("erp/transfers/transfers_list") ?>",
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

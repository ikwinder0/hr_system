<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\DepartmentModel;
use App\Models\StaffdetailsModel;

$UsersModel = new UsersModel();
$DepartmentModel = new DepartmentModel();
$StaffdetailsModel = new StaffdetailsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$result = $UsersModel->where('user_id', $user_id)->first();
$employee_detail = $StaffdetailsModel->where('user_id', $result['user_id'])->first();

if($user_info['user_type'] == 'staff'){
	$department = $DepartmentModel->where('company_id',$user_info['company_id'])->orderBy('department_id', 'ASC')->findAll();
} else {
	$department = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
}
?>

<div class="form-group" id="mdepartment_ajax">
  <label class="form-label">
    <?= lang('Employees.xin_transfer_department');?>
  </label>
  <span class="text-danger">*</span>
  <select class="form-control" name="department" id="mdepartment_id" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_transfer_department');?>">
    <option value="">
    <?= lang('Employees.xin_transfer_department');?>
    </option>
    <?php foreach($department as $idepartment) {?>
    <?php if($employee_detail['department_id'] != $idepartment['department_id']){?>
    <option value="<?= $idepartment['department_id']?>">
    <?= $idepartment['department_name']?>
    </option>
    <?php } ?>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#mdepartment_id").change(function(){
		jQuery.get(main_url+"transfers/is_designationajx/"+jQuery(this).val(), function(data, status){
			jQuery('#mdesignation_ajax').html(data);
		});
	});	
});
</script>
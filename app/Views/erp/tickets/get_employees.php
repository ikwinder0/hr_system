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
if($user_info['user_type'] == 'staff'){
	$staff_details = $StaffdetailsModel->where('department_id',$department_id)->orderBy('user_id', 'ASC')->findAll();
} else {
	$staff_details = $StaffdetailsModel->where('department_id',$department_id)->orderBy('user_id', 'ASC')->findAll();
}
?>

<div class="form-group" id="staff_ajax">
  <label class="form-label">
    <?= lang('Dashboard.dashboard_employee');?>
  </label>
  <span class="text-danger">*</span>
  <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>">
    <option value=""></option>
	<?php foreach($staff_details as $staff) {?>
    <?php $staff_info = $UsersModel->where('user_id', $staff['user_id'])->where('user_type','staff')->first();?>
    <option value="<?= $staff_info['user_id']?>">
    <?= $staff_info['first_name'].' '.$staff_info['last_name'];?>
    </option>
    <?php } ?>
  </select>
</div>
<script type="text/javascript">
$(document).ready(function(){	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>
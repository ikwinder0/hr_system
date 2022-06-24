<?php
use App\Models\DesignationModel;
use App\Models\SystemModel;
use App\Models\UsersModel;

$DesignationModel = new DesignationModel();
$UsersModel = new UsersModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$designations = $DesignationModel->where('company_id',$user_info['company_id'])->where('department_id',$department_id)->orderBy('designation_id', 'ASC')->findAll();
} else {
	$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->where('department_id',$department_id)->orderBy('designation_id', 'ASC')->findAll();
}
?>

<div class="form-group" id="designation_ajax">
  <label class="form-label">
    <?= lang('Employees.xin_transfer_designation');?>
  </label>
  <span class="text-danger">*</span>
  <select class="form-control" name="designation" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_transfer_designation');?>">
    <option value="">
    <?= lang('Employees.xin_transfer_designation');?>
    </option>
    <?php foreach($designations as $idesignation) {?>
    <option value="<?= $idesignation['designation_id']?>">
    <?= $idesignation['designation_name']?>
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
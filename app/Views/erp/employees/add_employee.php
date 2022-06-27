<?php
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ShiftModel;
use App\Models\ConstantsModel;
use App\Models\SystemModel;

$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$ConstantsModel = new ConstantsModel();
$ShiftModel = new ShiftModel();
$SystemModel = new SystemModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$departments = $DepartmentModel->where('company_id',$user_info['company_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$user_info['company_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$user_info['company_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$roles = $RolesModel->where('company_id',$user_info['company_id'])->orderBy('role_id', 'ASC')->findAll();
} else {
	$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$usession['sup_user_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$roles = $RolesModel->where('company_id',$usession['sup_user_id'])->orderBy('role_id', 'ASC')->findAll();
}
		

$xin_system = $SystemModel->where('setting_id', 1)->first();
$employee_id = generate_random_employeeid();
$get_animate='';
?>
<div
    id="smartwizard-2"
    class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
    <ul class="nav nav-tabs step-anchor">
        <li class="nav-item active">
            <a href="<?= site_url('erp/staff-list');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon fas fa-user-friends"></span>
                <?= lang('Dashboard.xin_personal_info');?>
                <div class="text-muted small">
                    <?= lang('Main.xin_info');?>
                </div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/set-roles');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon fas fa-user-lock"></span>
                <?= lang('Main.xin_experience_and_education');?>
                <div class="text-muted small">
                    <?= lang('Dashboard.xin_experience_and_education');?>
                </div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/office-shifts');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-clock"></span>
                <?= lang('Dashboard.xin_interview_details');?>
                <div class="text-muted small">
                    <?= lang('Dashboard.xin_interview_details');?>
                </div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/employee-exit');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-log-out"></span>
                <?= lang('Dashboard.xin_attachment');?>
                <div class="text-muted small">
                    <?= lang('Main.xin_add');?>
                    <?= lang('Dashboard.xin_attachment');?>
                </div>
            </a>
        </li>
    </ul>
</div>
<hr class="border-light m-0 mb-3">
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
                <?= lang('Main.xin_personal_info');?>
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
                    <?= lang('Main.xin_experience_and_education');?>
                </div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/office-shifts');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-clock"></span>
                <?= lang('Main.xin_interview_details');?>
                <div class="text-muted small">
                    <?= lang('Main.xin_interview_details');?>
                </div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/employee-exit');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-log-out"></span>
                <?= lang('Main.xin_attachment');?>
                <div class="text-muted small">
                    <?= lang('Main.xin_add');?>
                    <?= lang('Main.xin_attachment');?>
                </div>
            </a>
        </li>
    </ul>
</div>
<hr class="border-light m-0 mb-3">
<div id="accordion">
    <div
        id="add_form"
        style="">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0);?>
        <?= form_open_multipart('erp/employees/add_employee', $attributes, $hidden);?>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header">
                        <h5>
                            <?= lang('Main.xin_add');?>
                            <?= lang('Main.xin_personal_info');?>
                        </h5>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-md-12">
                                <label for="logo">
                                    <?= lang('Main.xin_e_details_profile_picture');?>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file">
                                    <label class="custom-file-label">
                                        <?= lang('Main.xin_choose_file');?>
                                    </label>
                                    <small>
                                        <?= lang('Main.xin_company_file_type');?>
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name">
                                        <?= lang('Main.xin_employee_first_name');?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i></span></div>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="<?= lang('Main.xin_employee_first_name');?>"
                                            name="first_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">
                                        <?= lang('Main.xin_employee_last_name');?>
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i></span></div>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="<?= lang('Main.xin_employee_last_name');?>"
                                            name="last_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">
                                        <?= lang('Main.xin_email');?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i></span></div>
                                        <input
                                            class="form-control"
                                            placeholder="<?= lang('Main.xin_email');?>"
                                            name="email"
                                            type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number">
                                        <?= lang('Main.xin_contact_number');?>
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-phone"></i></span></div>
                                        <input
                                            class="form-control"
                                            placeholder="<?= lang('Main.xin_contact_number');?>"
                                            name="contact_number"
                                            type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number">
                                        <?= lang('Main.xin_dob');?>
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-birthday-cake"></i></span></div>
                                        <input
                                            class="form-control maxdate"
                                            placeholder="<?= lang('Main.xin_dob');?>"
                                            name="dob"
                                            type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender" class="control-label">
                                        <?= lang('Main.xin_employee_gender');?>
                                    </label>
                                    <select
                                        class="form-control"
                                        name="gender"
                                        data-plugin="select_hrm"
                                        data-placeholder="<?= lang('Main.xin_employee_gender');?>">
                                        <option value="1">
                                            <?= lang('Main.xin_gender_male');?>
                                        </option>
                                        <option value="2">
                                            <?= lang('Main.xin_gender_female');?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number">
                                        <?= lang('Main.xin_nationality');?>
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-flag"></i></span></div>
                                        <input
                                            class="form-control"
                                            placeholder="<?= lang('Main.xin_nationality');?>"
                                            name="nationality"
                                            type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number">
                                        <?= lang('Main.xin_marital_status');?>
                                        <span class="text-danger">*</span></label>
                                    <select
                                        class="form-control"
                                        name="marital_status"
                                        data-plugin="select_hrm"
                                        data-placeholder="<?= lang('Main.xin_employee_gender');?>">
                                        <option value="1">
                                            <?= lang('Main.xin_marital_single');?>
                                        </option>
                                        <option value="2">
                                            <?= lang('Main.xin_marital_married');?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number">
                                        <?= lang('Main.xin_religion');?>
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-atom"></i></span></div>
                                        <input
                                            class="form-control"
                                            placeholder="<?= lang('Main.xin_religion');?>"
                                            name="religion"
                                            type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="card-footer text-right">
						<button type="submit" class="btn btn-primary">
							<?= lang('Main.xin_save');?>
						</button>
					</div>
				</div>
			</div>
		</div>
		<?= form_close(); ?>
	</div>
</div>
</div>
</div>
</div>
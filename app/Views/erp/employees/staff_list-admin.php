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
if($user_info['user_type'] == 'super_user'){
	$departments = $DepartmentModel->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = '';
	$leave_types = '';
	$roles = '';
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

<?php if(in_array('staff3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="accordion">
    <div
        id="add_form"
        class="collapse add-form <?php echo $get_animate;?>"
        data-parent="#accordion"
        style="">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0);?>
        <?= form_open_multipart('erp/employees/add_employee', $attributes, $hidden);?>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
				<?php if($user_info['user_type'] == 'company') { ?>
                    <div class="card-header">
                        <h5>
                            <?= lang('Main.xin_add_new');?>
                            <?= lang('Dashboard.dashboard_employee');?>
                        </h5>
					
                        <div class="card-header-right">
                            <a
                                data-toggle="collapse"
                                href="#add_form"
                                aria-expanded="false"
                                class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0">
                                <i data-feather="minus"></i>
                                <?= lang('Main.xin_hide');?>
                            </a>
                        </div>
                    </div>
				<?php } ?>
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
                        <hr class="m-0 mb-3">
                        <span class="preview-title-lg">
                            <b><?= lang('Main.xin_experience');?></b>
                        </span>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number">
                                        <?= lang('Main.xin_experience_1');?>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-calendar-star"></i></span></div>
                                            <input
                                                class="form-control"
                                                placeholder="<?= lang('Main.xin_experience_1');?>"
                                                name="experience_1"
                                                type="text">
                                        </div>
                                </div>
                            </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_number">
                                            <?= lang('Main.xin_experience_2');?>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-star"></i></span></div>
                                                <input
                                                    class="form-control"
                                                    placeholder="<?= lang('Main.xin_experience_2');?>"
                                                    name="experience_2"
                                                    type="text">
                                            </div>
                                    </div>
                                </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="contact_number">
                                                <?= lang('Main.xin_experience_3');?>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-calendar-star"></i></span></div>
                                                    <input
                                                        class="form-control"
                                                        placeholder="<?= lang('Main.xin_experience_3');?>"
                                                        name="experience_3"
                                                        type="text">
                                                </div>
                                        </div>
                                    </div>
                        </div>
                        <hr class="m-0 mb-3">
                        <span class="preview-title-lg">
                            <b><?= lang('Main.xin_education_details');?></b>
                        </span>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number">
                                        <?= lang('Main.xin_education_high_school');?>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                <i class="fas fa-school"></i></span></div>
                                            <input
                                                class="form-control"
                                                placeholder="<?= lang('Main.xin_education_high_school');?>"
                                                name="high_school"
                                                type="text">
                                        </div>
                                </div>
                            </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_number">
                                            <?= lang('Main.xin_education_degree');?>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                    <i class="fas fa-graduation-cap"></i></span></div>
                                                <input
                                                    class="form-control"
                                                    placeholder="<?= lang('Main.xin_education_degree');?>"
                                                    name="degree"
                                                    type="text">
                                            </div>
                                    </div>
                                </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="contact_number">
                                                <?= lang('Main.xin_education_other');?>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                        <i class="fas fa-circle"></i></span></div>
                                                    <input
                                                        class="form-control"
                                                        placeholder="<?= lang('Main.xin_education_other');?>"
                                                        name="other_education"
                                                        type="text">
                                                </div>
                                        </div>
                                    </div>
                        </div>

                                    <div class="card-footer text-right">
                                        <button
                                            type="reset"
                                            class="btn btn-light"
                                            href="#add_form"
                                            data-toggle="collapse"
                                            aria-expanded="false">
                                            <?= lang('Main.xin_reset');?>
                                        </button>
                                        &nbsp;
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
                <?php } ?>
                <div class="card user-profile-list">
				<?php if($user_info['user_type'] == 'company') { ?>
                    <div class="card-header">
                        <h5>
                            <?= lang('Main.xin_list_all');?>
                            <?= lang('Dashboard.dashboard_employees');?>
                        </h5>
                        <div class="card-header-right">
                            <a
                                href="<?= site_url().'erp/staff-grid';?>"
                                class="btn btn-sm waves-effect waves-light btn-primary btn-icon m-0"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="<?= lang('Projects.xin_grid_view');?>">
                                <i class="fas fa-th-large"></i>
                            </a>
                            <?php if(in_array('staff3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                            <a
                                
                                href="<?= site_url().'erp/create-employee'; ?>"
                               
                                class="btn waves-effect waves-light btn-primary btn-sm m-0">
                                <i data-feather="plus"></i>
                                <?= lang('Main.xin_add_new');?>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
				<?php } ?> 
                    <div class="card-body">
                        <div class="box-datatable table-responsive">
                            <table
                                class="datatables-demo table table-striped table-bordered"
                                id="xin_table">
                                <thead>
                                    <tr>
                                        <th><?= lang('Main.xin_name');?></th>
                                        <th>Company Name</th>
                                        <th><?= lang('Dashboard.left_designation');?></th>
                                        <th>ID</th>
                                        <th><?= lang('Main.xin_contact_number');?></th>
                                        <th><?= lang('Main.xin_employee_gender');?></th>
                                        <th><?= lang('Main.xin_country');?></th>
                                        <th><?= lang('Main.dashboard_xin_status');?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
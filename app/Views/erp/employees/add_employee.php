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
        <li class="nav-item step1 active">
            <a href="#">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon fas fa-user-friends"></span>
                <?= lang('Main.xin_personal_info');?>
                <div class="text-muted small">
                    <?= lang('Main.xin_info');?>
                </div>
            </a>
        </li>
        <li class="nav-item step2 clickable">
            <a href="#" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon fas fa-user-lock"></span>
                <?= lang('Main.xin_experience_and_education');?>
                <div class="text-muted small">
                    <?= lang('Main.xin_experience_and_education');?>
                </div>
            </a>
        </li>
        <li class="nav-item step3 clickable">
            <a href="#" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon fas fa-paperclip"></span>
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
		<fieldset class="fieldset_1">
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
						    <div class="col-md-4">
                                <label for="logo">
                                    <?= lang('Main.xin_position_applied_for');?>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="fas fa-user"></i></span></div>
									<input
										type="text"
										class="form-control"
										placeholder="<?= lang('Main.xin_position_applied_for');?>"
										name="applied_for">
                                </div>
                            </div>
                            <div class="col-md-4">
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
						</div>
						<div class="row">
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
                                        <span class="text-danger">*</span>
									</label>
                                    <div class="input-group">
                            
									<select class="form-control dropdown" id="religion" name="religion">
										<option value="" selected="selected" disabled="disabled"><?= lang('Employees.xin_select_religion');?></option>
										<option value="African Traditional &amp; Diasporic">African Traditional &amp; Diasporic</option>
										<option value="Agnostic">Agnostic</option>
										<option value="Atheist">Atheist</option>
										<option value="Baha'i">Baha'i</option>
										<option value="Buddhism">Buddhism</option>
										<option value="Cao Dai">Cao Dai</option>
										<option value="Chinese traditional religion">Chinese traditional religion</option>
										<option value="Christianity">Christianity</option>
										<option value="Hinduism">Hinduism</option>
										<option value="Islam">Islam</option>
										<option value="Jainism">Jainism</option>
										<option value="Juche">Juche</option>
										<option value="Judaism">Judaism</option>
										<option value="Neo-Paganism">Neo-Paganism</option>
										<option value="Nonreligious">Nonreligious</option>
										<option value="Rastafarianism">Rastafarianism</option>
										<option value="Secular">Secular</option>
										<option value="Shinto">Shinto</option>
										<option value="Sikhism">Sikhism</option>
										<option value="Spiritism">Spiritism</option>
										<option value="Tenrikyo">Tenrikyo</option>
										<option value="Unitarian-Universalism">Unitarian-Universalism</option>
										<option value="Zoroastrianism">Zoroastrianism</option>
										<option value="primal-indigenous">primal-indigenous</option>
										<option value="Other">Other</option>
									</select>
											
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="card-footer text-right">
						<button type="button" class="btn btn-primary next">
							<?= lang('Main.next');?>
						</button>
					</div>
				</div>
			</div>
		</div>
		</fieldset>
		<fieldset class="fieldset_2">
		<div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header">
                        <h5>
                            <?= lang('Main.xin_add');?>
                            <?= lang('Main.xin_experience_and_education');?>
                        </h5>
                    </div>
                    <div class="card-body">
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
					</div>
					<div class="card-footer text-right">
					    <button
							type="button"
							class="btn btn-light previous">
							<?= lang('Main.back');?>
						</button>
						&nbsp;
						<button type="button" class="btn btn-primary next">
							<?= lang('Main.next');?>
						</button>
					</div>
				</div>
			</div>
		</div>
		</fieldset>
		<fieldset class="fieldset_3">
		<div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header">
                        <h5>
                            <?= lang('Main.xin_add');?>
                            <?= lang('Main.xin_attachment');?>
                        </h5>
                    </div>
                    <div class="card-body">
					    <div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="contact_number">
										<?= lang('Main.xin_resume');?>
                                    </label>
										<div class="custom-file">
											<input
												class="form-control"
												name="resume"
												type="file">
											<label class="custom-file-label">
												<?= lang('Main.xin_choose_file');?>
											</label>
											<small>
												<?= lang('Main.xin_company_file_type');?>
											</small>
										</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="contact_number">
										<?= lang('Main.xin_passport');?>
									</label>
											<div class="custom-file">
											<input
												class="form-control"
												name="passport"
												type="file">
											<label class="custom-file-label">
												<?= lang('Main.xin_choose_file');?>
											</label>
											<small>
												<?= lang('Main.xin_company_file_type');?>
											</small>
										</div>
								</div>
							</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="contact_number">
											<?= lang('Main.xin_education_certificate');?>
										</label>
											<div class="custom-file">
												<input
													class="form-control"
													name="education_certificate"
													type="file">
												<label class="custom-file-label">
													<?= lang('Main.xin_choose_file');?>
												</label>
												<small>
													<?= lang('Main.xin_company_file_type');?>
												</small>
											</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="contact_number">
											<?= lang('Main.xin_experience_certificate');?>
										</label>
											<div class="custom-file">
												<input
													class="form-control"
													name="experience_certificate"
													type="file">
											<label class="custom-file-label">
												<?= lang('Main.xin_choose_file');?>
											</label>
											<small>
												<?= lang('Main.xin_company_file_type');?>
											</small>
											</div>
									</div>
								</div>
								<div class="col-md-4">
								<div class="form-group">
									<label for="contact_number">
										<?= lang('Main.xin_police_clearance_certificate');?>
									</label>
											<div class="custom-file">
											<input
												class="form-control"
												name="police_clearance_certificate"
												type="file">
											<label class="custom-file-label">
												<?= lang('Main.xin_choose_file');?>
											</label>
											<small>
												<?= lang('Main.xin_company_file_type');?>
											</small>
										</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer text-right">
					    <button
							type="button"
							class="btn btn-light previous">
							<?= lang('Main.back');?>
						</button>
						&nbsp;
						<button type="submit" class="btn btn-primary">
							<?= lang('Main.save');?>
						</button>
					</div>
				</div>
			</div>
		</div>
		</fieldset>
		<?= form_close(); ?>
	</div>
</div>
</div>
</div>
</div>
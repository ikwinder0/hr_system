<?php
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ShiftModel;
use App\Models\ConstantsModel;
use App\Models\SystemModel;
use App\Models\CountryModel;

$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$ConstantsModel = new ConstantsModel();
$ShiftModel = new ShiftModel();
$SystemModel = new SystemModel();
$CountryModel = new CountryModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();

//$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
//$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->orderBy('designation_id', 'ASC')->findAll();
$designations = $DesignationModel->orderBy('designation_id', 'ASC')->findAll();
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$religion = $ConstantsModel->where('type','religion')->orderBy('constants_id', 'ASC')->findAll();
$xin_system = $SystemModel->where('setting_id', 1)->first();

//$employee_id = generate_random_employeeid();
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
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'class' => 'add_employee_form', 'autocomplete' => 'off');?>
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
									<select
                                        class="form-control"
                                        name="applied_for"
                                        data-plugin="select_hrm">
                                        <option value="">
                                            <?= lang('Employees.xin_select');?>
                                        </option>
										<?php foreach($designations as $job){  ?>
                                        <option value="<?= $job['designation_id']; ?>">
                                            <?= $job['designation_name']; ?>
                                        </option>
										<?php }  ?>
                                    </select>
									<div class="error-applied_for"></div> 
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
									<div class="error-file"></div>
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
									<div class="error-first_name"></div>
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
									<div class="error-last_name"></div>
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
									<div class="error-email"></div>
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
									<div class="error-contact_number"></div>
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
									<div class="error-dob"></div>
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
									<div class="error-gender"></div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number">
                                        <?= lang('Main.xin_marital_status');?>
                                        <span class="text-danger">*</span></label>
                                    <select class="form-control" name="marital_status" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_employee_mstatus');?>">
										<option value="0">
										<?= lang('Employees.xin_status_single');?>
										</option>
										<option value="1" >
										<?= lang('Employees.xin_status_married');?>
										</option>
										<option value="2">
										<?= lang('Employees.xin_status_widowed');?>
										</option>
										<option value="3">
										<?= lang('Employees.xin_status_divorced_separated');?>
										</option>
									</select>
									<div class="error-marital_status"></div>
                                </div>
                            </div>
							<div class="col-md-4">
							<div class="form-group">
							  <label for="estate">
								<?= lang('Main.xin_state');?>
							  </label>
							  <input class="form-control" placeholder="<?= lang('Main.xin_state');?>" name="state" type="text" value="">
							  <div class="error-state"></div>
							</div>
						  </div>
						  <div class="col-md-4">
							<div class="form-group">
							  <label for="ecity">
								<?= lang('Main.xin_city');?>
							  </label>
							  <input class="form-control" placeholder="<?= lang('Main.xin_city');?>" name="city" type="text" value="">
							  <div class="error-city"></div>
							</div>
						  </div>
						  <div class="col-md-4">
							<div class="form-group">
							  <label for="ezipcode" class="control-label">
								<?= lang('Main.xin_zipcode');?>
							  </label>
							  <input class="form-control" placeholder="<?= lang('Main.xin_zipcode');?>" name="zipcode" type="text" value="">
							  <div class="error-zipcode"></div>
							</div>
						  </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number">
                                        <?= lang('Main.xin_religion');?>
                                        <span class="text-danger">*</span>
									</label>
                                    <div class="input-group">
                            
										<select class="form-control" name="religion" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_ethnicity_type_title');?>">
										<option value=""></option>
										<?php foreach($religion as $ireligion) {?>
										<option value="<?= $ireligion['constants_id']?>">
										<?= $ireligion['category_name']?>
										</option>
										<?php } ?>
									  </select>
										<div class="error-religion"></div>	
                                    </div>
                                </div>
                            </div>
							<div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_number">
                                        <?= lang('Main.xin_nationality');?>
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
									    <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_nationality');?>">
											<option value="">
											<?= lang('Main.xin_select_one');?>
											</option>
											<?php foreach($all_countries as $country) {?>
											<option value="<?= $country['country_id'];?>">
											<?= $country['country_name'];?>
											</option>
											<?php } ?>
										</select>
										<div class="error-country"></div>
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
										<div class="error-experience_1"></div>
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
										<div class="error-high_school"></div>
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
											<div class="error-degree"></div>
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
												class="custom-file-input"
												name="resume"
												type="file">
											<label class="custom-file-label">
												<?= lang('Main.xin_choose_file');?>
											</label>
											<small>
												<?= lang('Main.xin_company_file_type');?>
											</small>
											<div class="error-resume"></div>
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
												class="custom-file-input"
												name="passport"
												type="file">
											<label class="custom-file-label">
												<?= lang('Main.xin_choose_file');?>
											</label>
											<small>
												<?= lang('Main.xin_company_file_type');?>
											</small>
											<div class="error-passport"></div>
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
													class="custom-file-input"
													name="education_certificate"
													type="file">
												<label class="custom-file-label">
													<?= lang('Main.xin_choose_file');?>
												</label>
												<small>
													<?= lang('Main.xin_company_file_type');?>
												</small>
												<div class="error-education_certificate"></div>
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
													class="custom-file-input"
													name="experience_certificate"
													type="file">
											<label class="custom-file-label">
												<?= lang('Main.xin_choose_file');?>
											</label>
											<small>
												<?= lang('Main.xin_company_file_type');?>
											</small>
											<div class="error-experience_certificate"></div>
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
												class="custom-file-input"
												name="police_clearance_certificate"
												type="file">
											<label class="custom-file-label">
												<?= lang('Main.xin_choose_file');?>
											</label>
											<small>
												<?= lang('Main.xin_company_file_type');?>
											</small>
											<div class="error-police_clearance_certificate"></div>
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
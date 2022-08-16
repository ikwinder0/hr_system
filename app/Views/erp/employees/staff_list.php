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
                                
                                href="#"
                               
                                class="btn waves-effect waves-light btn-primary btn-sm m-0" data-toggle="modal" data-target="#exampleModal">
                                <i data-feather="plus"></i>
                                Import Candidates
                            </a>
                            <a
                                
                                href="<?= site_url().'erp/create-employee'; ?>"
                               
                                class="btn waves-effect waves-light btn-primary btn-sm m-0">
                                <i data-feather="plus"></i>
                                <?= lang('Main.xin_add_new');?>
                            </a>
                            <?php } ?>
                        </div>
                    </div>

					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Import Candidate</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button> 
						  </div>
						  <form>
						  <div class="modal-body">
							<div class="form-group">
								<label>Select Excel file</label>
								<input type="file" name="import_file" class="form-control" required>
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Import</button>
						  </div>
						  </form>
						</div>
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
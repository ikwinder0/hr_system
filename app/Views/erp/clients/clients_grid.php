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
	$get_clients = $UsersModel->where('company_id',$user_info['company_id'])->where('user_type','customer')->orderBy('user_id', 'ASC')->paginate(9);
	$pager = $UsersModel->pager;
} else {
	$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$usession['sup_user_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$get_clients = $UsersModel->where('company_id',$usession['sup_user_id'])->where('user_type','customer')->orderBy('user_id', 'ASC')->paginate(9);
	$pager = $UsersModel->pager;
}
		
$roles = $RolesModel->orderBy('role_id', 'ASC')->findAll();
$xin_system = $SystemModel->where('setting_id', 1)->first();

$employee_id = generate_random_employeeid();
?>
<?php if(in_array('client2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="accordion">
  <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
    <?php $attributes = array('name' => 'add_client', 'id' => 'xin-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('user_id' => 0);?>
    <?= form_open_multipart('erp/clients/add_client', $attributes, $hidden);?>
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Dashboard.dashboard_employee');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="company_name">
                    <?= lang('Main.xin_employee_first_name');?>
                    <span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Main.xin_employee_first_name');?>" name="first_name" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="last_name" class="control-label">
                    <?= lang('Main.xin_employee_last_name');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Main.xin_employee_last_name');?>" name="last_name" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="website">
                    <?= lang('Main.xin_employee_password');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye-slash"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Main.xin_employee_password');?>" name="password" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contact_number">
                    <?= lang('Main.xin_contact_number');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="number">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="gender" class="control-label">
                    <?= lang('Main.xin_employee_gender');?>
                  </label>
                  <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_gender');?>">
                    <option value="1">
                    <?= lang('Main.xin_gender_male');?>
                    </option>
                    <option value="2">
                    <?= lang('Main.xin_gender_female');?>
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">
                    <?= lang('Main.xin_email');?>
                    <span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">
                    <?= lang('Main.dashboard_username');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Main.dashboard_username');?>" name="username" type="text">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false">
            <?= lang('Main.xin_reset');?>
            </button>
            &nbsp;
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_e_details_profile_picture');?>
            </h5>
          </div>
          <div class="card-body py-2">
            <div class="row">
              <div class="col-md-12">
                <label for="logo">
                  <?= lang('Main.xin_e_details_profile_picture');?>
                  <span class="text-danger">*</span> </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="file">
                  <label class="custom-file-label">
                    <?= lang('Main.xin_choose_file');?>
                  </label>
                  <small>
                  <?= lang('Main.xin_company_file_type');?>
                  </small> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?= form_close(); ?>
  </div>
</div>
<?php } ?>
<div class="row justify-content-center"> 
  <!-- client-section start -->
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body text-center">
        <div class="row align-items-center m-l-0">
          <div class="col-sm-6 text-left">
            <h5>
              <?= lang('Projects.xin_clients_management');?>
            </h5>
          </div>
          <div class="col-sm-6 text-right"> <span class="m-r-15">
            <?= lang('Projects.xin_view_mode');?>
            :</span> <a href="<?= site_url().'erp/clients-list';?>" class="btn btn-sm waves-effect waves-light btn-primary btn-icon m-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Projects.xin_list_view');?>"> <i class="fas fa-list-ul"></i> </a> <a href="<?= site_url().'erp/clients-grid';?>" class="btn btn-sm waves-effect waves-light btn-primary btn-icon m-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Projects.xin_grid_view');?>"> <i class="fas fa-th-large"></i> </a> 
            <?php if(in_array('client2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
            <a data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
            <?= lang('Main.xin_add_new');?>
            </a>
            <?php }?>
            </div>
        </div>
      </div>
    </div>
  </div>
  <?php foreach($get_clients as $r) { ?>
  <?php
	if($r['is_active'] == 1){
		$status = '<span class="badge badge-success">'.lang('Main.xin_employees_active').'</span>';
	} else {
		$status = '<span class="badge badge-danger">'.lang('Main.xin_employees_inactive').'</span>';
	}
	?>
  <div class="col-lg-4 col-md-6">
    <div class="card user-card user-card-1 mt-4">
      <div class="card-body pt-0">
        <div class="user-about-block text-center">
          <div class="row align-items-end">
            <div class="col text-left pb-3">
              <?= $status;?>
            </div>
            <div class="col"><img class="img-radius img-fluid wid-80" src="<?= base_url().'/public/uploads/clients/thumb/'.$r['profile_photo'];?>" alt="<?= $r['first_name'].' '.$r['last_name'];?>"></div>
            <div class="col text-right pb-3">
              <?php if(in_array('client3',staff_role_resource()) || in_array('client4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
              <div class="dropdown"> <a class="drp-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-horizontal"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                <?php if(in_array('client3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                	<a class="dropdown-item" href="<?= site_url('erp/view-client-info').'/'.uencode($r['user_id']);?>"><i class="feather icon-eye"></i>
                  <?= lang('Main.xin_view');?>
                  </a> 
                  <?php } ?>
                  <?php if(in_array('client4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                  <a href="#!" class="dropdown-item delete" data-toggle="modal" data-target=".delete-modal" data-record-id="<?= uencode($r['user_id']);?>"><i class="feather icon-trash-2"></i>
                  <?= lang('Main.xin_delete');?>
                  </a>
                  <?php } ?>
                  </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="text-center"> <a href="#!" data-toggle="modal" data-target="#modal-report">
          <h4 class="mb-1 mt-3">
            <?= $r['first_name'].' '.$r['last_name'];?>
          </h4>
          </a>
          <p class="mb-3 text-muted">@<?= $r['username'];?>
          </p>
          <p class="mb-1"><b>
            <?= lang('Main.xin_email');?>
            : </b><a href="mailto:<?= $r['email'];?>">
            <?= $r['email'];?>
            </a></p>
          <p class="mb-0"><b>
            <?= lang('Dashboard.dashboard_contact');?>
            : </b>
            <?= $r['contact_number'];?>
          </p>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <!-- client-section end --> 
</div>
<hr>
<div class="p-2">
  <?= $pager->links() ?>
</div>

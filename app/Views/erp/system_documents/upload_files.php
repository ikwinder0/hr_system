<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\DepartmentModel;
use App\Models\StaffdetailsModel;

$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$DepartmentModel = new DepartmentModel();
$StaffdetailsModel = new StaffdetailsModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	
	$employee_detail = $StaffdetailsModel->where('user_id', $user_info['user_id'])->first();
	$val = $employee_detail['department_id'];
    $main_department = $DepartmentModel->where('company_id', $user_info['company_id'])->where('department_id', $employee_detail['department_id'])->findAll();
	$tab_active = 'active';
} else {
	$val = 0;
	$main_department = $DepartmentModel->where('company_id', $usession['sup_user_id'])->findAll();
	$tab_active = '';
}
?>

<?php if(in_array('file1',staff_role_resource()) || in_array('officialfile1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('file1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/upload-files');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file-invoice"></span>
      <?= lang('Employees.xin_general_documents');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.xin_files');?>
      </div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('officialfile1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/official-documents');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file-code"></span>
      <?= lang('Employees.xin_official_documents');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Employees.xin_official_documents');?>
      </div>
      </a> </li>
   <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<input type="hidden" id="depval" value="<?= $val;?>" />
<div class="row">
  <div class="col-lg-4">
    <div class="card user-card user-card-1">
      <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical">
        <?php if($user_info['user_type'] != 'staff'){?>
        <a class="department-file nav-link list-group-item list-group-item-action active" id="user-set-profile-tab" data-toggle="pill" href="#user-set-profile" role="tab" aria-controls="user-set-profile" aria-selected="true"  data-department-id="0"> <span class="f-w-500">
        <?= lang('Dashboard.left_departments');?>
        </span> </a>
        <?php } else {?>
        <a class="disabled nav-link list-group-item list-group-item-action" id="user-set-profile-tab" data-toggle="pill" href="#user-set-profile" role="tab" aria-controls="user-set-profile" aria-selected="true"> <span class="f-w-500">
        <?= lang('Dashboard.left_departments');?>
        </span> </a>
        <?php } ?>
        <?php foreach($main_department as $department):?>
        <a class="department-file nav-link list-group-item list-group-item-action <?= $tab_active;?>" id="user-set-information-tab" data-toggle="pill" href="#user-set-information" role="tab" aria-controls="user-set-information" aria-selected="false" data-department-id="<?= $department['department_id'];?>"> <span class="f-w-500">
        <?= $department['department_name'];?>
        </span> </a>
        <?php endforeach;?>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
   <?php if(in_array('file2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div id="accordion">
        <div class="card">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Employees.xin_document');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <?php $attributes = array('name' => 'system_document', 'id' => 'system_document', 'autocomplete' => 'off');?>
          <?php $hidden = array('token' => 000);?>
          <?= form_open_multipart('erp/documents/add_document', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="department_id"><?php echo lang('Dashboard.left_department');?> <span class="text-danger">*</span></label>
                  <select name="department_id" id="department_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.left_department');?>">
                    <option value=""><?php echo lang('Dashboard.left_department');?></option>
                    <?php foreach($main_department as $_department) {?>
                    <option value="<?php echo $_department['department_id'];?>"> <?php echo $_department['department_name'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="date_of_expiry" class="control-label">
                    <?= lang('Employees.xin_document_name');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_document_name');?>" name="document_name" type="text">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="title" class="control-label">
                    <?= lang('Employees.xin_document_type');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_document_eg_payslip_etc');?>" name="document_type" type="text">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="logo">
                    <?= lang('Employees.xin_document_file');?>
                    <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="document_file">
                    <label class="custom-file-label">
                      <?= lang('Main.xin_choose_file');?>
                    </label>
                    <small>
                    <?= lang('Employees.xin_e_details_d_type_file');?>
                    </small> </div>
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
          <?= form_close(); ?>
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="row">
      <div class="col-md-12">
        <div class="card user-profile-list">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_list_all');?>
              <?= lang('Dashboard.xin_files');?>
            </h5>
            <?php if(in_array('file2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
              <?= lang('Main.xin_add_new');?>
              </a> </div>
            <?php } ?>
          </div>
          <div class="card-body">
            <div class="card-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered" id="xin_table_document">
                <thead>
                  <tr>
                    <th><?= lang('Dashboard.left_department');?></th>
                    <th><?= lang('Employees.xin_document_name');?></th>
                    <th><?= lang('Employees.xin_document_type');?></th>
                    <th><?= lang('Employees.xin_document_file');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

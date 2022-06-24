<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>
<?php if(in_array('file1',staff_role_resource()) || in_array('officialfile1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('file1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/upload-files');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file-invoice"></span>
      <?= lang('Employees.xin_general_documents');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.xin_files');?>
      </div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('officialfile1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/official-documents');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file-code"></span>
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
<?php if(in_array('officialfile2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div class="row m-b-1 animated fadeInRight">
<div class="col-md-12">
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
<?php $attributes = array('name' => 'add_official_document', 'id' => 'add_official_document', 'autocomplete' => 'off');?>
<?php $hidden = array('user_id' => uencode($usession['sup_user_id']));?>
<?php echo form_open_multipart('erp/documents/add_official_document', $attributes, $hidden);?>
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div id="accordion">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Employees.xin_document');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <div class="card-body">
            <div class="row">
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="license_name"><?= lang('Employees.xin_license_name');?> <span class="text-danger">*</span></label>
                <input class="form-control" placeholder="<?= lang('Employees.xin_license_name');?>" name="license_name" type="text">
              </div>
            </div> 
            <div class="col-md-6">
                <div class="form-group">
                  <label for="title" class="control-label">
                    <?= lang('Employees.xin_document_type');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Employees.xin_document_eg_payslip_etc');?>" name="document_type" type="text">
                </div>
              </div> 
            <div class="col-md-6">
                <div class="form-group">
                  <label for="expiry_date"><?= lang('Employees.xin_document_doe');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                  <input class="form-control date" placeholder="<?= lang('Employees.xin_document_doe');?>" name="expiry_date" type="text">
                  <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                </div>
                </div>
              </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="license_number"><?= lang('Employees.xin_license_number');?> <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?= lang('Employees.xin_license_number');?>" name="license_number" type="text">
                  </div>
                </div>
              </div>
          </div>
          <div class="card-footer text-right">
            <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false"><?= lang('Main.xin_reset');?></button>
            &nbsp;
            <button type="submit" class="btn btn-primary"><?= lang('Main.xin_save');?></button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h5> <?= lang('Employees.xin_document_file');?>
          </h5>
        </div>
        <div class="card-body py-2">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="logo">
                  <?= lang('Main.xin_attachment');?>
                  <span class="text-danger">*</span> </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="document_file">
                  <label class="custom-file-label"><?= lang('Main.xin_choose_file');?></label>
                  <small>
                  <?= lang('Main.xin_company_file_type');?>
                  </small> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?= form_close(); ?>
</div>
</div>
</div>
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Employees.xin_official_documents');?>
    </h5>
    <?php if(in_array('officialfile2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
      <?= lang('Main.xin_add_new');?>
      </a> </div>
    <?php } ?>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table_document">
        <thead>
          <tr>
            <th><?= lang('Employees.xin_document_type');?></th>
            <th><?= lang('Employees.xin_license_name');?></th>
            <th><?= lang('Employees.xin_license_number');?></th>
            <th><i class="fa fa-calendar"></i> <?= lang('Employees.xin_document_doe');?></th>
            <th><i class="fa fa-file"></i> <?= lang('Employees.xin_document_file');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
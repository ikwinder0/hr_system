<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$CountryModel = new CountryModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$get_animate = '';
?>
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <div class="card mb-2">
    <div id="accordion">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_add_new');?>
          <?= lang('Main.xin_custom_field');?>
        </h5>
        <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
          <?= lang('Main.xin_hide');?>
          </a> </div>
      </div>
      <?php $attributes = array('name' => 'add_customfield', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 1);?>
      <?php echo form_open('erp/customfields/add_customfield', $attributes, $hidden);?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="country">
                <?= lang('Main.xin_module');?>
                <span class="text-danger">*</span> </label>
              <select class="form-control" name="module" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_module');?>">
                <option value="">
                <?= lang('Main.xin_select_one');?>
                </option>
                <option value="1"><?= lang('Dashboard.left_awards');?></option>
                <option value="2"><?= lang('Dashboard.xin_assets');?></option>
                <option value="3"><?= lang('Dashboard.dashboard_helpdesk');?></option>
                <option value="4"><?= lang('Dashboard.left_training');?></option>
                <option value="5"><?= lang('Main.xin_employee_contract');?></option>
                <option value="6"><?= lang('Dashboard.left_announcement_make');?></option>
                <option value="7"><?= lang('Main.xin_inventory_products');?></option>
                <option value="8"><?= lang('Main.xin_employee_bsic_info');?></option>
                <option value="9"><?= lang('Main.xin_employee_personal_info_bio');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="name">
                <?= lang('Dashboard.xin_name');?>
                <span class="text-danger">*</span> </label>
              <input class="form-control" placeholder="<?= lang('Dashboard.xin_name');?>" name="name" type="text" value="">
              <small class="text-primary">Put small letters only, use underscore instead of space. e.g <strong>first_name, employee_info</strong> </small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="field_label">
                <?= lang('Main.xin_field_label');?> <span class="text-danger">*</span>
              </label>
              <input class="form-control" placeholder="<?= lang('Main.xin_field_label');?>" name="field_label" type="text" value="">
              <small class="text-primary">for example <strong>First Name, Employee Info</strong> </small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="priority">
                <?= lang('Projects.xin_p_priority');?> <span class="text-danger">*</span>
              </label>
              <input class="form-control" placeholder="<?= lang('Projects.xin_p_priority');?>" name="priority" type="text" value="">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="validation">
                <?= lang('Main.xin_validation');?>
                <span class="text-danger">*</span> </label>
              <select class="form-control" name="validation" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_validation');?>">
                <option value="0">None</option>
                <option value="1">Required</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="field_type">
                <?= lang('Main.xin_column_width');?>
                <span class="text-danger">*</span> </label>
              <select class="form-control" name="column" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_column_width');?>">
                <option value="col-md-2">Col-md-2</option>
                <option value="col-md-3">Col-md-3</option>
                <option value="col-md-4" selected="selected">Col-md-4</option>
                <option value="col-md-5">Col-md-5</option>
                <option value="col-md-6">Col-md-6</option>
                <option value="col-md-7">Col-md-7</option>
                <option value="col-md-8">Col-md-8</option>
                <option value="col-md-9">Col-md-9</option>
                <option value="col-md-10">Col-md-10</option>
                <option value="col-md-12">Col-md-12</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="field_type">
                <?= lang('Main.xin_field_type');?>
                <span class="text-danger">*</span> </label>
              <select class="form-control" name="field_type" id="field_type" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_field_type');?>">
                <option value="">
                <?= lang('Main.xin_select_one');?>
                </option>
                <option value="text">Text Field</option>
                <option value="textarea">Text Area</option>
                <option value="select">Select</option>
                <option value="date">Date</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">      
              <div class="form-group" id="add_items" style="display:none;">
                    <label for="more_items">&nbsp;</label><br />
                    <button type="button" class="btn btn-sm btn-primary add" onclick="new_link();"><?= lang('Main.xin_add_labels');?></button>
                  </div>
            </div>
        </div>
        <div class="row" id="newlinktpl" style="display:none">
          <div class="col-md-4"> 
              <div class="form-group">
                <label for="field_label"><?= lang('Main.xin_label');?></label>
                <input class="form-control" placeholder="<?= lang('Main.xin_label');?>" name="select_value[]" type="text">
              </div>
          </div>
        </div>
        <div class="row" id="newlink" style="display:block"></div>
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
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Main.xin_custom_fields');?>
    </h5>
    <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
      <?= lang('Main.xin_add_new');?>
      </a> </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th width="200"><?= lang('Main.xin_module');?></th>
            <th><?= lang('Dashboard.xin_name');?></th>
            <th><?= lang('Main.xin_field_label');?></th>
            <th><?= lang('Main.xin_field_type');?></th>
            <th><?= lang('Main.xin_column_width');?></th>
            <th><?= lang('Main.xin_validation');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

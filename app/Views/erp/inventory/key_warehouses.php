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
<?php if(in_array('warehouse2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>

<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <div class="card mb-2">
    <div id="accordion">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_add_new');?>
          <?= lang('Inventory.xin_warehouse');?>
        </h5>
        <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
          <?= lang('Main.xin_hide');?>
          </a> </div>
      </div>
      <?php $attributes = array('name' => 'add_warehouse', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 1);?>
      <?php echo form_open('erp/warehouse/add_warehouse', $attributes, $hidden);?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="start_date">
                <?= lang('Inventory.xin_warehouse_name');?>
                <span class="text-danger">*</span> </label>
              <input class="form-control" placeholder="<?= lang('Inventory.xin_warehouse_name');?>" name="name" type="text" value="">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="contact_number">
                <?= lang('Main.xin_contact_number');?>
                <span class="text-danger">*</span></label>
              <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text" value="">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="country">
                <?= lang('Inventory.xin_use_for_pickup');?>
                <span class="text-danger">*</span> </label>
              <select class="form-control" name="pickup_location" data-plugin="select_hrm" data-placeholder="<?= lang('Inventory.xin_use_for_pickup');?>">
                <option value="1">
                <?= lang('Main.xin_yes');?>
                </option>
                <option value="0">
                <?= lang('Main.xin_no');?>
                </option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="country">
                <?= lang('Main.xin_country');?>
                <span class="text-danger">*</span> </label>
              <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_country');?>">
                <option value="">
                <?= lang('Main.xin_select_one');?>
                </option>
                <?php foreach($all_countries as $country) {?>
                <option value="<?= $country['country_id'];?>">
                <?= $country['country_name'];?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="address_1">
                <?= lang('Main.xin_address');?>
              </label>
              <input class="form-control" placeholder="<?= lang('Main.xin_address');?>" name="address_1" type="text" value="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="address_2"> &nbsp;</label>
              <input class="form-control" placeholder="<?= lang('Main.xin_address_2');?>" name="address_2" type="text" value="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="city">
                <?= lang('Main.xin_city');?>
              </label>
              <input class="form-control" placeholder="<?= lang('Main.xin_city');?>" name="city" type="text" value="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="state">
                <?= lang('Main.xin_state');?>
              </label>
              <input class="form-control" placeholder="<?= lang('Main.xin_state');?>" name="state" type="text" value="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="zipcode">
                <?= lang('Main.xin_zipcode');?>
              </label>
              <input class="form-control" placeholder="<?= lang('Main.xin_zipcode');?>" name="zipcode" type="text" value="">
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
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Inventory.xin_warehouses');?>
    </h5>
    <?php if(in_array('warehouse2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
      <?= lang('Main.xin_add_new');?>
      </a> </div>
    <?php } ?>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th width="250"><?= lang('Inventory.xin_warehouse_name');?></th>
            <th><?= lang('Main.xin_contact_number');?></th>
            <th><?= lang('Main.xin_city');?></th>
            <th><?= lang('Main.xin_country');?></th>
            <th><?= lang('Main.xin_added_by');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

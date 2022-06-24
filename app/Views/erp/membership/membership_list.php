
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <div class="card mb-2">
    <div class="card-header">
      <h5>
        <?= lang('Main.xin_add_new');?>
        <?= lang('Membership.xin_plan');?>
      </h5>
      <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
        <?= lang('Main.xin_hide');?>
        </a> </div>
    </div>
    <div id="accordion">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_membership', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
        <?php $hidden = array('user_id' => 0);?>
        <?php echo form_open('erp/membership/add_membership', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="membership_type">
                      <?= lang('Membership.xin_membership_type');?>
                      <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?= lang('Membership.xin_membership_type');?>" name="membership_type" type="text" value="">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="price_monthly">
                      <?= lang('Main.xin_price');?>
                      <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?= lang('Main.xin_price');?>" name="price" type="text" value="">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="price_yearly" class="control-label">
                      <?= lang('Membership.xin_plan_duration');?>
                      <span class="text-danger">*</span></label>
                    <select class="form-control custom-select" data-plugin="select_hrm" name="plan_duration"  data-placeholder="<?= lang('Membership.xin_plan_duration');?>">
                      <option value="">&nbsp;</option>
                      <option value="1">
                      <?= lang('Membership.xin_per_month');?>
                      </option>
                      <option value="2">
                      <?= lang('Membership.xin_per_year');?>
                      </option>
                      <option value="3">
                      <?= lang('Membership.xin_subscription_unlimit');?>
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="price_monthly">
                      <?= lang('Employees.xin_total_employees');?>
                      <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?= lang('Employees.xin_total_employees');?>" name="total_employees" type="text" value="">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="description">
                  <?= lang('Main.xin_description');?>
                </label>
                <textarea class="form-control" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="1"></textarea>
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
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Membership.xin_membership_plans');?>
    </h5>
    <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
      <?= lang('Membership.xin_new_subscription');?>
      </a> </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?= lang('Membership.xin_membership_type');?></th>
            <th><?= lang('Membership.xin_subscription_id');?></th>
            <th><?= lang('Membership.xin_plan_duration');?></th>
            <th><?= lang('Main.xin_price');?></th>
            <th><?= lang('Employees.xin_total_employees');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

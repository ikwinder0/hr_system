<?php
use App\Models\UsersModel;
use App\Models\MembershipModel;
use App\Models\SuperroleModel;
use App\Models\SystemModel;

$MembershipModel = new MembershipModel();
$SuperroleModel = new SuperroleModel();
$MembershipModel = new MembershipModel();

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$request = \Config\Services::request();

$xin_system = $SystemModel->where('setting_id', 1)->first();
$field_id = $request->uri->getSegment(3);
$membership_id = udecode($field_id);
$result = $MembershipModel->where('membership_id', $membership_id)->first();
?>

<div class="media align-items-center py-3 mb-3">
  <div class="display-1 text-primary"><i class="lnr lnr-briefcase text-big"></i></div>
  <div class="media-body ml-0">
    <h4 class="font-weight-bold mb-2 text-primary">
      <?= $result['membership_type'];?>
    </h4>
    <div class="text-muted mb-0">
      <?= lang('Membership.xin_subscription_id');?>
      :
      <?= $result['subscription_id']?>
    </div>
    <div class="text-muted mb-0">
      <?= lang('Membership.xin_you_can_view_and_update');?>
      <span class="text-primary"><i class="fas fa-info-circle"></i></span>
      <?= lang('Main.xin_created_at');?>
      :
      <?= $result['created_at'];?>
    </div>
  </div>
</div>
<h3 class="mt-0">
  <?= lang('Membership.xin_update_subscription');?>
</h3>
<div class="row">
  <div class="col-md-12">
    <div class="card mt-4">
      <div class="card-header">
        <h5>
          <?= lang('Membership.xin_update_subscription');?>
        </h5>
      </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'update_membership', 'id' => 'edit_membership', 'autocomplete' => 'off', 'class' => 'form');?>
        <?php $hidden = array('user_id' => 0, 'token' => $field_id);?>
        <?php echo form_open('erp/membership/update_membership', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="membership_type">
                      <?= lang('Membership.xin_membership_type');?>
                      <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?= lang('Membership.xin_membership_type');?>" name="membership_type" type="text" value="<?= $result['membership_type'];?>">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="price_monthly">
                      <?= lang('Main.xin_price');?>
                      <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?= lang('Main.xin_price');?>" name="price" type="text" value="<?= $result['price'];?>">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="price_yearly" class="control-label">
                      <?= lang('Employees.xin_total_employees');?>
                      <span class="text-danger">*</span></label>
                    <input class="form-control" placeholder="<?= lang('Employees.xin_total_employees');?>" name="total_employees" type="text" value="<?= $result['total_employees'];?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="role_name">
                  <?= lang('Membership.xin_plan_duration');?>
                  <span class="text-danger">*</span></label>
                <select class="form-control custom-select" data-plugin="select_hrm" name="plan_duration"  data-placeholder="<?= lang('Membership.xin_plan_duration');?>">
                  <option value="">&nbsp;</option>
                  <option value="1" <?php if($result['plan_duration']==1):?> selected="selected"<?php endif;?>>
                  <?= lang('Membership.xin_per_month');?>
                  </option>
                  <option value="2" <?php if($result['plan_duration']==2):?> selected="selected"<?php endif;?>>
                  <?= lang('Membership.xin_per_year');?>
                  </option>
                  <option value="3" <?php if($result['plan_duration']==3):?> selected="selected"<?php endif;?>>
                  <?= lang('Membership.xin_subscription_unlimit');?>
                  </option>
                </select>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="description">
                  <?= lang('Main.xin_description');?>
                </label>
                <textarea class="form-control" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="1"><?= $result['description'];?>
</textarea>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary">
          <?= lang('Membership.xin_update_subscription');?>
          </button>
        </div>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>

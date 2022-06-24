<?php
use App\Models\MembershipModel;
use App\Models\CompanymembershipModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$CompanymembershipModel = new CompanymembershipModel();

$request = \Config\Services::request();
$session = \Config\Services::session();
$usession = $session->get('sup_username');

if($request->getGet('type') === 'view_membership' && $request->getGet('field_id')){
$MembershipModel = new MembershipModel();
$membership_id = udecode($field_id);
$result = $MembershipModel->where('membership_id', $membership_id)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff' || $user_info['user_type'] == 'company'){
	$xin_system = erp_company_settings();
	$converted = currency_converter($result['price']);
} else {
	$xin_system = $SystemModel->where('setting_id', 1)->first();
	$converted = $result['price'];
}
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Membership.xin_view_membership');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info_specific');?>
    (
    <?= $result['membership_type'];?>
    ) </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<form class="m-b-1">
<div class="modal-body">
  <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th width="180"><?= lang('Membership.xin_membership_type');?></th>
          <td colspan="3" style="display: table-cell;"><?= $result['membership_type'];?></td>
        </tr>
        <tr>
          <th><?= lang('Main.xin_price');?></th>
          <td style="display: table-cell;"><?= number_to_currency($converted, $xin_system['default_currency'],null,2);?></td>
        </tr>
        <tr>
          <th><?= lang('Employees.xin_total_employees');?></th>
          <td style="display: table-cell;"><?= $result['total_employees'];?></td>
        </tr>
        <tr>
          <th><?= lang('Membership.xin_plan_duration');?></th>
          <td style="display: table-cell;"><?php if($result['plan_duration']==1):?>
            <?= lang('Membership.xin_per_month');?>
            <?php endif;?>
            <?php if($result['plan_duration']==2):?>
            <?= lang('Membership.xin_per_month');?>
            <?php endif;?>
            <?php if($result['plan_duration']==3):?>
            <?= lang('Membership.xin_subscription_unlimit');?>
            <?php endif;?></td>
        </tr>
        <tr>
          <th><?= lang('Main.xin_description');?></th>
          <td colspan="2" style="display: table-cell;"><?= html_entity_decode($result['description']);?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
</div>
<?= form_close(); ?>
<?php }
?>

<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();
$i=1;
?>
<?php if(in_array('invoice2',staff_role_resource()) || in_array('invoice_payments',staff_role_resource()) || in_array('invoice_calendar',staff_role_resource()) || in_array('tax_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('invoice2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/estimates-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_estimates');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.xin_estimates');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('estimates_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/estimates-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calendar-plus"></span>
      <?= lang('Dashboard.xin_quote_calendar');?>
      <div class="text-muted small">
        <?= lang('Dashboard.xin_quote_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-xl-2 col-md-12">
        <div id="external-events" class="external-events">
          <h4><?= lang('Dashboard.xin_hr_events');?></h4>
          <div class="fc-event" style="background-color:#f4c22b;border-color:#f4c22b;color:#fff"><?= lang('Main.xin_estimated');?></div>
          <div class="fc-event" style="background-color:#1de9b6;border-color:#1de9b6;color:#fff"><?= lang('Main.xin_invoiced');?></div>
          <div class="fc-event" style="background-color:#f9cdcd;border-color:#f9cdcd;color:#fff"><?= lang('Main.xin_cancelled');?></div>
        </div>
      </div>
      <div class="col-xl-10 col-md-12">
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>

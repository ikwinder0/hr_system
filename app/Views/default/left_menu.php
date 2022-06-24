<?php
use App\Models\SystemModel;
use App\Models\SuperroleModel;
use App\Models\UsersModel;
use App\Models\MembershipModel;
use App\Models\CompanymembershipModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$SuperroleModel = new SuperroleModel();
$MembershipModel = new MembershipModel();
$CompanymembershipModel = new CompanymembershipModel();
$session = \Config\Services::session();
$router = service('router');
$usession = $session->get('sup_username');
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$xin_system = $SystemModel->where('setting_id', 1)->first();
?>
<?php $arr_mod = select_module_class($router->controllerName(),$router->methodName()); ?>
<?php if($user_info['user_type'] == 'super_user'){ ?>
	<?php // super users menu?>
    <?= view('default/super_users_left_menu');?>
<?php } ?>
<?php if($user_info['user_type'] == 'company'){ ?>
	<?php // main company menu?>
    <?= view('default/company_left_menu');?>
<?php } ?>
<?php if($user_info['user_type'] == 'staff'){?>
	<?php // staff menu?>
    <?= view('default/staff_left_menu');?>
<?php } ?>
<?php if($user_info['user_type'] == 'customer'){?>
	<?php // client menu?>
    <?= view('default/client_left_menu');?>
<?php } ?>

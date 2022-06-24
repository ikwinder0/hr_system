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
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();
?>
<?php

if($user['user_type'] == 'customer'){
	$inf = 'customer';
} elseif($user['user_type'] == 'supplier'){
	$inf = 'supplier';
} elseif($user['user_type'] == 'super_user'){
	$inf = 'super_user';
} elseif($user['user_type'] == 'staff'){
	$inf = 'staff';
} elseif($user['user_type'] == 'company'){
	$inf = 'company';
} else {
	$inf = 'clients';
}
?>
dashboard...<br />
<?= $inf;?>
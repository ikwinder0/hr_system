<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
die;
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
<?php if($session->get('unauthorized_module')){?>
<div class="alert alert-danger alert-dismissible fade show">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <?= $session->get('unauthorized_module');?>
</div>
<?php } ?>
<?php
$first_date = strtotime("2021-03-11 21:00:00");
$second_date = strtotime("2021-03-11 09:00:00");
//$second_date = strtotime("2021-03-12 05:00:00");
//echo round(abs($first_date - $second_date) / 60,2) / 60 ." hours"; 
if($user['user_type'] == 'super_user'){
    $inf = 'super_user';
	echo view('erp/dashboard/super_admin_dashboard');
} elseif($user['user_type'] == 'customer'){
	$inf = 'customer';
	echo view('erp/dashboard/clients_dashboard');
} elseif($user['user_type'] == 'staff'){
	$inf = 'staff_dashboard';
	echo view('erp/dashboard/staff_dashboard');
} elseif($user['user_type'] == 'company'){
	$inf = 'company';
	echo view('erp/dashboard/company_dashboard');
} else {
	$inf = 'staff_dashboard';
	echo view('erp/dashboard/staff_dashboard');
}
?>
<? //= $inf;?>
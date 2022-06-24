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
	echo view('erp/profile/client_profile');
} elseif($user['user_type'] == 'super_user'){
	echo view('erp/profile/super_admin_profile');
} elseif($user['user_type'] == 'staff'){
	echo view('erp/profile/staff_profile');
} elseif($user['user_type'] == 'company'){
	echo view('erp/profile/company_profile');
} else {
	echo view('erp/profile/client_profile');;
}
?>
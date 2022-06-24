<?php
use App\Models\SystemModel;
use App\Models\CompanysettingsModel;
$SystemModel = new SystemModel();
$CompanysettingsModel = new CompanysettingsModel();
$xin_system = $SystemModel->where('setting_id', 1)->first();
$xin_com_system = $CompanysettingsModel->where('setting_id', 1)->first();
$favicon = base_url().'/public/uploads/logo/favicon/'.$xin_system['favicon'];
$session = \Config\Services::session();
$request = \Config\Services::request();
$username = $session->get('sup_username');
?>
<?= doctype();?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>
<?= $title; ?>
</title>
<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
<!-- Meta -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="" />
<meta name="keywords" content="">
<meta name="author" content="erp" />

<!-- Favicon icon -->
<link rel="icon" type="image/x-icon" href="<?= $favicon;?>">

<!-- font css -->
<link rel="stylesheet" href="<?= base_url('public/assets/fonts/font-awsome-pro/css/pro.min.css');?>">
<link rel="stylesheet" href="<?= base_url('public/assets/fonts/feather.css');?>">
<link rel="stylesheet" href="<?= base_url('public/assets/fonts/fontawesome.css');?>">

<!-- vendor css -->
<link rel="stylesheet" href="<?= base_url('public/assets/css/style.css');?>">
<link rel="stylesheet" href="<?= base_url('public/assets/css/customizer.css');?>">
<link rel="stylesheet" href="<?= base_url('public/assets/plugins/toastr/toastr.css');?>">
</head>

<body>
<!-- [ auth-signin ] start -->
<?php
if($xin_com_system['login_page']==1){
	echo view('erp/auth/erp_login_page1'); //login page load
} else if($xin_com_system['login_page']==2){
	echo view('erp/auth/erp_login_page2'); //login page load
} else if($xin_com_system['login_page']==3){
	echo view('erp/auth/erp_login_page3'); //login page load
} else {
	echo view('erp/auth/erp_login_page1'); //login page load
}
?>
<!-- [ auth-sign ] end --> 

<!-- Required Js --> 
<script src="<?= base_url('public/assets/js/vendor-all.min.js');?>"></script> 
<script src="<?= base_url('public/assets/js/plugins/bootstrap.min.js');?>"></script> 
<script src="<?= base_url('public/assets/js/plugins/feather.min.js');?>"></script> 
<script src="<?= base_url('public/assets/js/pcoded.min.js');?>"></script> 
<script src="<?= base_url();?>/public/assets/plugins/toastr/toastr.js"></script> 
<script src="<?= base_url();?>/public/assets/plugins/sweetalert2/sweetalert2@10.js"></script>
<link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/ladda/ladda.css">
<script src="<?= base_url();?>/public/assets/plugins/spin/spin.js"></script> 
<script src="<?= base_url();?>/public/assets/plugins/ladda/ladda.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
	Ladda.bind('button[type=submit]');
	toastr.options.closeButton = <?= $xin_system['notification_close_btn'];?>;
	toastr.options.progressBar = <?= $xin_system['notification_bar'];?>;
	toastr.options.timeOut = 3000;
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "<?= $xin_system['notification_position'];?>";
});
</script> 
<script type="text/javascript">
var desk_url = '<?php echo site_url('erp/desk'); ?>';
var processing_request = '<?= lang('Login.xin_processing_request');?>';</script></script> 
<script type="text/javascript" src="<?= base_url();?>/public/module_scripts/ci_erp_login.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$(".login-as").click(function(){
		var uname = jQuery(this).data('demo_user');
		var password = jQuery(this).data('demo_password');
		jQuery('#iusername').val(uname);
		jQuery('#ipassword').val(password);
	});
});	
</script>
</body></html>
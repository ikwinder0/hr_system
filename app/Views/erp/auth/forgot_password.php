<?php
use App\Models\SystemModel;
use App\Models\UsersModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();

$session = \Config\Services::session();
$username = $session->get('sup_user_id');
$xin_system = $SystemModel->where('setting_id', 1)->first();
?>  
<!DOCTYPE html>
<html lang="en">

<head>

	<title><?= $title; ?></title>
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
	<meta name="author" content="TIMEHRM" />

	<!-- Favicon icon -->
	<link rel="icon" href="<?= base_url();?>/public/assets/images/favicon.svg" type="image/x-icon">

	<!-- font css -->
	<link rel="stylesheet" href="<?= base_url();?>/public/assets/fonts/font-awsome-pro/css/pro.min.css">
	<link rel="stylesheet" href="<?= base_url();?>/public/assets/fonts/feather.css">
	<link rel="stylesheet" href="<?= base_url();?>/public/assets/fonts/fontawesome.css">

	<!-- vendor css -->
	<link rel="stylesheet" href="<?= base_url();?>/public/assets/css/style.css">
	<link rel="stylesheet" href="<?= base_url();?>/public/assets/css/customizer.css">
    <link rel="stylesheet" href="<?= base_url('public/assets/plugins/toastr/toastr.css');?>">

</head>

<body>
<!-- Content -->
<div class="auth-wrapper">
	<!-- [ reset-password ] start -->
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
					<div class="card-body">
						<img src="<?= base_url();?>/public/assets/images/logo-dark.svg" alt="" class="img-fluid mb-4">
						<h4 class="mb-3 f-w-400">Reset your password</h4>
                        <?php $attributes = array('class' => 'form', 'name' => 'erp_form', 'id' => 'hrm-form', 'autocomplete' => 'off');?>
						<?php $hidden = array('user_id' => 0);?>
                        <?= form_open('erp/auth/check_password', $attributes, $hidden);?>
						<div class="input-group mb-4">
							<div class="input-group-prepend">
								<span class="input-group-text"><i data-feather="mail"></i></span>
							</div>
							<input type="text" name="email" class="form-control" placeholder="Email address">
						</div>
						<button type="submit" class="btn btn-block btn-primary mb-4">Reset password</button>
						<p class="mb-0 text-muted">Remember password? <a href="<?= site_url('erp/login');?>" class="f-w-400">Click here</a></p>
                        <?= form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ reset-password ] end -->
</div>

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
	$(document).ready(function(){
		
		/* Add data */ /*Form Submit*/
		$("#hrm-form").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&add_type=forgot_password&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
						Ladda.stopAll();
					} else {
						toastr.success(JSON.result);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
						Ladda.stopAll();
					}
				}
			});
		});
	});
</script>
</body></html>
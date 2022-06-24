<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;

$SystemModel = new SystemModel();
$UserRolesModel = new RolesModel();
$UsersModel = new UsersModel();

$xin_system = $SystemModel->where('setting_id', 1)->first();
$router = service('router'); 
$favicon = base_url().'/public/uploads/logo/favicon/'.$xin_system['favicon'];

$session = \Config\Services::session();
$router = service('router');

$username = $session->get('sup_username');
$user_id = $username['sup_user_id'];
$user_info = $UsersModel->where('user_id', $user_id)->first();
$xin_com_system = erp_company_settings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $title?></title>
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
    <link rel="icon" href="<?= base_url();?>/public/uploads/logo/favicon/<?= $xin_system['favicon'];?>" type="image/x-icon">

    <!-- font css -->
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/fonts/font-awsome-pro/css/pro.min.css">
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/fonts/feather.css">
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/fonts/fontawesome.css">

    <!-- vendor css -->
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/customizer.css">
    
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/layout-modern.css">
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/plugins/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/plugins/select2.min.css">
    <link rel="stylesheet" href="<?= base_url('public/assets/plugins/toastr/toastr.css');?>">
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css">
    <!--<link rel="stylesheet" href="<?= base_url();?>/public/assets/css/plugins/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/plugins/bootstrap-timepicker.min.css">-->
    <?php //if($router->controllerName() =='\App\Controllers\Erp\Roles') { ?>
        <?php /*?><link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/kendo/kendo.common.min.css">
        <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/kendo/kendo.default.min.css"><?php */?>
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.1.330/styles/kendo.bootstrap-v4.min.css">
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.1.330/styles/kendo.rtl.min.css">
    <?php //} ?>
    <?php if($router->methodName() =='goal_details' || $router->methodName() =='task_details' || $router->methodName() =='project_details'){?>
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/ion.rangeSlider/css/ion.rangeSlider.css">
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css">
    <?php } ?>
   <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/plugins/bars-movie.css"> 
   <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/plugins/css-stars.css">
   <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/plugins/bars-1to10.css">
   <!-- rangeslider css -->
	<link rel="stylesheet" href="<?= base_url();?>/public/assets/css/plugins/bootstrap-slider.min.css">
    <?php if($user_info['user_type'] == 'customer'){?>
	<link rel="stylesheet" href="<?= base_url();?>/public/assets/css/layout-advance.css">
    <?php } ?>
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/plugins/fullcalendar.min.css">
    <?php if($router->methodName() =='tasks_scrum_board' || $router->methodName() =='projects_scrum_board') { ?>
    <link rel="stylesheet" href="<?php echo base_url();?>/public/assets/plugins/dragula/dragula.css">
    <?php } ?>
    <?php if($router->controllerName() =='\App\Controllers\Erp\Settings' && $router->methodName() =='index') { ?>
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/plugins/ekko-lightbox.css">
    <link rel="stylesheet" href="<?= base_url();?>/public/assets/css/plugins/lightbox.min.css">
    <?php } ?>
</head>
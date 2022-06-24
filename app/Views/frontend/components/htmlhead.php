<?php
use App\Models\SystemModel;
use App\Models\RolesModel;

$SystemModel = new SystemModel();
$UserRolesModel = new RolesModel();

$session = \Config\Services::session();
$session = $session->get('sup_username');
$router = service('router');

$xin_system = $SystemModel->where('setting_id', 1)->first();
$role_user = $UserRolesModel->where('role_id', 1)->first();
?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?= $title;?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Place favicon.ico in the root directory -->
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url();?>/public/uploads/logo/favicon/<?= $xin_system['favicon'];?>">
  <!-- CSS here -->
  <link rel="stylesheet" href="<?= base_url();?>/public/frontend/assets/css/preloader.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/frontend/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/frontend/assets/css/meanmenu.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/frontend/assets/css/animate.min.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/frontend/assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/frontend/assets/css/backToTop.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/frontend/assets/css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/frontend/assets/css/fontAwesome5Pro.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/frontend/assets/css/elegantFont.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/frontend/assets/css/default.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/frontend/assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/toastr/toastr.css">
</head>
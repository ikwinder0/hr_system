<!DOCTYPE html>

<html lang="en" class="light-style">
<head>
  <title>404 Not Found - Appwork</title>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
  <link rel="icon" type="image/x-icon" href="favicon.ico">

  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

  <!-- Core stylesheets -->
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/bootstrap.css" class="theme-settings-bootstrap-css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/appwork.css" class="theme-settings-appwork-css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/theme-corporate.css" class="theme-settings-theme-css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/colors.css" class="theme-settings-colors-css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/uikit.css">

  <script src="<?= base_url();?>/public/module_scripts/assets/vendor/js/material-ripple.js"></script>
  <script src="<?= base_url();?>/public/module_scripts/assets/vendor/js/layout-helpers.js"></script>

  <!-- Theme settings -->
  <!-- This file MUST be included after core stylesheets and layout-helpers.js in the <head> section -->
  <script src="<?= base_url();?>/public/module_scripts/assets/vendor/js/theme-settings.js"></script>
  <script>
    window.themeSettings = new ThemeSettings({
      cssPath: '<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/',
      themesPath: '<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/'
    });
  </script>

  <!-- Core scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- Page -->
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/css/error.css">
</head>

<body class="bg-primary">

  <div class="overflow-hidden">
    <div class="container d-flex align-items-stretch ui-mh-100vh p-0">
      <div class="row w-100">
        <div class="d-flex col-md justify-content-center align-items-center order-2 order-md-1 position-relative p-5">
          <div class="error-bg-skew theme-bg-white"></div>

          <div class="text-md-left text-center">
            <h1 class="display-2 font-weight-bolder mb-4">Whoops...</h1>
            <div class="text-xlarge font-weight-light mb-5">We couldn't find the page<br> you are looking for :(</div>
            <button type="button" class="btn btn-primary">←&nbsp; Go Back</button>
          </div>
        </div>

        <div class="d-flex col-md-5 justify-content-center align-items-center order-1 order-md-2 text-center text-white p-5">
          <div>
            <div class="error-code font-weight-bolder mb-2">404</div>
            <div class="error-description font-weight-light">Not Found</div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Core scripts -->
  <script src="<?= base_url();?>/public/module_scripts/assets/vendor/libs/popper/popper.js"></script>
  <script src="<?= base_url();?>/public/module_scripts/assets/vendor/js/bootstrap.js"></script>
</body>
</html>



<?php /*?><!DOCTYPE html>

<html lang="en" class="default-style">

<head>
  <title><?= lang('Dashboard.xin_error_page_not_found_title');?></title>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
  <link rel="icon" type="image/x-icon" href="favicon.ico">

  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

  <!-- Icon fonts -->
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/fonts/fontawesome.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/fonts/ionicons.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/fonts/linearicons.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/fonts/pe-icon-7-stroke.css">

  <!-- Core stylesheets -->
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/bootstrap.css" class="theme-settings-bootstrap-css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/appwork.css" class="theme-settings-appwork-css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/theme-corporate.css" class="theme-settings-theme-css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/colors.css" class="theme-settings-colors-css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/css/rtl/uikit.css">
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/css/demo.css">
  <!-- Libs -->
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
  <!-- Page -->
  <link rel="stylesheet" href="<?= base_url();?>/public/module_scripts/assets/vendor/css/pages/authentication.css">
</head>

<body>
  <div class="page-loader">
    <div class="bg-primary"></div>
  </div>

  <!-- Content -->

  <div class="authentication-wrapper authentication-2 px-4">
    <div class="authentication-inner py-5">

      <!-- Form -->
      <div class="card">
        <div class="p-4 p-sm-5">

          <div class="display-1 lnr lnr-cross-circle text-center text-success mb-4"></div>

          <p class="text-center text-big mb-4">
          <?php if (! empty($message) && $message !== '(null)') : ?>
				<?= esc($message) ?>
			<?php else : ?>
				<?= lang('Dashboard.xin_error_page_text');?>
			<?php endif ?>
            </p>

          <a href="<?= site_url('erp/desk');?>">
          <button type="button" class="btn btn-primary btn-block"><?= lang('Dashboard.xin_error_page_go_to_home_page');?></button></a>

        </div>
      </div>
      <!-- / Form -->

    </div>
  </div>

</body>

</html><?php */?>
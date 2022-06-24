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
<!-- [ auth-signin ] start -->

<div class="auth-wrapper align-items-stretch aut-bg-img">
  <div class="flex-grow-1">
    <div class="h-100 d-md-flex align-items-end auth-side-img">
      <div class="col-sm-10 auth-content w-auto"> 
      <!--<img src="<?= base_url();?>/public/uploads/logo/<?= $xin_system['logo'];?>" alt="" class="img-fluid my-4" height="40" width="138">-->
         <h2>HR SYSTEM</h2>
        <h4 class="text-white font-weight-normal">
          <?= $xin_com_system['login_page_text'];?>
        </h4>
      </div>
    </div>
    <div class="auth-side-form">
      <div class=" auth-content">
        <div class="text-center">
        	<!--<img src="<?= base_url();?>/public/uploads/logo/other/<?= $xin_system['other_logo'];?>" alt="" class="img-fluid my-4" height="40" width="138">-->
        	<h2>HR SYSTEM</h2>
          <h4 class="mb-3 f-w-600">
            <?= lang('Login.xin_welcome_to');?>
            <span class="text-primary">
            <?= $xin_system['company_name'];?>
            </span></h4>
          <p class="text-muted">
            <?= lang('Login.xin_welcome_back_please_login');?>
          </p>
        </div>
        <?php $attributes = array('class' => 'form-timehrm', 'name' => 'erp-form', 'id' => 'erp-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0);?>
        <?= form_open('erp/auth/login', $attributes, $hidden);?>
        <div class="input-group mb-3">
          <div class="input-group-prepend"> <span class="input-group-text"><i data-feather="user"></i></span> </div>
          <input type="text" class="form-control" name="iusername" id="iusername" placeholder="<?= lang('Login.xin_login_username');?>">
        </div>
        <div class="input-group mb-4">
          <div class="input-group-prepend"> <span class="input-group-text"><i data-feather="lock"></i></span> </div>
          <input type="password" class="form-control" name="password" id="password" placeholder="<?= lang('Login.xin_login_enter_password');?>">
        </div>
        <button type="submit" class="btn btn-block btn-primary mb-0"><i class="fas fa-user-lock d-blockd"></i>
        <?= lang('Login.xin_login');?>
        </button>
        <?= form_close(); ?>
        <div class="text-center">
          <p class="mb-2 mt-4 text-muted"><a href="<?= site_url('erp/forgot-password');?>" class="f-w-400">
            <?= lang('Login.xin_forgot_password_link');?>
            </a></p>
        </div>
      </div>
    </div>
  </div>
</div>

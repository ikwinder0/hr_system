<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;

$SystemModel = new SystemModel();
$UserRolesModel = new RolesModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$router = service('router');
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();
$language = $LanguageModel->where('is_active', 1)->orderBy('language_id', 'ASC')->findAll();
if($user['user_type'] == 'super_user'){
	$xin_system = $SystemModel->where('setting_id', 1)->first();
} else {
	$xin_system = erp_company_settings();
}
$session_lang = $session->lang;
if(!empty($session_lang)):
	$lang_code = $LanguageModel->where('language_code', $session_lang)->first();
	$flg_icn = '<img src="'.base_url().'/public/uploads/languages_flag/'.$lang_code['language_flag'].'"> '.$lang_code['language_name'];
	$lg_code = $session_lang;
elseif($xin_system['default_language']!=''):
	$lg_code = $xin_system['default_language'];
	$lang_code = $LanguageModel->where('language_code', $xin_system['default_language'])->first();
	$flg_icn = '<img src="'.base_url().'/public/uploads/languages_flag/'.$lang_code['language_flag'].'"> '.$lang_code['language_name'];
else:
	$flg_icn = '<img src="'.base_url().'/public/uploads/languages_flag/gb.gif"> English';	
endif;
?>
<header>
 <div id="header-sticky" class="header__area header__border header__padding">
    <div class="container">
       <div class="row align-items-center">
          <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-6">
             <div class="logo">
                <a href="<?= site_url();?>">
                   <img src="<?= base_url();?>/public/frontend/assets/img/logo/logo.png" alt="logo">
                </a>
             </div>
          </div>
          <div class="col-xxl-7 col-xl-7 col-lg-7 d-none d-lg-block">
             <div class="main-menu main-menu-2 pl-40">
                <nav id="mobile-menu">
                   <ul>
                  <li> <a href="<?= site_url();?>">
                    <?= lang('Frontend.xin_home');?>
                    </a> </li>
                  <li><a href="<?= site_url('features');?>">
                    <?= lang('Frontend.xin_features');?>
                    </a></li>
                  <li> <a href="<?= site_url('pricing');?>">
                    <?= lang('Frontend.xin_pricing');?>
                    </a> </li>
                  <li> <a href="<?= site_url('contact');?>">
                    <?= lang('Frontend.xin_contact_us');?>
                    </a> </li>
                  <li class="has-dropdown">
                     <a href="#!"><?= $flg_icn;?></a>
                     <ul class="submenu">
                     	<?php foreach($language as $lang):?>
                        <li><a href="<?= site_url('erp/dashboard/language/');?><?= $lang['language_code'];?>">
                        <img src="<?= base_url();?>/public/uploads/languages_flag/<?= $lang['language_flag'];?>" width="16" height="11" /> <?= $lang['language_name'];?>
                        </a></li>
                        <?php endforeach;?>
                     </ul>
                  </li>
                </ul>
                </nav>
             </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-6">
             <div class="header__right text-end d-flex align-items-center justify-content-end">
                <div class="header__right-btn d-none d-md-flex d-xl-block">
                   <a target="_blank" href="<?= site_url('erp/login');?>" class="w-btn w-btn-transparent w-btn-transparent-2"><i class="fas fa-sign-in-alt"></i> <?= lang('Frontend.xin_sign_in');?></a>
                   <a href="<?= site_url('register');?>" class="w-btn w-btn-blue w-btn-blue-header ml-30"><?= lang('Frontend.xin_get_started');?></a>
                </div>
                <div class="sidebar__menu d-lg-none">
                   <div class="sidebar-toggle-btn sidebar-toggle-btn-2" id="sidebar-toggle">
                       <span class="line"></span>
                       <span class="line"></span>
                       <span class="line"></span>
                   </div>
               </div>
             </div>
          </div>
       </div>
    </div>
 </div>
</header>
<!-- header area end -->

<!-- sidebar area start -->
<div class="sidebar__area">
 <div class="sidebar__wrapper">
    <div class="sidebar__close">
       <button class="sidebar__close-btn" id="sidebar__close-btn">
       <span><i class="fal fa-times"></i></span>
       <span><?= lang('Main.xin_close');?></span>
       </button>
    </div>
    <div class="sidebar__content">
       <div class="logo mb-40">
          <a href="index.html">
          <img src="<?= base_url();?>/public/frontend/assets/img/logo/logo.png" alt="logo">
          </a>
       </div>
       <div class="mobile-menu mobile-menu-2"></div>
       <div class="sidebar__info mt-350">
          <a href="<?= site_url('erp/login');?>" target="_blank" class="w-btn w-btn-blue-2 w-btn-4 d-block mb-15 mt-15"><?= lang('Frontend.xin_sign_in');?></a>
          <a href="<?= site_url('register');?>" class="w-btn w-btn-blue d-block"><?= lang('Frontend.xin_get_started');?></a>
       </div>
    </div>
 </div>
</div>
      

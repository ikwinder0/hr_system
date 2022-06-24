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
<?php if($router->methodName() =='contact' || $router->methodName() =='register' || $router->methodName() =='features'){?>
<footer class="footer__area grey-bg-3 pt-120 p-relative fix">
<?php } else { ?>
<footer class="footer__area grey-bg-3 pt-270 p-relative">
<?php } ?>
 <div class="footer__shape">
    <img class="footer-circle-1" src="<?= base_url();?>/public/frontend/assets/img/icon/footer/home-1/circle-1.png" alt="">
    <img class="footer-circle-2" src="<?= base_url();?>/public/frontend/assets/img/icon/footer/home-1/circle-2.png" alt="">
 </div>
 <div class="footer__top pb-65">
    <div class="container">
       <div class="row">
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".3s">
             <div class="footer__widget mb-50">
                <div class="footer__widget-title mb-25">
                   <div class="footer__logo">
                      <a href="index.html">
                         <img src="<?= base_url();?>/public/frontend/assets/img/logo/logo.png" alt="logo">
                      </a>
                   </div>
                </div>
                <div class="footer__widget-content">
                   <p><?= lang('Frontend.xin_time_hrm_description');?></p>
                </div>
             </div>
          </div>
          <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".5s">
             <div class="footer__widget mb-50 footer__pl-70">
                <div class="footer__widget-title mb-25">
                   <h3>Overview</h3>
                </div>
                <div class="footer__widget-content">
                   <div class="footer__link">
                      <ul>
                         <li><a href="#">Terms</a></li>
                         <li><a href="#">Privacy Policy</a></li>
                         <li><a href="#">Cookies</a></li>
                         <li><a href="#">Integrations</a></li>
                      </ul>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-xxl-3 col-xl-2 col-lg-2 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".7s">
             <div class="footer__widget mb-50 footer__pl-90">
                <div class="footer__widget-title mb-25">
                   <h3>Customer</h3>
                </div>
                <div class="footer__widget-content">
                   <div class="footer__link">
                      <ul>
                         <li><a href="#">Home</a></li>
                         <li><a href="#">Product</a></li>
                         <li><a href="#">Pricing</a></li>
                         <li><a href="#">Integrations</a></li>
                      </ul>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".9s">
             <div class="footer__widget mb-50">
                <div class="footer__widget-title mb-25">
                   <h3>Product</h3>
                </div>
                <div class="footer__widget-content">
                   <div class="footer__link">
                      <ul>
                         <li><a href="#">Getting Started</a></li>
                         <li><a href="#">Style Guide</a></li>
                         <li><a href="#">Licences</a></li>
                         <li><a href="#">Changelog</a></li>
                      </ul>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.2s">
             <div class="footer__widget mb-50 float-md-end fix">
                <div class="footer__widget-title mb-25">
                   <h3>Follow Us</h3>
                </div>
                <div class="footer__widget-content">
                   <div class="footer__social">
                      <ul>
                         <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                         <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                         <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                      </ul>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 <div class="footer__bottom">
    <div class="container">
       <div class="footer__copyright">
          <div class="row">
             <div class="col-xxl-12 wow fadeInUp" data-wow-delay=".5s">
                <div class="footer__copyright-wrapper text-center">
                   <p>Copyright © <?= date('Y');?> All Rights Reserved.</p>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
</footer>
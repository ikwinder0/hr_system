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
<footer class="footer__area grey-bg-3 pt-15 p-relative fix">
<?php } else { ?>
<footer class="footer__area grey-bg-3 pt-170 p-relative">
<?php } ?>
 <div class="footer__bottom ">
    <div class="container">
       <div class="footer__copyright footer__copyright-3">
          <div class="row">
             <div class="col-xxl-12">
                <div class="footer__copyright-wrapper footer__copyright-wrapper-4 text-center">
                   <p>Copyright © <?= date('Y');?> TimeHRM - The Cloud Suite</p>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
</footer>
      

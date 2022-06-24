<?php
use App\Models\ConstantsModel;
use App\Models\CountryModel;
use App\Models\MembershipModel;
use App\Models\CompanymembershipModel;
use App\Models\MainModel;
use App\Models\UsersModel;
use App\Models\SystemModel;

$ConstantsModel = new ConstantsModel();
$CountryModel = new CountryModel();
$MembershipModel = new MembershipModel();
$MainModel = new MainModel();
$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$CompanymembershipModel = new CompanymembershipModel();

$company_types = $ConstantsModel->where('type','company_type')->orderBy('constants_id', 'ASC')->findAll();
$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$membership = $MembershipModel->orderBy('membership_id', 'ASC')->findAll();
/* Company Details view
*/		
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$xin_system = $SystemModel->where('setting_id', 1)->first();
?>
<?php echo view('frontend/components/htmlhead'); ?>
   <body>
      <!-- pre loader area start -->
      <div id="loading">
         <div id="loading-center">
            <div id="loading-center-absolute">
               <div class="object" id="object_one"></div>
               <div class="object" id="object_two" style="left:20px;"></div>
               <div class="object" id="object_three" style="left:40px;"></div>
               <div class="object" id="object_four" style="left:60px;"></div>
               <div class="object" id="object_five" style="left:80px;"></div>
            </div>
         </div>  
      </div>
      <!-- pre loader area end -->
      <!-- back to top start -->
      <div class="progress-wrap">
         <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
         </svg>
      </div>
      <!-- back to top end -->
      <!-- header area start -->
      <?php echo view('frontend/components/top_link'); ?>
      <!-- header area end -->
      <!-- sidebar area start -->      
      <div class="body-overlay"></div>
      <!-- sidebar area end -->
      <main>
        <!-- page title area start -->
        <section class="page__title-area page__title-height d-flex align-items-center fix p-relative z-index-1" data-background="<?= base_url();?>/public/frontend/assets/img/page-title/page-title.jpg">
         <div class="page__title-shape">
            <img class="page-title-dot-4" src="<?= base_url();?>/public/frontend/assets/img/page-title/dot-4.png" alt="">
            <img class="page-title-dot" src="<?= base_url();?>/public/frontend/assets/img/page-title/dot.png" alt="">
            <img class="page-title-dot-2" src="<?= base_url();?>/public/frontend/assets/img/page-title/dot-2.png" alt="">
            <img class="page-title-dot-3" src="<?= base_url();?>/public/frontend/assets/img/page-title/dot-3.png" alt="">
            <img class="page-title-plus" src="<?= base_url();?>/public/frontend/assets/img/page-title/plus.png" alt="">
            <img class="page-title-triangle" src="<?= base_url();?>/public/frontend/assets/img/page-title/triangle.png" alt="">
         </div>
           <div class="container">
              <div class="row">
                 <div class="col-xxl-12">
                    <div class="page__title-wrapper text-center">
                       <h3> <?= lang('Frontend.xin_pricing');?> </h3>
                        <nav aria-label="breadcrumb">
                           <ol class="breadcrumb justify-content-center">
                              <li class="breadcrumb-item"><a href="<?= site_url('');?>"><?= lang('Frontend.xin_home');?></a></li>
                              <li class="breadcrumb-item active" aria-current="page"><?= lang('Frontend.xin_pricing');?></li>
                           </ol>
                        </nav>
                    </div>
                 </div>
              </div>
           </div>
        </section>
       <!-- pricing area start -->
         <section class="price__area pt-105 pb-90">
            <div class="container">
               <div class="row">
                  <div class="col-xxl-7 col-xl-7 col-lg-8">
                     <div class="section__title-wrapper mb-65 wow fadeInUp" data-wow-delay=".3s">
                        <h2 class="section__title"><?= lang('Frontend.xin_choose_the_plan_that');?> <br><?= lang('Frontend.xin_best_fits_your_needs');?></h2>
                        <p class="bk_pra"><?= lang('Frontend.xin_choose_your_plan_text_details');?></p>
                     </div>
                  </div>
               </div>
               <div class="row">
                 <?php foreach($membership as $r) { ?>
                 <?php
				if($r['plan_duration']==1){
					$plan_duration = lang('Membership.xin_per_month');
				} else if($r['plan_duration']==2) {
					$plan_duration = lang('Membership.xin_per_year');
				} else {
					$plan_duration = lang('Membership.xin_subscription_unlimit');
				}
				$converted = currency_converter($r['price']);
				?>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                     <div class="price__item white-bg mb-30 transition-3 fix wow fadeInUp" data-wow-delay=".3s">
                        <div class="price__offer mb-15">
                           <span><?= $r['membership_type']?></span>
                        </div>
                        <div class="price__tag mb-15">
                           <h3><?= number_to_currency($r['price'],$xin_system['default_currency'],null,2);?><span> <?= $plan_duration;?></span></h3>
                        </div>
                        <div class="price__text mb-25">
                           <p><?= lang('Frontend.xin_start_for_free_pick_a_plan');?></p>
                        </div>
                        <div class="price__features mb-40">
                           <ul>
                              <li><span class="text-primary"><?= $r['total_employees']?></span> <?= lang('Frontend.xin_number_of_employees');?></li>
                              <li><?= lang('Frontend.xin_all_modules_included');?></li>
                              <li><?= lang('Frontend.xin_priority_support');?></li>
                              <li><?= lang('Frontend.xin_automated_unified_skills_assessments');?></li>
                              <li><?= lang('Frontend.xin_24_7_support_trained_professionals');?></li>
                           </ul>
                        </div>
                        <a href="<?= site_url('register');?>" class="w-btn w-btn-4 w-100 price__btn"><?= lang('Frontend.xin_try_for_free');?></a>
                     </div>
                  </div>
                  <?php } ?>
               </div>
            </div>
         </section>
         <!-- pricing area end -->
         <!-- cta area start -->
         <section class="cta__area mb--149 p-relative">
            <div class="circle-animation cta-1">
               <span></span>
            </div>
            <div class="circle-animation cta-1 cta-2">
               <span></span>
            </div>
            <div class="circle-animation cta-3">
               <span></span>
            </div>
            <div class="container">
               <div class="cta__inner p-relative fix z-index-1 wow fadeInUp" data-wow-delay=".5s">
                  <div class="cta__shape">
                     <img class="circle" src="<?= base_url();?>/public/frontend/assets/img/cta/home-1/cta-circle.png" alt="">
                     <img class="circle-2" src="<?= base_url();?>/public/frontend/assets/img/cta/home-1/cta-circle-2.png" alt="">
                     <img class="circle-3" src="<?= base_url();?>/public/frontend/assets/img/cta/home-1/cta-circle-3.png" alt="">
                     <img class="triangle-1" src="<?= base_url();?>/public/frontend/assets/img/cta/home-1/cta-triangle.png" alt="">
                     <img class="triangle-2" src="<?= base_url();?>/public/frontend/assets/img/cta/home-1/cta-triangle-2.png" alt="">
                  </div>
                  <div class="row">
                     <div class="col-xxl-12">
                        <div class="cta__wrapper d-lg-flex justify-content-between align-items-center">
                           <div class="cta__content">
                              <h3 class="cta__title"><?= lang('Frontend.xin_ready_to_take_the_next_step');?></h3>
                           </div>
                           <div class="cta__btn">
                              <a href="<?= site_url('register');?>" class="w-btn w-btn-white"><?= lang('Frontend.xin_get_started');?></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- cta area end -->
      </main>
      <!-- footer area start -->
      <?php echo view('frontend/components/footer'); ?>
      <!-- footer area end -->
      <!-- JS here -->
      <?php echo view('frontend/components/htmlfooter'); ?>
   </body>
</html>
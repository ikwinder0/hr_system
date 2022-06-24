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
                       <h3>  <?= lang('Frontend.xin_features');?></h3>
                        <nav aria-label="breadcrumb">
                           <ol class="breadcrumb justify-content-center">
                              <li class="breadcrumb-item"><a href="<?= site_url('');?>"><?= lang('Frontend.xin_home');?></a></li>
                              <li class="breadcrumb-item active" aria-current="page"><?= lang('Frontend.xin_features');?></li>
                           </ol>
                        </nav>
                    </div>
                 </div>
              </div>
           </div>
        </section>
        <!-- services area start -->
         <section class="services__area pt-120 pb-110 p-relative">
            <div class="container">
               <div class="row">
                  <div class="col-xxl-8 offset-xxl-2 col-xl-10 offset-xl-1">
                     <div class="section__title-wrapper section__title-wrapper-3 text-center section-padding-3 mb-80 wow fadeInUp" data-wow-delay=".3s">
                        <span class="section__pre-title-img"><img src="<?= base_url();?>/public/frontend/assets/img/icon/title/services.png" alt=""></span>
                        <h2 class="section__title section__title-3"><?= lang('Frontend.xin_hr_software_that_improves');?></h2>
                        <p><?= lang('Frontend.xin_hr_software_that_improve_experience');?></p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                     <div class="services__item-3 white-bg transition-3 mb-30 text-center">
                        <div class="services__icon-3">
                           <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-3/services-1.png" alt="">
                        </div>
                        <div class="services__content-3">
                           <h3 class="services__title-3"><a href="#!"><?= lang('Frontend.xin_secure_login');?></a></h3>
                           <p><?= lang('Frontend.xin_login_safely_and_securely');?></p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                     <div class="services__item-3 white-bg transition-3 mb-30 text-center">
                        <div class="services__icon-3">
                           <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-3/services-2.png" alt="">
                        </div>
                        <div class="services__content-3">
                           <h3 class="services__title-3"><a href="#!"><?= lang('Frontend.xin_everything_in_one_place');?></a></h3>
                           <p><?= lang('Frontend.xin_get_a_complete_overiew');?></p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                     <div class="services__item-3 white-bg transition-3 mb-30 text-center">
                        <div class="services__icon-3">
                           <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-3/services-3.png" alt="">
                        </div>
                        <div class="services__content-3">
                           <h3 class="services__title-3"><a href="#!"><?= lang('Frontend.xin_core_hr');?></a></h3>
                           <p><?= lang('Frontend.xin_automate_essential_hr_process');?></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-12 wow fadeInUp" data-wow-delay=".9s">
                     <div class="services__more text-center mt-30">
                        <a href="<?= site_url('register');?>" class="w-btn w-btn-purple w-btn-purple-2 w-btn-3 w-btn-6"><?= lang('Frontend.xin_free_trial');?></a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- services area end -->
        <!-- page title area end -->
        <section class="about__area pb-120 p-relative">
            <div class="about__shape">
               <img class="about-triangle" src="<?= base_url();?>/public/frontend/assets/img/icon/about/home-1/triangle.png" alt="">
               <img class="about-circle" src="<?= base_url();?>/public/frontend/assets/img/icon/about/home-1/circle.png" alt="">
               <img class="about-circle-2" src="<?= base_url();?>/public/frontend/assets/img/icon/about/home-1/circle-2.png" alt="">
               <img class="about-circle-3" src="<?= base_url();?>/public/frontend/assets/img/icon/about/home-1/circle-3.png" alt="">
            </div>
            <div class="container">
               <div class="row align-items-center">
                  <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-9">
                     <div class="about__wrapper mb-10">
                        <div class="section__title-wrapper mb-25">
                           <h2 class="section__title"><?= lang('Frontend.xin_time_and_attendance');?></h2>
                           <p><?= lang('Frontend.xin_setup_company_attendance');?></p>
                        </div>
                        <a href="<?= site_url('register');?>" class="w-btn w-btn-3 w-btn-1"><?= lang('Frontend.xin_get_started');?></a>
                     </div>
                  </div>
                  <div class="col-xxl-6 offset-xxl-1 col-xl-6 col-lg-6 col-md-10 order-first order-lg-last">
                     <div class="about__thumb-wrapper p-relative ml-40 fix text-end">
                        <img src="<?= base_url();?>/public/frontend/assets/img/about/home-1/about-bg.png" alt="">
                        <div class="about__thumb p-absolute">
                           <img class="bounceInUp wow about-big" data-wow-delay=".3s" src="<?= base_url();?>/public/frontend/assets/img/about/home-1/about-1.png" alt="">
                           <img class="about-sm" src="<?= base_url();?>/public/frontend/assets/img/about/home-1/about-1-1.png" alt="">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <section class="features__area pt-135 pb-120 p-relative">
            <div class="features__shape-2">
               <img class="features-2-dot" src="<?= base_url();?>/public/frontend/assets/img/icon/features/home-2/features-dot.png" alt="">
               <img class="features-2-dot-2" src="<?= base_url();?>/public/frontend/assets/img/icon/features/home-2/features-dot-2.png" alt="">
               <img class="features-2-dot-3" src="<?= base_url();?>/public/frontend/assets/img/icon/features/home-2/features-dot-3.png" alt="">
               <img class="features-2-triangle-1" src="<?= base_url();?>/public/frontend/assets/img/icon/features/home-2/features-triangle-1.png" alt="">
               <img class="features-2-triangle-2" src="<?= base_url();?>/public/frontend/assets/img/icon/features/home-2/features-triangle-2.png" alt="">
               <img class="features-2-triangle-3" src="<?= base_url();?>/public/frontend/assets/img/icon/features/home-2/features-triangle-3.png" alt="">
            </div>
            <div class="container">
               <div class="row">
                  <div class="col-xxl-6 offset-xxl-3 col-xl-8 offset-xl-2 col-lg-8 offset-lg-2">
                     <div class="section__title-wrapper section__title-wrapper-2 text-center mb-75 wow fadeInUp" data-wow-delay=".3s">
                        <span class="section__pre-title purple"><?= lang('Frontend.xin_features');?></span>
                        <h2 class="section__title section__title-2"><?= lang('Frontend.xin_highly_creative_solutions');?></h2>
                        <p><?= lang('Frontend.xin_software_can_handle_every_business');?></p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-8 offset-xxl-2 col-xl-8 offset-xl-1 col-lg-8 col-md-8">
                     <div class="features__tab-content">
                        <div class="tab-content" id="feaTabContent">
                           <div class="tab-pane fade" id="sync" role="tabpanel" aria-labelledby="sync-tab">
                              <div class="features__thumb">
                                 <div class="features__thumb-inner">
                                    <img class="fea-thumb" src="<?= base_url();?>/public/frontend/assets/img/features/home-2/fea-thumb-2.jpg" alt="">
                                    <img class="fea-sm" src="<?= base_url();?>/public/frontend/assets/img/features/home-2/fea-sm.jpg" alt="">
                                    <img class="fea-sm-2" src="<?= base_url();?>/public/frontend/assets/img/features/home-2/fea-sm-2.jpg" alt="">
                                    <img class="fea-2-shape" src="<?= base_url();?>/public/frontend/assets/img/icon/features/home-2/features-shape.png" alt="">
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade show active" id="security" role="tabpanel" aria-labelledby="security-tab">
                              <div class="features__thumb">
                                 <div class="features__thumb-inner">
                                    <img class="fea-thumb" src="<?= base_url();?>/public/frontend/assets/img/features/home-2/fea-thumb.jpg" alt="">
                                    <img class="fea-sm" src="<?= base_url();?>/public/frontend/assets/img/features/home-2/fea-sm.jpg" alt="">
                                    <img class="fea-sm-2" src="<?= base_url();?>/public/frontend/assets/img/features/home-2/fea-sm-2.jpg" alt="">
                                    <img class="fea-2-shape" src="<?= base_url();?>/public/frontend/assets/img/icon/features/home-2/features-shape.png" alt="">
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade" id="multitask" role="tabpanel" aria-labelledby="multitask-tab">
                              <div class="features__thumb">
                                 <div class="features__thumb-inner">
                                    <img class="fea-thumb" src="<?= base_url();?>/public/frontend/assets/img/features/home-2/fea-thumb-3.jpg" alt="">
                                    <img class="fea-sm" src="<?= base_url();?>/public/frontend/assets/img/features/home-2/fea-sm.jpg" alt="">
                                    <img class="fea-sm-2" src="<?= base_url();?>/public/frontend/assets/img/features/home-2/fea-sm-2.jpg" alt="">
                                    <img class="fea-2-shape" src="<?= base_url();?>/public/frontend/assets/img/icon/features/home-2/features-shape.png" alt="">
                                 </div>
                              </div>
                           </div>
                         </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <section class="services__area pt-120 pb-110 p-relative">
            <div class="container">
               <div class="row">
                  <div class="col-xxl-8 offset-xxl-2 col-xl-10 offset-xl-1">
                     <div class="section__title-wrapper section__title-wrapper-3 text-center section-padding-3 mb-80 wow fadeInUp" data-wow-delay=".3s">
                        <span class="section__pre-title-img"><img src="<?= base_url();?>/public/frontend/assets/img/icon/title/services.png" alt=""></span>
                        <h2 class="section__title section__title-3"><?= lang('Frontend.xin_why_use_hrm_solution');?></h2>
                        <p><?= lang('Frontend.xin_with_a_wide_variety_of_core_hr');?></p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                     <div class="services__item-3 white-bg transition-3 mb-30 text-center">
                        <div class="services__icon-3">
                           <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-3/services-4.png" alt="">
                        </div>
                        <div class="services__content-3">
                           <h3 class="services__title-3"><a href="#!"><?= lang('Frontend.xin_keep_track_of_employees');?></a></h3>
                           <p><?= lang('Frontend.xin_stay_aware_of_how_many_employees');?></p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                     <div class="services__item-3 white-bg transition-3 mb-30 text-center">
                        <div class="services__icon-3">
                           <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-3/services-5.png" alt="">
                        </div>
                        <div class="services__content-3">
                           <h3 class="services__title-3"><a href="#!"><?= lang('Frontend.xin_enhanced_analytics');?></a></h3>
                           <p><?= lang('Frontend.xin_enhanced_analytics_create_different_types');?></p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                     <div class="services__item-3 white-bg transition-3 mb-30 text-center">
                        <div class="services__icon-3">
                           <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-3/services-6.png" alt="">
                        </div>
                        <div class="services__content-3">
                           <h3 class="services__title-3"><a href="#!"><?= lang('Frontend.xin_solution_alternatives');?></a></h3>
                           <p><?= lang('Frontend.xin_solution_alternatives_offers_cloud');?></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-12 wow fadeInUp" data-wow-delay=".9s">
                     <div class="services__more text-center mt-30">
                        <a href="<?= site_url('register');?>" class="w-btn w-btn-purple w-btn-purple-2 w-btn-3 w-btn-6"><?= lang('Frontend.xin_try_for_free');?></a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <section class="services__area pt-90 pb-110">
            <div class="container">
               <div class="row">
                  <div class="col-xxl-6 offset-xl-3 col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                     <div class="section__title-wrapper section__title-wrapper-4 text-center mb-65 wow fadeInUp" data-wow-delay=".3s">
                        <h2 class="section__title section__title-4 section__title-4-p-2"><?= lang('Frontend.xin_bring_your_team_together');?></h2>
                        <p><?= lang('Frontend.xin_give_hr_team_a_new_advantage2');?></p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                     <div class="services__item-4 white-bg mb-30">
                        <div class="services__thumb-4 text-center d-flex align-items-end justify-content-center">
                           <img src="<?= base_url();?>/public/frontend/assets/img/services/home-4/services-1.png" alt="">
                        </div>
                        <div class="services__content-4">
                           <h3 class="services__title-4"><a href="#!"><?= lang('Frontend.xin_employee_ss');?></a></h3>
                           <p><?= lang('Frontend.xin_employee_ss_engagement');?></p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                     <div class="services__item-4 white-bg mb-30">
                        <div class="services__thumb-4 text-center d-flex align-items-end justify-content-center">
                           <img src="<?= base_url();?>/public/frontend/assets/img/services/home-4/services-2.png" alt="">
                        </div>
                        <div class="services__content-4">
                           <h3 class="services__title-4"><a href="#!"><?= lang('Frontend.xin_performance');?></a></h3>
                           <p><?= lang('Frontend.xin_empower_and_engage');?></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-12 wow fadeInUp" data-wow-delay=".7s">
                     <div class="services__more-4 text-center mt-30">
                        <a href="<?= site_url('contact');?>" class="w-btn-round w-btn-round-border"> <?= lang('Frontend.xin_contact_us');?></a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- cta area start -->
         <section class="cta__area blue-bg-10 pt-140 pb-130 p-relative fix z-index-1">
            <div class="cta__shape">
               <img class="cta-4-shape" src="<?= base_url();?>/public/frontend/assets/img/cta/home-4/cta-shape.png" alt="">
            </div>
            <div class="container">
               <div class="row">
                  <div class="col-xxl-8 offset-xxl-2">
                     <div class="cta__content-4 text-center">
                        <div class="section__title-wrapper section__title-wrapper-4 section__title-white text-center mb-45 wow fadeInUp" data-wow-delay=".3s">
                           <h2 class="section__title section__title-4"><?= lang('Frontend.xin_our_free_trial_for_30days');?></h2>
                           <p><?= lang('Frontend.xin_spend_less_time_scheduling');?></p>
                        </div>
                        <div class="cta__form mb-25 wow fadeInUp" data-wow-delay=".5s">
                              <a href="<?= site_url('register');?>" class="w-btn w-btn-3 w-btn-1"><?= lang('Frontend.xin_start_free_trial');?></a>
                        </div>
                        <div class="cta__features wow fadeInUp" data-wow-delay=".7s">
                           <ul>
                              <li><?= lang('Frontend.xin_product_support');?></li>
                              <li><?= lang('Frontend.xin_free_trial');?></li>
                              <li><?= lang('Frontend.xin_connect_customer');?></li>
                           </ul>
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
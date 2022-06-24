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
      <!-- sidebar area end -->      
      <div class="body-overlay"></div>
      <!-- sidebar area end -->
      <main>
         <!-- hero area start -->
         <section class="hero__area hero__height-2 p-relative d-flex align-items-center">
            <div class="hero__shape-2">
               <img class="hero-2-dot" src="<?= base_url();?>/public/frontend/assets/img/icon/hero/home-2/hero-2-dot.png" alt="">
               <img class="hero-2-dot-2" src="<?= base_url();?>/public/frontend/assets/img/icon/hero/home-2/hero-2-dot-2.png" alt="">
               <img class="hero-2-flower" src="<?= base_url();?>/public/frontend/assets/img/icon/hero/home-2/hero-2-flower.png" alt="">
               <img class="hero-2-triangle" src="<?= base_url();?>/public/frontend/assets/img/icon/hero/home-2/hero-2-triangle.png" alt="">
               <img class="hero-2-triangle-2" src="<?= base_url();?>/public/frontend/assets/img/icon/hero/home-2/hero-2-triangle-2.png" alt="">
            </div>
            <div class="container">
               <div class="row">
                  <div class="col-xxl-5 col-xl-6 col-lg-8">
                     <div class="hero__content-2 mt-55">
                        <span class="hero__pre-title"><?= lang('Frontend.xin_analytics');?></span>
                        <h2 class="hero__title-2"><?= lang('Frontend.xin_bring_your_team_together');?></h2>
                        <p><?= lang('Frontend.xin_succ_move_your_employees');?></p>
                        <a href="<?= site_url('register');?>" class="w-btn w-btn-blue w-btn-7 w-btn-6"><?= lang('Frontend.xin_try_for_free');?></a>

                        <div class="hero__client mt-60">
                           <ul>
                              <li><img src="<?= base_url();?>/public/frontend/assets/img/client/home-2/client-2-1.png" alt=""></li>
                              <li><img src="<?= base_url();?>/public/frontend/assets/img/client/home-2/client-2-2.png" alt=""></li>
                              <li><img src="<?= base_url();?>/public/frontend/assets/img/client/home-2/client-2-3.png" alt=""></li>
                              <li><img src="<?= base_url();?>/public/frontend/assets/img/client/home-2/client-2-4.png" alt=""></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-6 offset-xxl-1 col-xl-6">
                     <div class="hero__thumb-2 mt-80">
                        <div class="hero__thumb-inner p-relative ml-90">
                           <img class="hero-2-thumb" width="600" height="380" src="<?= base_url();?>/public/frontend/assets/img/hero/home-2/hero-2-thumb.jpg" alt="">
                           <div class="promotion__play" style="border:2px solid #7127ea; border-radius:50%;">
                           <a href="https://www.youtube.com/watch?v=zIOsMvbkft0" data-fancybox="" class="pulse-play"><i class="arrow_triangle-right"></i></a>
                        </div>
                           <img class="hero-2-girl" src="<?= base_url();?>/public/frontend/assets/img/hero/home-2/hero-2-girl.png" alt="">
                           <img class="hero-2-thumb-sm" src="<?= base_url();?>/public/frontend/assets/img/hero/home-2/hero-2-thumb-sm.png" alt="">
                           <img class="hero-2-thumb-sm-2" src="<?= base_url();?>/public/frontend/assets/img/hero/home-2/hero-2-thumb-sm-2.png" alt="">
                           <img class="hero-2-thumb-sm-3" src="<?= base_url();?>/public/frontend/assets/img/hero/home-2/hero-2-thumb-sm-3.png" alt="">
                           <img class="hero-2-circle" src="<?= base_url();?>/public/frontend/assets/img/hero/home-2/hero-2-circle.png" alt="">
                           <img class="hero-2-circle-2" src="<?= base_url();?>/public/frontend/assets/img/hero/home-2/hero-2-circle-2.png" alt="">
                           <img class="hero-2-leaf" src="<?= base_url();?>/public/frontend/assets/img/hero/home-2/hero-2-leaf.png" alt="">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- hero area end -->
         <!-- services area start -->
         <section class="services__area grey-bg-3 pt-120 mt-0 pb-60 p-relative">
            <div class="services__shape-2">
               <img class="services-2-circle" src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-2/services-circle.png" alt="">
               <img class="services-2-circle-2" src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-2/services-circle-2.png" alt="">
            </div>
            <div class="container">
               <div class="row align-items-end">
                  <div class="col-xxl-4 col-lg-5 col-md-7">
                     <div class="section__title-wrapper mb-70 wow fadeInUp" data-wow-delay=".3s">
                        <span class="section__pre-title purple"><?= lang('Frontend.xin_reason_why');?></span>
                        <h2 class="section__title section__title-2"><?= lang('Frontend.xin_everything_in_one_hr');?></h2>
                     </div>
                  </div>
                  <div class="col-xxl-8 col-lg-7 col-md-5">
                     <div class="services__more mb-70 text-sm-end wow fadeInUp" data-wow-delay=".5s">
                        <a href="<?= site_url('features');?>" class="w-btn w-btn-blue w-btn-6 w-btn-3"><?= lang('Frontend.xin_view_more');?></a>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                     <div class="services__inner services__inner-2 hover__active mb-30">
                        <div class="services__item-2 transition-3 white-bg ">
                           <div class="services__icon-2">
                              <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-2/services-1.png" alt="">
                           </div>
                           <div class="services__content-2">
                              <h3 class="services__title-2"><a href="#!"><?= lang('Frontend.xin_workmates');?></a></h3>
                              <p><?= lang('Frontend.xin_workmates_an_employee_experience');?></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                     <div class="services__inner services__inner-2 hover__active active mb-30">
                        <div class="services__item-2 transition-3 white-bg ">
                           <div class="services__icon-2">
                              <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-2/services-2.png" alt="">
                           </div>
                           <div class="services__content-2">
                              <h3 class="services__title-2"><a href="#!"><?= lang('Frontend.xin_onboard');?></a></h3>
                              <p><?= lang('Frontend.xin_obboard_automate_entire_onboarding');?></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                     <div class="services__inner services__inner-2 hover__active mb-30">
                        <div class="services__item-2  transition-3 white-bg">
                           <div class="services__icon-2">
                              <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-2/services-3.png" alt="">
                           </div>
                           <div class="services__content-2">
                              <h3 class="services__title-2"><a href="#!"><?= lang('Frontend.xin_people_hrms');?></a></h3>
                              <p><?= lang('Frontend.xin_people_hrms_powerfull_proven');?></p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- services area end -->
         <!-- about area start -->
         <section class="about__area grey-bg-3 pt-40 pb-120 p-relative">
            <div class="about__shape-2">
               <img class="about-2-circle" src="<?= base_url();?>/public/frontend/assets/img/about/home-2/about-circle.png" alt="">
               <img class="about-2-circle-2" src="<?= base_url();?>/public/frontend/assets/img/about/home-2/about-circle-2.png" alt="">
            </div>
            <div class="container">
               <div class="row">
                  <div class="col-xxl-7 col-xl-7 col-lg-6 col-md-8">
                     <div class="about__thumb-3 wow fadeInLeft" data-wow-delay=".3s">
                        <img src="<?= base_url();?>/public/frontend/assets/img/services/01.png" alt="" width="525">
                     </div>
                  </div>
                  <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-8">
                     <div class="about__content-3 pt-55">
                        <div class="section__title-wrapper section__title-wrapper-2 mb-55 wow fadeInUp" data-wow-delay=".3s">
                           <span class="section__pre-title pink">Features</span>
                           <h2 class="section__title section__title-2"><?= lang('Frontend.xin_save_time_money');?></h2>
                           <p><?= lang('Frontend.xin_save_time_money_automated_core_hr');?></p>
                        </div>
                        <a href="<?= site_url('register');?>" class="w-btn w-btn-blue w-btn-3 w-btn-1"><?= lang('Frontend.xin_get_started');?></a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- about area end -->
         <section class="services__area p-relative pt-150 pb-130">
            <div class="services__shape">
               <img class="services-circle-1" src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-1/circle-1.png" alt="">
               <img class="services-circle-2" src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-1/circle-2.png" alt="">
               <img class="services-dot" src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-1/dot.png" alt="">
               <img class="services-triangle" src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-1/triangle.png" alt="">
            </div>
            <div class="container">
               <div class="row">
                  <div class="col-xxl-6 offset-xxl-3 col-xl-6 offset-xl-3 col-lg-6 col-md-10 offset-md-1 p-0">
                     <div class="section__title-wrapper text-center mb-75 wow fadeInUp" data-wow-delay=".3s">
                        <h2 class="section__title"><?= lang('Frontend.xin_give_most_valuable');?></h2>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                     <div class="services__inner hover__active mb-30 wow fadeInUp" data-wow-delay=".3s">
                        <div class="services__item white-bg text-center transition-3 ">
                           <div class="services__icon mb-25 d-flex align-items-end justify-content-center">
                              <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-1/services-1.png" alt="">
                           </div>
                           <div class="services__content">
                              <h3 class="services__title"><a href="#!"><?= lang('Frontend.xin_approve_requests');?></a></h3>
                              <p><?= lang('Frontend.xin_approve_requests_notifications');?></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                     <div class="services__inner hover__active active mb-30 wow fadeInUp" data-wow-delay=".5s">
                        <div class="services__item white-bg mb-30 text-center transition-3" >
                           <div class="services__icon mb-25 d-flex align-items-end justify-content-center">
                              <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-1/services-2.png" alt="">
                           </div>
                           <div class="services__content">
                              <h3 class="services__title"><a href="#!"><?= lang('Frontend.xin_track_attendance');?></a></h3>
                              <p><?= lang('Frontend.xin_track_attendance_request_approve_timeoff');?></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                     <div class="services__inner hover__active mb-30 wow fadeInUp" data-wow-delay=".9s">
                        <div class="services__item white-bg text-center transition-3">
                           <div class="services__icon mb-25 d-flex align-items-end justify-content-center">
                              <img src="<?= base_url();?>/public/frontend/assets/img/icon/services/home-1/services-4.png" alt="">
                           </div>
                           <div class="services__content">
                              <h3 class="services__title"><a href="#!"><?= lang('Frontend.xin_personal_data');?></a></h3>
                              <p><?= lang('Frontend.xin_personal_data_access_personal_data');?></p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- why area start -->
         <section class="why__area pt-135 pb-90">
            <div class="container">
               <div class="row">
                  <div class="col-xxl-7 col-xl-8 col-lg-8">
                     <div class="why__wrapper">
                        <div class="section__title-wrapper section__title-wrapper-3 mb-45 wow fadeInUp" data-wow-delay=".3s">
                           <span class="section__pre-title-img"><img src="<?= base_url();?>/public/frontend/assets/img/icon/title/why.png" alt=""></span>
                           <h2 class="section__title section__title-3"><?= lang('Frontend.xin_great_companies_hire_great_people');?></h2>
                           <p><?= lang('Frontend.xin_great_companies_hire_great_people_details_text');?></p>
                        </div>
                        <div class="why__counter">
                           <div class="row">
                              <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 wow fadeInUp" data-wow-delay=".3s">
                                 <div class="why__item text-center white-bg mb-30">
                                    <div class="why__icon mb-15">
                                       <i class="icon_star"></i>
                                    </div>
                                    <div class="why__content">
                                       <h3 class="why__title"> <span class="counter">4.9</span> <?= lang('Frontend.xin_stars');?></h3>
                                       <p><?= lang('Frontend.xin_average_rating');?></p>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 wow fadeInUp" data-wow-delay=".5s">
                                 <div class="why__item text-center white-bg mb-30">
                                    <div class="why__icon mb-15">
                                       <i class="icon_ribbon"></i>
                                    </div>
                                    <div class="why__content">
                                       <h3 class="why__title"> <span class="counter">4000</span>+</h3>
                                       <p><?= lang('Frontend.xin_global_clients');?></p>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 wow fadeInUp" data-wow-delay=".7s">
                                 <div class="why__item text-center white-bg mb-30">
                                    <div class="why__icon mb-15">
                                       <i class="icon_star"></i>
                                    </div>
                                    <div class="why__content">
                                       <h3 class="why__title"> <span class="counter">1000</span>+</h3>
                                       <p><?= lang('Frontend.xin_client_testimonials');?></p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 offset-xxl-1 col-xl-4 col-lg-4 col-md-6">
                     <div class="why__features white-bg wow fadeInUp" data-wow-delay=".9s">
                        <ul>
                           <li><?= lang('Frontend.xin_free_setup');?></li>
                           <li><?= lang('Frontend.xin_free_support');?></li>
                           <li><?= lang('Frontend.xin_free_training');?></li>
                           <li><?= lang('Frontend.xin_no_maintenance_fees');?></li>
                           <li><?= lang('Frontend.xin_free_updates');?></li>
                        </ul>
                        <a href="<?= site_url('contact');?>" class="w-btn w-btn-purple w-100"><?= lang('Frontend.xin_contact_us');?> </a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- why area end -->
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
                              <h3 class="cta__title"><?= lang('Frontend.xin_start_working_together');?></h3>
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


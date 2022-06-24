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
         <!-- sign up area start -->
         <section class="signup__area po-rel-z1 pt-100 pb-145">
            <div class="sign__shape">
               <img class="man-1" src="<?= base_url();?>/public/frontend/assets/img/icon/sign/man-3.png" alt="">
               <img class="man-2 man-22" src="<?= base_url();?>/public/frontend/assets/img/icon/sign/man-2.png" alt="">
               <img class="circle" src="<?= base_url();?>/public/frontend/assets/img/icon/sign/circle.png" alt="">
               <img class="zigzag" src="<?= base_url();?>/public/frontend/assets/img/icon/sign/zigzag.png" alt="">
               <img class="dot" src="<?= base_url();?>/public/frontend/assets/img/icon/sign/dot.png" alt="">
               <img class="bg" src="<?= base_url();?>/public/frontend/assets/img/icon/sign/sign-up.png" alt="">
               <img class="flower" src="<?= base_url();?>/public/frontend/assets/img/icon/sign/flower.png" alt="">
            </div>
            <div class="container">
               <div class="row">
                  <div class="col-xxl-8 offset-xxl-2 col-xl-8 offset-xl-2">
                     <div class="page__title-wrapper text-center mb-55">
                        <h2 class="page__title-2"><?= lang('Frontend.xin_create_a_free');?> <br> <?= lang('Frontend.xin_account');?></h2>
                        <p><?= lang('Frontend.xin_take_timehrm_for_a_spin_with_trial_account');?></p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-6 offset-xxl-3 col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                     <div class="sign__wrapper white-bg">
                        
                        <div class="sign__form">
                           <?php $attributes = array('name' => 'setup_trial', 'id' => 'setup-trial', 'autocomplete' => 'off', 'class' => 'form');?>
						   <?php $hidden = array('support_timehrm' => true);?>
                           <?= form_open('keyhrm/setup_trial', $attributes, $hidden);?>
                              <div class="sign__input-wrapper mb-25">
                                 <h5><?= lang('Main.xin_employee_first_name');?> *</h5>
                                 <div class="sign__input">
                                    <input type="text" name="first_name" placeholder="<?= lang('Main.xin_employee_first_name');?>">
                                    <i class="fal fa-user"></i>
                                 </div>
                              </div>
                              <div class="sign__input-wrapper mb-25">
                                 <h5><?= lang('Main.xin_employee_last_name');?> *</h5>
                                 <div class="sign__input">
                                    <input type="text" name="last_name" placeholder="<?= lang('Main.xin_employee_last_name');?>">
                                    <i class="fal fa-user"></i>
                                 </div>
                              </div>
                              <div class="sign__input-wrapper mb-25">
                                 <h5><?= lang('Company.xin_company_name');?> *</h5>
                                 <div class="sign__input">
                                    <input type="text" name="company_name" placeholder="<?= lang('Company.xin_company_name');?>">
                                    <i class="fal fa-user"></i>
                                 </div>
                              </div>
                              <div class="sign__input-wrapper mb-25">
                                 <h5><?= lang('Frontend.xin_email');?> *</h5>
                                 <div class="sign__input">
                                    <input type="text" name="email" placeholder="<?= lang('Frontend.xin_email');?>">
                                    <i class="fal fa-envelope"></i>
                                 </div>
                              </div>
                              <div class="sign__input-wrapper mb-10">
                                 <h5><?= lang('Main.xin_contact_number');?> *</h5>
                                 <div class="sign__input">
                                    <input type="text" name="contact_number" placeholder="<?= lang('Main.xin_contact_number');?>">
                                    <i class="fal fa-lock"></i>
                                 </div>
                              </div>
                              <div class="sign__input-wrapper mb-25">
                                 <h5><?= lang('Main.xin_employee_password');?> *</h5>
                                 <div class="sign__input">
                                    <input type="text" name="password" placeholder="<?= lang('Main.xin_employee_password');?>">
                                    <i class="fal fa-lock"></i>
                                 </div>
                              </div>
                              
                              <button class="w-btn w-btn-11 w-100"> <span></span> <?= lang('Frontend.xin_sign_up');?></button>
                              <div class="sign__new text-center mt-20">
                                 <p><?= lang('Frontend.xin_we_guarantee_100_privacy');?></p>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- sign up area end -->
      </main>
      <!-- footer area start -->
      <?php echo view('frontend/components/footer'); ?>
      <!-- footer area end -->
      <!-- JS here -->
      <?php echo view('frontend/components/htmlfooter'); ?>
   </body>
</html>
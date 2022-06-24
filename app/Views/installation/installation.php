<?php echo view('frontend/components/htmlhead'); ?>
   <body>
      <!--[if lte IE 9]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
      <![endif]-->
      
      <!-- Add your site or application content here -->  

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

      <!-- sidebar area start -->      
      <div class="body-overlay"></div>
      <!-- sidebar area end -->

      <main>


         <!-- sign up area start -->
         <section class="signup__area po-rel-z1 pt-50 pb-145">
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
                        <h2 class="page__title-2 bt-20">Setup Database Setings</h2>
                        <p><?= lang('Frontend.xin_take_timehrm_for_a_spin_with_trial_account');?></p>
                     </div>
                     <div class="page__title-wrapper text-center mb-55">
                        <h2 class="page__title-2 bt-20">Setup Database Setinasdasdasdasdasdasdadgs</h2>
                        <p><?= lang('Frontend.xin_take_timehrm_for_a_spin_with_trial_account');?></p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-6 offset-xxl-3 col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                     <div class="sign__wrapper white-bg">
                        
                        <div class="sign__form">
                           <form action="#">
                              <div class="sign__input-wrapper mb-25">
                                 <h5>Hostname <span class="text-danger">*</span></h5>
                                 <div class="sign__input">
                                    <input type="text" placeholder="localhost" value="localhost">
                                 </div>
                                 <small class="text-primary">If 'localhost' does not work, you can get the hostname from web host</small>
                              </div>
                              <div class="sign__input-wrapper mb-25">
                                 <h5>Database Username <span class="text-danger">*</span></h5>
                                 <div class="sign__input">
                                    <input type="text" value="root">
                                 </div>
                              </div>
                              <div class="sign__input-wrapper mb-25">
                                 <h5>Database Password <span class="text-danger">*</span></h5>
                                 <div class="sign__input">
                                    <input type="text">
                                 </div>
                              </div>
                              <div class="sign__input-wrapper mb-25">
                                 <h5>Database Name <span class="text-danger">*</span></h5>
                                 <div class="sign__input">
                                    <input type="text">
                                 </div>
                              </div>                              
                              <button class="w-btn w-btn-11 w-100"> <span></span>Install</button>
                              <div class="sign__new mt-20">
                                 <p class="text-danger">Please make sure the app/Config/Database.php file is writable.</p>
                                 <p><strong>Example:</strong> <code>chmod 777 app/Config/Database.php</code></p>
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
      <!-- JS here -->
      <?php echo view('frontend/components/htmlfooter'); ?>
   </body>

</html>
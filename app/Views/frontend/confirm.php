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
               <img class="circle" src="<?= base_url();?>/public/frontend/assets/img/icon/sign/circle.png" alt="">
               <img class="zigzag" src="<?= base_url();?>/public/frontend/assets/img/icon/sign/zigzag.png" alt="">
               <img class="dot" src="<?= base_url();?>/public/frontend/assets/img/icon/sign/dot.png" alt="">
            </div>
            <div class="container">
               <div class="row">
                  <div class="col-xxl-8 offset-xxl-2 col-xl-8 offset-xl-2">
                     <div class="page__title-wrapper text-center mb-55">
                        <h2 class="page__title-2"><?= lang('Frontend.xin_your_account_is_verified');?></h2>
                        <p><?= lang('Frontend.xin_you_can_login_now');?> <a href="<?= site_url('erp/login');?>"><?= lang('Frontend.xin_click_here');?></a></p>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- sign up area end -->
      </main>
      <!-- footer area end -->
      <!-- JS here -->
      <?php echo view('frontend/components/htmlfooter'); ?>
   </body>
</html>
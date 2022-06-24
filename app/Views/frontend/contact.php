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
                        <h3><?= lang('Frontend.xin_contact_us');?> </h3>
                           <nav aria-label="breadcrumb">
                              <ol class="breadcrumb justify-content-center">
                                 <li class="breadcrumb-item"><a href="<?= site_url('');?>"><?= lang('Frontend.xin_home');?></a></li>
                                 <li class="breadcrumb-item active" aria-current="page"><?= lang('Frontend.xin_contact_us');?></li>
                              </ol>
                           </nav>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- page title area end -->
          <!-- contact area start  -->
          <section class="contact__area pb-150 p-relative z-index-1">
             <div class="container">
                <div class="row">
                   <div class="col-xxl-10 offset-xxl-1 col-xl-10 offset-xl-1 col-lg-10 offset-lg-1">
                      <div class="contact__wrapper white-bg mt--70 p-relative z-index-1 wow fadeInUp" data-wow-delay=".3s">
                         <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                               <div class="contact__info pr-80">
                                  <h3 class="contact__title"><?= lang('Frontend.xin_get_in_touch');?></h3>
                                  <div class="contact__details">
                                     <ul>
                                        <li>
                                           <h4><?= lang('Frontend.xin_visit_our_office_at');?></h4>
                                           <p><?= lang('Frontend.xin_office_address');?></p>
                                        </li>
                                        <li>
                                           <h4><?= lang('Frontend.xin_support_email');?></h4>
                                           <p><a href="#">info@timehrm.om</a></p>
                                        </li>
                                     </ul>
                                  </div>
                               </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                               <div class="contact__form">
                                  <?php $attributes = array('name' => 'contact_form', 'id' => 'support-form', 'autocomplete' => 'off', 'class' => 'form');?>
								  <?php $hidden = array('support_timehrm' => true);?>
                                  <?= form_open('keyhrm/send_contact', $attributes, $hidden);?>
                                     <input type="text" name="full_name" placeholder="<?= lang('Main.xin_name');?>">
                                     <input type="text" name="email" placeholder="<?= lang('Main.xin_email');?>">
                                     <input type="text" name="subject" placeholder="<?= lang('Main.xin_subject');?>">
                                     <textarea name="message" placeholder="<?= lang('Frontend.xin_your_message');?>"></textarea>
                                     <button type="submit" class="w-btn w-btn-blue-5 w-btn-6 w-btn-14"><?= lang('Frontend.xin_send_message');?></button>
                                  <?= form_close(); ?>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </section>
          <!-- contact area end  -->
      </main>
      <!-- footer area start -->
      <?php echo view('frontend/components/footer'); ?>
      <!-- footer area end -->
      <!-- JS here -->
      <?php echo view('frontend/components/htmlfooter'); ?>
   </body>
</html>
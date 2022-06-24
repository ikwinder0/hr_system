<?php $back_asset_url = '../public/assets';?>
<?php $asset_url = '../public/frontend/assets';?>
<!doctype html>
<html class="no-js" lang="zxx">
   
<head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>HRSALE - Installation</title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Place favicon.ico in the root directory -->
      <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
      <!-- CSS here -->
      <link rel="stylesheet" href="<?= $asset_url;?>/css/preloader.css">
      <link rel="stylesheet" href="<?= $asset_url;?>/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?= $asset_url;?>/css/meanmenu.css">
      <link rel="stylesheet" href="<?= $asset_url;?>/css/animate.min.css">
      <link rel="stylesheet" href="<?= $asset_url;?>/css/owl.carousel.min.css">
      <link rel="stylesheet" href="<?= $asset_url;?>/css/backToTop.css">
      <link rel="stylesheet" href="<?= $asset_url;?>/css/jquery.fancybox.min.css">
      <link rel="stylesheet" href="<?= $asset_url;?>/css/fontAwesome5Pro.css">
      <link rel="stylesheet" href="<?= $asset_url;?>/css/elegantFont.css">
      <link rel="stylesheet" href="<?= $asset_url;?>/css/default.css">
      <link rel="stylesheet" href="<?= $asset_url;?>/css/style.css">
      <link rel="stylesheet" href="<?= $back_asset_url;?>/plugins/toastr/toastr.css">
   </head>
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
      <div class="body-overlay"></div>
      <!-- sidebar area end -->

      <main>


         <!-- sign up area start -->
         <section class="signup__area po-rel-z1 pt-50 pb-145">
            <div class="sign__shape">
               <img class="man-1" src="<?= $asset_url;?>/img/icon/sign/man-3.png" alt="">
               <img class="man-2 man-22" src="<?= $asset_url;?>/img/icon/sign/man-2.png" alt="">
               <img class="circle" src="<?= $asset_url;?>/img/icon/sign/circle.png" alt="">
               <img class="zigzag" src="<?= $asset_url;?>/img/icon/sign/zigzag.png" alt="">
               <img class="dot" src="<?= $asset_url;?>/img/icon/sign/dot.png" alt="">
               <img class="bg" src="<?= $asset_url;?>/img/icon/sign/sign-up.png" alt="">
               <img class="flower" src="<?= $asset_url;?>/img/icon/sign/flower.png" alt="">
            </div>
            <div class="container">
               <div class="row">
                  <div class="col-xxl-8 offset-xxl-2 col-xl-8 offset-xl-2">
                     <div class="page__title-wrapper text-center">
                        <img class="man-1" src="assets/img/hrsale_logo.png" alt="">
                     </div>
					 <div class="page__title-wrapper text-center mt-20 mb-55">
						<p>Setup database setings</p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-6 offset-xxl-3 col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                     <div class="sign__wrapper white-bg">
                        <div class="sign__form">
                           <form id="install-app" action="install_app.php" method="post" autocomplete="off">
                              <div class="sign__input-wrapper mb-25">
                                 <h5>Hostname <span class="text-danger">*</span></h5>
                                 <div class="sign__input">
                                    <input type="text" name="hostname" value="localhost">
                                    <i class="fal fa-server"></i>
                                 </div>
                                 <small class="text-primary">If 'localhost' does not work, you can get the hostname from web host</small>
                              </div>
                              <div class="sign__input-wrapper mb-25">
                                 <h5>Database Username <span class="text-danger">*</span></h5>
                                 <div class="sign__input">
                                    <input type="text" value="root" name="username">
                                    <i class="fal fa-user-plus"></i>
                                 </div>
                              </div>
                              <div class="sign__input-wrapper mb-25">
                                 <h5>Database Password <span class="text-danger">*</span></h5>
                                 <div class="sign__input">
                                    <input type="password" name="password">
                                    <i class="fal fa-lock"></i>
                                 </div>
                              </div>
                              <div class="sign__input-wrapper mb-25">
                                 <h5>Database Name <span class="text-danger">*</span></h5>
                                 <div class="sign__input">
                                    <input type="text" name="database">
                                    <i class="fal fa-database"></i>
                                 </div>
                              </div>                              
                              <button class="w-btn w-btn-11 w-100" type="submit"> <span></span>Install</button>
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


      <!-- footer area start -->
      <footer class="footer__area grey-bg-3 p-relative fix">        
         <div class="footer__bottom">
            <div class="container">
               <div class="footer__copyright">
                  <div class="row">
                     <div class="col-xxl-12 wow fadeInUp" data-wow-delay=".5s">
                        <div class="footer__copyright-wrapper footer__copyright-wrapper-2 text-center">
                           <p>Copyright © <?= date('Y');?> All Rights Reserved - HRSALE</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- footer area end -->

      <!-- JS here -->
      <script src="<?= $asset_url;?>/js/vendor/jquery-3.5.1.min.js"></script>
      <script src="<?= $asset_url;?>/js/vendor/waypoints.min.js"></script>
      <script src="<?= $asset_url;?>/js/bootstrap.bundle.min.js"></script>
      <script src="<?= $asset_url;?>/js/jquery.meanmenu.js"></script>
      <script src="<?= $asset_url;?>/js/owl.carousel.min.js"></script>
      <script src="<?= $asset_url;?>/js/jquery.fancybox.min.js"></script>
      <script src="<?= $asset_url;?>/js/isotope.pkgd.min.js"></script>
      <script src="<?= $asset_url;?>/js/parallax.min.js"></script>
      <script src="<?= $asset_url;?>/js/backToTop.js"></script>
      <script src="<?= $asset_url;?>/js/jquery.counterup.min.js"></script>
      <script src="<?= $asset_url;?>/js/ajax-form.js"></script>
      <script src="<?= $asset_url;?>/js/wow.min.js"></script>
      <script src="<?= $asset_url;?>/js/imagesloaded.pkgd.min.js"></script>
      <script src="<?= $asset_url;?>/js/main.js"></script>
      <script src="<?= $back_asset_url;?>/plugins/spin/spin.js"></script>
      <script src="<?= $back_asset_url;?>/plugins/ladda/ladda.js"></script>
      <script src="<?= $back_asset_url;?>/plugins/toastr/toastr.js"></script>
      <script type="text/javascript">
		$(document).ready(function(){
			toastr.options.closeButton = true;
			toastr.options.progressBar = true;
			toastr.options.timeOut = 2000;
			toastr.options.preventDuplicates = true;
			toastr.options.positionClass = "toast-top-center";
			Ladda.bind('button[type=submit]');
			$('.reset').prop('disabled', true);
			$("#install-app").submit(function(e){
			e.preventDefault();
				var obj = $(this), action = obj.attr('name');
				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize()+"&is_ajax=1&type=install&form="+action,
					cache: false,
					success: function (JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_token"]').val(JSON.csrf_hash);
							$('.reset').prop('disabled', false);
							Ladda.stopAll();
						} else {
							toastr.success(JSON.result);
							$('input[name="csrf_token"]').val(JSON.csrf_hash);
							Ladda.stopAll();
							$('.reset').prop('disabled', false);
							window.location = 'finalizing_setup.php';
						}
					}
				});
			});
		});
	</script>
   </body>

</html>
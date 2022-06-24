<?php session_start(); ?>
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
               <img class="man-1" src="<?= $asset_url;?>/img/icon/sign/man-1.png" alt="">
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
                  </div>
               </div>
               <div class="row">
                  <div class="col-xxl-8 offset-xxl-2 col-xl-8 offset-xl-2 col-lg-8 offset-lg-2">
                     <div class="sign__wrapper white-bg">
                        <div class="alert alert-success" role="alert">
							<h4 class="alert-heading">Well done!</h4>
							<p>Congratulations!! The installation was successfull.</p>
						</div>
                        <p class="mb-0">Please login to continue..</p><hr>
                        <p><strong>Administrator Username: </strong><?php echo $_SESSION['admin_username'];?></p>
                        <p><strong>Password: </strong>Your chosen password</p>
                        <?php    
						 $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
						 $redir .= "://".$_SERVER['HTTP_HOST'];
						 $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
						 $redir = str_replace('installation/','',$redir); 
						 
						?>
                        <a href="<?php echo $redir .'erp/login' ?>" class="btn btn-success">Go to Login Page</a>
                        <div class="alert alert-danger mt-20" role="alert">
							For your own security. Please Delete or rename installation folder
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
   </body>

</html>
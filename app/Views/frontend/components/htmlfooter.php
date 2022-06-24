<script src="<?= base_url();?>/public/frontend/assets/js/vendor/jquery-3.5.1.min.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/vendor/waypoints.min.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/jquery.meanmenu.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/owl.carousel.min.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/jquery.fancybox.min.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/isotope.pkgd.min.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/parallax.min.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/backToTop.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/jquery.counterup.min.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/ajax-form.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/wow.min.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/imagesloaded.pkgd.min.js"></script>
<script src="<?= base_url();?>/public/frontend/assets/js/main.js"></script>
<script src="<?= base_url();?>/public/assets/plugins/spin/spin.js"></script>
<script src="<?= base_url();?>/public/assets/plugins/ladda/ladda.js"></script>
<script src="<?= base_url();?>/public/assets/plugins/toastr/toastr.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = true;
	toastr.options.progressBar = true;
	toastr.options.timeOut = 2000;
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "toast-top-center";
	Ladda.bind('button[type=submit]');
	$("#support-form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=contact&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
					window.location = '';
				}
			}
		});
	});
	$("#setup-trial").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=add_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
					window.location = 'thankyou';
				}
			}
		});
	});
});
</script>
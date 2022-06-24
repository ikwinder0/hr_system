<?php
use App\Models\SystemModel;
$SystemModel = new SystemModel();
$xin_system = $SystemModel->where('setting_id', 1)->first();
$favicon = base_url().'/public/uploads/logo/favicon/'.$xin_system['favicon'];
$session = \Config\Services::session();
$request = \Config\Services::request();
$username = $session->get('sup_username');
?>
<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
					<div class="card-body">
						<!--<img src="<?= base_url();?>/public/uploads/logo/other/<?= $xin_system['other_logo'];?>" height="40" width="138" alt="" class="img-fluid mb-4">-->
						 <h2>HR SYSTEM</h2>
                          <p class="text-muted">
                            <?= lang('Login.xin_welcome_back_please_login');?>
                          </p>
                        <?php $attributes = array('class' => 'form-timehrm', 'name' => 'erp-form', 'id' => 'erp-form', 'autocomplete' => 'off');?>
						<?php $hidden = array('user_id' => 0);?>
                        <?= form_open('erp/auth/login', $attributes, $hidden);?>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text"><i data-feather="user"></i></span>
							</div>
							<input type="text" class="form-control" name="iusername" id="iusername" placeholder="<?= lang('Login.xin_login_username');?>">
						</div>
						<div class="input-group mb-4">
							<div class="input-group-prepend">
								<span class="input-group-text"><i data-feather="lock"></i></span>
							</div>
							<input type="password" class="form-control" name="password" id="password" placeholder="<?= lang('Login.xin_login_enter_password');?>">
						</div>
						<button class="btn btn-block btn-primary mb-4" type="submit"><i class="fas fa-user-lock d-blockd"></i> <?= lang('Login.xin_login');?></button>
                        <?= form_close(); ?>
						<p class="mb-2 text-muted"><a href="<?= site_url('erp/forgot-password');?>" class="f-w-400"><?= lang('Login.xin_forgot_password_link');?></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
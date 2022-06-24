<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;

$SystemModel = new SystemModel();
$UserRolesModel = new RolesModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$router = service('router');
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();
$language = $LanguageModel->where('is_active', 1)->orderBy('language_id', 'ASC')->findAll();
if($user['user_type'] == 'super_user'){
	$xin_system = $SystemModel->where('setting_id', 1)->first();
} else {
	$xin_system = erp_company_settings();
}
$ci_erp_settings = $SystemModel->where('setting_id', 1)->first();
$xin_com_system = erp_company_settings();
?>
<?php
$session_lang = $session->lang;
if(!empty($session_lang)):
	$lang_code = $LanguageModel->where('language_code', $session_lang)->first();
	$flg_icn = '<img src="'.base_url().'/public/uploads/languages_flag/'.$lang_code['language_flag'].'">';
	$lg_code = $session_lang;
elseif($xin_system['default_language']!=''):
	$lg_code = $xin_system['default_language'];
	$lang_code = $LanguageModel->where('language_code', $xin_system['default_language'])->first();
	$flg_icn = '<img src="'.base_url().'/public/uploads/languages_flag/'.$lang_code['language_flag'].'">';
else:
	$flg_icn = '<img src="'.base_url().'/public/uploads/languages_flag/gb.gif">';	
endif;
if($user['user_type'] == 'super_user'){
	$bg_option = 'bg-dark';
} else if($user['user_type'] == 'company'){
	if($xin_com_system['header_background'] == ''){
		$bg_option = 'bg-dark';
	} else {
		$bg_option = $xin_com_system['header_background'];
	}
} else if($user['user_type'] == 'customer'){
	if($xin_com_system['header_background'] == ''){
		$bg_option = 'bg-dark';
	} else {
		$bg_option = $xin_com_system['header_background'];
	}
} else {
	$bg_option = 'bg-dark';
}
$setup_modules = unserialize($xin_com_system['setup_modules']);
?>
<header class="pc-header <?= $bg_option;?>">
    <div class="header-wrapper">
       <?php if($user['user_type'] == 'super_user' || $user['user_type'] == 'company' || $user['user_type'] == 'customer' || $user['user_type'] == 'staff'){ ?>
        <div class="m-header d-flex align-items-center">
            <a href="<?= site_url('erp/desk');?>" class="b-brand">
                <!--<img src="<?= base_url();?>/public/uploads/logo/<?= $ci_erp_settings['logo'];?>" alt="" class="logo logo-lg" height="40" width="138">-->
                HR SYSTEM
            </a>
        </div>
        <?php } ?>
        <div class="mr-auto pc-mob-drp">
            <ul class="list-unstyled">
                <?php if($user['user_type']!= 'customer' && $user['user_type']!= 'super_user'){ ?>
                <li class="pc-h-item">
                    <a class="pc-head-link active arrow-none mr-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Main.xin_account_settings');?>" href="<?= site_url('erp/my-profile');?>">
                        <i data-feather="user-check"></i>
                    </a>
                </li> 
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link active dropdown-toggle arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <span  data-toggle="tooltip" data-placement="top" title="<?= lang('Dashboard.xin_apps');?>"><?= lang('Dashboard.xin_apps');?></span>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown">
                     	<?php if(isset($setup_modules['travel'])): if($setup_modules['travel']==1):?>
                        <?php if($user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/business-travel');?>" class="dropdown-item">
                            <i data-feather="globe"></i>
                            <span><?= lang('Dashboard.left_travels');?></span>
                        </a>
                        <?php } ?>
                        <?php endif; endif;?>
                        <?php if(isset($setup_modules['events'])): if($setup_modules['events']==1):?>
                        <?php if(in_array('hr_event1',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/events-list');?>" class="dropdown-item">
                            <i data-feather="disc"></i>
                            <span><?= lang('Dashboard.xin_hr_events');?></span>
                        </a>
                        <?php } ?>
                        <?php endif; endif;?>
						<?php if(in_array('holiday1',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/holidays-list');?>" class="dropdown-item">
                            <i data-feather="sun"></i>
                            <span><?= lang('Dashboard.left_holidays');?></span>
                        </a>
                        <?php } ?>
						<?php if(in_array('visitor1',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/visitors-list');?>" class="dropdown-item">
                            <i data-feather="user-plus"></i>
                            <span><?= lang('Main.xin_visitor_book');?></span>
                        </a>
                        <?php } ?>
                        <?php if(isset($setup_modules['events'])): if($setup_modules['events']==1):?>
                        <?php if(in_array('conference1',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/meeting-list');?>" class="dropdown-item">
                            <i data-feather="calendar"></i>
                            <span><?= lang('Dashboard.xin_hr_meetings');?></span>
                        </a>
                        <?php } ?>
                        <?php endif; endif;?>
                        <?php if(isset($setup_modules['fmanager'])): if($setup_modules['fmanager']==1):?>
						<?php if(in_array('file1',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/upload-files');?>" class="dropdown-item">
                            <i data-feather="file-plus"></i>
                            <span><?= lang('Dashboard.xin_upload_files');?></span>
                        </a>
                        <?php } ?>
                        <?php endif; endif;?>
                        <div class="dropdown-divider"></div>
						<?php if(in_array('asset1',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/assets-list');?>" class="dropdown-item">
                            <i data-feather="command"></i>
                            <span><?= lang('Dashboard.xin_assets');?></span>
                        </a>
                        <?php } ?>
                        <?php if(isset($setup_modules['award'])): if($setup_modules['award']==1):?>
						<?php if(in_array('award1',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/awards-list');?>" class="dropdown-item">
                            <i data-feather="award"></i>
                            <span><?= lang('Dashboard.left_awards');?></span>
                        </a>
                        <?php } ?>
                        <?php endif; endif;?>
                        <?php if(in_array('transfers1',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/transfers-list');?>" class="dropdown-item">
                            <i data-feather="minimize-2"></i>
                            <span><?= lang('Dashboard.left_transfers');?></span>
                        </a>
                        <?php } ?>
						<?php if(in_array('complaint1',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/complaints-list');?>" class="dropdown-item">
                            <i data-feather="edit"></i>
                            <span><?= lang('Dashboard.left_complaints');?></span>
                        </a>
                        <?php } ?>
						<?php if(in_array('resignation1',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/resignation-list');?>" class="dropdown-item">
                            <i data-feather="user-minus"></i>
                            <span><?= lang('Dashboard.left_resignations');?></span>
                        </a>
                       <?php } ?> 
                       <?php if(in_array('custom_fields',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/custom-fields');?>" class="dropdown-item">
                            <i data-feather="file-text"></i>
                            <span><?= lang('Main.xin_custom_fields');?></span>
                        </a>
                        <?php } ?>
                       <div class="dropdown-divider"></div>
                       <?php if(in_array('settings5',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/system-backup');?>" class="dropdown-item">
                            <i data-feather="download-cloud"></i>
                            <span><?= lang('Main.header_db_log');?></span>
                        </a>
                       <?php } ?>
                       <?php if(in_array('settings6',staff_role_resource()) || $user['user_type']== 'company') {?>
                        <a href="<?= site_url('erp/currency-converter');?>" class="dropdown-item">
                            <i data-feather="pocket"></i>
                            <span><?= lang('Main.xin_currency_converter');?></span>
                        </a>
                       <?php } ?>
                    </div>
                </li>
                <?php if(in_array('system_calendar',staff_role_resource()) || $user['user_type']== 'company') {?>
                <li class="pc-h-item">
                    <a class="pc-head-link active arrow-none mr-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Dashboard.xin_system_calendar');?>" href="<?= site_url('erp/system-calendar');?>">
                        <i data-feather="calendar"></i>
                    </a>
                </li> 
                <?php } ?>
				<?php if(in_array('system_reports',staff_role_resource()) || $user['user_type']== 'company') {?>
                <li class="pc-h-item">
                    <a class="pc-head-link active arrow-none mr-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Dashboard.xin_system_reports');?>" href="<?= site_url('erp/system-reports');?>">
                        <i data-feather="pie-chart"></i>
                    </a>
                </li>
                <?php } ?>
                <?php if(in_array('settings1',staff_role_resource()) || $user['user_type']== 'company') {?>
                <li class="pc-h-item">
                    <a class="pc-head-link active arrow-none mr-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Main.xin_configuration_wizard');?>" href="<?= site_url('erp/system-settings');?>">
                        <i data-feather="settings"></i>
                    </a>
                </li> 
                <?php } ?>
				<?php } if($user['user_type']== 'customer') {?>
                <li class="pc-h-item">
                    <a class="pc-head-link active arrow-none mr-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Dashboard.xin_acc_calendar');?>" href="<?= site_url('erp/my-invoices-calendar');?>">
                        <i data-feather="calendar"></i>
                    </a>
                </li>    
                <?php } if($user['user_type']== 'super_user') {?>
                <li class="pc-h-item">
                    <a class="pc-head-link active arrow-none mr-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Dashboard.xin_my_account');?>" href="<?= site_url('erp/my-profile');?>">
                        <i data-feather="user"></i>
                    </a>
                </li>    
                <li class="pc-h-item">
                    <a class="pc-head-link active arrow-none mr-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Main.xin_frontend_landing');?>" href="<?= site_url('');?>" target="_blank">
                        <i data-feather="layout"></i>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="ml-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <?= $flg_icn;?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pc-h-dropdown">
                        <?php foreach($language as $lang):?>
                        <a href="<?= site_url('erp/set-language/');?><?= $lang['language_code'];?>" class="dropdown-item">
                            <img src="<?= base_url();?>/public/uploads/languages_flag/<?= $lang['language_flag'];?>" width="16" height="11" />
                            <span><?= $lang['language_name'];?></span>
                        </a>
                        <?php endforeach;?>
                    </div>
                </li>
                <?php if(in_array('todo_ist',staff_role_resource()) || $user['user_type']== 'company' || $user['user_type']== 'customer' || $user['user_type']== 'super_user') {?>
                <li class="pc-h-item">
                    <a class="pc-head-link mr-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Main.xin_todo_ist');?>" href="<?= site_url('erp/todo-list');?>">
                        <i data-feather="check-circle"></i>
                        <span class="sr-only"></span>
                    </a>
                </li>
                <?php }?>
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="<?= staff_profile_photo($user['user_id']);?>" alt="" class="user-avtar">
                        <span>
                            <span class="user-name"><?= $user['first_name'].' '.$user['last_name'];?></span>
                            <span class="user-desc"><?= $user['username']?></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pc-h-dropdown">
                        <div class=" dropdown-header">
                            <h6 class="text-overflow m-0"><?= lang('Dashboard.xin_welcome');?></h6>
                        </div>
                        <a href="<?= site_url('erp/my-profile');?>" class="dropdown-item">
                            <i data-feather="user"></i>
                            <span><?= lang('Dashboard.xin_my_account');?></span>
                        </a>
                        <a href="<?= site_url('erp/system-logout')?>" class="dropdown-item">
                            <i data-feather="power"></i>
                            <span><?= lang('Main.xin_logout');?></span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
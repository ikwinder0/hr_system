<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the TimeHRM License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.timehrm.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to timehrm.official@gmail.com so we can send you a copy immediately.
 *
 * @author   TimeHRM
 * @author-email  timehrm.official@gmail.com
 * @copyright  Copyright © timehrm.com All Rights Reserved
 */
namespace App\Controllers;
use App\Controllers\BaseController;
 
use App\Models\SystemModel;

class Home extends BaseController {

	public function index()
	{		
		$SystemModel = new SystemModel();
		$session = \Config\Services::session();
		if($session->has('sup_username')){ 
			return redirect()->to(site_url('erp/desk?module=dashboard'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = $xin_system['application_name'].' | '.lang('Login.xin_login_title');
		return view('erp/auth/erp_login',$data);
	}
}

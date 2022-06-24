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
namespace App\Controllers\Erp;
use App\Controllers\BaseController;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
 
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\MembershipModel;


class Subscription extends BaseController {
	
	public function index()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Membership.xin_my_subscription').' | '.$xin_system['application_name'];
		$data['path_url'] = 'membership';
		$data['breadcrumbs'] = lang('Membership.xin_my_subscription');
		$data['subview'] = view('erp/membership/key_membership', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function subscription_expired()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Membership.xin_membership_plans').' | '.$xin_system['application_name'];
		$data['path_url'] = 'membership';
		$data['breadcrumbs'] = lang('Membership.xin_membership_plans');
		$data['subview'] = view('erp/membership/key_subscription_expired', $data);
		$session->destroy();
		return view('erp/layout/expired_layout_main', $data); //page load
		
	}
	public function more_subscriptions()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Membership.xin_membership_plans').' | '.$xin_system['application_name'];
		$data['path_url'] = 'membership';
		$data['breadcrumbs'] = lang('Membership.xin_membership_plans');
		$data['subview'] = view('erp/membership/key_more_membership', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function upgrade_subscription()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$usession = $session->get('sup_username');
		$MembershipModel = new MembershipModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $MembershipModel->where('membership_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_upgrade').' | '.$xin_system['application_name'];
		$data['path_url'] = 'membership';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_upgrade');
		$data['subview'] = view('erp/membership/key_subscription', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
}

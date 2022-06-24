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
 
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\InvoicepaymentsModel;
use App\Models\MembershipModel;

class Paymenthistory extends BaseController {

	public function index()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Invoices.xin_billing_invoices').' | '.$xin_system['application_name'];
		$data['path_url'] = 'payment_history';
		$data['breadcrumbs'] = lang('Invoices.xin_billing_invoices');

		$data['subview'] = view('erp/invoices/payment_history_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function billing_details()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$InvoicepaymentsModel = new InvoicepaymentsModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $InvoicepaymentsModel->where('membership_invoice_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Invoices.xin_view_invoice').' | '.$xin_system['application_name'];
		$data['path_url'] = 'payment_details';
		$data['breadcrumbs'] = lang('Invoices.xin_view_invoice');

		$data['subview'] = view('erp/invoices/payment_details', $data);
		return view('erp/layout/pre_layout_main', $data); //page load
	}
	// list
	public function payment_history_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');	
		$InvoicepaymentsModel = new InvoicepaymentsModel();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$MembershipModel = new MembershipModel();
		$billing = $InvoicepaymentsModel->where('company_id',$usession['sup_user_id'])->orderBy('membership_invoice_id', 'ASC')->findAll();
		$xin_system = erp_company_settings();
		
		$data = array();
		
          foreach($billing as $r) {						
		  	
			$membership = $MembershipModel->where('membership_id', $r['membership_id'])->first();
			$company = $UsersModel->where('user_id', $r['company_id'])->first();
			if($r['subscription'] == 'monthly'){
				$subscription = '<span class="text-success">'.lang('Membership.xin_subscription_monthly').'</span>';
			} else {
				$subscription = '<span class="text-info">'.lang('Membership.xin_subscription_yearly').'</span>';
			}
			$mp_subs = $membership['membership_type'];	
			$price = number_to_currency($r['membership_price'], $xin_system['default_currency'],null,2);

			$transaction_date = set_date_format($r['transaction_date']);
			if($r['payment_method'] == 'Stripe'){
				$invoice_url = $r['receipt_url'];
				$target_blnk = 'target="_blank"';
				$logo = '<i class="fab fa-cc-'.$r['source_info'].'"></i>';
			} else {
				$invoice_url = site_url('erp/payment-details').'/'.uencode($r['membership_invoice_id']);
				$logo = '<i class="fab fa-cc-paypal text-primary"></i>';
				$target_blnk = 'target="_blank"';
			}
			$invoice_id = '<a target="_blank" href="'.site_url('erp/payment-details').'/'.uencode($r['membership_invoice_id']).'"><span>'.$r['invoice_id'].'</span></a>';					 			  			$links = '
				'.$invoice_id.'
				<div class="overlay-edit">
					<a '.$target_blnk.' href="'.$invoice_url . '"><button type="button" class="btn btn-sm btn-icon btn-light-primary"><i class="feather icon-download"></i></button></a>
				</div>
			';
			$data[] = array(
				$links,
				$company['company_name'],
				$mp_subs,
				$price,
				$logo.' '.$r['payment_method'],
				$transaction_date,
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
}

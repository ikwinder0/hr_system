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

class Membershipinvoices extends BaseController {

	public function index()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Invoices.xin_billing_invoices').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoice_payments';
		$data['breadcrumbs'] = lang('Invoices.xin_billing_invoices');

		$data['subview'] = view('erp/invoices/invoice_payment_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function billing_details()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
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
		$data['path_url'] = 'billing_detail';
		$data['breadcrumbs'] = lang('Invoices.xin_view_invoice');

		$data['subview'] = view('erp/invoices/billing_details', $data);
		return view('erp/layout/pre_layout_main', $data); //page load
	}
	// list
	public function billing_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');	
		$InvoicepaymentsModel = new InvoicepaymentsModel();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$MembershipModel = new MembershipModel();
		$billing = $InvoicepaymentsModel->orderBy('membership_invoice_id', 'ASC')->findAll();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
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
				$invoice_url = site_url('erp/billing-detail').'/'.uencode($r['membership_invoice_id']);
				$logo = '<i class="fab fa-cc-paypal text-primary"></i>';
				$target_blnk = '';
			}
			$invoice_id = '<a target="_blank" href="'.site_url('erp/billing-detail').'/'.uencode($r['membership_invoice_id']).'"><span>'.$r['invoice_id'].'</span></a>';					 			  			$links = '
				'.$invoice_id.'
				<div class="overlay-edit">
					<a target="_blank" '.$target_blnk.' href="'.$invoice_url . '"><button type="button" class="btn btn-sm btn-icon btn-light-primary"><i class="feather icon-download"></i></button></a>
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
	 public function membership_invoice_amount_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();		
		/* Define return | here result is used to return user data and error for error message *///
		$Return = array('invoice_amount'=>'', 'paid_invoice'=>'','unpaid_invoice'=>'', 'paid_inv_label'=>'','unpaid_inv_label'=>'');
		$invoice_month = array();
		$paid_invoice = array();
		$someArray = array();
		$j=0;
		for ($i = 0; $i <= 11; $i++) 
		{
		   $months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));		   
		   $paid_amount = company_paid_invoices($months);
		   $paid_invoice[] = $paid_amount;
		   $invoice_month[] = $months;		   
		}
		$Return['invoice_month'] = $invoice_month;
		$Return['paid_inv_label'] = lang('Invoices.xin_paid_invoices');
		$Return['paid_invoice'] = $paid_invoice;
		$Return['total_payment'] = lang('Invoices.xin_payment');
		$this->output($Return);
		exit;
	}
}

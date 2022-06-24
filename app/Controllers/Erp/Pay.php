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
use App\Models\MainModel;
use App\Models\UsersModel;
use App\Models\ConstantsModel;
use App\Models\MembershipModel;
use App\Models\InvoicepaymentsModel;
use App\Models\CompanymembershipModel;
use App\Models\CompanysettingsModel;

class Pay extends BaseController {

	//Paypal Process
	public function paypal_process($param1 = '',$param2='',$param3='',$param4='')
    {
        $validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		//use App\Models\SystemModel;
		
		
		$ipaypal = 1;
		$ipaypal_invid = 2;
		
		if ($param1 == '') {
         
            /****TRANSFERRING USER TO PAYPAL****/
			$token = $this->request->getPost('token',FILTER_SANITIZE_STRING);
			$paypal_info = $this->request->getPost('paypal_info',FILTER_SANITIZE_STRING);
			
			$pay_token = udecode($token);
			$user_id = udecode($paypal_info);
			
			$paypal = new \Config\Paypal();
			$SystemModel = new SystemModel();
			$CompanysettingsModel = new CompanysettingsModel();
			$ipn_info = $paypal->validate_ipn();
			//$paypal = new Paypal();
			//$invoice = read_invoice_record($invoice_id);
			//$system_settings = system_settings_info(1);
			$MembershipModel = new MembershipModel();
			$xin_system = erp_company_settings();
			$company_settings = $CompanysettingsModel->where('company_id', $usession['sup_user_id'])->first();
			$xin_super_system = $SystemModel->where('setting_id', 1)->first();
			$result = $MembershipModel->where('membership_id', $pay_token)->first();
			$converted = currency_converter($result['price']);
			//echo "'".$xin_system['default_currency']."'"; exit;
			$default_currency = "'".$xin_system['default_currency']."'";
            $paypal->add_field('rm','0'); 
           // $paypal->add_field('no_note', 0);
			//$paypal->add_field('cmd','_express');
            $paypal->add_field('item_name', $result['membership_type']);
            $paypal->add_field('amount',$converted);
			$paypal->add_field('invoice',$token);
			$paypal->add_field('custom',$token);
			$paypal->add_field('cn', 'After payment please click on Merchant button for redirection to TimeHRM');
			$paypal->add_field('currency_code', $xin_system['default_currency']);
            $paypal->add_field('business', $company_settings['paypal_email']);
            $paypal->add_field('notify_url', site_url() . 'erp/pay/paypal_process/paypal_ipn/'.$token);
            $paypal->add_field('cancel_return', site_url() . 'erp/pay/paypal_process/paypal_cancel/'.$token);
            $paypal->add_field('return', site_url() . 'erp/pay/paypal_process/paypal_success/'.$token.'/'.$paypal_info);
            
            $paypal->submit_paypal_post();
            // submit the fields to paypal
        }
        if ($param1 == 'paypal_ipn') {
            if ($paypal->validate_ipn() == true) {	
						       
           }
        }
        if ($param1 == 'paypal_cancel') {
			$session->setFlashdata('paypal_payment_error_status',lang('Membership.xin_paypal_cancel_text'));
			return redirect()->to(site_url('erp/subscription-list'));
        }
		if ($param1 == 'paypal_success') {
			
			// Membership details
			$segment_id1 = udecode($request->uri->getSegment(5));
			$segment_id2 = udecode($request->uri->getSegment(6));
			$payerID = $this->request->getGet('PayerID');

			$UsersModel = new UsersModel();
			$MembershipModel = new MembershipModel();
			$result = $MembershipModel->where('membership_id', $segment_id1)->first();		
			$converted = currency_converter($result['price']);
			$data = [
				'invoice_id'  => $payerID,
				'company_id' => $usession['sup_user_id'],
				'membership_id'  => $result['membership_id'],
				'subscription_id'  => $result['subscription_id'],
				'membership_type'  => $result['membership_type'],
				'subscription'  => $result['plan_duration'],
				'description'  => $result['description'],
				'membership_price'  => $converted,
				'payment_method'  => 'PayPal',
				'invoice_month'  => date('Y-m'),
				'transaction_date'  => date('Y-m-d h:i:s'),
				'created_at' => date('Y-m-d h:i:s'),
				'receipt_url'  => 'paypal invoice',
				'source_info'  => 'paypal',
			];
		  $InvoicepaymentsModel = new InvoicepaymentsModel();
		  $InvoicepaymentsModel->insert($data);
		  $data2 = array(
			'membership_id'  => $result['membership_id'],
			'subscription_type'  => $result['plan_duration'],
			'update_at' => date('Y-m-d h:i:s'),
			);
			$MainModel = new MainModel();
			$MainModel->update_company_membership($data2,$usession['sup_user_id']);
		  $session->setFlashdata('payment_made_successfully',lang('Membership.payment_made_successfully'));
		  return redirect()->to(site_url('erp/my-subscription'));
		}
		
	}
	
	/*public function paypal_ipn(){
		//paypal return transaction details array
		$paypalInfo    = $this->input->post();
		if(!empty($paypalInfo)){
			echo $paypalInfo["custom"];
		}
	}*/
}

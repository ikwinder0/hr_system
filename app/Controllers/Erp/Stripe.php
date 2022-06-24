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

require_once APPPATH . 'ThirdParty/Stripe/init.php';


use App\Models\SystemModel;
use App\Models\MainModel;
use App\Models\UsersModel;
use App\Models\ConstantsModel;
use App\Models\MembershipModel;
use App\Models\InvoicepaymentsModel;
use App\Models\CompanymembershipModel;

class Stripe extends BaseController {

	public function payment() 
	{
        $validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		// get order info
		$token = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
		$stripe_info = udecode($this->request->getPost('stripe_info',FILTER_SANITIZE_STRING));
		
		// Membership details
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$MembershipModel = new MembershipModel();
		$result = $MembershipModel->where('membership_id', $token)->first();
		$company_id = $UsersModel->where('user_id', $usession['sup_user_id'])->where('user_type','company')->first();
		
		$xin_system = erp_company_settings();
		$xin_super_system = $SystemModel->where('setting_id', 1)->first();
		\Stripe\Stripe::setApiKey($xin_super_system['stripe_secret_key']);
		$converted = currency_converter($result['price']);
		//$asdas = number_to_currency($converted, $xin_system['default_currency'],null,2);
		$converted = number_format($converted,2);
		//echo $converted; exit;
		$charge = \Stripe\Charge::create ([
                "amount" => $converted * 100,
				//"customer" => $company_id['company_name'],
                "currency" => $xin_system['default_currency'],
                "source" => $this->request->getPost('stripeToken',FILTER_SANITIZE_STRING),
                "description" => $result['membership_type']
        ]);
		$chargeJson = $charge->jsonSerialize();
	  
	  $data = [
			'invoice_id'  => $chargeJson['balance_transaction'],
			'company_id' => $usession['sup_user_id'],
			'membership_id'  => $result['membership_id'],
			'subscription_id'  => $result['subscription_id'],
			'membership_type'  => $result['membership_type'],
			'subscription'  => $result['plan_duration'],
			'description'  => $result['description'],
			'membership_price'  => $converted,
			'payment_method'  => 'Stripe',
			'invoice_month'  => date('Y-m'),
			'transaction_date'  => date('Y-m-d h:i:s'),
			'created_at' => date('Y-m-d h:i:s'),
			'receipt_url'  => $chargeJson['receipt_url'],
			'source_info'  => $chargeJson['payment_method_details']['card']['brand'],
		];
	  $InvoicepaymentsModel = new InvoicepaymentsModel();
	  $result1 = $InvoicepaymentsModel->insert($data);
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

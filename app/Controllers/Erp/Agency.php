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

class Agency extends BaseController {

	public function index()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 2)->first();
		$data['title'] = lang('Main.xin_agency_list_page').' | '.$xin_system['application_name'];
		$data['path_url'] = 'create-agency';
		$data['breadcrumbs'] = lang('Invoices.xin_agency_list_page');
        
		$data['subview'] = view('erp/admin/agency/agency_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	
	//Create Agency
	public function create_agency()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Agency.create_agency').' | '.$xin_system['application_name'];
		$data['path_url'] = 'create-agency';
		$data['breadcrumbs'] = lang('Agency.create_agency');

		$data['subview'] = view('erp/admin/agency/create', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	
	//Store Agency
	public function store()
	{		
	    $validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
// 		echo"<pre>";
// 		print_r($this->request->getFile('agency_logo'));
// 		die;
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
		$validation->setRules([
					'agency_name' => 'required',
					'country' => 'required',
					'phone_no' => 'required|numeric',
					'email' => 'required|valid_email',
					'website' => 'required|valid_url_strict',
					'contact_person' => 'required',
					'contact_person_phone' => 'required|numeric'
				],
				[   // Errors
					'agency_name' => [
						'required' => lang('Main.xin_agency_error_name_field'),
					],
					'country' => [
						'required' => lang('Main.xin_agency_error_country_field'),
					],
					'phone_no' => [
						'required' => lang('Employees.xin_agency_error_contact_field'),
					],
					'email' => [
						'required' => lang('Main.xin_agency_error_email_field'),
						'valid_email' => lang('Main.xin_employee_error_invalid_email'),
						'is_unique' => lang('Main.xin_already_exist_error_email'),
					],
					'website' => [
						'required' => lang('Main.xin_agency_error_website_field'),
					],
					'contact_person' => [
						'required' => lang('Main.xin_agency_error_contact_person_field'),
					],
					'contact_person_phone' => [
						'required' => lang('Main.xin_agency_error_contact_person_phone_field'),
					],
				]);
				
				$validation->withRequest($this->request)->run();
				
			    //check error
				if ($validation->hasError('agency_name')) {
					$Return['error'] = $validation->getError('agency_name');
				} elseif($validation->hasError('country')){
					$Return['error'] = $validation->getError('country');
				} elseif($validation->hasError('phone_no')) {
					$Return['error'] = $validation->getError('phone_no');
				} elseif($validation->hasError('email')){
					$Return['error'] = $validation->getError('email');
				} elseif($validation->hasError('website')){
					$Return['error'] = $validation->getError('website');
				} elseif($validation->hasError('contact_person')){
					$Return['error'] = $validation->getError('contact_person');
				} elseif($validation->hasError('contact_person_phone')){
					$Return['error'] = $validation->getError('contact_person_phone');
				}
				
				if($Return['error']!=''){
					$this->output($Return);
				}
			
			
			$image = \Config\Services::image();
			
			$validation->setRules([
				'agency_logo' => 'uploaded[agency_logo]|mime_in[agency_logo,image/jpg,image/jpeg,image/gif,image/png]|max_size[agency_logo,4096]',
				'bank_certificate' => 'uploaded[bank_certificate]|mime_in[bank_certificate,image/jpg,image/jpeg,image/gif,image/png]|max_size[bank_certificate,4096]',
				'cr_tax_card' => 'uploaded[cr_tax_card]|mime_in[cr_tax_card,image/jpg,image/jpeg,image/gif,image/png]|max_size[cr_tax_card,4096]',
				'bank_account' => 'uploaded[bank_account]|mime_in[bank_account,image/jpg,image/jpeg,image/gif,image/png]|max_size[bank_account,4096]',
				'bank_account_with_seal' => 'uploaded[bank_account_with_seal]|mime_in[bank_account_with_seal,image/jpg,image/jpeg,image/gif,image/png]|max_size[bank_account_with_seal,4096]',
			    ],
				[   // Errors
					
					'agency_logo' => [
						'uploaded' => lang('Main.xin_agency_error_logo_field'),
						'mime_in' => lang('Main.xin_agency_logo_file_type'),
						'max_size' => lang('Main.xin_agency_error_logo_size'),
					],
					'bank_certificate' => [
						'uploaded' => lang('Main.xin_agency_error_bank_certificate_field'),
						'mime_in' => lang('Main.xin_agency_error_bank_certificate_format_field'),
						'max_size' => lang('Main.xin_agency_error_bank_certificate_size_field'),
					],
					'cr_tax_card' => [
						'uploaded' => lang('Main.xin_agency_error_cr_tax_card_field'),
						'mime_in' => lang('Main.xin_agency_error_cr_tax_card_format_field'),
						'max_size' => lang('Main.xin_agency_error_cr_tax_card_size_field'),
					],
					'bank_account' => [
						'uploaded' => lang('Main.xin_agency_error_bank_account_field'),
						'mime_in' => lang('Main.xin_agency_error_bank_account_format_field'),
						'max_size' => lang('Main.xin_agency_error_bank_account_size_field'),
					],
					'bank_account_with_seal' => [
						'uploaded' => lang('Main.xin_agency_error_bank_account_with_seal_field'),
						'mime_in' => lang('Main.xin_agency_error_bank_account_with_seal_format'),
						'max_size' => lang('Main.xin_agency_error_bank_account_with_seal_size'),
					],
					
				]);
				
				$validation->withRequest($this->request)->run();
			
			//if (!$validated) {
				if ($validation->hasError('agency_logo')) {
					$Return['error'] = $validation->getError('agency_logo');
				} elseif($validation->hasError('cr_tax_card')){
					$Return['error'] = $validation->getError('cr_tax_card');
				} elseif($validation->hasError('bank_account_with_seal')) {
					$Return['error'] = $validation->getError('bank_account_with_seal');
				} elseif($validation->hasError('bank_account')){
					$Return['error'] = $validation->getError('bank_account');
				} elseif($validation->hasError('bank_certificate')){
					$Return['error'] = $validation->getError('bank_certificate');
				}
				//$Return['error'] = lang('Employees.xin_staff_picture_field_error');
			//} else {
				
				// $user_image = $this->request->getFile('file');
				// $file_name = $user_image->getName();
				// $user_image->move('public/uploads/users/');
				// $image->withFile(filesrc($file_name))
				// ->fit(100, 100, 'center')
				// ->save('public/uploads/users/thumb/'.$file_name);
			//}
			if($Return['error']!=''){
				$this->output($Return);
			}
			
	}
		
		
	
}

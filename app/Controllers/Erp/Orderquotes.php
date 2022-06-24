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
use App\Models\RolesModel;
use App\Models\ConstantsModel;
use App\Models\UsersModel;
use App\Models\ProductsModel;
use App\Models\OrdersModel;
use App\Models\OrderitemsModel;
use App\Models\OrderquotesModel;
use App\Models\OrderquoteitemsModel;

class Orderquotes extends BaseController {

	public function stock_quoteorders()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('invoice2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Inventory.xin_quote_orders').' | '.$xin_system['application_name'];
		$data['path_url'] = 'sales_orderquotes';
		$data['breadcrumbs'] = lang('Inventory.xin_quote_orders');

		$data['subview'] = view('erp/inventory/orderquotes/stock_quoteorders', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function create_quote()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('invoice3',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Inventory.xin_create_quote').' | '.$xin_system['application_name'];
		$data['path_url'] = 'create_orderquote';
		$data['breadcrumbs'] = lang('Inventory.xin_create_quote');

		$data['subview'] = view('erp/inventory/orderquotes/create_quote', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function edit_quote()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$OrderquotesModel = new OrderquotesModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $OrderquotesModel->where('quote_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] != 'company'){
			if(!in_array('invoice4',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Inventory.xin_edit_quote').' | '.$xin_system['application_name'];
		$data['path_url'] = 'create_orderquote';
		$data['breadcrumbs'] = lang('Inventory.xin_edit_quote');

		$data['subview'] = view('erp/inventory/orderquotes/edit_quote', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function quote_details()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$OrderquotesModel = new OrderquotesModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $OrderquotesModel->where('quote_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff' && $user_info['user_type']!='customer'){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='customer'){
			if(!in_array('invoice2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Inventory.xin_view_quote').' | '.$xin_system['application_name'];
		$data['path_url'] = 'quoteorder_details';
		$data['breadcrumbs'] = lang('Inventory.xin_view_quote');

		$data['subview'] = view('erp/inventory/orderquotes/quote_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function view_quote_order()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$OrderquotesModel = new OrderquotesModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $OrderquotesModel->where('quote_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Inventory.xin_view_quote').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoice_details';
		$data['breadcrumbs'] = lang('Inventory.xin_view_quote');

		$data['subview'] = view('erp/inventory/orderquotes/view_quote_order', $data);
		return view('erp/layout/pre_layout_main', $data); //page load
	}
	// |||add record|||
	public function create_new_quote() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'quote_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'customer' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'quote_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'quote_due_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "quote_number" => $validation->getError('quote_number'),
					"customer" => $validation->getError('customer'),
					"quote_date" => $validation->getError('quote_date'),
					"quote_due_date" => $validation->getError('quote_due_date')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$quote_number = $this->request->getPost('quote_number',FILTER_SANITIZE_STRING);
				$customer = $this->request->getPost('customer',FILTER_SANITIZE_STRING);
				$quote_date = $this->request->getPost('quote_date',FILTER_SANITIZE_STRING);
				$quote_due_date = $this->request->getPost('quote_due_date',FILTER_SANITIZE_STRING);
				$j=0;
				foreach($this->request->getPost('item_name',FILTER_SANITIZE_STRING) as $items){
					$item_name = $this->request->getPost('item_name',FILTER_SANITIZE_STRING);
					$iname = $item_name[$j];
					// item qty
					$qty = $this->request->getPost('qty_hrs',FILTER_SANITIZE_STRING);
					$qtyhrs = $qty[$j];
					// item price
					$unit_price = $this->request->getPost('unit_price',FILTER_SANITIZE_STRING);
					$price = $unit_price[$j];
					
					if($iname==='') {
						$Return['error'] = lang('Success.xin_item_field_field_error');
					} else if($qty==='') {
						$Return['error'] = lang('Success.xin_qty_field_error');
					} else if($price==='' || $price===0) {
						$Return['error'] = $j. ' '.lang('Success.xin_price_field_error');
					}
					$j++;
				}
				if($Return['error']!=''){
					$this->output($Return);
				}
				$items_sub_total = $this->request->getPost('items_sub_total',FILTER_SANITIZE_STRING);
				$discount_type = $this->request->getPost('discount_type',FILTER_SANITIZE_STRING);
				$discount_figure = $this->request->getPost('discount_figure',FILTER_SANITIZE_STRING);
				$discount_amount = $this->request->getPost('discount_amount',FILTER_SANITIZE_STRING);
				$tax_type = $this->request->getPost('tax_type',FILTER_SANITIZE_STRING);
				$tax_rate = $this->request->getPost('tax_rate',FILTER_SANITIZE_STRING);
				$fgrand_total = $this->request->getPost('fgrand_total',FILTER_SANITIZE_STRING);
				$quote_note = $this->request->getPost('quote_note',FILTER_SANITIZE_STRING);
							
				$UsersModel = new UsersModel();
				//$ProjectsModel = new ProjectsModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				//$_project = $ProjectsModel->where('company_id',$company_id)->where('project_id', $project_id)->first();
				//$_client = $UsersModel->where('user_id', $_project['client_id'])->where('user_type','customer')->first();
				// invoice month
				$dd1 = explode('-',$quote_date);
				$inv_mnth = $dd1[0].'-'.$dd1[1];
				$data = [
					'quote_number'  => $quote_number,
					'company_id' => $company_id,
					'customer_id'  => $customer,
					'quote_month'  => $inv_mnth,
					'quote_date'  => $quote_date,
					'quote_due_date'  => $quote_due_date,
					'sub_total_amount'  => $items_sub_total,
					'discount_type'  => $discount_type,
					'discount_figure'  => $discount_figure,
					'total_tax'  => $tax_rate,
					'tax_type'  => $tax_type,
					'total_discount'  => $discount_amount,
					'grand_total'  => $fgrand_total,
					'status'  => 0,
					'payment_method'  => 0,
					'quote_note'  => $quote_note,
					'created_at' => date('d-m-Y h:i:s')
				];
				$OrderquotesModel = new OrderquotesModel();
				$result = $OrderquotesModel->insert($data);	
				$invoice_id = $OrderquotesModel->insertID();
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$key=0;
					foreach($this->request->getPost('item_name',FILTER_SANITIZE_STRING) as $items){
		
						/* get items info */
						// item name
						$item_name = $this->request->getPost('item_name',FILTER_SANITIZE_STRING);
						$iname = $item_name[$key]; 
						// item qty
						$qty = $this->request->getPost('qty_hrs',FILTER_SANITIZE_STRING);
						$qtyhrs = $qty[$key]; 
						// item price
						$unit_price = $this->request->getPost('unit_price',FILTER_SANITIZE_STRING);
						$price = $unit_price[$key]; 
						// item sub_total
						$sub_total_item = $this->request->getPost('sub_total_item',FILTER_SANITIZE_STRING);
						$item_sub_total = $sub_total_item[$key];
						// add values  
						$data2 = array(
						'quote_id' => $invoice_id,
						'item_id' => $iname,
						'item_name' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_sub_total' => $item_sub_total,
						'created_at' => date('d-m-Y H:i:s')
						);
						$OrderquoteitemsModel = new OrderquoteitemsModel();
						$OrderquoteitemsModel->insert($data2);						
					$key++; }
					$Return['result'] = lang('Inventory.xin_quote_added_success');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// |||update record|||
	public function update_quote() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'quote_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'customer' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'quote_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'quote_due_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "quote_number" => $validation->getError('quote_number'),
					"customer" => $validation->getError('customer'),
					"quote_date" => $validation->getError('quote_date'),
					"quote_due_date" => $validation->getError('quote_due_date')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$quote_number = $this->request->getPost('quote_number',FILTER_SANITIZE_STRING);
				$customer = $this->request->getPost('customer',FILTER_SANITIZE_STRING);
				$quote_date = $this->request->getPost('quote_date',FILTER_SANITIZE_STRING);
				$quote_due_date = $this->request->getPost('quote_due_date',FILTER_SANITIZE_STRING);
				$j=0;
				foreach($this->request->getPost('eitem_name',FILTER_SANITIZE_STRING) as $eitem_id=>$key_val){
					$item_name = $this->request->getPost('eitem_name',FILTER_SANITIZE_STRING);
					$iname = $item_name[$eitem_id];
					// item qty
					$qty = $this->request->getPost('eqty_hrs',FILTER_SANITIZE_STRING);
					$qtyhrs = $qty[$eitem_id];
					// item price
					$unit_price = $this->request->getPost('eunit_price',FILTER_SANITIZE_STRING);
					$price = $unit_price[$eitem_id];
					
					if($iname==='') {
						$Return['error'] = lang('Success.xin_item_field_field_error');
					} else if($qty==='') {
						$Return['error'] = lang('Success.xin_qty_field_error');
					} else if($price==='' || $price===0) {
						$Return['error'] = $j. " ".lang('Success.xin_price_field_error');
					}
					// item name
					$item_name = $this->request->getPost('eitem_name',FILTER_SANITIZE_STRING);
					$iname = $item_name[$eitem_id]; 
					// item qty
					$qty = $this->request->getPost('eqty_hrs',FILTER_SANITIZE_STRING);
					$qtyhrs = $qty[$eitem_id]; 
					// item price
					$unit_price = $this->request->getPost('eunit_price',FILTER_SANITIZE_STRING);
					$price = $unit_price[$eitem_id]; 
					// item sub_total
					$sub_total_item = $this->request->getPost('esub_total_item',FILTER_SANITIZE_STRING);
					$item_sub_total = $sub_total_item[$eitem_id];
					
					// add values  
					$data2 = array(
					'item_id' => $iname,
					'item_qty' => $qtyhrs,
					'item_unit_price' => $price,
					'item_sub_total' => $item_sub_total
					);
					$OrderquoteitemsModel = new OrderquoteitemsModel();
					$OrderquoteitemsModel->update($eitem_id,$data2);
					
					$j++;
				}
				if($Return['error']!=''){
					$this->output($Return);
				}
				if($this->request->getPost('item_name')) {
					$k=0;
					foreach($this->request->getPost('item_name') as $items){
						$item_name = $this->request->getPost('item_name',FILTER_SANITIZE_STRING);
						$iname = $item_name[$k];
						// item qty
						$qty = $this->request->getPost('qty_hrs',FILTER_SANITIZE_STRING);
						$qtyhrs = $qty[$k];
						// item price
						$unit_price = $this->request->getPost('unit_price',FILTER_SANITIZE_STRING);
						$price = $unit_price[$k];
						
						if($iname==='') {
							$Return['error'] = lang('Success.xin_item_field_field_error');
						} else if($qty==='') {
							$Return['error'] = lang('Success.xin_qty_field_error');
						} else if($price==='' || $price===0) {
							$Return['error'] = $k. " ".lang('Success.xin_price_field_error');
						}
						$k++;
					}
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
				
				$items_sub_total = $this->request->getPost('items_sub_total',FILTER_SANITIZE_STRING);
				$discount_type = $this->request->getPost('discount_type',FILTER_SANITIZE_STRING);
				$discount_figure = $this->request->getPost('discount_figure',FILTER_SANITIZE_STRING);
				$discount_amount = $this->request->getPost('discount_amount',FILTER_SANITIZE_STRING);
				$tax_type = $this->request->getPost('tax_type',FILTER_SANITIZE_STRING);
				$tax_rate = $this->request->getPost('tax_rate',FILTER_SANITIZE_STRING);
				$fgrand_total = $this->request->getPost('fgrand_total',FILTER_SANITIZE_STRING);
				$quote_note = $this->request->getPost('quote_note',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
							
				$UsersModel = new UsersModel();
				//$ProjectsModel = new ProjectsModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				//$_project = $ProjectsModel->where('company_id',$company_id)->where('project_id', $project_id)->first();
				//$_client = $UsersModel->where('user_id', $_project['client_id'])->where('user_type','customer')->first();
				// invoice month
				$dd1 = explode('-',$quote_date);
				$inv_mnth = $dd1[0].'-'.$dd1[1];
				$data = [
					'quote_number'  => $quote_number,
					'company_id' => $company_id,
					'customer_id'  => $customer,
					'quote_month'  => $inv_mnth,
					'quote_date'  => $quote_date,
					'quote_due_date'  => $quote_due_date,
					'sub_total_amount'  => $items_sub_total,
					'discount_type'  => $discount_type,
					'discount_figure'  => $discount_figure,
					'total_tax'  => $tax_rate,
					'tax_type'  => $tax_type,
					'total_discount'  => $discount_amount,
					'grand_total'  => $fgrand_total,
					'quote_note'  => $quote_note,
				];
				$OrderquotesModel = new OrderquotesModel();
				$result = $OrderquotesModel->update($id,$data);	
				//$invoice_id = $InvoicesModel->insertID();
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					if($this->request->getPost('item_name')) {
					$ik=0;
					foreach($this->request->getPost('item_name',FILTER_SANITIZE_STRING) as $items){
		
						/* get items info */
						// item name
						$item_name = $this->request->getPost('item_name',FILTER_SANITIZE_STRING);
						$iname = $item_name[$ik]; 
						// item qty
						$qty = $this->request->getPost('qty_hrs',FILTER_SANITIZE_STRING);
						$qtyhrs = $qty[$ik]; 
						// item price
						$unit_price = $this->request->getPost('unit_price',FILTER_SANITIZE_STRING);
						$price = $unit_price[$ik]; 
						// item sub_total
						$sub_total_item = $this->request->getPost('sub_total_item',FILTER_SANITIZE_STRING);
						$item_sub_total = $sub_total_item[$ik];
						// add values  
						$data3 = array(
						'quote_id' => $id,
						'item_id' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_sub_total' => $item_sub_total,
						'created_at' => date('d-m-Y H:i:s')
						);
						$OrderquoteitemsModel = new OrderquoteitemsModel();
						$OrderquoteitemsModel->insert($data3);						
					$ik++; }
					}
					$Return['result'] = lang('Inventory.xin_quote_updated_success');
				} else {
					$Return['error'] = lang('Main.xin_error_msg');
				}
				$this->output($Return);
				exit;
			}
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// get purchase items record
	public function get_purchase_items()
	{
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		$id = $request->getGet('field_id');
		$data = [
				'field_id' => 0,
			];
		if($session->has('sup_username')){
			return view('erp/inventory/purchases/get_purchase_items', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_quote_items() {
		
		if($this->request->getVar('record_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$record_id = udecode($this->request->getVar('record_id',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$OrderquoteitemsModel = new OrderquoteitemsModel();
			$result = $OrderquoteitemsModel->where('quote_item_id', $record_id)->delete($record_id);
			if ($result == TRUE) {
				$Return['result'] = lang('Inventory.xin_item_deleted_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// read record
	public function read_quote_data()
	{
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		$id = $request->getGet('field_id');
		$data = [
				'field_id' => $id,
			];
		if($session->has('sup_username')){
			return view('erp/inventory/orderquotes/update_quote', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// |||update cancel_quote_record|||
	public function cancel_quote_record() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'cancel_quote_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$data = [
				'status'  => 2
			];
			$OrderquotesModel = new OrderquotesModel();
			$result = $OrderquotesModel->update($id,$data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Inventory.xin_quote_cancelled_success_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// |||update convert_quote_record|||
	public function convert_quote_record() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'convert_quote_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$UsersModel = new UsersModel();
			$OrderquotesModel = new OrderquotesModel();
			$OrderquoteitemsModel = new OrderquoteitemsModel();
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
			$result = $OrderquotesModel->where('quote_id', $id)->first();
			
			$data = [
				'order_number'  => $result['quote_number'],
				'company_id' => $result['company_id'],
				'customer_id' => $result['customer_id'],
				'invoice_month'  => $result['quote_month'],
				'invoice_date'  => $result['quote_date'],
				'invoice_due_date'  => $result['quote_due_date'],
				'sub_total_amount'  => $result['sub_total_amount'],
				'discount_type'  => $result['discount_type'],
				'discount_figure'  => $result['discount_figure'],
				'total_tax'  => $result['total_tax'],
				'tax_type'  => $result['tax_type'],
				'total_discount'  => $result['total_discount'],
				'grand_total'  => $result['grand_total'],
				'status'  => 0,
				'payment_method'  => 0,
				'invoice_note'  => $result['quote_note'],
				'created_at' => date('d-m-Y h:i:s')
			];
			$OrdersModel = new OrdersModel();
			$result = $OrdersModel->insert($data);	
			$invoice_id = $OrdersModel->insertID();
			$invoice_items = $OrderquoteitemsModel->where('quote_id', $id)->findAll();
			foreach($invoice_items as $item){
				$data2 = array(
				'order_id' => $invoice_id,
				'item_id' => $item['item_id'],
				'item_qty' => $item['item_qty'],
				'item_unit_price' => $item['item_unit_price'],
				'item_sub_total' => $item['item_sub_total'],
				'created_at' => date('d-m-Y H:i:s')
				);
				$OrderitemsModel = new OrderitemsModel();
				$OrderitemsModel->insert($data2);	
			}
			$data3 = [
				'status'  => 1
			];
			$OrderquotesModel = new OrderquotesModel();
			$result = $OrderquotesModel->update($id,$data3);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Inventory.ci_quote_convert_to_invoice_success_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
			$this->output($Return);
			exit;
		}
	}
	// delete record
	public function delete_quoteorder() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$OrderquotesModel = new OrderquotesModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $OrderquotesModel->where('quote_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Inventory.xin_quote_deleted_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

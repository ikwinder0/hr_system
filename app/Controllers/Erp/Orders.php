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

class Orders extends BaseController {

	public function stock_orders()
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
		$data['title'] = lang('Inventory.xin_sales_order').' | '.$xin_system['application_name'];
		$data['path_url'] = 'sales_order';
		$data['breadcrumbs'] = lang('Inventory.xin_sales_order');

		$data['subview'] = view('erp/inventory/salesorder/stock_orders', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function paid_orders()
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
		$data['title'] = lang('Inventory.xin_paid_orders').' | '.$xin_system['application_name'];
		$data['path_url'] = 'sales_order';
		$data['breadcrumbs'] = lang('Inventory.xin_paid_orders');

		$data['subview'] = view('erp/inventory/salesorder/order_status_paid', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function unpaid_orders()
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
		$data['title'] = lang('Inventory.xin_unpaid_orders').' | '.$xin_system['application_name'];
		$data['path_url'] = 'sales_order';
		$data['breadcrumbs'] = lang('Inventory.xin_unpaid_orders');

		$data['subview'] = view('erp/inventory/salesorder/order_status_unpaid', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function packed_orders()
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
		$data['title'] = lang('Inventory.xin_packed_orders').' | '.$xin_system['application_name'];
		$data['path_url'] = 'sales_order';
		$data['breadcrumbs'] = lang('Inventory.xin_packed_orders');

		$data['subview'] = view('erp/inventory/salesorder/order_status_packed', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function delivered_orders()
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
		$data['title'] = lang('Inventory.xin_sales_order').' | '.$xin_system['application_name'];
		$data['path_url'] = 'sales_order';
		$data['breadcrumbs'] = lang('Inventory.xin_sales_order');

		$data['subview'] = view('erp/inventory/salesorder/order_status_delivered', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function cancelled_orders()
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
		$data['title'] = lang('Inventory.xin_sales_order').' | '.$xin_system['application_name'];
		$data['path_url'] = 'sales_order';
		$data['breadcrumbs'] = lang('Inventory.xin_sales_order');

		$data['subview'] = view('erp/inventory/salesorder/order_status_cancelled', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function create_order()
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
		$data['title'] = lang('Inventory.xin_create_new_order').' | '.$xin_system['application_name'];
		$data['path_url'] = 'create_order';
		$data['breadcrumbs'] = lang('Inventory.xin_create_new_order');

		$data['subview'] = view('erp/inventory/salesorder/create_order', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function edit_order()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$OrdersModel = new OrdersModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $OrdersModel->where('order_id', $ifield_id)->first();
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
		$data['title'] = lang('Invoices.xin_edit_invoice').' | '.$xin_system['application_name'];
		$data['path_url'] = 'create_order';
		$data['breadcrumbs'] = lang('Invoices.xin_edit_invoice');

		$data['subview'] = view('erp/inventory/salesorder/edit_order', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function order_details()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$OrdersModel = new OrdersModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $OrdersModel->where('order_id', $ifield_id)->first();
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
		$data['title'] = lang('Inventory.xin_view_order').' | '.$xin_system['application_name'];
		$data['path_url'] = 'salesorder_details';
		$data['breadcrumbs'] = lang('Inventory.xin_view_order');

		$data['subview'] = view('erp/inventory/salesorder/order_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function view_order_invoice()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$OrdersModel = new OrdersModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $OrdersModel->where('order_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Inventory.xin_view_order').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoice_details';
		$data['breadcrumbs'] = lang('Inventory.xin_view_order');

		$data['subview'] = view('erp/inventory/salesorder/view_order_invoice', $data);
		return view('erp/layout/pre_layout_main', $data); //page load
	}
	// |||add record|||
	public function create_new_order() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'order_number' => [
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
				'invoice_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'invoice_due_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "order_number" => $validation->getError('order_number'),
					"customer" => $validation->getError('customer'),
					"invoice_date" => $validation->getError('invoice_date'),
					"invoice_due_date" => $validation->getError('invoice_due_date')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$order_number = $this->request->getPost('order_number',FILTER_SANITIZE_STRING);
				$customer = $this->request->getPost('customer',FILTER_SANITIZE_STRING);
				$invoice_date = $this->request->getPost('invoice_date',FILTER_SANITIZE_STRING);
				$invoice_due_date = $this->request->getPost('invoice_due_date',FILTER_SANITIZE_STRING);
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
				$invoice_note = $this->request->getPost('invoice_note',FILTER_SANITIZE_STRING);
							
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
				$dd1 = explode('-',$invoice_date);
				$inv_mnth = $dd1[0].'-'.$dd1[1];
				$data = [
					'order_number'  => $order_number,
					'company_id' => $company_id,
					'customer_id'  => $customer,
					'invoice_month'  => $inv_mnth,
					'invoice_date'  => $invoice_date,
					'invoice_due_date'  => $invoice_due_date,
					'sub_total_amount'  => $items_sub_total,
					'discount_type'  => $discount_type,
					'discount_figure'  => $discount_figure,
					'total_tax'  => $tax_rate,
					'tax_type'  => $tax_type,
					'total_discount'  => $discount_amount,
					'grand_total'  => $fgrand_total,
					'status'  => 0,
					'payment_method'  => 0,
					'invoice_note'  => $invoice_note,
					'created_at' => date('d-m-Y h:i:s')
				];
				$OrdersModel = new OrdersModel();
				$result = $OrdersModel->insert($data);	
				$invoice_id = $OrdersModel->insertID();
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
						'order_id' => $invoice_id,
						'item_id' => $iname,
						'item_name' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_sub_total' => $item_sub_total,
						'created_at' => date('d-m-Y H:i:s')
						);
						$OrderitemsModel = new OrderitemsModel();
						$OrderitemsModel->insert($data2);						
					$key++; }
					$Return['result'] = lang('Inventory.xin_order_added_success');
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
	public function update_order() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'order_number' => [
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
				'invoice_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'invoice_due_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "order_number" => $validation->getError('order_number'),
					"customer" => $validation->getError('customer'),
					"invoice_date" => $validation->getError('invoice_date'),
					"invoice_due_date" => $validation->getError('invoice_due_date')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$order_number = $this->request->getPost('order_number',FILTER_SANITIZE_STRING);
				$customer = $this->request->getPost('customer',FILTER_SANITIZE_STRING);
				$invoice_date = $this->request->getPost('invoice_date',FILTER_SANITIZE_STRING);
				$invoice_due_date = $this->request->getPost('invoice_due_date',FILTER_SANITIZE_STRING);
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
					$OrderitemsModel = new OrderitemsModel();
					$OrderitemsModel->update($eitem_id,$data2);
					
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
				$invoice_note = $this->request->getPost('invoice_note',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
							
				$UsersModel = new UsersModel();
			//	$ProjectsModel = new ProjectsModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				//$_project = $ProjectsModel->where('company_id',$company_id)->where('project_id', $project_id)->first();
			//	$_client = $UsersModel->where('user_id', $_project['client_id'])->where('user_type','customer')->first();
				// invoice month
				$dd1 = explode('-',$invoice_date);
				$inv_mnth = $dd1[0].'-'.$dd1[1];
				$data = [
					'order_number'  => $order_number,
					'company_id' => $company_id,
					'customer_id'  => $customer,
					'invoice_month'  => $inv_mnth,
					'invoice_date'  => $invoice_date,
					'invoice_due_date'  => $invoice_due_date,
					'sub_total_amount'  => $items_sub_total,
					'discount_type'  => $discount_type,
					'discount_figure'  => $discount_figure,
					'total_tax'  => $tax_rate,
					'tax_type'  => $tax_type,
					'total_discount'  => $discount_amount,
					'grand_total'  => $fgrand_total,
					'invoice_note'  => $invoice_note,
				];
				$OrdersModel = new OrdersModel();
				$result = $OrdersModel->update($id,$data);	
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
						'order_id' => $id,
						'item_id' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_sub_total' => $item_sub_total,
						'created_at' => date('d-m-Y H:i:s')
						);
						$OrderitemsModel = new OrderitemsModel();
						$OrderitemsModel->insert($data3);						
					$ik++; }
					}
					$Return['result'] = lang('Inventory.xin_order_updated_success');
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
	public function delete_order_items() {
		
		if($this->request->getVar('record_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$record_id = udecode($this->request->getVar('record_id',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$OrderitemsModel = new OrderitemsModel();
			$result = $OrderitemsModel->where('order_item_id', $record_id)->delete($record_id);
			if ($result == TRUE) {
				$Return['result'] = lang('Inventory.xin_item_deleted_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// read record
	public function read_invoice_data()
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
			return view('erp/inventory/salesorder/pay_order_invoice', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// |||update record|||
	public function pay_invoice_record() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'payment_method' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'status' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "payment_method" => $validation->getError('payment_method'),
					"status" => $validation->getError('status')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$payment_method = $this->request->getPost('payment_method',FILTER_SANITIZE_STRING);	
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'payment_method' => $payment_method,
					'status'  => $status
				];
				$OrdersModel = new OrdersModel();
				$result = $OrdersModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_invoice_status_updated_msg');
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
	public function packing_status() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'status' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
					"status" => $validation->getError('status')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'status'  => $status
				];
				$OrdersModel = new OrdersModel();
				$result = $OrdersModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Inventory.xin_order_packing_status_updated');
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
	public function delivery_status() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'status' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
					"status" => $validation->getError('status')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'status'  => $status
				];
				$OrdersModel = new OrdersModel();
				$result = $OrdersModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Inventory.xin_order_delivery_status_updated');
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
	// delete record
	public function delete_order() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$OrdersModel = new OrdersModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $OrdersModel->where('order_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Inventory.xin_order_deleted_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

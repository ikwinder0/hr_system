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
use App\Models\PurchasesModel;
use App\Models\SuppliersModel;
use App\Models\PurchaseitemsModel;

class Purchases extends BaseController {

	public function stock_purchases()
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
			if(!in_array('purchases1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Inventory.xin_purchases').' | '.$xin_system['application_name'];
		$data['path_url'] = 'purchases';
		$data['breadcrumbs'] = lang('Inventory.xin_purchases');

		$data['subview'] = view('erp/inventory/purchases/purchase_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function create_purchase()
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
			if(!in_array('purchases2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Inventory.xin_create_purchase').' | '.$xin_system['application_name'];
		$data['path_url'] = 'create_purchase';
		$data['breadcrumbs'] = lang('Inventory.xin_create_purchase');

		$data['subview'] = view('erp/inventory/purchases/create_purchase', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function edit_purchase()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$PurchasesModel = new PurchasesModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $PurchasesModel->where('purchase_id', $ifield_id)->first();
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
			if(!in_array('purchases3',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Inventory.xin_edit_purchase').' | '.$xin_system['application_name'];
		$data['path_url'] = 'create_purchase';
		$data['breadcrumbs'] = lang('Inventory.xin_edit_purchase');

		$data['subview'] = view('erp/inventory/purchases/edit_purchase', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function purchase_details()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$PurchasesModel = new PurchasesModel();
		$request = \Config\Services::request();
		$purchase_id = udecode($request->uri->getSegment(3));
		$isegment_val = $PurchasesModel->where('purchase_id', $purchase_id)->first();
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
			if(!in_array('purchases1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Inventory.xin_view_purchase').' | '.$xin_system['application_name'];
		$data['path_url'] = 'purchase_details';
		$data['breadcrumbs'] = lang('Inventory.xin_view_purchase');

		$data['subview'] = view('erp/inventory/purchases/purchase_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function view_purchase_invoice()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$PurchasesModel = new PurchasesModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $PurchasesModel->where('purchase_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Invoices.xin_view_purchase').' | '.$xin_system['application_name'];
		$data['path_url'] = 'purchase_details';
		$data['breadcrumbs'] = lang('Invoices.xin_view_purchase');

		$data['subview'] = view('erp/inventory/purchases/view_purchase_invoice', $data);
		return view('erp/layout/pre_layout_main', $data); //page load
	}
	// |||add record|||
	public function create_new_purchase() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'purchase_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'supplier' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'purchase_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "purchase_number" => $validation->getError('purchase_number'),
					"supplier" => $validation->getError('supplier'),
					"purchase_date" => $validation->getError('purchase_date')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$purchase_number = $this->request->getPost('purchase_number',FILTER_SANITIZE_STRING);
				$supplier = $this->request->getPost('supplier',FILTER_SANITIZE_STRING);
				$purchase_date = $this->request->getPost('purchase_date',FILTER_SANITIZE_STRING);
				$payment_method = $this->request->getPost('payment_method',FILTER_SANITIZE_STRING);
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
				$purchase_note = $this->request->getPost('purchase_note',FILTER_SANITIZE_STRING);
							
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
				$dd1 = explode('-',$purchase_date);
				$inv_mnth = $dd1[0].'-'.$dd1[1];
				$data = [
					'purchase_number'  => $purchase_number,
					'company_id' => $company_id,
					'supplier_id'  => $supplier,
					'purchase_month'  => $inv_mnth,
					'purchase_date'  => $purchase_date,
					'sub_total_amount'  => $items_sub_total,
					'discount_type'  => $discount_type,
					'discount_figure'  => $discount_figure,
					'total_tax'  => $tax_rate,
					'tax_type'  => $tax_type,
					'total_discount'  => $discount_amount,
					'grand_total'  => $fgrand_total,
					'status'  => 0,
					'payment_method'  => $payment_method,
					'purchase_note'  => $purchase_note,
					'created_at' => date('d-m-Y h:i:s')
				];
				$PurchasesModel = new PurchasesModel();
				$result = $PurchasesModel->insert($data);	
				$invoice_id = $PurchasesModel->insertID();
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
						'purchase_id' => $invoice_id,
						'item_id' => $iname,
						'item_name' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_sub_total' => $item_sub_total,
						'created_at' => date('d-m-Y H:i:s')
						);
						$PurchaseitemsModel = new PurchaseitemsModel();
						$PurchaseitemsModel->insert($data2);						
					$key++; }
					$Return['result'] = lang('Inventory.xin_purchase_added_success');
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
	public function update_purchase() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'purchase_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'supplier' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'purchase_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "purchase_number" => $validation->getError('purchase_number'),
					"supplier" => $validation->getError('supplier'),
					"purchase_date" => $validation->getError('purchase_date')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$purchase_number = $this->request->getPost('purchase_number',FILTER_SANITIZE_STRING);
				$supplier = $this->request->getPost('supplier',FILTER_SANITIZE_STRING);
				$purchase_date = $this->request->getPost('purchase_date',FILTER_SANITIZE_STRING);
				$payment_method = $this->request->getPost('payment_method',FILTER_SANITIZE_STRING);
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
					$PurchaseitemsModel = new PurchaseitemsModel();
					$PurchaseitemsModel->update($eitem_id,$data2);
					
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
				$purchase_note = $this->request->getPost('purchase_note',FILTER_SANITIZE_STRING);
				$payment_method = $this->request->getPost('payment_method',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
							
				$UsersModel = new UsersModel();
				//$ProjectsModel = new ProjectsModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
			//	$_project = $ProjectsModel->where('company_id',$company_id)->where('project_id', $project_id)->first();
			//	$_client = $UsersModel->where('user_id', $_project['client_id'])->where('user_type','customer')->first();
				// invoice month
				$dd1 = explode('-',$purchase_date);
				$inv_mnth = $dd1[0].'-'.$dd1[1];
				$data = [
					'purchase_number'  => $purchase_number,
					'company_id' => $company_id,
					'supplier_id'  => $supplier,
					'purchase_month'  => $inv_mnth,
					'purchase_date'  => $purchase_date,
					'sub_total_amount'  => $items_sub_total,
					'discount_type'  => $discount_type,
					'discount_figure'  => $discount_figure,
					'total_tax'  => $tax_rate,
					'tax_type'  => $tax_type,
					'total_discount'  => $discount_amount,
					'grand_total'  => $fgrand_total,
					'payment_method'  => $payment_method,
					'purchase_note'  => $purchase_note,
				];
				$PurchasesModel = new PurchasesModel();
				$result = $PurchasesModel->update($id,$data);	
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
						'purchase_id' => $id,
						'item_id' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_sub_total' => $item_sub_total,
						'created_at' => date('d-m-Y H:i:s')
						);
						$PurchaseitemsModel = new PurchaseitemsModel();
						$PurchaseitemsModel->insert($data3);						
					$ik++; }
					}
					$Return['result'] = lang('Inventory.xin_purchase_updated_success');
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
	public function delete_invoice_items() {
		
		if($this->request->getVar('record_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$record_id = udecode($this->request->getVar('record_id',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$PurchaseitemsModel = new PurchaseitemsModel();
			$result = $PurchaseitemsModel->where('purchase_item_id', $record_id)->delete($record_id);
			if ($result == TRUE) {
				$Return['result'] = lang('Inventory.xin_item_deleted_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// read record
	public function read_purchase_data()
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
			return view('erp/inventory/purchases/purchase_status', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// |||update record|||
	public function update_purchase_record() {
			
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
				$PurchasesModel = new PurchasesModel();
				$result = $PurchasesModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Inventory.xin_purchase_status_updated');
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
	public function delete_purchase() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$PurchasesModel = new PurchasesModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $PurchasesModel->where('purchase_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Inventory.xin_purchase_deleted_success');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

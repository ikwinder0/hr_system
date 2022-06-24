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
use App\Models\ProjectsModel;
use App\Models\EstimatesModel;
use App\Models\InvoicesModel;
use App\Models\InvoiceitemsModel;
use App\Models\EstimatesitemsModel;

class Estimates extends BaseController {

	//project_estimates
	public function project_estimates()
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
			if(!in_array('estimate2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_estimates').' | '.$xin_system['application_name'];
		$data['path_url'] = 'estimates';
		$data['breadcrumbs'] = lang('Dashboard.xin_estimates');

		$data['subview'] = view('erp/estimates/estimate_project_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	//create_estimate
	public function create_estimate()
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
			if(!in_array('estimate3',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Main.xin_create_new_estimate').' | '.$xin_system['application_name'];
		$data['path_url'] = 'create_estimates';
		$data['breadcrumbs'] = lang('Main.xin_create_new_estimate');

		$data['subview'] = view('erp/estimates/create_estimate', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	//estimate_details
	public function estimate_details()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$EstimatesModel = new EstimatesModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $EstimatesModel->where('estimate_id', $ifield_id)->first();
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
			if(!in_array('estimate2',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Main.xin_view_estimate').' | '.$xin_system['application_name'];
		$data['path_url'] = 'estimate_details';
		$data['breadcrumbs'] = lang('Main.xin_view_estimate');

		$data['subview'] = view('erp/estimates/estimate_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	//edit_estimate
	public function edit_estimate()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$EstimatesModel = new EstimatesModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $EstimatesModel->where('estimate_id', $ifield_id)->first();
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
			if(!in_array('estimate4',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Main.xin_edit_estimate').' | '.$xin_system['application_name'];
		$data['path_url'] = 'create_estimates';
		$data['breadcrumbs'] = lang('Main.xin_edit_estimate');

		$data['subview'] = view('erp/estimates/edit_estimate', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	//view_project_estimate
	public function view_project_estimate()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$EstimatesModel = new EstimatesModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $EstimatesModel->where('estimate_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_print_estimate').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoice_details';
		$data['breadcrumbs'] = lang('Main.xin_print_estimate');

		$data['subview'] = view('erp/estimates/view_project_estimate', $data);
		return view('erp/layout/pre_layout_main', $data); //page load
	}
	// |||add record|||
	public function create_new_estimate() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'estimate_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'project' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'estimate_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'estimate_due_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "estimate_number" => $validation->getError('estimate_number'),
					"project" => $validation->getError('project'),
					"estimate_date" => $validation->getError('estimate_date'),
					"estimate_due_date" => $validation->getError('estimate_due_date')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$invoice_number = $this->request->getPost('estimate_number',FILTER_SANITIZE_STRING);
				$project_id = $this->request->getPost('project',FILTER_SANITIZE_STRING);
				$invoice_date = $this->request->getPost('estimate_date',FILTER_SANITIZE_STRING);
				$invoice_due_date = $this->request->getPost('estimate_due_date',FILTER_SANITIZE_STRING);
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
				$invoice_note = $this->request->getPost('estimate_note',FILTER_SANITIZE_STRING);
							
				$UsersModel = new UsersModel();
				$ProjectsModel = new ProjectsModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$_project = $ProjectsModel->where('company_id',$company_id)->where('project_id', $project_id)->first();
				$_client = $UsersModel->where('user_id', $_project['client_id'])->where('user_type','customer')->first();
				// invoice month
				$dd1 = explode('-',$invoice_date);
				$inv_mnth = $dd1[0].'-'.$dd1[1];
				$data = [
					'estimate_number'  => $invoice_number,
					'company_id' => $company_id,
					'client_id' => $_client['user_id'],
					'project_id'  => $project_id,
					'estimate_month'  => $inv_mnth,
					'estimate_date'  => $invoice_date,
					'estimate_due_date'  => $invoice_due_date,
					'sub_total_amount'  => $items_sub_total,
					'discount_type'  => $discount_type,
					'discount_figure'  => $discount_figure,
					'total_tax'  => $tax_rate,
					'tax_type'  => $tax_type,
					'total_discount'  => $discount_amount,
					'grand_total'  => $fgrand_total,
					'status'  => 0,
					'payment_method'  => 0,
					'estimate_note'  => $invoice_note,
					'created_at' => date('d-m-Y h:i:s')
				];
				$EstimatesModel = new EstimatesModel();
				$result = $EstimatesModel->insert($data);	
				$invoice_id = $EstimatesModel->insertID();
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
						'estimate_id' => $invoice_id,
						'project_id' => $project_id,
						'item_name' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_sub_total' => $item_sub_total,
						'created_at' => date('d-m-Y H:i:s')
						);
						$EstimatesitemsModel = new EstimatesitemsModel();
						$EstimatesitemsModel->insert($data2);						
					$key++; }
					$Return['result'] = lang('Success.ci_estimate_created__msg');
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
	public function update_estimate() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'estimate_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'project' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'estimate_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'estimate_due_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "estimate_number" => $validation->getError('estimate_number'),
					"project" => $validation->getError('project'),
					"estimate_date" => $validation->getError('estimate_date'),
					"estimate_due_date" => $validation->getError('estimate_due_date')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$invoice_number = $this->request->getPost('estimate_number',FILTER_SANITIZE_STRING);
				$project_id = $this->request->getPost('project',FILTER_SANITIZE_STRING);
				$invoice_date = $this->request->getPost('estimate_date',FILTER_SANITIZE_STRING);
				$invoice_due_date = $this->request->getPost('estimate_due_date',FILTER_SANITIZE_STRING);
				$j=0;
				foreach($this->request->getPost('item',FILTER_SANITIZE_STRING) as $eitem_id=>$key_val){
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
					'item_name' => $iname,
					'item_qty' => $qtyhrs,
					'item_unit_price' => $price,
					'item_sub_total' => $item_sub_total
					);
					$EstimatesitemsModel = new EstimatesitemsModel();
					$EstimatesitemsModel->update($eitem_id,$data2);
					
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
				$invoice_note = $this->request->getPost('estimate_note',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
							
				$UsersModel = new UsersModel();
				$ProjectsModel = new ProjectsModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$_project = $ProjectsModel->where('company_id',$company_id)->where('project_id', $project_id)->first();
				$_client = $UsersModel->where('user_id', $_project['client_id'])->where('user_type','customer')->first();
				// invoice month
				$dd1 = explode('-',$invoice_date);
				$inv_mnth = $dd1[0].'-'.$dd1[1];
				$data = [
					'estimate_number'  => $invoice_number,
					'company_id' => $company_id,
					'client_id' => $_client['user_id'],
					'project_id'  => $project_id,
					'estimate_month'  => $inv_mnth,
					'estimate_date'  => $invoice_date,
					'estimate_due_date'  => $invoice_due_date,
					'sub_total_amount'  => $items_sub_total,
					'discount_type'  => $discount_type,
					'discount_figure'  => $discount_figure,
					'total_tax'  => $tax_rate,
					'tax_type'  => $tax_type,
					'total_discount'  => $discount_amount,
					'grand_total'  => $fgrand_total,
					'estimate_note'  => $invoice_note,
				];
				$EstimatesModel = new EstimatesModel();
				$result = $EstimatesModel->update($id,$data);	
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
						'estimate_id' => $id,
						'project_id' => $project_id,
						'item_name' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_sub_total' => $item_sub_total,
						'created_at' => date('d-m-Y H:i:s')
						);
						$EstimatesitemsModel = new EstimatesitemsModel();
						$EstimatesitemsModel->insert($data3);						
					$ik++; }
					}
					$Return['result'] = lang('Success.ci_estimate_updated_msg');
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
	///estimates_calendar
	public function estimates_calendar()
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
			if(!in_array('invoice_calendar',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_quote_calendar').' | '.$xin_system['application_name'];
		$data['path_url'] = 'estimates';
		$data['breadcrumbs'] = lang('Dashboard.xin_quote_calendar');

		$data['subview'] = view('erp/estimates/calendar_estimates', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function client_invoice_calendar()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_invoice_calendar').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoices';
		$data['breadcrumbs'] = lang('Dashboard.xin_invoice_calendar');

		$data['subview'] = view('erp/invoices/calendar_client_invoices', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}	
	// delete record
	public function delete_estimate_items() {
		
		if($this->request->getVar('record_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$record_id = udecode($this->request->getVar('record_id',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$EstimatesitemsModel = new EstimatesitemsModel();
			$result = $EstimatesitemsModel->where('estimate_item_id', $record_id)->delete($record_id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_estimate_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// read record
	public function read_estimate_data()
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
			return view('erp/estimates/update_estimate', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// |||update cancel_estimate_record|||
	public function cancel_estimate_record() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'cancel_estimate_record') {
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
			$EstimatesModel = new EstimatesModel();
			$result = $EstimatesModel->update($id,$data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_estimate_cancelled_success_msg');
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
	// |||update convert_estimate_record|||
	public function convert_estimate_record() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'convert_estimate_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$UsersModel = new UsersModel();
			$EstimatesModel = new EstimatesModel();
			$EstimatesitemsModel = new EstimatesitemsModel();
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
			$result = $EstimatesModel->where('estimate_id', $id)->first();
			
			$data = [
				'invoice_number'  => $result['estimate_number'],
				'company_id' => $result['company_id'],
				'client_id' => $result['client_id'],
				'project_id'  => $result['project_id'],
				'invoice_month'  => $result['estimate_month'],
				'invoice_date'  => $result['estimate_date'],
				'invoice_due_date'  => $result['estimate_due_date'],
				'sub_total_amount'  => $result['sub_total_amount'],
				'discount_type'  => $result['discount_type'],
				'discount_figure'  => $result['discount_figure'],
				'total_tax'  => $result['total_tax'],
				'tax_type'  => $result['tax_type'],
				'total_discount'  => $result['total_discount'],
				'grand_total'  => $result['grand_total'],
				'status'  => 0,
				'payment_method'  => 0,
				'invoice_note'  => $result['estimate_note'],
				'created_at' => date('d-m-Y h:i:s')
			];
			$InvoicesModel = new InvoicesModel();
			$result = $InvoicesModel->insert($data);	
			$invoice_id = $InvoicesModel->insertID();
			$invoice_items = $EstimatesitemsModel->where('estimate_id', $id)->findAll();
			foreach($invoice_items as $item){
				$data2 = array(
				'invoice_id' => $invoice_id,
				'project_id' => $item['project_id'],
				'item_name' => $item['item_name'],
				'item_qty' => $item['item_qty'],
				'item_unit_price' => $item['item_unit_price'],
				'item_sub_total' => $item['item_sub_total'],
				'created_at' => date('d-m-Y H:i:s')
				);
				$InvoiceitemsModel = new InvoiceitemsModel();
				$InvoiceitemsModel->insert($data2);	
			}
			$data3 = [
				'status'  => 1
			];
			$EstimatesModel = new EstimatesModel();
			$result = $EstimatesModel->update($id,$data3);
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_estimate_convert_to_invoice_success_msg');
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
	public function delete_estimate() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$EstimatesModel = new EstimatesModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $EstimatesModel->where('estimate_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_estimate_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

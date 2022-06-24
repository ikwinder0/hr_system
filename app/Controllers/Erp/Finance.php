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
use CodeIgniter\HTTP\Files\UploadedFile;
 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\PayeesModel;
use App\Models\AccountsModel;
use App\Models\ConstantsModel;
use App\Models\TransactionsModel;

class Finance extends BaseController {
	
	public function bank_cash()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
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
			if(!in_array('accounts1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Finance.xin_accounts').' | '.$xin_system['application_name'];
		$data['path_url'] = 'finance_accounts';
		$data['breadcrumbs'] = lang('Finance.xin_accounts');

		$data['subview'] = view('erp/finance/finance_accounts', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function deposit()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
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
			if(!in_array('deposit1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_acc_deposit').' | '.$xin_system['application_name'];
		$data['path_url'] = 'finance_deposit';
		$data['breadcrumbs'] = lang('Dashboard.xin_acc_deposit');

		$data['subview'] = view('erp/finance/finance_deposit', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function account_ledger()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$AccountsModel = new AccountsModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $AccountsModel->where('account_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
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
			if(!in_array('deposit1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_account_ledger').' | '.$xin_system['application_name'];
		$data['path_url'] = 'finance_deposit';
		$data['breadcrumbs'] = lang('Main.xin_account_ledger');

		$data['subview'] = view('erp/finance/finance_account_ledger', $data);
		return view('erp/layout/pre_layout_main', $data); //page load
	}
	public function transaction_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$TransactionsModel = new TransactionsModel();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $TransactionsModel->where('transaction_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
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
			if(!in_array('deposit1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_transaction_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'finance_deposit';
		$data['breadcrumbs'] = lang('Main.xin_transaction_details');

		$data['subview'] = view('erp/finance/finance_transaction_details', $data);
		return view('erp/layout/pre_layout_main', $data); //page load
	}
	public function expense()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
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
			if(!in_array('expense1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_acc_expense').' | '.$xin_system['application_name'];
		$data['path_url'] = 'finance_expense';
		$data['breadcrumbs'] = lang('Dashboard.xin_acc_expense');

		$data['subview'] = view('erp/finance/finance_expense', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function transfer()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Employees.xin_employee_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'employee_details';
		$data['breadcrumbs'] = lang('Employees.xin_employee_details');

		$data['subview'] = view('erp/finance/finance_transfer', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function transactions()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
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
			if(!in_array('transaction1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_acc_transactions').' | '.$xin_system['application_name'];
		$data['path_url'] = 'finance_transactions';
		$data['breadcrumbs'] = lang('Dashboard.xin_acc_transactions');

		$data['subview'] = view('erp/finance/finance_transactions', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function accounts_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$AccountsModel = new AccountsModel();
		$xin_system = erp_company_settings();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $AccountsModel->where('company_id',$user_info['company_id'])->orderBy('account_id', 'ASC')->findAll();
		} else {
			$get_data = $AccountsModel->where('company_id',$usession['sup_user_id'])->orderBy('account_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('accounts3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['account_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('accounts4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['account_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			// account ledger
			if(in_array('accounts3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$ledger = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/account-ledger').'/'.uencode($r['account_id']).'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			} else {
				$ledger = $r['account_name'];
			}
			$account_balance = number_to_currency($r['account_balance'], $xin_system['default_currency'],null,2);
			$created_at = set_date_format($r['created_at']);
			//$account_name = $ledger;
			$combhr = $ledger.$edit.$delete;
			if(in_array('accounts3',staff_role_resource()) || in_array('accounts4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$iaccount_name = '
				'.$r['account_name'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';	  				
			} else {
				$iaccount_name = $r['account_name'];
			}
				
			$data[] = array(
				$iaccount_name,
				$r['account_number'],
				$account_balance,
				$r['bank_branch']
			);
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
    }
	// record list
	public function deposit_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TransactionsModel = new TransactionsModel();
		$AccountsModel = new AccountsModel();
		$PayeesModel = new PayeesModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$xin_system = erp_company_settings();
		if($user_info['user_type'] == 'staff'){
			$get_data = $TransactionsModel->where('company_id',$user_info['company_id'])->where('transaction_type','income')->orderBy('transaction_id', 'ASC')->findAll();
		} else {
			$get_data = $TransactionsModel->where('company_id',$usession['sup_user_id'])->where('transaction_type','income')->orderBy('transaction_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('deposit3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['transaction_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('deposit4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['transaction_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$iaccounts = $AccountsModel->where('account_id', $r['account_id'])->first();
			if($iaccounts){
				$account_name = $iaccounts['account_name'];
			} else {
				$account_name = '';
			}
			//$f_entity = $PayeesModel->where('entity_id', $r['entity_id'])->where('type', 'payer')->first();
			// user info
			$f_entity = $UsersModel->where('user_id', $r['entity_id'])->where('user_type','staff')->first();
			if($f_entity){
				$payer_name = $f_entity['first_name'].' '.$f_entity['last_name'];
			} else {
				$payer_name = '';
			}
			
			$amount = number_to_currency($r['amount'], $xin_system['default_currency'],null,2);
			$category_info = $ConstantsModel->where('constants_id', $r['entity_category_id'])->where('type', 'income_type')->first();
			if($category_info){
				$category_name = $category_info['category_name'];
			} else {
				$category_name = '';
			}
			$payment_method = $ConstantsModel->where('constants_id', $r['payment_method_id'])->where('type', 'payment_method')->first();
			if($payment_method){
				$ipayment_method = $payment_method['category_name'];
			} else {
				$ipayment_method = '';
			}
			
			$transaction_date = set_date_format($r['transaction_date']);
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/transaction-details').'/'.uencode($r['transaction_id']).'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			$combhr = $view.$edit.$delete;
			$iaccount_name = '
			'.$account_name.'
			<div class="overlay-edit">
				'.$combhr.'
			</div>';
			$data[] = array(
				$iaccount_name,
				$payer_name,
				$amount,
				$category_name,
				$r['reference'],
				$ipayment_method,
				$transaction_date
			);	
			
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     } 
	// record list
	public function expense_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TransactionsModel = new TransactionsModel();
		$AccountsModel = new AccountsModel();
		$PayeesModel = new PayeesModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$xin_system = erp_company_settings();
		if($user_info['user_type'] == 'staff'){
			$get_data = $TransactionsModel->where('entity_id',$usession['sup_user_id'])->where('transaction_type','expense')->orderBy('transaction_id', 'ASC')->findAll();
		} else {
			$get_data = $TransactionsModel->where('company_id',$usession['sup_user_id'])->where('transaction_type','expense')->orderBy('transaction_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('expense3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. uencode($r['transaction_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('expense4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['transaction_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$iaccounts = $AccountsModel->where('account_id', $r['account_id'])->first();
			if($iaccounts){
				$account_name = $iaccounts['account_name'];
			} else {
				$account_name = '';
			}
			//$f_entity = $PayeesModel->where('entity_id', $r['entity_id'])->where('type', 'payee')->first();
			$f_entity = $UsersModel->where('user_id', $r['entity_id'])->where('user_type','staff')->first();
			if($f_entity){
				$payer_name = $f_entity['first_name'].' '.$f_entity['last_name'];
			} else {
				$payer_name = '';
			}
			$amount = number_to_currency($r['amount'], $xin_system['default_currency'],null,2);
			$category_info = $ConstantsModel->where('constants_id', $r['entity_category_id'])->where('type', 'expense_type')->first();
			if($category_info){
				$category_name = $category_info['category_name'];
			} else {
				$category_name = '';
			}
			$payment_method = $ConstantsModel->where('constants_id', $r['payment_method_id'])->where('type', 'payment_method')->first();
			if($payment_method){
				$ipayment_method = $payment_method['category_name'];
			} else {
				$ipayment_method = '';
			}
			
			$transaction_date = set_date_format($r['transaction_date']);
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/transaction-details').'/'.uencode($r['transaction_id']).'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			$combhr = $view.$edit.$delete;
			$iaccount_name = '
			'.$iaccounts['account_name'].'
			<div class="overlay-edit">
				'.$combhr.'
			</div>';
				
			$data[] = array(
				$iaccount_name,
				$payer_name,
				$amount,
				$category_name,
				$r['reference'],
				$ipayment_method,
				$transaction_date
			);	
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }  
	 // record list
	public function transaction_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TransactionsModel = new TransactionsModel();
		$AccountsModel = new AccountsModel();
		$PayeesModel = new PayeesModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$xin_system = erp_company_settings();
		if($user_info['user_type'] == 'staff'){
			$get_data = $TransactionsModel->where('company_id',$user_info['company_id'])->orderBy('transaction_id', 'ASC')->findAll();
		} else {
			$get_data = $TransactionsModel->where('company_id',$usession['sup_user_id'])->orderBy('transaction_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  			
			$iaccounts = $AccountsModel->where('account_id', $r['account_id'])->first();
			if($iaccounts){
				$account_name = $iaccounts['account_name'];
			} else {
				$account_name = '--';
			}
			
			$amount = number_to_currency($r['amount'], $xin_system['default_currency'],null,2);
		//	$category_info = $ConstantsModel->where('constants_id', $r['entity_category_id'])->first();
			$payment_method = $ConstantsModel->where('constants_id', $r['payment_method_id'])->where('type', 'payment_method')->first();
			if($payment_method){
				$ipayment_method = $payment_method['category_name'];
			} else {
				$ipayment_method = '';
			}
			$transaction_date = set_date_format($r['transaction_date']);
			// credit
			$cr_dr = $r['dr_cr']=="cr" ? lang('Finance.xin_credit') : lang('Finance.xin_debit');
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/transaction-details').'/'.uencode($r['transaction_id']).'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			$combhr = $view;
			$iaccount_name = '
			'.$account_name.'
			<div class="overlay-edit">
				'.$combhr.'
			</div>';
			$data[] = array(
				$iaccount_name,
				$transaction_date,
				$cr_dr,
				$ipayment_method,
				$amount,
				$r['reference']
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     } 
	// |||add record|||
	public function add_account() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'account_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'account_balance' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'account_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "account_name" => $validation->getError('account_name'),
					"account_balance" => $validation->getError('account_balance'),
					"account_number" => $validation->getError('account_number')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$account_name = $this->request->getPost('account_name',FILTER_SANITIZE_STRING);		
				$account_balance = $this->request->getPost('account_balance',FILTER_SANITIZE_STRING);	
				$account_number = $this->request->getPost('account_number',FILTER_SANITIZE_STRING);
				$branch_code = $this->request->getPost('branch_code',FILTER_SANITIZE_STRING);
				$bank_branch = $this->request->getPost('bank_branch',FILTER_SANITIZE_STRING);
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'account_name' => $account_name,
					'account_balance'  => $account_balance,
					'account_opening_balance' => $account_balance,
					'account_number'  => $account_number,
					'branch_code' => $branch_code,
					'bank_branch'  => $bank_branch,
					'created_at' => date('d-m-Y h:i:s')
				];
				$AccountsModel = new AccountsModel();
				$result = $AccountsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_finance_account_added_msg');
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
	// |||add record|||
	public function add_deposit() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'account_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_account_field_error')
					]
				],
				'amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'deposit_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'category_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_category_field_error')
					]
				],
				'payer_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_payer_field_error')
					]
				],
				'payment_method' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'attachment' => [
					'rules'  => 'uploaded[attachment]|mime_in[attachment,image/jpg,image/jpeg,image/gif,image/png]|max_size[attachment,3072]',
					'errors' => [
						'uploaded' => lang('Main.xin_error_field_text'),
						'mime_in' => 'wrong size'
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "account_id" => $validation->getError('account_id'),
					"amount" => $validation->getError('amount'),
					"deposit_date" => $validation->getError('deposit_date'),
					"category_id" => $validation->getError('category_id'),
					"payer_id" => $validation->getError('payer_id'),
					"payment_method" => $validation->getError('payment_method'),
					"attachment" => $validation->getError('attachment')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				$attachment = $this->request->getFile('attachment');
				$file_name = $attachment->getName();
				$attachment->move('public/uploads/transactions/');
				
				$account_id = $this->request->getPost('account_id',FILTER_SANITIZE_STRING);
				$amount = $this->request->getPost('amount',FILTER_SANITIZE_STRING);
				$deposit_date = $this->request->getPost('deposit_date',FILTER_SANITIZE_STRING);
				$category_id = $this->request->getPost('category_id',FILTER_SANITIZE_STRING);
				$payer_id = $this->request->getPost('payer_id',FILTER_SANITIZE_STRING);
				$payment_method = $this->request->getPost('payment_method',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$reference = $this->request->getPost('reference',FILTER_SANITIZE_STRING);
				
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				
				$data = [
					'company_id' => $company_id,
					'staff_id' => $usession['sup_user_id'],
					'account_id'  => $account_id,
					'transaction_date'  => $deposit_date,
					'transaction_type'  => 'income',
					'entity_id'  => $payer_id,
					'entity_type'  => 'payer',
					'entity_category_id'  => $category_id,
					'description'  => $description,
					'amount'  => $amount,
					'dr_cr'  => 'cr',
					'payment_method_id' => $payment_method,
					'reference' => $reference,
					'attachment_file' => $file_name,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TransactionsModel = new TransactionsModel();
				$result = $TransactionsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_finance_deposit_added_msg');
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
	// |||add record|||
	public function add_expense() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'account_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_account_field_error')
					]
				],
				'amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'deposit_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_date_field_error')
					]
				],
				'category_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_category_field_error')
					]
				],
				'payer_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_payee_field_error')
					]
				],
				'payment_method' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'attachment' => [
					'rules'  => 'uploaded[attachment]|mime_in[attachment,image/jpg,image/jpeg,image/gif,image/png]|max_size[attachment,3072]',
					'errors' => [
						'uploaded' => lang('Main.xin_error_field_text'),
						'mime_in' => 'wrong size'
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "account_id" => $validation->getError('account_id'),
					"amount" => $validation->getError('amount'),
					"deposit_date" => $validation->getError('deposit_date'),
					"category_id" => $validation->getError('category_id'),
					"payer_id" => $validation->getError('payer_id'),
					"payment_method" => $validation->getError('payment_method'),
					"attachment" => $validation->getError('attachment')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				$attachment = $this->request->getFile('attachment');
				$file_name = $attachment->getName();
				$attachment->move('public/uploads/transactions/');
				
				$account_id = $this->request->getPost('account_id',FILTER_SANITIZE_STRING);
				$amount = $this->request->getPost('amount',FILTER_SANITIZE_STRING);
				$deposit_date = $this->request->getPost('deposit_date',FILTER_SANITIZE_STRING);
				$category_id = $this->request->getPost('category_id',FILTER_SANITIZE_STRING);
				$payer_id = $this->request->getPost('payer_id',FILTER_SANITIZE_STRING);
				$payment_method = $this->request->getPost('payment_method',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$reference = $this->request->getPost('reference',FILTER_SANITIZE_STRING);
				
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				
				$data = [
					'company_id' => $company_id,
					'staff_id' => $usession['sup_user_id'],
					'account_id'  => $account_id,
					'transaction_date'  => $deposit_date,
					'transaction_type'  => 'expense',
					'entity_id'  => $payer_id,
					'entity_type'  => 'payee',
					'entity_category_id'  => $category_id,
					'description'  => $description,
					'amount'  => $amount,
					'dr_cr'  => 'dr',
					'payment_method_id' => $payment_method,
					'reference' => $reference,
					'attachment_file' => $file_name,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TransactionsModel = new TransactionsModel();
				$result = $TransactionsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_finance_expense_added_msg');
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
	// |||edit record|||
	public function update_deposit() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'account_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_account_field_error')
					]
				],
				'amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'deposit_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'category_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_category_field_error')
					]
				],
				'payer_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_payer_field_error')
					]
				],
				'payment_method' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "account_id" => $validation->getError('account_id'),
					"amount" => $validation->getError('amount'),
					"deposit_date" => $validation->getError('deposit_date'),
					"category_id" => $validation->getError('category_id'),
					"payer_id" => $validation->getError('payer_id'),
					"payment_method" => $validation->getError('payment_method')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				 $validated = $this->validate([
					'attachment' => [
						'rules'  => 'uploaded[attachment]|mime_in[attachment,image/jpg,image/jpeg,image/gif,image/png]|max_size[attachment,3072]',
						'errors' => [
							'uploaded' => lang('Main.xin_error_field_text'),
							'mime_in' => 'wrong size'
						]
					]
				]);
				if ($validated) {
					$attachment = $this->request->getFile('attachment');
					$file_name = $attachment->getName();
					$attachment->move('public/uploads/transactions/');
				}
				
				$account_id = $this->request->getPost('account_id',FILTER_SANITIZE_STRING);
				$amount = $this->request->getPost('amount',FILTER_SANITIZE_STRING);
				$deposit_date = $this->request->getPost('deposit_date',FILTER_SANITIZE_STRING);
				$category_id = $this->request->getPost('category_id',FILTER_SANITIZE_STRING);
				$payer_id = $this->request->getPost('payer_id',FILTER_SANITIZE_STRING);
				$payment_method = $this->request->getPost('payment_method',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$reference = $this->request->getPost('reference',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				
				if ($validated) {
					$data = [
						'account_id'  => $account_id,
						'transaction_date'  => $deposit_date,
						'entity_id'  => $payer_id,
						'entity_category_id'  => $category_id,
						'description'  => $description,
						'amount'  => $amount,
						'payment_method_id' => $payment_method,
						'reference' => $reference,
						'attachment_file' => $file_name
					];
				} else {
					$data = [
						'account_id'  => $account_id,
						'transaction_date'  => $deposit_date,
						'entity_id'  => $payer_id,
						'entity_category_id'  => $category_id,
						'description'  => $description,
						'amount'  => $amount,
						'payment_method_id' => $payment_method,
						'reference' => $reference
					];
				}
				
				$TransactionsModel = new TransactionsModel();
				$result = $TransactionsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_finance_deposit_updated_msg');
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
	// |||edit record|||
	public function update_expense() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'account_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' =>lang('Success.xin_account_field_error')
					]
				],
				'amount' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'deposit_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_date_field_error')
					]
				],
				'category_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_category_field_error')
					]
				],
				'payer_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_payee_field_error')
					]
				],
				'payment_method' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "account_id" => $validation->getError('account_id'),
					"amount" => $validation->getError('amount'),
					"deposit_date" => $validation->getError('deposit_date'),
					"category_id" => $validation->getError('category_id'),
					"payer_id" => $validation->getError('payer_id'),
					"payment_method" => $validation->getError('payment_method')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				 $validated = $this->validate([
					'attachment' => [
						'rules'  => 'uploaded[attachment]|mime_in[attachment,image/jpg,image/jpeg,image/gif,image/png]|max_size[attachment,3072]',
						'errors' => [
							'uploaded' => lang('Main.xin_error_field_text'),
							'mime_in' => 'wrong size'
						]
					]
				]);
				if ($validated) {
					$attachment = $this->request->getFile('attachment');
					$file_name = $attachment->getName();
					$attachment->move('public/uploads/transactions/');
				}
				
				$account_id = $this->request->getPost('account_id',FILTER_SANITIZE_STRING);
				$amount = $this->request->getPost('amount',FILTER_SANITIZE_STRING);
				$deposit_date = $this->request->getPost('deposit_date',FILTER_SANITIZE_STRING);
				$category_id = $this->request->getPost('category_id',FILTER_SANITIZE_STRING);
				$payer_id = $this->request->getPost('payer_id',FILTER_SANITIZE_STRING);
				$payment_method = $this->request->getPost('payment_method',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$reference = $this->request->getPost('reference',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				
				if ($validated) {
					$data = [
						'account_id'  => $account_id,
						'transaction_date'  => $deposit_date,
						'entity_id'  => $payer_id,
						'entity_category_id'  => $category_id,
						'description'  => $description,
						'amount'  => $amount,
						'payment_method_id' => $payment_method,
						'reference' => $reference,
						'attachment_file' => $file_name
					];
				} else {
					$data = [
						'account_id'  => $account_id,
						'transaction_date'  => $deposit_date,
						'entity_id'  => $payer_id,
						'entity_category_id'  => $category_id,
						'description'  => $description,
						'amount'  => $amount,
						'payment_method_id' => $payment_method,
						'reference' => $reference
					];
				}
				
				$TransactionsModel = new TransactionsModel();
				$result = $TransactionsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_finance_expense_updated_msg');
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
	// |||edit record|||
	public function update_account() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'account_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'account_balance' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'account_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "account_name" => $validation->getError('account_name'),
					"account_balance" => $validation->getError('account_balance'),
					"account_number" => $validation->getError('account_number')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$account_name = $this->request->getPost('account_name',FILTER_SANITIZE_STRING);		
				$account_balance = $this->request->getPost('account_balance',FILTER_SANITIZE_STRING);	
				$account_number = $this->request->getPost('account_number',FILTER_SANITIZE_STRING);
				$branch_code = $this->request->getPost('branch_code',FILTER_SANITIZE_STRING);
				$bank_branch = $this->request->getPost('bank_branch',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				
				$data = [
					'account_name' => $account_name,
					'account_balance'  => $account_balance,
					'account_opening_balance' => $account_balance,
					'account_number'  => $account_number,
					'branch_code' => $branch_code,
					'bank_branch'  => $bank_branch
				];
				$AccountsModel = new AccountsModel();
				$result = $AccountsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_finance_account_updated_msg');
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
	// read record
	public function read_accounts()
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
			return view('erp/finance/dialog_accounts', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_transactions()
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
			return view('erp/finance/dialog_transactions', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_account() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$AccountsModel = new AccountsModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $AccountsModel->where('account_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_finance_account_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_transaction() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$TransactionsModel = new TransactionsModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $TransactionsModel->where('transaction_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_finance_data_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

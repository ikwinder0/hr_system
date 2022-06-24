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
use App\Models\InvoicesModel;
use App\Models\InvoiceitemsModel;

class Invoices extends BaseController {

	public function project_invoices()
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
		$data['title'] = lang('Invoices.xin_billing_invoices').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoices';
		$data['breadcrumbs'] = lang('Invoices.xin_billing_invoices');

		$data['subview'] = view('erp/invoices/invoice_project_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function project_invoice_payment()
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
			if(!in_array('invoice_payments',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_acc_invoice_payments').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoice_project_payments';
		$data['breadcrumbs'] = lang('Dashboard.xin_acc_invoice_payments');

		$data['subview'] = view('erp/invoices/project_invoice_payment_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function client_invoice_payment()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_acc_invoice_payments').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoice_client_payments';
		$data['breadcrumbs'] = lang('Dashboard.xin_acc_invoice_payments');

		$data['subview'] = view('erp/invoices/client_invoice_payment_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function invoices_client()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Invoices.xin_billing_invoices').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoices_client';
		$data['breadcrumbs'] = lang('Invoices.xin_billing_invoices');

		$data['subview'] = view('erp/invoices/client_invoice_project_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function invoice_dashboard()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Invoices.xin_billing_invoices').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoices';
		$data['breadcrumbs'] = lang('Invoices.xin_billing_invoices');

		$data['subview'] = view('erp/invoices/invoice_dashboard', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function invoice_calendar()
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
		$data['title'] = lang('Dashboard.xin_invoice_calendar').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoices';
		$data['breadcrumbs'] = lang('Dashboard.xin_invoice_calendar');

		$data['subview'] = view('erp/invoices/calendar_invoices', $data);
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
	public function create_invoice()
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
		$data['title'] = lang('Invoices.xin_create_new_invoices').' | '.$xin_system['application_name'];
		$data['path_url'] = 'create_invoice';
		$data['breadcrumbs'] = lang('Invoices.xin_create_new_invoices');

		$data['subview'] = view('erp/invoices/create_invoice', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function edit_invoice()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$InvoicesModel = new InvoicesModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $InvoicesModel->where('invoice_id', $ifield_id)->first();
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
		$data['path_url'] = 'create_invoice';
		$data['breadcrumbs'] = lang('Invoices.xin_edit_invoice');

		$data['subview'] = view('erp/invoices/edit_invoice', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function invoice_details()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$InvoicesModel = new InvoicesModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $InvoicesModel->where('invoice_id', $ifield_id)->first();
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
		$data['title'] = lang('Invoices.xin_view_invoice').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoice_details';
		$data['breadcrumbs'] = lang('Invoices.xin_view_invoice');

		$data['subview'] = view('erp/invoices/project_billing_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function view_project_invoice()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		//$SuperroleModel = new SuperroleModel();
		$usession = $session->get('sup_username');
		$InvoicesModel = new InvoicesModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $InvoicesModel->where('invoice_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Invoices.xin_view_invoice').' | '.$xin_system['application_name'];
		$data['path_url'] = 'invoice_details';
		$data['breadcrumbs'] = lang('Invoices.xin_view_invoice');

		$data['subview'] = view('erp/invoices/view_project_invoice', $data);
		return view('erp/layout/pre_layout_main', $data); //page load
	}
	// list
	public function invoices_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');	
		$InvoicesModel = new InvoicesModel();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$ProjectsModel = new ProjectsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $InvoicesModel->where('company_id',$user_info['company_id'])->orderBy('invoice_id', 'ASC')->findAll();
		} else {
			$get_data = $InvoicesModel->where('company_id',$usession['sup_user_id'])->orderBy('invoice_id', 'ASC')->findAll();
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
		$data = array();
		
          foreach($get_data as $r) {						
		  	
			
			$project = $ProjectsModel->where('company_id',$r['company_id'])->where('project_id',$r['project_id'])->first();
			$invoice_total = number_to_currency($r['grand_total'], $xin_system['default_currency']);

			$invoice_date = set_date_format($r['invoice_date']);
			$invoice_due_date = set_date_format($r['invoice_due_date']);
			$invoice_id = '<a href="'.site_url('erp/invoice-detail').'/'.uencode($r['invoice_id']).'"><span>#'.$r['invoice_number'].'</span></a>';
			if($r['status'] == 0){
				$status = '<span class="badge badge-light-danger">'.lang('Invoices.xin_unpaid').'</span>';
			} else if($r['status'] == 1) {
				$status = '<span class="badge badge-light-success">'.lang('Invoices.xin_paid').'</span>';
			} else {
				$status = '<span class="badge badge-light-info">'.lang('Projects.xin_project_cancelled').'</span>';
			}
			$links = '
				'.$invoice_id.'
				<div class="overlay-edit">
					<a href="'.site_url('erp/invoice-detail/'). uencode($r['invoice_id']) . '"><button type="button" class="btn btn-sm btn-icon btn-light-primary"><i class="feather icon-download"></i></button></a>
				</div>
			';
			$data[] = array(
				$links,
				$project['title'],
				$invoice_total,
				$invoice_date,
				$invoice_due_date,
				$status,
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	// list
	public function client_invoices_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');	
		$InvoicesModel = new InvoicesModel();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$ProjectsModel = new ProjectsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $InvoicesModel->where('company_id',$user_info['company_id'])->where('client_id',$usession['sup_user_id'])->orderBy('invoice_id', 'ASC')->findAll();
		$xin_system = erp_company_settings();
		
		$data = array();
		
          foreach($get_data as $r) {						
		  	
			
			$project = $ProjectsModel->where('company_id',$r['company_id'])->where('project_id',$r['project_id'])->first();
			$invoice_total = number_to_currency($r['grand_total'], $xin_system['default_currency'],null,2);

			$invoice_date = set_date_format($r['invoice_date']);
			$invoice_due_date = set_date_format($r['invoice_due_date']);
			$invoice_id = '<a href="'.site_url('erp/invoice-detail').'/'.uencode($r['invoice_id']).'"><span>#'.$r['invoice_number'].'</span></a>';
			if($r['status'] == 0){
				$status = '<span class="badge badge-light-danger">'.lang('Invoices.xin_unpaid').'</span>';
			} else if($r['status'] == 1) {
				$status = '<span class="badge badge-light-success">'.lang('Invoices.xin_paid').'</span>';
			} else {
				$status = '<span class="badge badge-light-info">'.lang('Projects.xin_project_cancelled').'</span>';
			}
			$view = '<a href="'.site_url('erp/invoice-detail/'). uencode($r['invoice_id']) . '"><button type="button" class="btn btn-sm btn-icon btn-light-success"><i class="feather icon-eye"></i></button></a>';
			if($r['status'] == 1){
				$download = '<a href="'.site_url('erp/print-invoice/'). uencode($r['invoice_id']) . '"><button type="button" class="btn btn-sm btn-icon btn-light-primary"><i class="feather icon-download"></i></button></a>';
			} else {
				$download = '';
			}
			$links = '
				'.$invoice_id.'
				<div class="overlay-edit">
					 '.$view.$download.'
				</div>
			';
			$data[] = array(
				$links,
				$project['title'],
				$invoice_total,
				$invoice_date,
				$invoice_due_date,
				$status,
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     } 
	 // list
	public function client_profile_invoices_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');	
		$request = \Config\Services::request();
		$InvoicesModel = new InvoicesModel();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$ProjectsModel = new ProjectsModel();
		$client_id = udecode($this->request->getVar('client_id',FILTER_SANITIZE_STRING));
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		$get_data = $InvoicesModel->where('company_id',$company_id)->where('client_id',$client_id)->orderBy('invoice_id', 'ASC')->findAll();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
		$data = array();
		
          foreach($get_data as $r) {						
		  	
			
			$project = $ProjectsModel->where('company_id',$r['company_id'])->where('project_id',$r['project_id'])->first();
			$invoice_total = number_to_currency($r['grand_total'], $xin_system['default_currency'],null,2);

			$invoice_date = set_date_format($r['invoice_date']);
			$invoice_due_date = set_date_format($r['invoice_due_date']);
			$invoice_id = '<a href="'.site_url('erp/invoice-detail').'/'.uencode($r['invoice_id']).'"><span>#'.$r['invoice_number'].'</span></a>';
			if($r['status'] == 0){
				$status = '<span class="badge badge-light-danger">'.lang('Invoices.xin_unpaid').'</span>';
			} else if($r['status'] == 1) {
				$status = '<span class="badge badge-light-success">'.lang('Invoices.xin_paid').'</span>';
			} else {
				$status = '<span class="badge badge-light-info">'.lang('Projects.xin_project_cancelled').'</span>';
			}
			$links = '
				'.$invoice_id.'
				<div class="overlay-edit">
					<a href="'.site_url('erp/invoice-detail/'). uencode($r['invoice_id']) . '"><button type="button" class="btn btn-sm btn-icon btn-light-primary"><i class="feather icon-download"></i></button></a>
				</div>
			';
			$data[] = array(
				$links,
				$project['title'],
				$invoice_date,
				$invoice_total,
				$status,
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     } 
	// list
	public function project_billing_list() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');	
		$InvoicesModel = new InvoicesModel();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$ProjectsModel = new ProjectsModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $InvoicesModel->where('company_id',$user_info['company_id'])->where('status',1)->orderBy('invoice_id', 'ASC')->findAll();
		} else {
			$get_data = $InvoicesModel->where('company_id',$usession['sup_user_id'])->where('status',1)->orderBy('invoice_id', 'ASC')->findAll();
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		
		$data = array();
		
          foreach($get_data as $r) {						
		  	
			
			$project = $ProjectsModel->where('company_id',$r['company_id'])->where('project_id',$r['project_id'])->first();
			if($project){
				$ititle = $project['title'];
			} else {
				$ititle = '--';
			}
			$invoice_total = number_to_currency($r['grand_total'], $xin_system['default_currency'],null,2);

			$invoice_date = set_date_format($r['invoice_date']);
			$invoice_due_date = set_date_format($r['invoice_due_date']);
			$invoice_id = '<a href="'.site_url('erp/invoice-detail').'/'.uencode($r['invoice_id']).'"><span>'.$r['invoice_number'].'</span></a>';
			if($r['status'] == 0){
				$status = '<span class="badge badge-light-danger">'.lang('Invoices.xin_unpaid').'</span>';
			} else if($r['status'] == 1) {
				$status = '<span class="badge badge-light-success">'.lang('Invoices.xin_paid').'</span>';
			} else {
				$status = '<span class="badge badge-light-info">'.lang('Projects.xin_project_cancelled').'</span>';
			}
			$_payment_method = $ConstantsModel->where('type','payment_method')->where('constants_id', $r['payment_method'])->first();
			if($_payment_method){
				$ipayment_method = $_payment_method['category_name'];
			} else {
				$ipayment_method = '--';
			}
			$links = '
				'.$invoice_id.'
				<div class="overlay-edit">
					<a href="'.site_url('erp/invoice-detail/'). uencode($r['invoice_id']) . '"><button type="button" class="btn btn-sm btn-icon btn-light-success"><i class="feather icon-eye"></i></button></a> <a href="'.site_url('erp/print-invoice/'). uencode($r['invoice_id']) . '"><button type="button" class="btn btn-sm btn-icon btn-light-primary"><i class="feather icon-download"></i></button></a>
				</div>
			';
			$data[] = array(
				$links,
				$ititle,
				$invoice_date,
				$invoice_total,
				$ipayment_method,
				$status,
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 // list
	public function client_project_billing_list() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');	
		$InvoicesModel = new InvoicesModel();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$ConstantsModel = new ConstantsModel();
		$ProjectsModel = new ProjectsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $InvoicesModel->where('company_id',$user_info['company_id'])->where('client_id',$usession['sup_user_id'])->where('status',1)->orderBy('invoice_id', 'ASC')->findAll();
		$xin_system = erp_company_settings();
		
		$data = array();
		
          foreach($get_data as $r) {						
		  	
			$project = $ProjectsModel->where('company_id',$r['company_id'])->where('project_id',$r['project_id'])->first();
			$invoice_total = number_to_currency($r['grand_total'], $xin_system['default_currency'],null,2);

			$invoice_date = set_date_format($r['invoice_date']);
			$invoice_due_date = set_date_format($r['invoice_due_date']);
			$invoice_id = '<a href="'.site_url('erp/invoice-detail').'/'.uencode($r['invoice_id']).'"><span>#'.$r['invoice_number'].'</span></a>';
			if($r['status'] == 0){
				$status = '<span class="badge badge-light-danger">'.lang('Invoices.xin_unpaid').'</span>';
			} else if($r['status'] == 1) {
				$status = '<span class="badge badge-light-success">'.lang('Invoices.xin_paid').'</span>';
			} else {
				$status = '<span class="badge badge-light-info">'.lang('Projects.xin_project_cancelled').'</span>';
			}
			$_payment_method = $ConstantsModel->where('type','payment_method')->where('constants_id', $r['payment_method'])->first();
			$links = '
				'.$invoice_id.'
				<div class="overlay-edit">
					<a href="'.site_url('erp/invoice-detail/'). uencode($r['invoice_id']) . '"><button type="button" class="btn btn-sm btn-icon btn-light-primary"><i class="feather icon-download"></i></button></a>
				</div>
			';
			$data[] = array(
				$links,
				$project['title'],
				$invoice_date,
				$invoice_total,
				$_payment_method['category_name'],
				$status,
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
	public function create_new_invoice() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'invoice_number' => [
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
                    "invoice_number" => $validation->getError('invoice_number'),
					"project" => $validation->getError('project'),
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
				$invoice_number = $this->request->getPost('invoice_number',FILTER_SANITIZE_STRING);
				$project_id = $this->request->getPost('project',FILTER_SANITIZE_STRING);
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
					'invoice_number'  => $invoice_number,
					'company_id' => $company_id,
					'client_id' => $_client['user_id'],
					'project_id'  => $project_id,
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
				$InvoicesModel = new InvoicesModel();
				$result = $InvoicesModel->insert($data);	
				$invoice_id = $InvoicesModel->insertID();
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
						'invoice_id' => $invoice_id,
						'project_id' => $project_id,
						'item_name' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_sub_total' => $item_sub_total,
						'created_at' => date('d-m-Y H:i:s')
						);
						$InvoiceitemsModel = new InvoiceitemsModel();
						$InvoiceitemsModel->insert($data2);						
					$key++; }
					$Return['result'] = lang('Success.ci_invoice_created__msg');
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
	public function update_invoice() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'invoice_number' => [
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
                    "invoice_number" => $validation->getError('invoice_number'),
					"project" => $validation->getError('project'),
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
				$invoice_number = $this->request->getPost('invoice_number',FILTER_SANITIZE_STRING);
				$project_id = $this->request->getPost('project',FILTER_SANITIZE_STRING);
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
					'item_name' => $iname,
					'item_qty' => $qtyhrs,
					'item_unit_price' => $price,
					'item_sub_total' => $item_sub_total
					);
					$InvoiceitemsModel = new InvoiceitemsModel();
					$InvoiceitemsModel->update($eitem_id,$data2);
					
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
					'invoice_number'  => $invoice_number,
					'company_id' => $company_id,
					'client_id' => $_client['user_id'],
					'project_id'  => $project_id,
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
				$InvoicesModel = new InvoicesModel();
				$result = $InvoicesModel->update($id,$data);	
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
						'invoice_id' => $id,
						'project_id' => $project_id,
						'item_name' => $iname,
						'item_qty' => $qtyhrs,
						'item_unit_price' => $price,
						'item_sub_total' => $item_sub_total,
						'created_at' => date('d-m-Y H:i:s')
						);
						$InvoiceitemsModel = new InvoiceitemsModel();
						$InvoiceitemsModel->insert($data3);						
					$ik++; }
					}
					$Return['result'] = lang('Success.ci_invoice_updated_msg');
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
	public function delete_invoice_items() {
		
		if($this->request->getVar('record_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$record_id = udecode($this->request->getVar('record_id',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$InvoiceitemsModel = new InvoiceitemsModel();
			$result = $InvoiceitemsModel->where('invoice_item_id', $record_id)->delete($record_id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_invoice_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	public function invoice_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$InvoicesModel = new InvoicesModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$unpaid_count = $InvoicesModel->where('company_id',$user_info['company_id'])->where('status', 0)->countAllResults();
			$paid_count = $InvoicesModel->where('company_id',$user_info['company_id'])->where('status', 1)->countAllResults();
		} else {
			$unpaid_count = $InvoicesModel->where('company_id',$usession['sup_user_id'])->where('status', 0)->countAllResults();
			$paid_count = $InvoicesModel->where('company_id',$usession['sup_user_id'])->where('status', 1)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('paid'=>'', 'paid_count'=>'','unpaid'=>'', 'unpaid_count'=>'');
		
		// unpaid
		$Return['unpaid'] = lang('Invoices.xin_unpaid');
		$Return['unpaid_count'] = $unpaid_count;
		// paid
		$Return['paid'] = lang('Invoices.xin_paid');
		$Return['paid_count'] = $paid_count;
		$this->output($Return);
		exit;
	}
	public function invoice_amount_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$InvoicesModel = new InvoicesModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		
		/* Define return | here result is used to return user data and error for error message *///
		$Return = array('invoice_amount'=>'', 'paid_invoice'=>'','unpaid_invoice'=>'', 'paid_inv_label'=>'','unpaid_inv_label'=>'');
		$invoice_month = array();
		$paid_invoice = array();
		$someArray = array();
		$j=0;
		for ($i = 0; $i <= 5; $i++) 
		{
		   $months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));		   
		   $paid_amount = erp_paid_invoices($months);
		   $paid_amount =  number_format($paid_amount, 2, '.', '');
		   $unpaid_amount = erp_unpaid_invoices($months);
		   $unpaid_amount =  number_format($unpaid_amount, 2, '.', '');
		   $paid_invoice[] = $paid_amount;
		   $unpaid_invoice[] = $unpaid_amount;
		   $invoice_month[] = $months;		   
		}
		$Return['invoice_month'] = $invoice_month;
		$Return['paid_inv_label'] = lang('Invoices.xin_paid_invoices');
		$Return['unpaid_inv_label'] = lang('Invoices.xin_unpaid_invoices');
		$Return['paid_invoice'] = $paid_invoice;
		$Return['unpaid_invoice'] = $unpaid_invoice;
		$this->output($Return);
		exit;
	}
	public function client_invoice_amount_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$InvoicesModel = new InvoicesModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$company_id = $user_info['company_id'];
		} else {
			$company_id = $usession['sup_user_id'];
		}
		
		/* Define return | here result is used to return user data and error for error message *///
		$Return = array('invoice_amount'=>'', 'paid_invoice'=>'','unpaid_invoice'=>'', 'paid_inv_label'=>'','unpaid_inv_label'=>'');
		$invoice_month = array();
		$paid_invoice = array();
		$someArray = array();
		$j=0;
		for ($i = 0; $i <= 5; $i++) 
		{
		   $months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));		   
		   $paid_amount = client_paid_invoices($months);
		   $unpaid_amount = client_unpaid_invoices($months);
		   $paid_invoice[] = $paid_amount;
		   $unpaid_invoice[] = $unpaid_amount;
		   $invoice_month[] = $months;		   
		}
		$Return['invoice_month'] = $invoice_month;
		$Return['paid_inv_label'] = lang('Invoices.xin_paid_invoices');
		$Return['unpaid_inv_label'] = lang('Invoices.xin_unpaid_invoices');
		$Return['paid_invoice'] = $paid_invoice;
		$Return['unpaid_invoice'] = $unpaid_invoice;
		$this->output($Return);
		exit;
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
			return view('erp/invoices/pay_invoice', $data);
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
				$InvoicesModel = new InvoicesModel();
				$result = $InvoicesModel->update($id,$data);	
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
	// delete record
	public function delete_invoice() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$InvoicesModel = new InvoicesModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $InvoicesModel->where('invoice_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_invoice_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

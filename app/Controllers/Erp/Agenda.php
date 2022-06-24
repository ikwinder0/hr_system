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
use CodeIgniter\I18n\Time;

use App\Models\MainModel;
use App\Models\TasksModel;
use App\Models\LeaveModel; 
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\PayeesModel;
use App\Models\SystemModel;
use App\Models\TravelModel;
use App\Models\AwardsModel;
use App\Models\ProjectsModel;
use App\Models\AccountsModel;
use App\Models\ConstantsModel;
use App\Models\ContractModel;
use App\Models\PayrollModel;
use App\Models\StaffdetailsModel;
use App\Models\TransactionsModel;
use App\Models\AdvancesalaryModel;
use App\Models\OvertimerequestModel;


class Agenda extends BaseController {

	// record list
	public function leave_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}	
		$request = \Config\Services::request();	
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$LeaveModel = new LeaveModel();
		$id = $request->uri->getSegment(4);
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $LeaveModel->where('employee_id',$id)->orderBy('leave_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
			  
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/view-leave-info/'.uencode($r['leave_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			// leave type
			$ltype = $ConstantsModel->where('constants_id', $r['leave_type_id'])->where('type','leave_type')->first();
			if($ltype['category_name']){
				$itype_name = $ltype['category_name'];
			} else {
				$itype_name = '';
			}
			// applied on
			$applied_on = set_date_format($r['created_at']);
			// get employee info
			$staff = $UsersModel->where('user_id', $r['employee_id'])->first();
			$name = $staff['first_name'].' '.$staff['last_name'];
			$uname = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/users/thumb/'.$staff['profile_photo'].'" alt="'.$name.'" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$name.'</h6>
					<p class="m-b-0">'.$staff['email'].'</p>
				</div>
			</div>';
			// get leave date difference
			$no_of_days = erp_date_difference($r['from_date'],$r['to_date']);
		
			if($r['is_half_day'] == 1){
				$idays = lang('Employees.xin_hr_leave_half_day');
			} else {
				$idays = $no_of_days.' '.lang('Leave.xin_leave_days');
			}
			$duration = set_date_format($r['from_date']).' '.lang('Employees.dashboard_to').' '.set_date_format($r['to_date']);
			$total_days = $idays;
			// leave status
			if($r['status']==1): $status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>';
			elseif($r['status']==2): $status = '<span class="badge badge-light-success">'.lang('Main.xin_approved').'</span>';
			elseif($r['status']==3): $status = '<span class="badge badge-light-danger">'.lang('Main.xin_rejected').'</span>';
			else: $status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>'; endif;
			$combhr = $view;
			$icname = '
				'.$uname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$icname,
				$itype_name,
				$duration,
				$total_days,
				$applied_on,
				$status
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
		$request = \Config\Services::request();	
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$PayeesModel = new PayeesModel();
		$AccountsModel = new AccountsModel();
		$ConstantsModel = new ConstantsModel();
		$TransactionsModel = new TransactionsModel();
				
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$xin_system = erp_company_settings();
		$id = $request->uri->getSegment(4);
		$get_data = $TransactionsModel->where('company_id',$usession['sup_user_id'])->where('entity_id',$id)->where('transaction_type','expense')->orderBy('transaction_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {
			  			
			$iaccounts = $AccountsModel->where('account_id', $r['account_id'])->first();
			if($iaccounts['account_name']){
				$account_name = $iaccounts['account_name'];
			} else {
				$account_name = '';
			}
			//$f_entity = $PayeesModel->where('entity_id', $r['entity_id'])->where('type', 'payee')->first();
			$f_entity = $UsersModel->where('user_id', $r['entity_id'])->where('user_type','staff')->first();
			if($f_entity['first_name']){
				$payer_name = $f_entity['first_name'].' '.$f_entity['last_name'];
			} else {
				$payer_name = '';
			}		
			$category_info = $ConstantsModel->where('constants_id', $r['entity_category_id'])->where('type', 'expense_type')->first();
			if($category_info['category_name']){
				$category_name = $category_info['category_name'];
			} else {
				$category_name = '';
			}
			$payment_method = $ConstantsModel->where('constants_id', $r['payment_method_id'])->where('type', 'payment_method')->first();
			if($payment_method['category_name']){
				$ipayment_method = $payment_method['category_name'];
			} else {
				$ipayment_method = '';
			}
			
			$amount = number_to_currency($r['amount'], $xin_system['default_currency'],null,2);
			$transaction_date = set_date_format($r['transaction_date']);
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/transaction-details').'/'.uencode($r['transaction_id']).'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			$combhr = $view;
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
	public function loan_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();	
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$AdvancesalaryModel = new AdvancesalaryModel();
		//$ConstantsModel = new ConstantsModel();
		$xin_system = erp_company_settings();
		$id = $request->uri->getSegment(4);
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $AdvancesalaryModel->where('employee_id',$id)->where('salary_type','loan')->orderBy('advance_salary_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {						
		  			
				
			// awards month year
			$d = explode('-',$r['month_year']);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$month_year = $get_month.', '.$d[0];
			// user info
			$iuser_info = $UsersModel->where('user_id', $r['employee_id'])->first();
			//$combhr = $edit.$delete;
			if($r['one_time_deduct']==1): $onetime = lang('Main.xin_yes'); else: $onetime = lang('Main.xin_no'); endif;	
			if($r['status'] == 0){
				$app_status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>';
			} else if($r['status'] == 1){
				$app_status = '<span class="badge badge-light-success">'.lang('Main.xin_accepted').'</span>';
			} else if($r['status'] == 2){
				$app_status = '<span class="badge badge-light-danger">'.lang('Main.xin_rejected').'</span>';
			}
			$created_at = set_date_format($r['created_at']);
			// advance_amount
			$advance_amount = number_to_currency($r['advance_amount'], $xin_system['default_currency'],null,2);
			$monthly_installment = number_to_currency($r['monthly_installment'], $xin_system['default_currency'],null,2);
			$total_paid = number_to_currency($r['total_paid'], $xin_system['default_currency'],null,2);
			$itotal_paid = $advance_amount.'<br>'.lang('Invoices.xin_paid').': '.$total_paid;
			$iapp_status = $created_at.'<br>'.$app_status;
			//'xin_paid' => 'Paid',
			$employee_name = $iuser_info['first_name'].' '.$iuser_info['last_name'];
			$uname = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/users/thumb/'.$iuser_info['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$employee_name.'</h6>
					<p class="m-b-0">'.$iuser_info['email'].'</p>
				</div>
			</div>';
			$icname = $uname;
			
			$data[] = array(
				$icname,
				$itotal_paid,
				$month_year,
				$onetime,
				$monthly_installment,
				$iapp_status,
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
	public function travel_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();	
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TravelModel = new TravelModel();
		$ConstantsModel = new ConstantsModel();
		$xin_system = erp_company_settings();
		$id = $request->uri->getSegment(4);
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $TravelModel->where('employee_id',$id)->orderBy('travel_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {						
		  			
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/view-travel-info/'.uencode($r['travel_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
				// user info
				$iuser_info = $UsersModel->where('user_id', $r['employee_id'])->first();
				$employee_name = $iuser_info['first_name'].' '.$iuser_info['last_name'];
				// type
				$category_info = $ConstantsModel->where('constants_id', $r['arrangement_type'])->where('type','travel_type')->first();
				if($category_info){
					$category_name = $category_info['category_name'];
				} else {
					$category_name = '';
				}
				$combhr = $view;			

				if($r['status']==0): $status = '<span class="badge badge-warning">'.lang('Main.xin_pending').'</span>';
				elseif($r['status']==1): $status = '<span class="badge badge-success">'.lang('Main.xin_accepted').'</span>';else: $status = '<span class="badge badge-danger">'.lang('Main.xin_rejected'); endif;
				$expected_budget = number_to_currency($r['expected_budget'], $xin_system['default_currency'],null,2);
				$actual_budget = number_to_currency($r['actual_budget'], $xin_system['default_currency'],null,2);
				$iemployee_name = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/users/thumb/'.$iuser_info['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$employee_name.'</h6>
					<p class="m-b-0">'.$iuser_info['email'].'</p>
				</div>
			</div>';
			// get start date
			$start_date = set_date_format($r['start_date']);
			// get end date
			$end_date = set_date_format($r['end_date']);
			
			$t_employee_name = '
				'.$iemployee_name.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$t_employee_name,
				$r['visit_place'],
				$r['visit_purpose'],
				$category_name,
				$actual_budget,
				$end_date
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
	public function advance_salary_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();	
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$AdvancesalaryModel = new AdvancesalaryModel();
		//$ConstantsModel = new ConstantsModel();
		$xin_system = erp_company_settings();
		$id = $request->uri->getSegment(4);
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $AdvancesalaryModel->where('employee_id',$id)->where('salary_type','advance')->orderBy('advance_salary_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {						
		  			
			// awards month year
			$d = explode('-',$r['month_year']);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$month_year = $get_month.', '.$d[0];
			// user info
			$iuser_info = $UsersModel->where('user_id', $r['employee_id'])->first();
			//$combhr = $edit.$delete;
			if($r['one_time_deduct']==1): $onetime = lang('Main.xin_yes'); else: $onetime = lang('Main.xin_no'); endif;	
			if($r['status'] == 0){
				$app_status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>';
			} else if($r['status'] == 1){
				$app_status = '<span class="badge badge-light-success">'.lang('Main.xin_accepted').'</span>';
			} else if($r['status'] == 2){
				$app_status = '<span class="badge badge-light-danger">'.lang('Main.xin_rejected').'</span>';
			}
			$created_at = set_date_format($r['created_at']);
			// advance_amount
			$advance_amount = number_to_currency($r['advance_amount'], $xin_system['default_currency'],null,2);
			$monthly_installment = number_to_currency($r['monthly_installment'], $xin_system['default_currency'],null,2);
			$total_paid = number_to_currency($r['total_paid'], $xin_system['default_currency'],null,2);
			$itotal_paid = $advance_amount.'<br>'.lang('Invoices.xin_paid').': '.$total_paid;
			$iapp_status = $created_at.'<br>'.$app_status;
			//'xin_paid' => 'Paid',
			$employee_name = $iuser_info['first_name'].' '.$iuser_info['last_name'];
			$uname = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/users/thumb/'.$iuser_info['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$employee_name.'</h6>
					<p class="m-b-0">'.$iuser_info['email'].'</p>
				</div>
			</div>';
			$icname = $uname;
			
			$data[] = array(
				$icname,
				$itotal_paid,
				$month_year,
				$onetime,
				$monthly_installment,
				$iapp_status,
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
	public function overtime_request_list() {

		$session = \Config\Services::session();
		$request = \Config\Services::request();	
		$usession = $session->get('sup_username');		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$OvertimerequestModel = new OvertimerequestModel();
		$id = $request->uri->getSegment(4);
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $OvertimerequestModel->where('staff_id',$id)->orderBy('time_request_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {						
		  			
				//get user info
				$iuser = $UsersModel->where('user_id', $r['staff_id'])->first();
				$uname = $iuser['first_name'].' '.$iuser['last_name'];
				$fname = '<div class="d-inline-block align-middle">
					<img src="'.base_url().'/public/uploads/users/thumb/'.$iuser['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
					<div class="d-inline-block">
						<h6 class="m-b-0">'.$uname.'</h6>
						<p class="m-b-0">'.$iuser['email'].'</p>
					</div>
				</div>';
				$clock_in_time = strtotime($r['clock_in']);
				$fclckIn = date("h:i a", $clock_in_time);
				
				$clock_out_time = strtotime($r['clock_out']);
				$fclckOut = date("h:i a", $clock_out_time);
				$attendance_date = set_date_format($r['request_date']);	
				// status
				if($r['is_approved'] == 0){
					$status = '<span class="badge badge-light-warning">'.lang('Main.xin_pending').'</span>';
				} else if($r['is_approved'] == 1){
					$status = '<span class="badge badge-light-success">'.lang('Main.xin_accepted').'</span>';
				} else {
					$status = '<span class="badge badge-light-danger">'.lang('Main.xin_rejected').'</span>';
				}
					 			  				
				$data[] = array(
					$fname,
					$attendance_date,
					$fclckIn,
					$fclckOut,
					$r['total_hours'],
					$status
				);
			}
          $output = array(
               "csrf_hash" => csrf_hash(),
			   "data" => $data
            );
		//  $output['csrf_hash'] = csrf_hash();	
		  $this->output($output);
         // echo json_encode($output);
          exit();
     }
	 // record list
	public function awards_list() {

		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$AwardsModel = new AwardsModel();
		$ConstantsModel = new ConstantsModel();
		$xin_system = erp_company_settings();
		$id = $request->uri->getSegment(4);
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $AwardsModel->where('employee_id',$id)->orderBy('award_id', 'ASC')->findAll();
		$data = array();
		
          foreach($get_data as $r) {						
		  			
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/award-view/'.uencode($r['award_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			// awards month year
			$d = explode('-',$r['award_month_year']);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$award_date = $get_month.', '.$d[0];
			// user info
			$iuser_info = $UsersModel->where('user_id', $r['employee_id'])->first();
			// award type
			$category_info = $ConstantsModel->where('constants_id', $r['award_type_id'])->where('type','award_type')->first();
			if($category_info){
				$category_name = $category_info['category_name'];
			} else {
				$category_name = '';
			}
			$combhr = $view;
			// award photo
			$cname = $category_name;	
			// award cash
			$cash_price = number_to_currency($r['cash_price'], $xin_system['default_currency'],null,2);
			$icname = '
				'.$cname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$icname,
				$iuser_info['first_name'].' '.$iuser_info['last_name'],
				$r['gift_item'],
				$cash_price,
				$award_date,
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
	public function projects_list() {

		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$id = $request->uri->getSegment(4);
		$ProjectsModel = new ProjectsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = assigned_staff_projects($id);
		$data = array();
		
          foreach($get_data as $r) {

			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/project-detail').'/'.uencode($r['project_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			//assigned user
			$assigned_to = explode(',',$r['assigned_to']);
			$multi_users = multi_user_profile_photo($assigned_to);
			
			$start_date = set_date_format($r['start_date']);
			$end_date = set_date_format($r['end_date']);
			
			// project progress
			if($r['project_progress'] <= 20) {
				$progress_class = 'bg-danger';
			} else if($r['project_progress'] > 20 && $r['project_progress'] <= 50){
				$progress_class = 'bg-warning';
			} else if($r['project_progress'] > 50 && $r['project_progress'] <= 75){
				$progress_class = 'bg-info';
			} else {
				$progress_class = 'bg-success';
			}
			
			$progress_bar = '<div class="progress" style="height: 10px;"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" style="width: '.$r['project_progress'].'%;" aria-valuenow="'.$r['project_progress'].'" aria-valuemin="0" aria-valuemax="100">'.$r['project_progress'].'%</div></div>';
			// status			
			if($r['status'] == 0) {
				$status = '<span class="label label-warning">'.lang('Projects.xin_not_started').'</span>';
			} else if($r['status'] ==1){
				$status = '<span class="label label-primary">'.lang('Projects.xin_in_progress').'</span>';
			} else if($r['status'] ==2){
				$status = '<span class="label label-success">'.lang('Projects.xin_completed').'</span>';
			} else if($r['status'] ==3){
				$status = '<span class="label label-danger">'.lang('Projects.xin_project_cancelled').'</span>';
			} else {
				$status = '<span class="label label-danger">'.lang('Projects.xin_project_hold').'</span>';
			}
			// priority
			if($r['priority'] == 1) {
				$priority = '<span class="badge badge-light-danger">'.lang('Projects.xin_highest').'</span>';
			} else if($r['priority'] ==2){
				$priority = '<span class="badge badge-light-danger">'.lang('Projects.xin_high').'</span>';
			} else if($r['priority'] ==3){
				$priority = '<span class="badge badge-light-primary">'.lang('Projects.xin_normal').'</span>';
			} else {
				$priority = '<span class="badge badge-light-success">'.lang('Projects.xin_low').'</span>';
			}
				
			$project_summary = $r['title'];
			// create by
			$created_by = $UsersModel->where('user_id',$r['added_by'])->first();
			if($created_by){
				$u_name = $created_by['first_name'].' '.$created_by['last_name'];
			} else {
				$u_name = '';
			}
			// client
			$client_info = $UsersModel->where('user_id', $r['client_id'])->where('user_type','customer')->first();	
			if($client_info){
				$iclient = $client_info['first_name'].' '.$client_info['last_name'];
			} else {
				$iclient = '';
			}
			
			$combhr = $view;
			$ititle = '
				'.$project_summary.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$ititle,
				$iclient,
				$start_date,
				$end_date,
				$multi_users,
				$priority,
				$progress_bar
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
	public function tasks_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$id = $request->uri->getSegment(4);
		$TasksModel = new TasksModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = assigned_staff_tasks($id);
		$data = array();
		
          foreach($get_data as $r) {
			  
			$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/task-detail').'/'.uencode($r['task_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			//assigned user
			$assigned_to = explode(',',$r['assigned_to']);
			$multi_users = multi_user_profile_photo($assigned_to);
			
			$start_date = set_date_format($r['start_date']);
			$end_date = set_date_format($r['end_date']);
			
			// task progress
			if($r['task_progress'] <= 20) {
				$progress_class = 'bg-danger';
			} else if($r['task_progress'] > 20 && $r['task_progress'] <= 50){
				$progress_class = 'bg-warning';
			} else if($r['task_progress'] > 50 && $r['task_progress'] <= 75){
				$progress_class = 'bg-info';
			} else {
				$progress_class = 'bg-success';
			}
			
			$progress_bar = '<div class="progress" style="height: 10px;"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" style="width: '.$r['task_progress'].'%;" aria-valuenow="'.$r['task_progress'].'" aria-valuemin="0" aria-valuemax="100">'.$r['task_progress'].'%</div></div>';
			
			// task status			
			if($r['task_status'] == 0) {
				$status = '<span class="badge badge-light-warning">'.lang('Projects.xin_not_started').'</span>';
			} else if($r['task_status'] ==1){
				$status = '<span class="badge badge-light-primary">'.lang('Projects.xin_in_progress').'</span>';
			} else if($r['task_status'] ==2){
				$status = '<span class="badge badge-light-success">'.lang('Projects.xin_completed').'</span>';
			} else if($r['task_status'] ==3){
				$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_cancelled').'</span>';
			} else {
				$status = '<span class="badge badge-light-danger">'.lang('Projects.xin_project_hold').'</span>';
			}
			
			$created_by = $UsersModel->where('user_id',$r['created_by'])->first();
			if($created_by){
				$u_name = $created_by['first_name'].' '.$created_by['last_name'];
			} else {
				$u_name = '';
			}
			
			$combhr = $view;
			$itask_name = '
				'.$r['task_name'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$itask_name,
				$multi_users,
				$start_date,
				$end_date,
				$status,
				$progress_bar
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
	public function payslip_history_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$UsersModel = new UsersModel();
		$config         = new \Config\Encryption();
		$config->key    = 'aBigsecret_ofAtleast32Characters';
		$config->driver = 'OpenSSL';
		
		$encrypter = \Config\Services::encrypter($config);
		$RolesModel = new RolesModel();
		$SystemModel = new SystemModel();
		$ContractModel = new ContractModel();
		$MainModel = new MainModel();
		$PayrollModel = new PayrollModel();
		$StaffdetailsModel = new StaffdetailsModel();
		$id = $request->uri->getSegment(4);
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$payslip = $PayrollModel->where('company_id',$user_info['company_id'])->where('staff_id',$id)->orderBy('payslip_id', 'ASC')->findAll();
			$company_id = $user_info['company_id'];
		} else {
			$payslip = $PayrollModel->where('company_id',$usession['sup_user_id'])->where('staff_id',$id)->orderBy('payslip_id', 'ASC')->findAll();
			$company_id = $usession['sup_user_id'];
		}
		$xin_system = erp_company_settings();
		$data = array();
		
          foreach($payslip as $r) {						
		  			
					
				$user_detail = $UsersModel->where('user_id', $r['staff_id'])->first();
				if($user_detail){
					$name = $user_detail['first_name'].' '.$user_detail['last_name'];
				} else {
					$name = '';
				}
				$wages_type = lang('Membership.xin_per_month');
				
				
				$uname = '<div class="d-inline-block align-middle">
					<img src="'.base_url().'/public/uploads/users/thumb/'.$user_detail['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
					<div class="d-inline-block">
						<h6 class="m-b-0">'.$name.'</h6>
						<p class="m-b-0">'.$user_detail['email'].'</p>
					</div>
				</div>';
				// Salary Options //
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Payroll.xin_view_payslip').'"><a target="_blank" href="'.site_url('erp/payroll-view').'/'.uencode($r['payslip_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
				
				// net salary
				$inet_salary = $r['net_salary'];
				$smonth = strtotime($r['salary_month']);
				$smonth = date('F, Y',$smonth);
				$salary_month = set_date_format($r['salary_month']);
				$net_salary = '<h6 class="text-success">'.number_to_currency($inet_salary, $xin_system['default_currency'],null,2).'</h6>';
				$combhr = $view;
				$links = '
					'.$uname.'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';					 			  				
				$data[] = array(
					$links,
					$net_salary,
					$smonth,
					$net_salary
				);
			}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
}

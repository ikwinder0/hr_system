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

use App\Models\MainModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\TravelModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;

class Travel extends BaseController {

	public function index()
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
			if(!in_array('travel1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_travels').' | '.$xin_system['application_name'];
		$data['path_url'] = 'travel';
		$data['breadcrumbs'] = lang('Dashboard.left_travels');

		$data['subview'] = view('erp/travel/key_travel', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function travel_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$TravelModel = new TravelModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $TravelModel->where('travel_id', $ifield_id)->first();
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
			if(!in_array('travel1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Main.xin_travel_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'travel_details';
		$data['breadcrumbs'] = lang('Main.xin_travel_details');

		$data['subview'] = view('erp/travel/key_travel_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function travel_calendar()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('travel_calendar',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_acc_calendar').' | '.$xin_system['application_name'];
		$data['path_url'] = 'travel';
		$data['breadcrumbs'] = lang('Dashboard.xin_acc_calendar');

		$data['subview'] = view('erp/travel/calendar_travel', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// |||add record|||
	public function add_travel() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'start_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'end_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'visit_purpose' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'visit_place' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'expected_budget' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'actual_budget' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'arrangement_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
					"visit_purpose" => $validation->getError('visit_purpose'),
					"visit_place" => $validation->getError('visit_place'),
					"expected_budget" => $validation->getError('expected_budget'),
					"actual_budget" => $validation->getError('actual_budget'),
					"arrangement_type" => $validation->getError('arrangement_type')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$visit_purpose = $this->request->getPost('visit_purpose',FILTER_SANITIZE_STRING);		
				$visit_place = $this->request->getPost('visit_place',FILTER_SANITIZE_STRING);
				$expected_budget = $this->request->getPost('expected_budget',FILTER_SANITIZE_STRING);
				$actual_budget = $this->request->getPost('actual_budget',FILTER_SANITIZE_STRING);	
				$arrangement_type = $this->request->getPost('arrangement_type',FILTER_SANITIZE_STRING);
				$travel_mode = $this->request->getPost('travel_mode',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$staff_id = $usession['sup_user_id'];
					$company_id = $user_info['company_id'];
				} else {
					$staff_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'employee_id' => $staff_id,
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'visit_purpose'  => $visit_purpose,
					'visit_place'  => $visit_place,
					'travel_mode' => $travel_mode,
					'arrangement_type'  => $arrangement_type,
					'expected_budget'  => $expected_budget,
					'actual_budget'  => $actual_budget,
					'description'  => $description,
					'added_by'  => $usession['sup_user_id'],
					'status'  => 0,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TravelModel = new TravelModel();
				$result = $TravelModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_travel_added_msg');
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
	public function update_travel() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'start_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'end_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'visit_purpose' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'visit_place' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'expected_budget' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'actual_budget' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'arrangement_type' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "start_date" => $validation->getError('start_date'),
					"end_date" => $validation->getError('end_date'),
					"visit_purpose" => $validation->getError('visit_purpose'),
					"visit_place" => $validation->getError('visit_place'),
					"expected_budget" => $validation->getError('expected_budget'),
					"actual_budget" => $validation->getError('actual_budget'),
					"arrangement_type" => $validation->getError('arrangement_type')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$start_date = $this->request->getPost('start_date',FILTER_SANITIZE_STRING);
				$end_date = $this->request->getPost('end_date',FILTER_SANITIZE_STRING);
				$visit_purpose = $this->request->getPost('visit_purpose',FILTER_SANITIZE_STRING);		
				$visit_place = $this->request->getPost('visit_place',FILTER_SANITIZE_STRING);
				$expected_budget = $this->request->getPost('expected_budget',FILTER_SANITIZE_STRING);
				$actual_budget = $this->request->getPost('actual_budget',FILTER_SANITIZE_STRING);	
				$arrangement_type = $this->request->getPost('arrangement_type',FILTER_SANITIZE_STRING);
				$travel_mode = $this->request->getPost('travel_mode',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$associated_goals = implode(',',$this->request->getPost('associated_goals',FILTER_SANITIZE_STRING));
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				
				$data = [
					'start_date'  => $start_date,
					'end_date'  => $end_date,
					'visit_purpose'  => $visit_purpose,
					'visit_place'  => $visit_place,
					'travel_mode' => $travel_mode,
					'arrangement_type'  => $arrangement_type,
					'expected_budget'  => $expected_budget,
					'actual_budget'  => $actual_budget,
					'description'  => $description,
					'associated_goals'  => $associated_goals
				];
				$TravelModel = new TravelModel();
				$result = $TravelModel->update($id,$data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_travel_updated_msg');
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
	public function update_travel_status() {
			
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
                    "status" => $validation->getError('status'),
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
				
				$data = [
					'status'  => $status,
				];
				$TravelModel = new TravelModel();
				$result = $TravelModel->update($id,$data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_travel_status_updated_msg');
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
	// record list
	public function travel_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TravelModel = new TravelModel();
		$ConstantsModel = new ConstantsModel();
		$xin_system = erp_company_settings();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $TravelModel->where('employee_id',$user_info['user_id'])->orderBy('travel_id', 'ASC')->findAll();
		} else {
			$get_data = $TravelModel->where('company_id',$usession['sup_user_id'])->orderBy('travel_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {						
		  			
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/view-travel-info/'.uencode($r['travel_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
				if(in_array('travel4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['travel_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
				} else {
					$delete = '';
				}
				// user info
				$iuser_info = $UsersModel->where('user_id', $r['employee_id'])->first();
				
				// type
				$category_info = $ConstantsModel->where('constants_id', $r['arrangement_type'])->where('type','travel_type')->first();
				if($category_info){
					$category_name = $category_info['category_name'];
				} else {
					$category_name = '';
				}
				$combhr = $view.$delete;			

				if($r['status']==0): $status = '<span class="badge badge-warning">'.lang('Main.xin_pending').'</span>';
				elseif($r['status']==1): $status = '<span class="badge badge-success">'.lang('Main.xin_accepted').'</span>';else: $status = '<span class="badge badge-danger">'.lang('Main.xin_rejected'); endif;
				$expected_budget = number_to_currency($r['expected_budget'], $xin_system['default_currency'],null,2);
				$actual_budget = number_to_currency($r['actual_budget'], $xin_system['default_currency'],null,2);
				if($iuser_info){
					$employee_name = $iuser_info['first_name'].' '.$iuser_info['last_name'];
					$iemployee_name = '<div class="d-inline-block align-middle">
						<img src="'.base_url().'/public/uploads/users/thumb/'.$iuser_info['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
						<div class="d-inline-block">
							<h6 class="m-b-0">'.$employee_name.'</h6>
							<p class="m-b-0">'.$iuser_info['email'].'</p>
						</div>
					</div>';
				} else {
					$iemployee_name = lang('Users.xin_user_data_removed');
				}
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
	// read record
	public function read_travel()
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
			return view('erp/travel/dialog_travel', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_travel() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$TravelModel = new TravelModel();
			$result = $TravelModel->where('travel_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_travel_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

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
 
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\RolesModel;
use App\Models\CountryModel;
use App\Models\MembershipModel;
use App\Models\CompanymembershipModel;


class Membership extends BaseController {
	
	public function index()
	{		
		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Membership.xin_membership_plans').' | '.$xin_system['application_name'];
		$data['path_url'] = 'membership';
		$data['breadcrumbs'] = lang('Membership.xin_membership_plans');
		$data['subview'] = view('erp/membership/membership_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	public function membership_details()
	{		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$usession = $session->get('sup_username');
		$MembershipModel = new MembershipModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $MembershipModel->where('membership_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Membership.xin_view_membership').' | '.$xin_system['application_name'];
		$data['path_url'] = 'membership_detail';
		$data['breadcrumbs'] = lang('Membership.xin_view_membership');

		$data['subview'] = view('erp/membership/membership_detail', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// list
	public function membership_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');	
		$MembershipModel = new MembershipModel();
		$SystemModel = new SystemModel();
		$membership = $MembershipModel->orderBy('membership_id', 'ASC')->findAll();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data = array();
		$avatar_array = array('badge badge-danger','badge badge-primary','badge badge-info','badge badge-success','badge badge-warning','badge badge-secondary','badge badge-dark');
		$i=0;
        foreach($membership as $r) {						
		  			
				$view = '<a href="'.site_url('erp/membership-detail/'). uencode($r['membership_id']) . '"><span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></span></a>';
				$view_modal = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-light-success waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['membership_id']) . '"><span class="fa fa-eye"></span></button></span>';
				if($r['membership_id'] != 1){
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['membership_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
				} else {
					$delete = '';
				}
			$price = number_to_currency($r['price'], $xin_system['default_currency'],null,2);
			$subs_str_plan = substr($r['membership_type'], 0, 1);
			$plan2= $r['membership_type'];
			/*'<div class="media align-items-center">
				<span class="bg-avatar d-block ui-w-30 '.$avatar_array[$i].'">'.$subs_str_plan.'</span>
				<div class="media-body flex-basis-auto pl-3">
				  <div>'.$r['membership_type'].'</div>
				</div>
			  </div>';*/
			if($r['plan_duration']==1){
				$plan_duration = lang('Membership.xin_subscription_monthly');
			} else if($r['plan_duration']==2){
				$plan_duration = lang('Membership.xin_subscription_yearly');
			} else {
				$plan_duration = lang('Membership.xin_subscription_unlimit');
			}	
			$combhr = $view_modal.$view.$delete;
			$_price = '<h6 class="mb-1 text-success">'.$price.'</h6>';
			$links = '
				'.$plan2.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';						 			  				
			$data[] = array(
				$links,
				'<h6 class="mb-1 text-primary">'.$r['subscription_id'].'</h6>',
				$plan_duration,
				$_price,
				$r['total_employees']
			);
		$i++; }
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	public function add_membership() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$MembershipModel = new MembershipModel();
	
		if ($this->request->getMethod() === 'post') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'membership_type' => 'required',
					'price' => 'required',
					'plan_duration' => 'required',
					'total_employees' => 'required'
				],
				[   // Errors
					'membership_type' => [
						'required' => lang('Membership.xin_membership_type_error_field'),
					],
					'price' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'plan_duration' => [
						'required' => lang('Main.xin_error_field_text'),
					],
					'total_employees' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('membership_type')) {
				$Return['error'] = $validation->getError('membership_type');
			} elseif($validation->hasError('price')){
				$Return['error'] = $validation->getError('price');
			} elseif($validation->hasError('plan_duration')){
				$Return['error'] = $validation->getError('plan_duration');
			} elseif ($validation->hasError('total_employees')) {
				$Return['error'] = $validation->getError('total_employees');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
		}
		$membership_type = $this->request->getPost('membership_type',FILTER_SANITIZE_STRING);
		$price = $this->request->getPost('price',FILTER_SANITIZE_STRING);
		$plan_duration = $this->request->getPost('plan_duration',FILTER_SANITIZE_STRING);
		$total_employees = $this->request->getPost('total_employees',FILTER_SANITIZE_STRING);
		$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);	
		//$ar_role_resources = serialize($role_resources);
		$subscription_id = generate_subscription_id();
		$data = [
            'subscription_id' => $subscription_id,
			'membership_type' => $membership_type,
			'price' => $price,
			'plan_duration'  => $plan_duration,
			'total_employees'  => $total_employees,
			'description'  => $description,
			'created_at' => date('d-m-Y h:i:s'),
        ];
		$MembershipModel = new MembershipModel();
        $result = $MembershipModel->insert($data);	
		$Return['csrf_hash'] = csrf_hash();	
		if ($result == TRUE) {
			$Return['result'] = lang('Membership.xin_membership_added_success');
		} else {
			$Return['error'] = lang('Main.xin_error_msg');
		}
		$this->output($Return);
		exit;
	} 
	// update record
	public function update_membership() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$MembershipModel = new MembershipModel();
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'membership_type' => 'required',
					'price' => 'required',
					'plan_duration' => 'required',
					'total_employees' => 'required'
				],
				[   // Errors
					'membership_type' => [
						'required' => lang('Membership.xin_membership_type_error_field'),
					],
					'price' => [
						'required' => lang('Membership.xin_membership_mprice_error_field'),
					],
					'plan_duration' => [
						'required' => lang('Membership.xin_membership_yprice_error_field'),
					],
					'total_employees' => [
						'required' => lang('Users.xin_role_error_access'),
					]
				]
			);
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('membership_type')) {
				$Return['error'] = $validation->getError('membership_type');
			} elseif($validation->hasError('price')){
				$Return['error'] = $validation->getError('price');
			} elseif($validation->hasError('plan_duration')){
				$Return['error'] = $validation->getError('plan_duration');
			} elseif ($validation->hasError('total_employees')) {
				$Return['error'] = $validation->getError('total_employees');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$membership_type = $this->request->getPost('membership_type',FILTER_SANITIZE_STRING);
			$price = $this->request->getPost('price',FILTER_SANITIZE_STRING);
			$plan_duration = $this->request->getPost('plan_duration',FILTER_SANITIZE_STRING);
			$total_employees = $this->request->getPost('total_employees',FILTER_SANITIZE_STRING);
			$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);		
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));			
			$data = [
				'membership_type' => $membership_type,
				'price' => $price,
				'plan_duration'  => $plan_duration,
				'total_employees'  => $total_employees,
				'description'  => $description
			];
			$MembershipModel = new MembershipModel();
			$Return['csrf_hash'] = csrf_hash();
			$result = $MembershipModel->update($id, $data);
			if ($result == TRUE) {
				$Return['result'] = lang('Membership.xin_membership_updated_success');
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
	// read record
	public function read()
	{
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$id = $request->getGet('field_id');
		$data = [
				'field_id' => $id,
			];
		if($session->has('sup_username')){
			return view('erp/membership/dialog_membership', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	public function membership_type_chart() {
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$MembershipModel = new MembershipModel();
		$CompanymembershipModel = new CompanymembershipModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $MembershipModel->orderBy('membership_id', 'ASC')->findAll();
		$data = array();
		$Return = array('iseries'=>'', 'ilabels'=>'');
		$title_info = array();
		$series_info = array();
		foreach($get_data as $r){
			$comp_count = $CompanymembershipModel->where('membership_id',$r['membership_id'])->countAllResults();
			if($comp_count > 0){
				$title_info[] = $r['membership_type'];
				$series_info[] = $comp_count;
			}
		}				  
		$Return['iseries'] = $series_info;
		$Return['ilabels'] = $title_info;
		$Return['total_label'] = lang('Main.xin_total');
		$this->output($Return);
		exit;
	}
	public function membership_by_country_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$CountryModel = new CountryModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$get_data = $CountryModel->orderBy('country_id', 'ASC')->findAll();
		$data = array();
		$Return = array('iseries'=>'', 'ilabels'=>'');
		$title_info = array();
		$series_info = array();
		foreach($get_data as $r){
			$comp_count = $UsersModel->where('country',$r['country_id'])->where('user_type','company')->countAllResults();
			if($comp_count > 0){
				$title_info[] = $r['country_name'];
				$series_info[] = $comp_count;
			}
		}				  
		$Return['iseries'] = $series_info;
		$Return['ilabels'] = $title_info;
		$this->output($Return);
		exit;
	}
	 // delete record
	public function delete_membership() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$MembershipModel = new MembershipModel();
			$result = $MembershipModel->where('membership_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Membership.xin_success_asset_deleted');
			} else {
				$Return['error'] = lang('Membership.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

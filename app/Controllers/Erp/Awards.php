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

use App\Models\OffModel; 
use App\Models\MainModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AwardsModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;
use App\Models\SmstemplatesModel;
use App\Models\EmailtemplatesModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;

class Awards extends BaseController {

	public function index()
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
			if(!in_array('award1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_awards').' | '.$xin_system['application_name'];
		$data['path_url'] = 'awards';
		$data['breadcrumbs'] = lang('Dashboard.left_awards');

		$data['subview'] = view('erp/awards/key_awards', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function award_view()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$AwardsModel = new AwardsModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $AwardsModel->where('award_id', $ifield_id)->first();
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
			if(!in_array('award1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Employees.xin_view_award').' | '.$xin_system['application_name'];
		$data['path_url'] = 'award_details';
		$data['breadcrumbs'] = lang('Employees.xin_view_award');

		$data['subview'] = view('erp/awards/key_award_view', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// |||add record|||
	public function add_awards() {
			
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
				'award_type_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_award_type_field_error')
					]
				],
				'award_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'month_year' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'cash' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'award_information' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'award_picture' => [
					'rules'  => 'uploaded[award_picture]|mime_in[award_picture,image/jpg,image/jpeg,image/gif,image/png]|max_size[award_picture,3072]',
					'errors' => [
						'uploaded' => lang('Main.xin_error_field_text'),
						'mime_in' => 'wrong size'
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "award_type_id" => $validation->getError('award_type_id'),
					"award_date" => $validation->getError('award_date'),
					"month_year" => $validation->getError('month_year'),
					"cash" => $validation->getError('cash'),
					"award_information" => $validation->getError('award_information'),
					"award_picture" => $validation->getError('award_picture')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				$award_picture = $this->request->getFile('award_picture');
				$file_name = $award_picture->getName();
				$award_picture->move('public/uploads/awards/');
				
				$award_type_id = $this->request->getPost('award_type_id',FILTER_SANITIZE_STRING);
				$award_date = $this->request->getPost('award_date',FILTER_SANITIZE_STRING);
				$gift = $this->request->getPost('gift',FILTER_SANITIZE_STRING);
				$cash = $this->request->getPost('cash',FILTER_SANITIZE_STRING);
				$month_year = $this->request->getPost('month_year',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$award_information = $this->request->getPost('award_information',FILTER_SANITIZE_STRING);
				
				$UsersModel = new UsersModel();
				$SystemModel = new SystemModel();
				$ConstantsModel = new ConstantsModel();
				$SmstemplatesModel = new SmstemplatesModel();
				$EmailtemplatesModel = new EmailtemplatesModel();
				$Moduleattributes = new Moduleattributes();
				$Moduleattributesval = new Moduleattributesval();
				$Moduleattributesvalsel = new Moduleattributesvalsel();
				$xin_system = $SystemModel->where('setting_id', 1)->first();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$staff_id = $usession['sup_user_id'];
					$company_id = $user_info['company_id'];
					$company_info = $UsersModel->where('company_id', $company_id)->first();
					$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',1)->orderBy('custom_field_id', 'ASC')->countAllResults();
					$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',1)->orderBy('custom_field_id', 'ASC')->findAll();
				} else {
					$staff_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
					$company_id = $usession['sup_user_id'];
					$company_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
					$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',1)->orderBy('custom_field_id', 'ASC')->countAllResults();
					$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',1)->orderBy('custom_field_id', 'ASC')->findAll();
				}
				$i=1;
				if($count_module_attributes > 0){
					 foreach($module_attributes as $mattribute) {
						 if($mattribute['validation'] == 1){
							 if($this->request->getPost($mattribute['attribute'])=='') {
								$Return['error'] = $mattribute['attribute_label'].' '.lang('Main.xin_field_is_required');
							}
						 }
						 $i++;
					 }		
					 if($Return['error']!=''){
						$this->output($Return);
					}	
				}
				$data = [
					'company_id' => $company_id,
					'employee_id'  => $staff_id,
					'award_type_id'  => $award_type_id,
					'gift_item'  => $gift,
					'cash_price'  => $cash,
					'award_photo'  => $file_name,
					'award_month_year'  => $month_year,
					'award_information'  => $award_information,
					'description'  => $description,
					'created_at' => $award_date
				];
				$AwardsModel = new AwardsModel();
				$result = $AwardsModel->insert($data);	
				$module_id = $AwardsModel->insertID();
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_award_added_msg');
					if($count_module_attributes > 0){
						foreach($module_attributes as $mattribute) {
							if($this->request->getPost($mattribute['attribute']) == ''){
								$file_val = '';
							} else {
								$file_val = $this->request->getPost($mattribute['attribute']);
							}
							$iattr_data = array(
								'company_id' => $company_id,
								'user_id' => $module_id,
								'module_attributes_id' => $mattribute['custom_field_id'],
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
							$Moduleattributesval->insert($iattr_data);
						}
					}
					if($xin_system['enable_email_notification'] == 1){
						// Send mail start
						$itemplate = $EmailtemplatesModel->where('template_id', 11)->first();
						$istaff_info = $UsersModel->where('user_id', $staff_id)->first();
						// award type
						$category_info = $ConstantsModel->where('constants_id', $award_type_id)->where('type','award_type')->first();
						$category_name = $category_info['category_name'];	
						$isubject = $itemplate['subject'];
						$ibody = html_entity_decode($itemplate['message']);
						$fbody = str_replace(array("{site_name}","{award_name}"),array($company_info['company_name'],$category_name),$ibody);
						timehrm_mail_data($company_info['email'],$company_info['company_name'],$istaff_info['email'],$isubject,$fbody);
						// Send mail end
					}
					if($xin_system['enable_sms_notification'] == 1){
						$itemplate = $SmstemplatesModel->where('template_id', 3)->first();
						$istaff_info = $UsersModel->where('user_id', $staff_id)->first();
						// award type
						$category_info = $ConstantsModel->where('constants_id', $award_type_id)->where('type','award_type')->first();
						$category_name = $category_info['category_name'];
						$ibody = html_entity_decode($itemplate['message']);
						$fbody = str_replace(array("{firstname}","{award_name}"),array($istaff_info['first_name'],$category_name),$ibody);
						timehrm_sms_data($istaff_info['contact_number'],$fbody);
					}
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
	public function update_award() {
			
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
				'award_type_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_award_type_field_error')
					]
				],
				'award_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'month_year' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'cash' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'award_information' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "award_type_id" => $validation->getError('award_type_id'),
					"award_date" => $validation->getError('award_date'),
					"month_year" => $validation->getError('month_year'),
					"cash" => $validation->getError('cash'),
					"award_information" => $validation->getError('award_information')
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
					'award_picture' => [
						'rules'  => 'uploaded[award_picture]|mime_in[award_picture,image/jpg,image/jpeg,image/gif,image/png]|max_size[award_picture,3072]',
						'errors' => [
							'uploaded' => lang('Main.xin_error_field_text'),
							'mime_in' => 'wrong size'
						]
					]
				]);
				if ($validated) {
					$award_picture = $this->request->getFile('award_picture');
					$file_name = $award_picture->getName();
					$award_picture->move('public/uploads/awards/');
				}
				
				$award_type_id = $this->request->getPost('award_type_id',FILTER_SANITIZE_STRING);
				$award_date = $this->request->getPost('award_date',FILTER_SANITIZE_STRING);
				$gift = $this->request->getPost('gift',FILTER_SANITIZE_STRING);
				$cash = $this->request->getPost('cash',FILTER_SANITIZE_STRING);
				$month_year = $this->request->getPost('month_year',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$award_information = $this->request->getPost('award_information',FILTER_SANITIZE_STRING);
				$associated_goals = implode(',',$this->request->getPost('associated_goals',FILTER_SANITIZE_STRING));
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$UsersModel = new UsersModel();
				$Moduleattributes = new Moduleattributes();
				$Moduleattributesval = new Moduleattributesval();
				$Moduleattributesvalsel = new Moduleattributesvalsel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
					$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',1)->orderBy('custom_field_id', 'ASC')->countAllResults();
					$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',1)->orderBy('custom_field_id', 'ASC')->findAll();
				} else {
					$company_id = $usession['sup_user_id'];
					$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',1)->orderBy('custom_field_id', 'ASC')->countAllResults();
					$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',1)->orderBy('custom_field_id', 'ASC')->findAll();
				}
				$i=1;
				if($count_module_attributes > 0){
					 foreach($module_attributes as $mattribute) {
						 if($mattribute['validation'] == 1){
							 if($this->request->getPost($mattribute['attribute'])=='') {
								$Return['error'] = $mattribute['attribute_label'].' '.lang('Main.xin_field_is_required');
							}
						 }
						 $i++;
					 }		
					 if($Return['error']!=''){
						$this->output($Return);
					}	
				}
				if ($validated) {
					$data = [
						'award_type_id'  => $award_type_id,
						'gift_item'  => $gift,
						'cash_price'  => $cash,
						'award_photo'  => $file_name,
						'award_month_year'  => $month_year,
						'award_information'  => $award_information,
						'created_at'  => $award_date,
						'description'  => $description,
						'associated_goals'  => $associated_goals
					];
				} else {
					$data = [
						'award_type_id'  => $award_type_id,
						'gift_item'  => $gift,
						'cash_price'  => $cash,
						'award_month_year'  => $month_year,
						'award_information'  => $award_information,
						'created_at'  => $award_date,
						'description'  => $description,
						'associated_goals'  => $associated_goals
					];
				}
				$AwardsModel = new AwardsModel();
				$MainModel = new MainModel();
				$result = $AwardsModel->update($id,$data);	
				if($count_module_attributes > 0){
					foreach($module_attributes as $mattribute) {
						
						// update value
						$count_exist_values = $Moduleattributesval->where('user_id',$id)->where('module_attributes_id',$mattribute['custom_field_id'])->countAllResults();
						if($count_exist_values > 0){
							$attr_data = array(
								'attribute_value' => $this->request->getPost($mattribute['attribute']),
							);
							$MainModel->update_attributes_value_record($mattribute['custom_field_id'],$attr_data);
						} else {
							// add value
							if($this->request->getPost($mattribute['attribute']) == ''){
								$file_val = '';
							} else {
								$file_val = $this->request->getPost($mattribute['attribute']);
							}
							$iattr_data = array(
								'company_id' => $company_id,
								'user_id' => $id,
								'module_attributes_id' => $mattribute['custom_field_id'],
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
							$Moduleattributesval->insert($iattr_data);
						}
					}
				}
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_award_updated_msg');
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
	public function awards_list() {

		$session = \Config\Services::session();
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
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $AwardsModel->where('employee_id',$user_info['user_id'])->orderBy('award_id', 'ASC')->findAll();
		} else {
			$get_data = $AwardsModel->where('company_id',$usession['sup_user_id'])->orderBy('award_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {						
		  			
				if(in_array('award4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
					$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['award_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
				} else {
					$delete = '';
				}
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/award-view/'.uencode($r['award_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			// awards month year
			$d = explode('-',$r['award_month_year']);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$award_date = $get_month.', '.$d[0];
			// user info
			$iuser_info = $UsersModel->where('user_id', $r['employee_id'])->first();
			if($iuser_info){
				$user_detail = $iuser_info['first_name'].' '.$iuser_info['last_name'];
			} else {
				$user_detail = lang('Users.xin_user_data_removed');
			}
			// award type
			$category_info = $ConstantsModel->where('constants_id', $r['award_type_id'])->where('type','award_type')->first();
			$combhr = $view.$delete;
			// category_name
			if($category_info){
				$cname = $category_info['category_name'];
			} else {
				$cname = '--';
			}	
			// award cash
			$cash_price = number_to_currency($r['cash_price'], $xin_system['default_currency'],null,2);
			$icname = '
				'.$cname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$icname,
				$user_detail,
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
	// read record
	public function read_award()
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
			return view('erp/awards/dialog_award', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_award() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$AwardsModel = new AwardsModel();
			$result = $AwardsModel->where('award_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_award_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

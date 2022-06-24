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
use App\Models\SystemModel;
use App\Models\ConstantsModel;
use App\Models\TicketsModel;
use App\Models\DepartmentModel;
use App\Models\TicketnotesModel;
use App\Models\TicketreplyModel;
use App\Models\TicketfilesModel;
use App\Models\StaffdetailsModel;
use App\Models\EmailtemplatesModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;

class Tickets extends BaseController {

	public function tickets_page()
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
			if(!in_array('helpdesk1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.dashboard_helpdesk').' | '.$xin_system['application_name'];
		$data['path_url'] = 'tickets';
		$data['breadcrumbs'] = lang('Dashboard.dashboard_helpdesk');

		$data['subview'] = view('erp/tickets/key_tickets', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function create_ticket()
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
		$data['title'] = lang('Dashboard.left_create_ticket').' | '.$xin_system['application_name'];
		$data['path_url'] = 'ticket_create';
		$data['breadcrumbs'] = lang('Dashboard.left_create_ticket');

		$data['subview'] = view('erp/tickets/key_create_ticket', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function ticket_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$TicketsModel = new TicketsModel();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $TicketsModel->where('ticket_id', $ifield_id)->first();
		if(!$isegment_val){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
			return redirect()->to(site_url('erp/desk'));
		}
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_ticket_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'ticket_details';
		$data['breadcrumbs'] = lang('Dashboard.left_ticket_details');

		$data['subview'] = view('erp/tickets/key_ticket_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function helpdesk_dashboard()
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
		$data['path_url'] = 'tickets';
		$data['breadcrumbs'] = lang('Employees.xin_employee_details');

		$data['subview'] = view('erp/tickets/helpdesk_dashboard', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function tickets_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$TicketsModel = new TicketsModel();
		$ConstantsModel = new ConstantsModel();
		$DepartmentModel = new DepartmentModel();
		$StaffdetailsModel = new StaffdetailsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		$staff_details = $StaffdetailsModel->where('user_id', $user_info['user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $TicketsModel->where('company_id',$user_info['company_id'])->where('employee_id', $usession['sup_user_id'])->orderBy('ticket_id', 'ASC')->findAll();
		} else {
			$get_data = $TicketsModel->where('company_id',$usession['sup_user_id'])->orderBy('ticket_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('erp10',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['ticket_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			if(in_array('erp10',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-success waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['ticket_id']) . '"><i class="feather icon-arrow-right"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('erp10',staff_role_resource()) || $user_info['user_type'] == 'company') { //details
				$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url('erp/ticket-view').'/'.uencode($r['ticket_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><i class="feather icon-arrow-right"></i></button></a></span>';
			} else {
				$view = '';
			}
			
			// priority
			if($r['ticket_priority']==1):
				$priority = lang('xin_low');
			elseif($r['ticket_priority']==2):
				$priority = lang('xin_medium');
			elseif($r['ticket_priority']==3):
				$priority = lang('xin_high');
			elseif($r['ticket_priority']==4):
				$priority = lang('xin_critical');
			endif;
			$created_at = set_date_format($r['created_at']);
			//
			/*if($r['is_inactivate_account'] == 0){
				$inactivate_account = lang('xin_yes');
			} else {
				$inactivate_account = lang('xin_no');
			}
			if($r['exit_interview'] == 1){
				$interview = lang('xin_yes');
			} else {
				$interview = lang('xin_no');
			}*/
			// employee
			$iuser = $UsersModel->where('user_id', $r['employee_id'])->first();
			$employee_name = $iuser['first_name'].' '.$iuser['last_name'];
			$uname = '<div class="d-inline-block align-middle">
				<img src="'.base_url().'/public/uploads/users/thumb/'.$iuser['profile_photo'].'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
				<div class="d-inline-block">
					<h6 class="m-b-0">'.$employee_name.'</h6>
					<p class="m-b-0">'.$iuser['email'].'</p>
				</div>
			</div>';
			// created by
			$created_by = $UsersModel->where('user_id', $r['created_by'])->first();
			$icreated_by = $created_by['first_name'].' '.$created_by['last_name'];
			//// department
			$department = $DepartmentModel->where('department_id', $r['department_id'])->first();;
			$combhr = $edit.$view.$delete;	
			if(in_array('erp9',staff_role_resource()) || in_array('erp10',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$iemployee_name = '
				'.$uname.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';	  				
			} else {
				$iemployee_name = $uname;
			}
			
			$data[] = array(
				$iemployee_name,
				$r['ticket_code'],
				$r['subject'],
				$department['department_name'],
				$priority,
				$created_at,
				$icreated_by
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
	public function add_ticket() {
			
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
				'subject' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'ticket_priority' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "subject" => $validation->getError('subject'),
					"ticket_priority" => $validation->getError('ticket_priority')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file			
				$subject = $this->request->getPost('subject',FILTER_SANITIZE_STRING);
				$ticket_priority = $this->request->getPost('ticket_priority',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$UsersModel = new UsersModel();
				$Moduleattributes = new Moduleattributes();
				$Moduleattributesval = new Moduleattributesval();
				$Moduleattributesvalsel = new Moduleattributesvalsel();
				$EmailtemplatesModel = new EmailtemplatesModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$employee_id = $usession['sup_user_id'];
					$company_id = $user_info['company_id'];
					$StaffdetailsModel = new StaffdetailsModel();
					$employee_detail = $StaffdetailsModel->where('user_id', $user_info['user_id'])->first();
					$department_id = $employee_detail['department_id'];
					$company_info = $UsersModel->where('company_id', $company_id)->first();
					$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',3)->orderBy('custom_field_id', 'ASC')->countAllResults();
					$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',3)->orderBy('custom_field_id', 'ASC')->findAll();
				} else {
					if($this->request->getPost('department_id',FILTER_SANITIZE_STRING) === ''){
						$Return['error'] = lang('Employees.xin_employee_error_department');
					} else if($this->request->getPost('employee_id',FILTER_SANITIZE_STRING) === ''){
						$Return['error'] = lang('Success.xin_employee_field_error');
					}
					if($Return['error']!=''){
						$this->output($Return);
					}
					$department_id = $this->request->getPost('department_id',FILTER_SANITIZE_STRING);
					$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);
					$company_id = $usession['sup_user_id'];
					$company_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
					$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',3)->orderBy('custom_field_id', 'ASC')->countAllResults();
					$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',3)->orderBy('custom_field_id', 'ASC')->findAll();
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
				$ticket_code = generate_random_code();
				$data = [
					'company_id'  => $company_id,
					'subject'  => $subject,
					'ticket_code'  => $ticket_code,
					'department_id'  => $department_id,
					'employee_id'  => $employee_id,
					'ticket_priority'  => $ticket_priority,
					'description'  => $description,
					'ticket_status' => '1',
					'ticket_remarks' => '',
					'created_by' => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s')
				];
				$TicketsModel = new TicketsModel();
				$result = $TicketsModel->insert($data);	
				$ticket_id = $TicketsModel->insertID();
				$data3 = [
					'company_id' => $company_id,
					'ticket_id' => $ticket_id,
					'sent_by'  => $usession['sup_user_id'],
					'assign_to'  => $employee_id,
					'reply_text'  => $description,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TicketreplyModel = new TicketreplyModel();
				
				$TicketreplyModel->insert($data3);
				$Return['csrf_hash'] = csrf_hash();	
				$SystemModel = new SystemModel();
				$xin_system = $SystemModel->where('setting_id', 1)->first();
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_ticket_created__msg');
					if($count_module_attributes > 0){
						foreach($module_attributes as $mattribute) {
							if($this->request->getPost($mattribute['attribute']) == ''){
								$file_val = '';
							} else {
								$file_val = $this->request->getPost($mattribute['attribute']);
							}
							$iattr_data = array(
								'company_id' => $company_id,
								'user_id' => $ticket_id,
								'module_attributes_id' => $mattribute['custom_field_id'],
								'attribute_value' => $file_val,
								'created_at' => date('Y-m-d h:i:s')
							);
							$Moduleattributesval->insert($iattr_data);
						}
					}
					if($xin_system['enable_email_notification'] == 1){
						// Send mail start
						$itemplate = $EmailtemplatesModel->where('template_id', 12)->first();
						$istaff_info = $UsersModel->where('user_id', $employee_id)->first();
	
						$isubject = str_replace("{ticket_code}",$ticket_code,$itemplate['subject']);
						$ibody = html_entity_decode($itemplate['message']);
						$fbody = str_replace(array("{site_name}","{ticket_code}"),array($company_info['company_name'],$ticket_code),$ibody);
						timehrm_mail_data($company_info['email'],$company_info['company_name'],$istaff_info['email'],$isubject,$fbody);
						// Send mail end
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
	// |||update record|||
	public function add_ticket_reply() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_ticket_reply_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$token2 = udecode($this->request->getPost('token2',FILTER_SANITIZE_STRING));	
				$data = [
					'company_id' => $company_id,
					'ticket_id' => $id,
					'sent_by'  => $usession['sup_user_id'],
					'assign_to'  => $token2,
					'reply_text'  => $description,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TicketreplyModel = new TicketreplyModel();
				$result = $TicketreplyModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_ticket_reply_updated_msg');
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
	public function add_note() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'description' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_note_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "description" => $validation->getError('description')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'company_id' => $company_id,
					'ticket_id' => $id,
					'employee_id'  => $usession['sup_user_id'],
					'ticket_note'  => $description,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TicketnotesModel = new TicketnotesModel();
				$result = $TicketnotesModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_ticket_note_added_msg');
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
	public function add_attachment() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'file_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'attachment_file' => [
					'rules'  => 'uploaded[attachment_file]|mime_in[attachment_file,image/jpg,image/jpeg,image/gif,image/png]|max_size[attachment_file,3072]',
					'errors' => [
						'uploaded' => lang('Success.xin_file_field_error'),
						'mime_in' => 'wrong size'
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "file_name" => $validation->getError('file_name'),
					"attachment_file" => $validation->getError('attachment_file')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				$attachment = $this->request->getFile('attachment_file');
				$file_name = $attachment->getName();
				$attachment->move('public/uploads/tickets/');
				
				$file_title = $this->request->getPost('file_name',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'ticket_id'  => $id,
					'employee_id'  => $usession['sup_user_id'],
					'file_title'  => $file_title,
					'attachment_file'  => $file_name,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TicketfilesModel = new TicketfilesModel();
				$result = $TicketfilesModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_ticket_file_added_msg');
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
	public function update_ticket_status() {
			
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
				],
				'remarks' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "remarks" => $validation->getError('remarks'),
					"status" => $validation->getError('status')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$remarks = $this->request->getPost('remarks',FILTER_SANITIZE_STRING);	
				$status = $this->request->getPost('status',FILTER_SANITIZE_STRING);	
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
				
				$MainModel = new MainModel();
				$UsersModel = new UsersModel();
				$TicketsModel = new TicketsModel();
				$Moduleattributes = new Moduleattributes();
				$Moduleattributesval = new Moduleattributesval();
				$Moduleattributesvalsel = new Moduleattributesvalsel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
					$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',3)->orderBy('custom_field_id', 'ASC')->countAllResults();
					$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',3)->orderBy('custom_field_id', 'ASC')->findAll();
				} else {
					$company_id = $usession['sup_user_id'];
					$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',3)->orderBy('custom_field_id', 'ASC')->countAllResults();
					$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',3)->orderBy('custom_field_id', 'ASC')->findAll();
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
					'ticket_remarks' => $remarks,
					'ticket_status'  => $status
				];
				$result = $TicketsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
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
					$Return['result'] = lang('Success.ci_ticket_status_updated_msg');
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
	public function update_ticket() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'subject' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'ticket_priority' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "subject" => $validation->getError('subject'),
					"ticket_priority" => $validation->getError('ticket_priority')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$subject = $this->request->getPost('subject',FILTER_SANITIZE_STRING);	
				$ticket_priority = $this->request->getPost('ticket_priority',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
				$data = [
					'subject' => $subject,
					'ticket_priority'  => $ticket_priority
				];
				$TicketsModel = new TicketsModel();
				$result = $TicketsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_ticket_updated_msg');
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
	public function read_ticket()
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
			return view('erp/tickets/dialog_ticket', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	public function tickets_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$TicketsModel = new TicketsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$open = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_status', 1)->countAllResults();
			$closed = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_status', 2)->countAllResults();
		} else {
			$open = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_status', 1)->countAllResults();
			$closed = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_status', 2)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('open_count'=>'', 'open_label'=>'','closed'=>'', 'closed_label'=>'');
		
		// closed
		$Return['closed_label'] = lang('Main.xin_closed');
		$Return['closed'] = $closed;
		// open
		$Return['open_label'] = lang('Main.xin_open');
		$Return['open_count'] = $open;
		$this->output($Return);
		exit;
	}
	public function tickets_priority_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$TicketsModel = new TicketsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$low = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_priority', 1)->countAllResults();
			$medium = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_priority', 2)->countAllResults();
			$high = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_priority', 3)->countAllResults();
			$critical = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_priority', 4)->countAllResults();
		} else {
			$low = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_priority', 1)->countAllResults();
			$medium = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_priority', 2)->countAllResults();
			$high = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_priority', 3)->countAllResults();
			$critical = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_priority', 4)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('low_count'=>'','medium_count'=>'','high_count'=>'','critical_count'=>'','low_labt'=>'','medium_lab'=>'','high_lab'=>'','critical_lab'=>'');
		
		// low
		$Return['low_labt'] = lang('Projects.xin_low');
		$Return['low_count'] = $low;
		// medium
		$Return['medium_lab'] = lang('Main.xin_medium');
		$Return['medium_count'] = $medium;
		// high
		$Return['high_lab'] = lang('Projects.xin_high');
		$Return['high_count'] = $high;
		// critical
		$Return['critical_lab'] = lang('Main.xin_critical');
		$Return['critical_count'] = $critical;
		$this->output($Return);
		exit;
	}
	public function staff_tickets_status_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$TicketsModel = new TicketsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$open = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_status', 1)->countAllResults();
			$closed = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_status', 2)->countAllResults();
		} else {
			$open = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_status', 1)->countAllResults();
			$closed = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_status', 2)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('open_count'=>'', 'open_label'=>'','closed'=>'', 'closed_label'=>'');
		
		// closed
		$Return['closed_label'] = lang('Main.xin_closed');
		$Return['closed'] = $closed;
		// open
		$Return['open_label'] = lang('Main.xin_open');
		$Return['open_count'] = $open;
		$this->output($Return);
		exit;
	}
	public function staff_tickets_priority_chart() {
		
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$TicketsModel = new TicketsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$low = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_priority', 1)->countAllResults();
			$medium = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_priority', 2)->countAllResults();
			$high = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_priority', 3)->countAllResults();
			$critical = $TicketsModel->where('company_id',$user_info['company_id'])->where('ticket_priority', 4)->countAllResults();
		} else {
			$low = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_priority', 1)->countAllResults();
			$medium = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_priority', 2)->countAllResults();
			$high = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_priority', 3)->countAllResults();
			$critical = $TicketsModel->where('company_id',$usession['sup_user_id'])->where('ticket_priority', 4)->countAllResults();
		}
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('low_count'=>'','medium_count'=>'','high_count'=>'','critical_count'=>'','low_labt'=>'','medium_lab'=>'','high_lab'=>'','critical_lab'=>'');
		
		// low
		$Return['low_labt'] = lang('Projects.xin_low');
		$Return['low_count'] = $low;
		// medium
		$Return['medium_lab'] = lang('Main.xin_medium');
		$Return['medium_count'] = $medium;
		// high
		$Return['high_lab'] = lang('Projects.xin_high');
		$Return['high_count'] = $high;
		// critical
		$Return['critical_lab'] = lang('Main.xin_critical');
		$Return['critical_count'] = $critical;
		$this->output($Return);
		exit;
	}
	public function is_department() {
		
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		$id = $request->uri->getSegment(4);
		
		$data = array(
			'department_id' => $id
			);
		if($session->has('sup_username')){
			return view('erp/tickets/get_employees', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	 }
	// delete record
	public function delete_ticket() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$TicketsModel = new TicketsModel();
			$result = $TicketsModel->where('ticket_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_ticket_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_ticket_note() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = $this->request->getVar('field_id',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();
			$TicketnotesModel = new TicketnotesModel();
			$result = $TicketnotesModel->where('ticket_note_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_ticket_note_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_ticket_reply() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = $this->request->getVar('field_id',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();
			$TicketreplyModel = new TicketreplyModel();
			$result = $TicketreplyModel->where('ticket_reply_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_ticket_reply_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_ticket_file() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = $this->request->getVar('field_id',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();
			$TicketfilesModel = new TicketfilesModel();
			$result = $TicketfilesModel->where('ticket_file_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_ticket_file_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

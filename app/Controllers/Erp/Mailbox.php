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
 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\MailboxModel;
use App\Models\MailreadModel;
use App\Models\MailreplyModel;
use App\Models\CountryModel;

class Mailbox extends BaseController {
	
	public function index()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_department').' | '.$xin_system['application_name'];
		$data['path_url'] = 'mailbox';
		$data['breadcrumbs'] = lang('Dashboard.left_department');

		$data['subview'] = view('erp/mailbox/staff_mailbox', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function starred()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_department').' | '.$xin_system['application_name'];
		$data['path_url'] = 'mailbox';
		$data['breadcrumbs'] = lang('Dashboard.left_department');

		$data['subview'] = view('erp/mailbox/staff_mailbox_starred', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function important()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_department').' | '.$xin_system['application_name'];
		$data['path_url'] = 'mailbox';
		$data['breadcrumbs'] = lang('Dashboard.left_department');

		$data['subview'] = view('erp/mailbox/staff_mailbox_important', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function sent()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_department').' | '.$xin_system['application_name'];
		$data['path_url'] = 'mailbox';
		$data['breadcrumbs'] = lang('Dashboard.left_department');

		$data['subview'] = view('erp/mailbox/staff_mailbox_sent', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function compose()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_department').' | '.$xin_system['application_name'];
		$data['path_url'] = 'mailbox_compose';
		$data['breadcrumbs'] = lang('Dashboard.left_department');

		$data['subview'] = view('erp/mailbox/staff_mail_compose', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function email_read()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_department').' | '.$xin_system['application_name'];
		$data['path_url'] = 'mailbox_read';
		$data['breadcrumbs'] = lang('Dashboard.left_department');
		/// read mail
		$segment_id = $request->uri->getSegment(3);
		$rid = udecode($segment_id);
		$MainModel = new MainModel();
		$MainModel->update_mail_record($usession['sup_user_id'],$rid);
		//view
		$data['subview'] = view('erp/mailbox/staff_mail_read', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// |||add record|||
	public function send_mail() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'staff_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_cat_name_field')
					]
				],
				'subject' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_cat_name_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "staff_id" => $validation->getError('staff_id'),
					"subject" => $validation->getError('subject')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$staff_id = $this->request->getPost('staff_id',FILTER_SANITIZE_STRING);	
				$subject = $this->request->getPost('subject',FILTER_SANITIZE_STRING);
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);
						
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'mail_to' => $staff_id,
					'sent_by'  => $usession['sup_user_id'],
					'subject'  => $subject,
					'description'  => $description,
					'is_read'  => 0,
					'is_replied'  => 0,
					'is_starred'  => 0,
					'is_important'  => 0,
					'created_at' => date('d-m-Y h:i:s')
				];
				$MailboxModel = new MailboxModel();
				$result = $MailboxModel->insert($data);	
				$f_mailid = $MailboxModel->insertID();
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$data2 = [
					'company_id'  => $company_id,
					'mail_id'  => $f_mailid,
					'mail_to' => $staff_id,
					'sent_by'  => $usession['sup_user_id'],
					'is_read'  => 0,
					'is_starred'  => 0,
					'is_important'  => 0,
					'created_at' => date('d-m-Y h:i:s')
				];
					$MailreadModel = new MailreadModel();
					$MailreadModel->insert($data2);
					$data3 = [
						'company_id'  => $company_id,
						'mail_id' => $f_mailid,
						'mail_to'  => $staff_id,
						'sent_by'  => $usession['sup_user_id'],
						'description'  => $description,
						'is_read'  => 0,
						'is_main'  => 1,
						'created_at' => date('d-m-Y h:i:s')
					];
					$MailreplyModel = new MailreplyModel();
					$MailreplyModel->insert($data3);
					$Return['result'] = lang('Asset.xin_success_assets_category_added');
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
	public function reply_mail() {
			
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
						'required' => lang('Asset.xin_error_cat_name_field')
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
				$description = $this->request->getPost('description',FILTER_SANITIZE_STRING);	
				$mail_id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$mail_to = udecode($this->request->getPost('token2',FILTER_SANITIZE_STRING));
									
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'mail_id' => $mail_id,
					'mail_to'  => $mail_to,
					'sent_by'  => $usession['sup_user_id'],
					'description'  => $description,
					'is_read'  => 0,
					'is_main'  => 0,
					'created_at' => date('d-m-Y h:i:s')
				];
				$MailreplyModel = new MailreplyModel();
				$result = $MailreplyModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$data2 = [
						'is_replied'  => 1,
					];
					$MailboxModel = new MailboxModel();
					$MailboxModel->update($mail_id,$data2);
					$data3 = [
					'company_id'  => $company_id,
					'mail_id'  => $mail_id,
					'mail_to' => $mail_to,
					'sent_by'  => $usession['sup_user_id'],
					'is_read'  => 0,
					'is_starred'  => 0,
					'is_important'  => 0,
					'created_at' => date('d-m-Y h:i:s')
				];
					$MailreadModel = new MailreadModel();
					$MailreadModel->insert($data3);
					$Return['result'] = lang('Asset.xin_success_assets_category_added');
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
	// update record
	public function update_starmail_record() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			//$id = udecode($this->request->getGet('field_id'));
			$id = udecode($request->getVar('field_id',FILTER_SANITIZE_STRING));
			$star_val = $request->getVar('star_val',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();

			$UsersModel = new UsersModel();
			$MainModel = new MainModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$data = [
				'is_starred' => $star_val,
			];
			$MailboxModel = new MailboxModel();
			$result = $MainModel->update_stars_mail($usession['sup_user_id'],$id,$data);
			if ($result == TRUE) {
				$Return['result'] = lang('Asset.xin_success_assets_category_deleted');
			} else {
				$Return['error'] = lang('Membership.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// update record
	public function update_important_mail_record() {
		
		if($this->request->getVar('field_id')) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			//$id = udecode($this->request->getGet('field_id'));
			$id = udecode($request->getVar('field_id',FILTER_SANITIZE_STRING));
			$imp_val = $request->getVar('imp_val',FILTER_SANITIZE_STRING);
			$Return['csrf_hash'] = csrf_hash();

			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$data = [
				'is_important' => $imp_val,
			];
			//$MailboxModel = new MailboxModel();
			//$result = $MailboxModel->update($id,$data);
			$MainModel = new MainModel();
			$result = $MainModel->update_important_mail($usession['sup_user_id'],$id,$data);
			if ($result == TRUE) {
				$Return['result'] = lang('Asset.xin_success_assets_category_deleted');
			} else {
				$Return['error'] = lang('Membership.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// read record
	public function read_department()
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
			return view('erp/department/dialog_department', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_department() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$DepartmentModel = new DepartmentModel();
			$result = $DepartmentModel->where('department_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Asset.xin_success_asset_deleted');
			} else {
				$Return['error'] = lang('Membership.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

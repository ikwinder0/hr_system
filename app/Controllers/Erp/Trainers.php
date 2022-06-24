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
use App\Models\TrainersModel;

class Trainers extends BaseController {

	public function index()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$request = \Config\Services::request();
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
			if(!in_array('trainer1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.left_trainers').' | '.$xin_system['application_name'];
		$data['path_url'] = 'trainers';
		$data['breadcrumbs'] = lang('Dashboard.left_trainers');

		$data['subview'] = view('erp/training/trainers', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function trainer_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$TrainersModel = new TrainersModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $TrainersModel->where('company_id',$user_info['company_id'])->orderBy('trainer_id', 'ASC')->findAll();
		} else {
			$get_data = $TrainersModel->where('company_id',$usession['sup_user_id'])->orderBy('trainer_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			if(in_array('trainer3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['trainer_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('trainer4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['trainer_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$full_name = $r['first_name'].' '.$r['last_name'];
			$combhr = $edit.$delete;
			if(in_array('trainer3',staff_role_resource()) || in_array('trainer4',staff_role_resource()) || $user_info['user_type'] == 'company') {
					$ifull_name = '
					'.$full_name.'
					<div class="overlay-edit">
						'.$combhr.'
					</div>';		  				
			} else {
				$ifull_name = $full_name;
			}
			$data[] = array(
				$ifull_name,
				$r['contact_number'],
				$r['email'],
				$r['expertise'],
				$created_at
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
	public function add_trainer() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'first_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'last_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contact_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'email' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'expertise' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "first_name" => $validation->getError('first_name'),
					"last_name" => $validation->getError('last_name'),
					"contact_number" => $validation->getError('contact_number'),
					"email" => $validation->getError('email'),
					"expertise" => $validation->getError('expertise'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
				$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
				$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
				$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
				$expertise = $this->request->getPost('expertise',FILTER_SANITIZE_STRING);
				$address = $this->request->getPost('address',FILTER_SANITIZE_STRING);
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'first_name' => $first_name,
					'last_name'  => $last_name,
					'contact_number'  => $contact_number,
					'email'  => $email,
					'expertise'  => $expertise,
					'address'  => $address,
					'created_at' => date('d-m-Y h:i:s')
				];
				$TrainersModel = new TrainersModel();
				$result = $TrainersModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_trainer_added_msg');
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
	public function update_trainer() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'first_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'last_name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'contact_number' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'email' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				],
				'expertise' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text'),
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "first_name" => $validation->getError('first_name'),
					"last_name" => $validation->getError('last_name'),
					"contact_number" => $validation->getError('contact_number'),
					"email" => $validation->getError('email'),
					"expertise" => $validation->getError('expertise'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$first_name = $this->request->getPost('first_name',FILTER_SANITIZE_STRING);
				$last_name = $this->request->getPost('last_name',FILTER_SANITIZE_STRING);
				$contact_number = $this->request->getPost('contact_number',FILTER_SANITIZE_STRING);
				$email = $this->request->getPost('email',FILTER_SANITIZE_STRING);
				$expertise = $this->request->getPost('expertise',FILTER_SANITIZE_STRING);
				$address = $this->request->getPost('address',FILTER_SANITIZE_STRING);
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
					'first_name' => $first_name,
					'last_name'  => $last_name,
					'contact_number'  => $contact_number,
					'email'  => $email,
					'expertise'  => $expertise,
					'address'  => $address
				];
				$TrainersModel = new TrainersModel();
				$result = $TrainersModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_trainer_updated_msg');
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
	public function read_trainer()
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
			return view('erp/training/dialog_trainer', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_trainer() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$TrainersModel = new TrainersModel();
			$result = $TrainersModel->where('trainer_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_trainer_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

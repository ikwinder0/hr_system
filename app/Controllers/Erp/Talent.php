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
use App\Models\KpiModel;
use App\Models\KpaModel;
use App\Models\ConstantsModel;
use App\Models\KpioptionsModel;
use App\Models\KpaoptionsModel;
use App\Models\DesignationModel;

class Talent extends BaseController {

	public function performance_indicator()
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
			if(!in_array('indicator1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_performance_indicator').' | '.$xin_system['application_name'];
		$data['path_url'] = 'kpi';
		$data['breadcrumbs'] = lang('Dashboard.left_performance_indicator');

		$data['subview'] = view('erp/talent/performance_indicator', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function indicator_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$KpiModel = new KpiModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $KpiModel->where('performance_indicator_id', $ifield_id)->first();
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
		$data['title'] = lang('Performance.xin_performance_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'kpi_details';
		$data['breadcrumbs'] = lang('Performance.xin_performance_details');

		$data['subview'] = view('erp/talent/indicator_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function appraisal_details()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$KpaModel = new KpaModel();
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $KpaModel->where('performance_appraisal_id', $ifield_id)->first();
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
		$data['title'] = lang('Performance.xin_performance_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'kpa_details';
		$data['breadcrumbs'] = lang('Performance.xin_performance_details');

		$data['subview'] = view('erp/talent/appraisal_details', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function performance_appraisal()
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
			if(!in_array('appraisal1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.left_performance_appraisal').' | '.$xin_system['application_name'];
		$data['path_url'] = 'kpa';
		$data['breadcrumbs'] = lang('Dashboard.left_performance_appraisal');

		$data['subview'] = view('erp/talent/performance_appraisal', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	
	// record list
	public function indicator_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$KpiModel = new KpiModel();
		$ConstantsModel = new ConstantsModel();
		$KpioptionsModel = new KpioptionsModel();
		$DesignationModel = new DesignationModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $KpiModel->where('company_id',$user_info['company_id'])->orderBy('performance_indicator_id', 'ASC')->findAll();
			$count_competencies = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies')->countAllResults();
			$count_competencies2 = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies2')->countAllResults();
		} else {
			$get_data = $KpiModel->where('company_id',$usession['sup_user_id'])->orderBy('performance_indicator_id', 'ASC')->findAll();
			$count_competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->countAllResults();
			$count_competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->countAllResults();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/kpi-details/'.uencode($r['performance_indicator_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			if(in_array('indicator4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['performance_indicator_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$designations = $DesignationModel->where('designation_id',$r['designation_id'])->first();
			if($designations){
				$designation_name = $designations['designation_name'];
			} else {
				$designation_name = '--';
			}
			$added_by = $UsersModel->where('user_id',$r['added_by'])->first();
			if($added_by){
				$iadded_by = $added_by['first_name'].' '.$added_by['last_name'];
			} else {
				$iadded_by = '--';
			}
			$combhr = $edit.$delete;
			$kpi_count_val = $KpioptionsModel->where('indicator_id',$r['performance_indicator_id'])->findAll();
			$star_value = 0;
			
			foreach($kpi_count_val as $nw_starval){
				$star_value += $nw_starval['indicator_option_value'];
			}
			$total_comp = $count_competencies+$count_competencies2;
			$total_val = $total_comp * 5;
			///
			if($total_val < 1){
				$rating_val = 0;
			} else {
				$rating_val = $star_value / $total_val * 5;
				$rating_val = number_format((float)$rating_val, 1, '.', '');
			}
			$total_stars = '<span class="overall-stars">';
			for ( $i = 1; $i <= 5; $i++ ) {
				if ( round( $rating_val - .49 ) >= $i ) {
					$total_stars .= "<i class='fa fa-star'></i>"; //fas fa-star for v5
				} elseif ( round( $rating_val + .49 ) >= $i ) {
					$total_stars .= "<i class='fas fa-star-half-alt'></i>"; //fas fa-star-half-alt for v5
				} else {
					$total_stars .= "<i class='far fa-star'></i>"; //far fa-star for v5
				}
			}
			$total_stars .= '</span> '.$rating_val;
			$ititle = '
					'.$r['title'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
			//$combhr = $edit.$delete;	
			$data[] = array(
				$ititle,
				$designation_name,
				$total_stars,
				$iadded_by,
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
	// record list
	public function appraisal_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$KpaModel = new KpaModel();
		$ConstantsModel = new ConstantsModel();
		$KpaoptionsModel = new KpaoptionsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $KpaModel->where('company_id',$user_info['company_id'])->orderBy('performance_appraisal_id', 'ASC')->findAll();
			// count
			$count_competencies = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies')->countAllResults();
			$count_competencies2 = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies2')->countAllResults();
		} else {
			$get_data = $KpaModel->where('company_id',$usession['sup_user_id'])->orderBy('performance_appraisal_id', 'ASC')->findAll();
			// count
			$count_competencies = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->countAllResults();
			$count_competencies2 = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->countAllResults();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/kpa-details/'.uencode($r['performance_appraisal_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			
			if(in_array('appraisal4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['performance_appraisal_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$user_assign = $UsersModel->where('user_id',$r['employee_id'])->first();
			if($user_assign){
				$user_staff = $user_assign['first_name'].' '.$user_assign['last_name'];
			} else {
				$user_staff = '--';
			}
			$added_by = $UsersModel->where('user_id',$r['added_by'])->first();
			if($added_by){
				$iadded_by = $added_by['first_name'].' '.$added_by['last_name'];
			} else {
				$iadded_by = '--';
			}
			$combhr = $edit.$delete;
			$kpa_count_val = $KpaoptionsModel->where('appraisal_id',$r['performance_appraisal_id'])->findAll();
			$star_value = 0;
			
			foreach($kpa_count_val as $nw_starval){
				$star_value += $nw_starval['appraisal_option_value'];
			}
			$total_comp = $count_competencies+$count_competencies2;
			$total_val = $total_comp * 5;
			///
			if($total_val < 1){
				$rating_val = 0;
			} else {
				$rating_val = $star_value / $total_val * 5;
				$rating_val = number_format((float)$rating_val, 1, '.', '');
			}
			$total_stars = '<span class="overall-stars">';
			for ( $i = 1; $i <= 5; $i++ ) {
				if ( round( $rating_val - .49 ) >= $i ) {
					$total_stars .= "<i class='fa fa-star'></i>"; //fas fa-star for v5
				} elseif ( round( $rating_val + .49 ) >= $i ) {
					$total_stars .= "<i class='fas fa-star-half-alt'></i>"; //fas fa-star-half-alt for v5
				} else {
					$total_stars .= "<i class='far fa-star'></i>"; //far fa-star for v5
				}
			}
			$total_stars .= '</span> '.$rating_val;
			$ititle = '
				'.$r['title'].'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';
			//$combhr = $edit.$delete;	
			$data[] = array(
				$ititle,
				$user_staff,
				$r['appraisal_year_month'],
				$iadded_by,
				$total_stars,
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
	public function add_indicator() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'designation_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Employees.xin_employee_error_designation')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"designation_id" => $validation->getError('designation_id')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);	
				$designation_id = $this->request->getPost('designation_id',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'title' => $title,
					'designation_id' => $designation_id,
					'added_by' => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s')
				];
				$KpiModel = new KpiModel();
				$KpioptionsModel = new KpioptionsModel();
				$result = $KpiModel->insert($data);	
				$indicator_id = $KpiModel->insertID();
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					foreach($this->request->getPost('technical_competencies_value',FILTER_SANITIZE_STRING) as $key=>$tech_value){
						$data_ind = array(
						'company_id' => $company_id,
						'indicator_id' => $indicator_id,
						'indicator_type' => 'technical',
						'indicator_option_id' => $key,
						'indicator_option_value' => $tech_value,
						);
						$KpioptionsModel->insert($data_ind);
					}
					foreach($this->request->getPost('organizational_competencies_value',FILTER_SANITIZE_STRING) as $ikey=>$org_value){
						$data_org = array(
						'company_id' => $company_id,
						'indicator_id' => $indicator_id,
						'indicator_type' => 'organizational',
						'indicator_option_id' => $ikey,
						'indicator_option_value' => $org_value,
						);
						$KpioptionsModel->insert($data_org);
					}
						
					$Return['result'] = lang('Success.ci_indicator_added_msg');
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
	public function update_indicator() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'designation_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Employees.xin_employee_error_designation')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"designation_id" => $validation->getError('designation_id')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);	
				$designation_id = $this->request->getPost('designation_id',FILTER_SANITIZE_STRING);		
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
				$data = [
					'title' => $title,
					'designation_id' => $designation_id
				];
				$KpiModel = new KpiModel();
				$KpioptionsModel = new KpioptionsModel();
				$result = $KpiModel->update($id,$data);
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					foreach($this->request->getPost('technical_competencies_value',FILTER_SANITIZE_STRING) as $key=>$tech_value){
						foreach($tech_value as $option_id => $star_data)
						{
							$data_ind = array(
							'indicator_option_id' => $option_id,
							'indicator_option_value' => $star_data,
							);
							$KpioptionsModel->update($key,$data_ind);
						}
					}
					foreach($this->request->getPost('organizational_competencies_value',FILTER_SANITIZE_STRING) as $ikey=>$org_value){
						foreach($org_value as $org_option_id => $star_data_org)
						{
							$data_org = array(
							'indicator_option_id' => $org_option_id,
							'indicator_option_value' => $star_data_org,
							);
							$KpioptionsModel->update($ikey,$data_org);
						}
					}
					$Return['result'] = lang('Success.ci_indicator_updated_msg');
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
	public function add_appraisal() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'employee_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_employee_field_error')
					]
				],
				'month_year' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_select_month_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"employee_id" => $validation->getError('employee_id'),
					"month_year" => $validation->getError('month_year')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);	
				$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);	
				$month_year = $this->request->getPost('month_year',FILTER_SANITIZE_STRING);
				$remarks = $this->request->getPost('remarks',FILTER_SANITIZE_STRING);		
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'title' => $title,
					'employee_id' => $employee_id,
					'remarks' => $remarks,
					'appraisal_year_month' => $month_year,
					'added_by' => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s')
				];
				$KpaModel = new KpaModel();
				$KpaoptionsModel = new KpaoptionsModel();
				$result = $KpaModel->insert($data);	
				$appraisal_id = $KpaModel->insertID();
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					foreach($this->request->getPost('technical_competencies_value',FILTER_SANITIZE_STRING) as $key=>$tech_value){
						$data_ind = array(
						'company_id' => $company_id,
						'appraisal_id' => $appraisal_id,
						'appraisal_type' => 'technical',
						'appraisal_option_id' => $key,
						'appraisal_option_value' => $tech_value,
						);
						$KpaoptionsModel->insert($data_ind);
					}
					foreach($this->request->getPost('organizational_competencies_value',FILTER_SANITIZE_STRING) as $ikey=>$org_value){
						$data_org = array(
						'company_id' => $company_id,
						'appraisal_id' => $appraisal_id,
						'appraisal_type' => 'organizational',
						'appraisal_option_id' => $ikey,
						'appraisal_option_value' => $org_value,
						);
						$KpaoptionsModel->insert($data_org);
					}
						
					$Return['result'] = lang('Success.ci_appraisal_added_msg');
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
	public function update_appraisal() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'title' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'employee_id' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_employee_field_error')
					]
				],
				'month_year' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_select_month_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "title" => $validation->getError('title'),
					"employee_id" => $validation->getError('employee_id'),
					"month_year" => $validation->getError('month_year')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$title = $this->request->getPost('title',FILTER_SANITIZE_STRING);	
				$employee_id = $this->request->getPost('employee_id',FILTER_SANITIZE_STRING);	
				$month_year = $this->request->getPost('month_year',FILTER_SANITIZE_STRING);
				$remarks = $this->request->getPost('remarks',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));		
				
				$data = [
					'title' => $title,
					'employee_id' => $employee_id,
					'remarks' => $remarks,
					'appraisal_year_month' => $month_year,
				];
				$KpaModel = new KpaModel();
				$KpaoptionsModel = new KpaoptionsModel();
				$result = $KpaModel->update($id,$data);	
				
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					foreach($this->request->getPost('technical_competencies_value',FILTER_SANITIZE_STRING) as $key=>$tech_value){
						foreach($tech_value as $option_id => $star_data)
						{
							$data_ind = array(
							'appraisal_option_id' => $option_id,
							'appraisal_option_value' => $star_data,
							);
							$KpaoptionsModel->update($key,$data_ind);
						}
					}
					foreach($this->request->getPost('organizational_competencies_value',FILTER_SANITIZE_STRING) as $ikey=>$org_value){
						foreach($org_value as $org_option_id => $star_data_org)
						{
							$data_org = array(
							'appraisal_option_id' => $org_option_id,
							'appraisal_option_value' => $star_data_org,
							);
							$KpaoptionsModel->update($ikey,$data_org);
						}
					}
					$Return['result'] = lang('Success.ci_appraisal_updated_msg');
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
	public function delete_indicator() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$KpiModel = new KpiModel();
			$result = $KpiModel->where('performance_indicator_id', $id)->delete($id);
			if ($result == TRUE) {
				$MainModel = new MainModel();
				$MainModel->delete_indicator_options($id);
				$Return['result'] = lang('Success.ci_indicator_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record
	public function delete_appraisal() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$KpaModel = new KpaModel();
			$result = $KpaModel->where('performance_appraisal_id', $id)->delete($id);
			if ($result == TRUE) {
				$MainModel = new MainModel();
				$MainModel->delete_appraisal_options($id);
				$Return['result'] = lang('Success.ci_appraisal_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

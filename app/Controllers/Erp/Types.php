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
use App\Models\ConstantsModel;

class Types extends BaseController {

	public function asset_category()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
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
			if(!in_array('asset_cat1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_assets_category';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_assets_category', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function product_category()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
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
			if(!in_array('product_category1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_product_category';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_product_category', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function asset_brand()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
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
			if(!in_array('asset_brand1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_assets_brand';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_assets_brand', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function leave_type()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('leave_type1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_leave_type';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_leave_type', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function award_type()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('award_type1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_award_type';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_award_type', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function arrangement_type()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('travel_type1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_arrangement_type';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_arrangement_type', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function exit_type()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('exit_type1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_exit_type';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_exit_type', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function income_type()
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
			if(!in_array('dep_cat1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_income_type';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_income_type', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function expense_type()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('exp_cat1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_expense_type';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_expense_type', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function competencies()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('competency1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_competencies';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_competencies', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function goal_type()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('track_type1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_goal_type';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_goal_type', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function training_type()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('training_skill1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_training_type';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_training_type', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function case_type()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('case_type1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_case_type';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_case_type', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function tax_type()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
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
			if(!in_array('tax_type1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_tax_type';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_tax_type', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function jobs_categories()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');	
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_jobs_categories';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_jobs_categories', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function customers_group()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		//$AssetsModel = new AssetsModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');	
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Dashboard.xin_category').' | '.$xin_system['application_name'];
		$data['path_url'] = 'cons_customers_group';
		$data['breadcrumbs'] = lang('Dashboard.xin_category');

		$data['subview'] = view('erp/constants/key_customers_group', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function assets_category_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','assets_category')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','assets_category')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('asset_cat3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('asset_cat4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('asset_cat3',staff_role_resource()) || in_array('asset_cat4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function products_category_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','product_category')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','product_category')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('product_category3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('product_category4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('product_category3',staff_role_resource()) || in_array('product_category4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function arrangement_type_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','travel_type')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','travel_type')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('travel_type3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('travel_type4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('travel_type3',staff_role_resource()) || in_array('travel_type4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function exit_type_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','exit_type')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','exit_type')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('exit_type3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('exit_type4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('exit_type3',staff_role_resource()) || in_array('exit_type4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function income_type_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','income_type')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','income_type')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('dep_cat3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('dep_cat4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('dep_cat3',staff_role_resource()) || in_array('dep_cat4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function expense_type_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','expense_type')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','expense_type')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('exp_cat3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('exp_cat4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('exp_cat3',staff_role_resource()) || in_array('exp_cat4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function competencies_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('competency3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '" data-comp_option="competencies"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('competency4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('competency3',staff_role_resource()) || in_array('competency4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function org_competencies_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','competencies2')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','competencies2')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('competency3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '" data-comp_option="competencies2"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('competency4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('competency3',staff_role_resource()) || in_array('competency4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function goal_type_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','goal_type')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','goal_type')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('track_type3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('track_type4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('track_type3',staff_role_resource()) || in_array('track_type4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function training_type_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','training_type')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','training_type')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('training_skill3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('training_skill4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('training_skill3',staff_role_resource()) || in_array('training_skill4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function case_type_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','warning_type')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','warning_type')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('case_type3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('case_type4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('case_type3',staff_role_resource()) || in_array('case_type4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function tax_type_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','tax_type')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','tax_type')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('tax_type3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('tax_type4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$field_one = number_to_currency($r['field_one'], $xin_system['default_currency'],null,2);
			if($r['field_two']=='fixed'){
				$_type = lang('Employees.xin_title_tax_fixed');
			} else {
				$_type = lang('Employees.xin_title_tax_percent');
			}
			$combhr = $edit.$delete;
			if(in_array('tax_type3',staff_role_resource()) || in_array('tax_type4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
				$field_one,
				$_type,
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
	public function jobs_categories_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','jobs_categories')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','jobs_categories')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('erp9',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('erp10',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('erp9',staff_role_resource()) || in_array('erp10',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function customers_group_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','customers_group')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','customers_group')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('erp9',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('erp10',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('erp9',staff_role_resource()) || in_array('erp10',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function leave_type_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('leave_type3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('leave_type4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			if($r['field_two'] == 1){
				$is_require = lang('Main.xin_yes');
			} else {
				$is_require = lang('Main.xin_no');
			}
			$combhr = $edit.$delete;
			if(in_array('leave_type3',staff_role_resource()) || in_array('leave_type4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
				$r['field_one'],
				$is_require
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
	public function award_type_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','award_type')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','award_type')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('award_type3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('award_type4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('award_type3',staff_role_resource()) || in_array('award_type4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			//$combhr = $edit.$delete;	
			$data[] = array(
				$category_name,
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
	public function assets_brand_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ConstantsModel = new ConstantsModel();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$category = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','assets_brand')->orderBy('constants_id', 'ASC')->findAll();
		} else {
			$category = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','assets_brand')->orderBy('constants_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($category as $r) {
			  
			if(in_array('asset_brand3',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-field_id="'. uencode($r['constants_id']) . '"><i class="feather icon-edit"></i></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('asset_brand4',staff_role_resource()) || $user_info['user_type'] == 'company') { //edit
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['constants_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			
			$created_at = set_date_format($r['created_at']);
			$combhr = $edit.$delete;
			if(in_array('asset_brand3',staff_role_resource()) || in_array('asset_brand4',staff_role_resource()) || $user_info['user_type'] == 'company') {
				$category_name = '
					'.$r['category_name'].'
					<div class="overlay-edit">
						'.$combhr.'
					</div>
				';
					 			  				
			} else {
				$category_name = $r['category_name'];
			}
			$data[] = array(
				$category_name,
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
	// read record
	public function read_asset_category()
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
			return view('erp/constants/dialog_assets_category', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_product_category()
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
			return view('erp/constants/dialog_product_category', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_leave_type()
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
			return view('erp/constants/dialog_leave_type', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_award_type()
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
			return view('erp/constants/dialog_award_type', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_asset_brand()
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
			return view('erp/constants/dialog_assets_brand', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_arrangement_type()
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
			return view('erp/constants/dialog_arrangement_type', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_exit_type()
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
			return view('erp/constants/dialog_exit_type', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_income_type()
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
			return view('erp/constants/dialog_income_type', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_expense_type()
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
			return view('erp/constants/dialog_expense_type', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_competencies()
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
			return view('erp/constants/dialog_competencies', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_goal_type()
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
			return view('erp/constants/dialog_goal_type', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_training_type()
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
			return view('erp/constants/dialog_training_type', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_case_type()
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
			return view('erp/constants/dialog_case_type', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_tax_type()
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
			return view('erp/constants/dialog_tax_type', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_jobs_categories()
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
			return view('erp/constants/dialog_jobs_categories', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// read record
	public function read_customers_group()
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
			return view('erp/constants/dialog_customers_group', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// |||add record|||
	public function add_category() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_cat_name_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'assets_category',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
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
	public function add_product_category() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_cat_name_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'product_category',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Asset.ci_product_category_added_msg');
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
	public function add_award_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_award_type_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'award_type',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_award_type_added_msg');
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
	public function add_brand() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_brand_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'assets_brand',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_brand_added_msg');
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
	public function add_leave_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_leave_type_field_error')
					]
				],
				'days_per_year' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name'),
					"days_per_year" => $validation->getError('days_per_year')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);		
				$days_per_year = $this->request->getPost('days_per_year',FILTER_SANITIZE_STRING);	
				$requires_approval = $this->request->getPost('requires_approval',FILTER_SANITIZE_STRING);		
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'leave_type',
					'field_one'  => $days_per_year,
					'field_two'  => $requires_approval,
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_leave_type_added_msg');
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
	public function add_arrangement_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_arrangement_type_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'travel_type',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_arrangement_type_added_msg');
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
	public function add_income_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_cat_name_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'income_type',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_category_added_msg');
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
	public function add_expense_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_cat_name_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'expense_type',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_category_added_msg');
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
	public function add_competencies() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_cat_name_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'competencies',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_category_added_msg');
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
	public function add_competencies2() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_cat_name_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'competencies2',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_category_added_msg');
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
	public function add_goal_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_goal_type_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'goal_type',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_goal_type_added_msg');
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
	public function add_training_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_training_skills_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'training_type',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_training_skills_added_msg');
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
	public function add_case_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_case_type_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'warning_type',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_case_type_added_msg');
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
	public function add_jobs_categories() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_cat_name_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'jobs_categories',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
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
	public function add_tax_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_tax_name_field_error')
					]
				],
				'fieldone' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_tax_rate_field_error')
					]
				],
				'fieldtwo' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_tax_type_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name'),
					"fieldone" => $validation->getError('fieldone'),
					"fieldtwo" => $validation->getError('fieldtwo')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);	
				$fieldone = $this->request->getPost('fieldone',FILTER_SANITIZE_STRING);	
				$fieldtwo = $this->request->getPost('fieldtwo',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'tax_type',
					'field_one'  => $fieldone,
					'field_two'  => $fieldtwo,
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_tax_type_added_msg');
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
	public function add_customers_group() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_cat_name_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'customers_group',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
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
	public function add_exit_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_exit_type_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);			
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'company_id'  => $company_id,
					'category_name' => $name,
					'type'  => 'exit_type',
					'field_one'  => 'Null',
					'field_two'  => 'Null',
					'created_at' => date('d-m-Y h:i:s')
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_exit_type_added_msg');
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
	public function update_constants_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Asset.xin_error_cat_name_field')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);	
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
				$erp_constant = udecode($this->request->getPost('erp_constant',FILTER_SANITIZE_STRING));
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'category_name' => $name,
					'company_id'  => $company_id
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_data_updated_msg');
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
	public function update_tax_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_tax_name_field_error')
					]
				],
				'fieldone' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_tax_rate_field_error')
					]
				],
				'fieldtwo' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_tax_type_field_error')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name'),
					"fieldone" => $validation->getError('fieldone'),
					"fieldtwo" => $validation->getError('fieldtwo')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
				$fieldone = $this->request->getPost('fieldone',FILTER_SANITIZE_STRING);
				$fieldtwo = $this->request->getPost('fieldtwo',FILTER_SANITIZE_STRING);	
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'category_name' => $name,
					'field_one'  => $fieldone,
					'field_two'  => $fieldtwo
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_tax_type_updated_msg');
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
	public function update_leave_type() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'name' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Success.xin_leave_type_field_error')
					]
				],
				'days_per_year' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name'),
					"days_per_year" => $validation->getError('days_per_year')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
				$days_per_year = $this->request->getPost('days_per_year',FILTER_SANITIZE_STRING);	
				$requires_approval = $this->request->getPost('requires_approval',FILTER_SANITIZE_STRING);	
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));	
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
				} else {
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'category_name' => $name,
					'field_one'  => $days_per_year,
					'field_two'  => $requires_approval,
				];
				$ConstantsModel = new ConstantsModel();
				$result = $ConstantsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_leave_type_updated_msg');
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
	public function delete_type() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ConstantsModel = new ConstantsModel();
			$UsersModel = new UsersModel();
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'staff'){
				$company_id = $user_info['company_id'];
			} else {
				$company_id = $usession['sup_user_id'];
			}
			$result = $ConstantsModel->where('constants_id', $id)->where('company_id', $company_id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_data_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

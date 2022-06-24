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
use App\Models\CountryModel;
use App\Models\ProductsModel;
use App\Models\ConstantsModel;
use App\Models\WarehouseModel;
use App\Models\Moduleattributes;
use App\Models\Moduleattributesval;
use App\Models\Moduleattributesvalsel;

class Products extends BaseController {

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
			if(!in_array('product1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Inventory.xin_products').' | '.$xin_system['application_name'];
		$data['path_url'] = 'products';
		$data['breadcrumbs'] = lang('Inventory.xin_products');

		$data['subview'] = view('erp/inventory/key_products', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function out_of_stock()
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
			if(!in_array('out_of_stock',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Inventory.xin_out_of_stock').' | '.$xin_system['application_name'];
		$data['path_url'] = 'products_outofstock';
		$data['breadcrumbs'] = lang('Inventory.xin_out_of_stock');

		$data['subview'] = view('erp/inventory/key_products_outofstock', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function expired_stock()
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
			if(!in_array('expired_product',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Inventory.xin_expired_products').' | '.$xin_system['application_name'];
		$data['path_url'] = 'products_expired';
		$data['breadcrumbs'] = lang('Inventory.xin_expired_products');

		$data['subview'] = view('erp/inventory/key_products_expired', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	public function product_view()
	{		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ProductsModel = new ProductsModel();
		$session = \Config\Services::session();		
		$usession = $session->get('sup_username');
		$request = \Config\Services::request();
		$ifield_id = udecode($request->uri->getSegment(3));
		$isegment_val = $ProductsModel->where('product_id', $ifield_id)->first();
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
			if(!in_array('product1',staff_role_resource())) {
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		}
		$data['title'] = lang('Inventory.xin_product_details').' | '.$xin_system['application_name'];
		$data['path_url'] = 'product_details';
		$data['breadcrumbs'] = lang('Inventory.xin_product_details');

		$data['subview'] = view('erp/inventory/product_view', $data);
		return view('erp/layout/layout_main', $data); //page load
	}
	// record list
	public function product_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ProductsModel = new ProductsModel();
		$ConstantsModel = new ConstantsModel();
		$WarehouseModel = new WarehouseModel();
		$xin_system = erp_company_settings();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $ProductsModel->where('company_id',$user_info['company_id'])->orderBy('product_id', 'ASC')->findAll();
		} else {
			$get_data = $ProductsModel->where('company_id',$usession['sup_user_id'])->orderBy('product_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/product-view/'.uencode($r['product_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			if(in_array('product4',staff_role_resource()) || $user_info['user_type'] == 'company') { //delete
				$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['product_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} else {
				$delete = '';
			}
			// category
			$category_info = $ConstantsModel->where('constants_id', $r['category_id'])->first();
			if($category_info){
				$category_name = $category_info['category_name'];
			} else {
				$category_name = '--';
			}
			// warehouse
			$warehouse_info = $WarehouseModel->where('warehouse_id', $r['warehouse_id'])->first();
			if($warehouse_info){
				$warehouse_name = $warehouse_info['warehouse_name'];
			} else {
				$warehouse_name = '--';
			}
			// purchase price
			$purchase_price = number_to_currency($r['purchase_price'], $xin_system['default_currency'],null,2);
			// selling price
			$retail_price = number_to_currency($r['retail_price'], $xin_system['default_currency'],null,2);
			// product rating
			$rating_val = $r['product_rating'];
			$total_stars = '<span class="overall-stars">';
			for ( $i = 1; $i <= 5; $i++ ) {
				if ( round( $rating_val - .49 ) >= $i ) {
					$total_stars .= "<span class='text-warning feather icon-star-on'></span>"; //fas fa-star for v5
				} elseif ( round( $rating_val + .49 ) >= $i ) {
					$total_stars .= "<span class='text-warning feather icon-star'></span>"; //fas fa-star-half-alt for v5
				} else {
					$total_stars .= "<span class='text-warning feather icon-star'></span>"; //far fa-star for v5
				}
			}
			$total_stars .= '</span> ';
			$iproduct = '<img src="'.base_url().'/public/uploads/products/'.$r['product_image'].'" alt="" title="" class="rounded mr-3" height="48">
			<p class="m-0 d-inline-block align-middle font-16">
				<a href="#!" class="text-body">'.$r['product_name'].'</a>
				<br>
				'.$total_stars.'
			</p>';
			// check out of stock and expired products
			$expiration_date = strtotime($r['expiration_date']);
			$current_date = strtotime(date('Y-m-d'));
			if($r['product_qty'] < 1){
				$status = '<span class="badge badge-light-warning">'.lang('Inventory.xin_out_of_stock').'</span>';
			} else if($expiration_date == $current_date){
				$status = '<span class="badge badge-light-primary">'.lang('Inventory.xin_stock_expire_today').'</span>';
			} else if($expiration_date <= $current_date){
				$status = '<span class="badge badge-light-danger">'.lang('Inventory.xin_stock_expired').'</span>';
			} else {
				$status = '';
			}
			$created_at = set_date_format($r['created_at']).'<br>'.$status;
			$combhr = $edit.$delete;
			$ivisitor_name = '
				'.$iproduct.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$ivisitor_name,
				$warehouse_name,
				$category_name,
				$r['product_qty'],
				$purchase_price,
				$retail_price,
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
	public function out_of_stock_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ProductsModel = new ProductsModel();
		$ConstantsModel = new ConstantsModel();
		$WarehouseModel = new WarehouseModel();
		$xin_system = erp_company_settings();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $ProductsModel->where('company_id',$user_info['company_id'])->where('product_qty',0)->orderBy('product_id', 'ASC')->findAll();
		} else {
			$get_data = $ProductsModel->where('company_id',$usession['sup_user_id'])->where('product_qty',0)->orderBy('product_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/product-view/'.uencode($r['product_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			
			$created_at = set_date_format($r['created_at']);
			// category
			$category_info = $ConstantsModel->where('constants_id', $r['category_id'])->first();
			if($category_info){
				$category_name = $category_info['category_name'];
			} else {
				$category_name = '--';
			}
			// warehouse
			$warehouse_info = $WarehouseModel->where('warehouse_id', $r['warehouse_id'])->first();
			if($warehouse_info){
				$warehouse_name = $warehouse_info['warehouse_name'];
			} else {
				$warehouse_name = '--';
			}
			// purchase price
			$purchase_price = number_to_currency($r['purchase_price'], $xin_system['default_currency'],null,2);
			// selling price
			$retail_price = number_to_currency($r['retail_price'], $xin_system['default_currency'],null,2);
			// product rating
			$rating_val = $r['product_rating'];
			$total_stars = '<span class="overall-stars">';
			for ( $i = 1; $i <= 5; $i++ ) {
				if ( round( $rating_val - .49 ) >= $i ) {
					$total_stars .= "<span class='text-warning feather icon-star-on'></span>"; //fas fa-star for v5
				} elseif ( round( $rating_val + .49 ) >= $i ) {
					$total_stars .= "<span class='text-warning feather icon-star'></span>"; //fas fa-star-half-alt for v5
				} else {
					$total_stars .= "<span class='text-warning feather icon-star'></span>"; //far fa-star for v5
				}
			}
			$total_stars .= '</span> ';
			$iproduct = '<img src="'.base_url().'/public/uploads/products/'.$r['product_image'].'" alt="" title="" class="rounded mr-3" height="48">
			<p class="m-0 d-inline-block align-middle font-16">
				<a href="#!" class="text-body">'.$r['product_name'].'</a>
				<br>
				'.$total_stars.'
			</p>';
			$combhr = $edit;
			$ivisitor_name = '
				'.$iproduct.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$ivisitor_name,
				$warehouse_name,
				$category_name,
				$r['product_qty'],
				$purchase_price,
				$retail_price,
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
	public function expired_product_list() {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}		
		$RolesModel = new RolesModel();
		$UsersModel = new UsersModel();
		$SystemModel = new SystemModel();
		$ProductsModel = new ProductsModel();
		$ConstantsModel = new ConstantsModel();
		$WarehouseModel = new WarehouseModel();
		$xin_system = erp_company_settings();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['user_type'] == 'staff'){
			$get_data = $ProductsModel->where('company_id',$user_info['company_id'])->where('expiration_date < CURDATE()')->orderBy('product_id', 'ASC')->findAll();
		} else {
			$get_data = $ProductsModel->where('company_id',$usession['sup_user_id'])->where('expiration_date < CURDATE()')->orderBy('product_id', 'ASC')->findAll();
		}
		$data = array();
		
          foreach($get_data as $r) {
			  
			$edit = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.lang('Main.xin_view_details').'"><a href="'.site_url().'erp/product-view/'.uencode($r['product_id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			
			$created_at = set_date_format($r['created_at']);
			// category
			$category_info = $ConstantsModel->where('constants_id', $r['category_id'])->first();
			if($category_info){
				$category_name = $category_info['category_name'];
			} else {
				$category_name = '--';
			}
			// warehouse
			$warehouse_info = $WarehouseModel->where('warehouse_id', $r['warehouse_id'])->first();
			if($warehouse_info){
				$warehouse_name = $warehouse_info['warehouse_name'];
			} else {
				$warehouse_name = '--';
			}
			// purchase price
			$purchase_price = number_to_currency($r['purchase_price'], $xin_system['default_currency'],null,2);
			// selling price
			$retail_price = number_to_currency($r['retail_price'], $xin_system['default_currency'],null,2);
			// product rating
			$rating_val = $r['product_rating'];
			$total_stars = '<span class="overall-stars">';
			for ( $i = 1; $i <= 5; $i++ ) {
				if ( round( $rating_val - .49 ) >= $i ) {
					$total_stars .= "<span class='text-warning feather icon-star-on'></span>"; //fas fa-star for v5
				} elseif ( round( $rating_val + .49 ) >= $i ) {
					$total_stars .= "<span class='text-warning feather icon-star'></span>"; //fas fa-star-half-alt for v5
				} else {
					$total_stars .= "<span class='text-warning feather icon-star'></span>"; //far fa-star for v5
				}
			}
			$total_stars .= '</span> ';
			$iproduct = '<img src="'.base_url().'/public/uploads/products/'.$r['product_image'].'" alt="" title="" class="rounded mr-3" height="48">
			<p class="m-0 d-inline-block align-middle font-16">
				<a href="#!" class="text-body">'.$r['product_name'].'</a>
				<br>
				'.$total_stars.'
			</p>';
			$combhr = $edit;
			$ivisitor_name = '
				'.$iproduct.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
			$data[] = array(
				$ivisitor_name,
				$warehouse_name,
				$category_name,
				$r['product_qty'],
				$purchase_price,
				$retail_price,
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
	public function add_product() {
			
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
						'required' =>  lang('Main.xin_error_field_text')
					]
				],
				'category' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'warehouse' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'sku' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'qty' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'expiration_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'purchase_price' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'selling_price' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'product_image' => [
					'rules'  => 'uploaded[product_image]|mime_in[product_image,image/jpg,image/jpeg,image/gif,image/png]|max_size[product_image,3072]',
					'errors' => [
						'uploaded' => lang('Main.xin_error_field_text'),
						'mime_in' => 'wrong size'
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name'),
					"category" => $validation->getError('category'),
					"warehouse" => $validation->getError('warehouse'),
					"sku" => $validation->getError('sku'),
					"qty" => $validation->getError('qty'),
					"expiration_date" => $validation->getError('expiration_date'),
					"purchase_price" => $validation->getError('purchase_price'),
					"selling_price" => $validation->getError('selling_price'),
					"product_image" => $validation->getError('product_image')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				// upload file
				$product_image = $this->request->getFile('product_image');
				$file_name = $product_image->getName();
				$product_image->move('public/uploads/products/');
				
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
				$category = $this->request->getPost('category',FILTER_SANITIZE_STRING);
				$warehouse = $this->request->getPost('warehouse',FILTER_SANITIZE_STRING);
				$barcode_type = $this->request->getPost('barcode_type',FILTER_SANITIZE_STRING);
				$barcode = $this->request->getPost('barcode',FILTER_SANITIZE_STRING);
				$sku = $this->request->getPost('sku',FILTER_SANITIZE_STRING);
				$serial_number = $this->request->getPost('serial_number',FILTER_SANITIZE_STRING);
				$qty = $this->request->getPost('qty',FILTER_SANITIZE_STRING);
				$reorder_stock = $this->request->getPost('reorder_stock',FILTER_SANITIZE_STRING);
				$expiration_date = $this->request->getPost('expiration_date',FILTER_SANITIZE_STRING);
				$purchase_price = $this->request->getPost('purchase_price',FILTER_SANITIZE_STRING);
				$selling_price = $this->request->getPost('selling_price',FILTER_SANITIZE_STRING);
				$product_description = $this->request->getPost('product_description',FILTER_SANITIZE_STRING);
				
				$UsersModel = new UsersModel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$staff_id = $usession['sup_user_id'];
					$company_id = $user_info['company_id'];
				} else {
					$staff_id = $usession['sup_user_id'];
					$company_id = $usession['sup_user_id'];
				}
				$data = [
					'product_name' => $name,
					'product_qty'  => $qty,
					'reorder_stock'  => $reorder_stock,
					'barcode'  => $barcode,
					'company_id'  => $company_id,
					'barcode_type'  => $barcode_type,
					'warehouse_id'  => $warehouse,
					'category_id'  => $category,
					'product_sku'  => $sku,
					'product_serial_number'  => $serial_number,
					'purchase_price'  => $purchase_price,
					'retail_price'  => $selling_price,
					'product_image'  => $file_name,
					'expiration_date'  => $expiration_date,
					'product_description'  => $product_description,
					'product_rating'  => 0,
					'added_by'  => $usession['sup_user_id'],
					'created_at' => date('d-m-Y h:i:s'),
					'status'  => 1,
				];
				$ProductsModel = new ProductsModel();
				$result = $ProductsModel->insert($data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_product_added_msg');
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
	public function update_product_image() {
			
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
			//$image = service('image');
			// set rules
			$validated = $this->validate([
				'product_image' => [
					'uploaded[product_image]',
					'mime_in[product_image,image/jpg,image/jpeg,image/gif,image/png]',
					'max_size[product_image,4096]',
				],
			]);
			if (!$validated) {
				$Return['error'] = lang('Inventory.xin_product_image_field_error');
			} else {
				$product_image = $this->request->getFile('product_image');
				$file_name = $product_image->getName();
				$product_image->move('public/uploads/products/');
				/*$image->withFile(filesrc($file_name))
				->fit(100, 100, 'center')
				->save('public/uploads/products/thumb/'.$file_name);*/
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
			$ProductsModel = new ProductsModel();
			if ($validated) {
				$data = [
					'product_image'  => $file_name
				];
				$result = $ProductsModel->update($id, $data);
				$Return['csrf_hash'] = csrf_hash();	
				$Return['result'] = lang('Inventory.xin_product_image_updated_success');
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
	// |||update record|||
	public function update_product() {
			
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
						'required' =>  lang('Main.xin_error_field_text')
					]
				],
				'category' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'warehouse' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'barcode' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'sku' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'expiration_date' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'purchase_price' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
				'selling_price' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				]
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "name" => $validation->getError('name'),
					"category" => $validation->getError('category'),
					"warehouse" => $validation->getError('warehouse'),
					"barcode" => $validation->getError('barcode'),
					"sku" => $validation->getError('sku'),
					"expiration_date" => $validation->getError('expiration_date'),
					"purchase_price" => $validation->getError('purchase_price'),
					"selling_price" => $validation->getError('selling_price')
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {				
				$name = $this->request->getPost('name',FILTER_SANITIZE_STRING);
				$category = $this->request->getPost('category',FILTER_SANITIZE_STRING);
				$warehouse = $this->request->getPost('warehouse',FILTER_SANITIZE_STRING);
				$barcode_type = $this->request->getPost('barcode_type',FILTER_SANITIZE_STRING);
				$barcode = $this->request->getPost('barcode',FILTER_SANITIZE_STRING);
				$sku = $this->request->getPost('sku',FILTER_SANITIZE_STRING);
				$serial_number = $this->request->getPost('serial_number',FILTER_SANITIZE_STRING);
				$reorder_stock = $this->request->getPost('reorder_stock',FILTER_SANITIZE_STRING);
				$expiration_date = $this->request->getPost('expiration_date',FILTER_SANITIZE_STRING);
				$purchase_price = $this->request->getPost('purchase_price',FILTER_SANITIZE_STRING);
				$selling_price = $this->request->getPost('selling_price',FILTER_SANITIZE_STRING);
				$product_description = $this->request->getPost('product_description',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				
				$UsersModel = new UsersModel();
				$MainModel = new MainModel();
				$Moduleattributes = new Moduleattributes();
				$Moduleattributesval = new Moduleattributesval();
				$Moduleattributesvalsel = new Moduleattributesvalsel();
				$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
				if($user_info['user_type'] == 'staff'){
					$company_id = $user_info['company_id'];
					$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',7)->orderBy('custom_field_id', 'ASC')->countAllResults();
					$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',7)->orderBy('custom_field_id', 'ASC')->findAll();
				} else {
					$company_id = $usession['sup_user_id'];
					$count_module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',7)->orderBy('custom_field_id', 'ASC')->countAllResults();
					$module_attributes = $Moduleattributes->where('company_id',$company_id)->where('module_id',7)->orderBy('custom_field_id', 'ASC')->findAll();
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
					'product_name' => $name,
					'reorder_stock'  => $reorder_stock,
					'barcode'  => $barcode,
					'barcode_type'  => $barcode_type,
					'warehouse_id'  => $warehouse,
					'category_id'  => $category,
					'product_sku'  => $sku,
					'product_serial_number'  => $serial_number,
					'purchase_price'  => $purchase_price,
					'retail_price'  => $selling_price,
					'expiration_date'  => $expiration_date,
					'product_description'  => $product_description
				];
				$ProductsModel = new ProductsModel();
				$result = $ProductsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_product_updated_msg');
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
	public function update_rating() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'edit_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$rules = [
				'product_rating' => [
					'rules'  => 'required',
					'errors' => [
						'required' => lang('Main.xin_error_field_text')
					]
				],
			];
			if(!$this->validate($rules)){
				$ruleErrors = [
                    "product_rating" => $validation->getError('product_rating'),
                ];
				foreach($ruleErrors as $err){
					$Return['error'] = $err;
					if($Return['error']!=''){
						$this->output($Return);
					}
				}
			} else {
				$product_rating = $this->request->getPost('product_rating',FILTER_SANITIZE_STRING);
				$id = udecode($this->request->getPost('token',FILTER_SANITIZE_STRING));
				$data = [
					'product_rating' => $product_rating,
				];
				$ProductsModel = new ProductsModel();
				$result = $ProductsModel->update($id,$data);	
				$Return['csrf_hash'] = csrf_hash();	
				if ($result == TRUE) {
					$Return['result'] = lang('Success.ci_product_rating_updated_msg');
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
	public function read_warehouse()
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
			return view('erp/inventory/dialog_warehouse', $data);
		} else {
			return redirect()->to(site_url('erp/login'));
		}
	}
	// delete record
	public function delete_product() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$usession = $session->get('sup_username');
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$ProductsModel = new ProductsModel();
			$result = $ProductsModel->where('product_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Success.ci_product_deleted_msg');
			} else {
				$Return['error'] = lang('Main.xin_error_msg');
			}
			$this->output($Return);
		}
	}
}

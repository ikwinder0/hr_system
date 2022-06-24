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
use App\Models\UsersModel;
use App\Models\LanguageModel;

class Languages extends BaseController {
	
	public function index()
	{		
		
		$session = \Config\Services::session();
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$usession = $session->get('sup_username');
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data['title'] = lang('Language.xin_languages').' | '.$xin_system['application_name'];
		$data['path_url'] = 'languages';
		$data['breadcrumbs'] = lang('Language.xin_languages');
		$data['subview'] = view('erp/languages/languages_list', $data);
		return view('erp/layout/layout_main', $data); //page load
		
	}
	
	 // list
	public function languages_list()
     {

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');		
		$LanguageModel = new LanguageModel();
		$SystemModel = new SystemModel();
		$languages = $LanguageModel->orderBy('language_id', 'ASC')->findAll();
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$data = array();
		
          foreach($languages as $r) {						
		  			
			$flag = '<img width="16" height="11" src="'.base_url().'/public/uploads/languages_flag/'.$r['language_flag'].'">';
			$name_flg = $flag.' '.$r['language_name'];
			
			if($r['language_id']=='1' ){
				$delete = '';
				$active_text = '';
				$success = lang('Main.xin_selected');
			} else {
				
				if($r['is_active']==1){
					$success = '<span data-toggle="tooltip" data-placement="top" title="'.lang('Main.xin_employees_inactive').'"><button type="button" class="btn icon-btn btn-sm btn-light-success active-lang mr-1" data-field_id="'. uencode($r['language_id']) . '" data-is_active="0"><span class="feather icon-check-circle"></span></button></span>';
					$active_text = lang('Main.xin_employees_active');
				} else {
					$success = '<span data-toggle="tooltip" data-placement="top" title="'.lang('Main.xin_employees_active').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger active-lang mr-1" data-field_id="'. uencode($r['language_id']) . '" data-is_active="1"><span class="feather icon-x-circle"></span></button></span>';
					$active_text = lang('Main.xin_employees_inactive');
				}
			$delete = '<span data-toggle="tooltip" data-placement="top" data-state="danger" title="'.lang('Main.xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['language_id']) . '"><i class="feather icon-trash-2"></i></button></span>';
			} 
			$combhr = $success.$delete;
			$links = '
				'.$active_text.'
				<div class="overlay-edit">
					'.$combhr.'
				</div>
			';						 			  				
			$data[] = array(
				$name_flg,
				$r['language_code'],
				$links,
			);
		}
          $output = array(
               //"draw" => $draw,
			   "data" => $data
            );
          echo json_encode($output);
          exit();
	}
	 
	public function add_language() {
			
		$validation =  \Config\Services::validation();
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');	
		if ($this->request->getPost('type') === 'add_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			// set rules
			$validation->setRules([
					'language_name' => 'required',
					'language_code' => 'required'
				],
				[   // Errors
					'language_name' => [
						'required' => lang('Language.xin_error_lang_name'),
					],
					'language_code' => [
						'required' => lang('Language.xin_error_lang_code'),
					]
				]
			);
			
			$validation->withRequest($this->request)->run();
			//check error
			if ($validation->hasError('language_name')) {
				$Return['error'] = $validation->getError('language_name');
			} elseif($validation->hasError('language_code')){
				$Return['error'] = $validation->getError('language_code');
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$image = service('image');
			$validated = $this->validate([
				'language_flag' => [
					'uploaded[language_flag]',
					'mime_in[language_flag,image/jpg,image/jpeg,image/gif,image/png]',
					'max_size[language_flag,4096]',
				],
			]);
			if (!$validated) {
				$Return['error'] = lang('Language.xin_error_lang_flag');
			} else {
				$avatar = $this->request->getFile('language_flag');
				$file_name = $avatar->getName();
				$avatar->move('public/uploads/languages_flag/temp/');
				$image->withFile(langfilesrc($file_name))
				->fit(16, 11, 'center')
				->save('public/uploads/languages_flag/'.$file_name);
			}
			if($Return['error']!=''){
				$this->output($Return);
			}
			$language_name = $this->request->getPost('language_name',FILTER_SANITIZE_STRING);
			$language_code = $this->request->getPost('language_code',FILTER_SANITIZE_STRING);
			
			$new_dir 	= 'app/Language/'.$language_code;
			$directoryName 	= $new_dir.'/Company.php';
			$directoryName2 	= $new_dir.'/Language.php';
			$directoryName3 	= $new_dir.'/index.html';
			$directoryName4 	= $new_dir.'/Asset.php';
			$directoryName5 	= $new_dir.'/Attendance.php';
			$directoryName6 	= $new_dir.'/Conference.php';
			$directoryName7 	= $new_dir.'/Dashboard.php';
			$directoryName8 	= $new_dir.'/Datatables.php';
			$directoryName9 	= $new_dir.'/Employees.php';
			$directoryName10 	= $new_dir.'/Finance.php';
			$directoryName11 	= $new_dir.'/Frontend.php';
			$directoryName12 	= $new_dir.'/Invoices.php';
			$directoryName13 	= $new_dir.'/Leave.php';
			$directoryName14 	= $new_dir.'/Login.php';
			$directoryName15 	= $new_dir.'/Main.php';
			$directoryName16 	= $new_dir.'/Membership.php';
			$directoryName17 	= $new_dir.'/Payroll.php';
			$directoryName18 	= $new_dir.'/Performance.php';
			$directoryName19 	= $new_dir.'/Projects.php';
			$directoryName20 	= $new_dir.'/Recruitment.php';
			$directoryName21 	= $new_dir.'/Success.php';
			$directoryName22 	= $new_dir.'/Users.php';
			//Check if the directory already exists.
			if(!is_dir($directoryName)){
				//Directory does not exist, so lets create it.
				mkdir(dirname($directoryName), 0777, true);
			}
			// create language file
			$fp = fopen('Company.php','w');
			fwrite($fp, 'data to be written');
			fclose($fp);
			// create language file
			$fp1 = fopen('Language.php','w');
			fwrite($fp1, 'data to be written');
			fclose($fp1);
			// create index-html file
			$fp2 = fopen('index.html','w');
			fwrite($fp2, 'data to be written');
			fclose($fp2);
			// create language file
			$fp3 = fopen('Asset.php','w');
			fwrite($fp3, 'data to be written');
			fclose($fp3);
			// create language file
			$fp4 = fopen('Attendance.php','w');
			fwrite($fp4, 'data to be written');
			fclose($fp4);
			// create language file
			$fp5 = fopen('Conference.php','w');
			fwrite($fp5, 'data to be written');
			fclose($fp5);
			// create language file
			$fp6 = fopen('Dashboard.php','w');
			fwrite($fp6, 'data to be written');
			fclose($fp6);
			// create language file
			$fp7 = fopen('Datatables.php','w');
			fwrite($fp7, 'data to be written');
			fclose($fp7);
			// create language file
			$fp8 = fopen('Employees.php','w');
			fwrite($fp8, 'data to be written');
			fclose($fp8);
			// create language file
			$fp9 = fopen('Finance.php','w');
			fwrite($fp9, 'data to be written');
			fclose($fp9);
			// create language file
			$fp10 = fopen('Frontend.php','w');
			fwrite($fp10, 'data to be written');
			fclose($fp10);
			// create language file
			$fp11 = fopen('Invoices.php','w');
			fwrite($fp11, 'data to be written');
			fclose($fp11);
			// create language file
			$fp12 = fopen('Leave.php','w');
			fwrite($fp12, 'data to be written');
			fclose($fp12);
			// create language file
			$fp13 = fopen('Login.php','w');
			fwrite($fp13, 'data to be written');
			fclose($fp13);
			// create language file
			$fp14 = fopen('Main.php','w');
			fwrite($fp14, 'data to be written');
			fclose($fp14);
			// create language file
			$fp15 = fopen('Membership.php','w');
			fwrite($fp15, 'data to be written');
			fclose($fp15);
			// create language file
			$fp16 = fopen('Payroll.php','w');
			fwrite($fp16, 'data to be written');
			fclose($fp16);
			// create language file
			$fp17 = fopen('Performance.php','w');
			fwrite($fp17, 'data to be written');
			fclose($fp17);
			// create language file
			$fp18 = fopen('Projects.php','w');
			fwrite($fp18, 'data to be written');
			fclose($fp18);
			// create language file
			$fp19 = fopen('Recruitment.php','w');
			fwrite($fp19, 'data to be written');
			fclose($fp19);
			// create language file
			$fp20 = fopen('Success.php','w');
			fwrite($fp20, 'data to be written');
			fclose($fp20);
			// create language file
			$fp21 = fopen('Users.php','w');
			fwrite($fp21, 'data to be written');
			fclose($fp21);
			
			
			$srcfile 	= 'app/Language/en/Company.php';
			$srcfile2 	= 'app/Language/en/Language.php';
			$srcfile3 	= 'app/Language/en/index.html';
			$srcfile4 	= 'app/Language/en/Asset.php';
			$srcfile5 	= 'app/Language/en/Attendance.php';
			$srcfile6 	= 'app/Language/en/Conference.php';
			$srcfile7 	= 'app/Language/en/Dashboard.php';
			$srcfile8 	= 'app/Language/en/Datatables.php';
			$srcfile9 	= 'app/Language/en/Employees.php';
			$srcfile10 	= 'app/Language/en/Finance.php';
			$srcfile11 	= 'app/Language/en/Frontend.php';
			$srcfile12 	= 'app/Language/en/Invoices.php';
			$srcfile13 	= 'app/Language/en/Leave.php';
			$srcfile14 	= 'app/Language/en/Login.php';
			$srcfile15 	= 'app/Language/en/Main.php';
			$srcfile16 	= 'app/Language/en/Membership.php';
			$srcfile17 	= 'app/Language/en/Payroll.php';
			$srcfile18 	= 'app/Language/en/Performance.php';
			$srcfile19 	= 'app/Language/en/Projects.php';
			$srcfile20 	= 'app/Language/en/Recruitment.php';
			$srcfile21 	= 'app/Language/en/Success.php';
			$srcfile22 	= 'app/Language/en/Users.php';
			// copy files
			copy($srcfile22, $directoryName22);
			copy($srcfile21, $directoryName21);
			copy($srcfile20, $directoryName20);
			copy($srcfile19, $directoryName19);
			copy($srcfile18, $directoryName18);
			copy($srcfile17, $directoryName17);
			copy($srcfile16, $directoryName16);
			copy($srcfile15, $directoryName15);
			copy($srcfile14, $directoryName14);
			copy($srcfile13, $directoryName13);
			copy($srcfile12, $directoryName12);
			copy($srcfile11, $directoryName11);
			copy($srcfile10, $directoryName10);
			copy($srcfile9, $directoryName9);
			copy($srcfile8, $directoryName8);
			copy($srcfile7, $directoryName7);
			copy($srcfile6, $directoryName6);
			copy($srcfile5, $directoryName5);
			copy($srcfile4, $directoryName4);
			copy($srcfile3, $directoryName3);
			copy($srcfile2, $directoryName2);
			copy($srcfile, $directoryName);
		
			$data = [
				'language_name' => $language_name,
				'language_code'  => $language_code,
				'language_flag'  => $file_name,
				'is_active'  => 1,
				'created_at' => date('d-m-Y h:i:s')
			];
			$LanguageModel = new LanguageModel();
			$result = $LanguageModel->insert($data);	
			$Return['csrf_hash'] = csrf_hash();	
			if ($result == TRUE) {
				$Return['result'] = lang('Language.xin_success_lang_added');
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
	 // delete record
	public function delete_language() {
		
		if($this->request->getPost('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$session = \Config\Services::session();
			$request = \Config\Services::request();
			$id = udecode($this->request->getPost('_token',FILTER_SANITIZE_STRING));
			$Return['csrf_hash'] = csrf_hash();
			$LanguageModel = new LanguageModel();
			$result = $LanguageModel->where('language_id', $id)->delete($id);
			if ($result == TRUE) {
				$Return['result'] = lang('Language.xin_success_lang_deleted');
			} else {
				$Return['error'] = lang('Membership.xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// Validate and update info in database
	public function language_status() {
	
		$request = \Config\Services::request();
		
		if ($this->request->getMethod() === 'get') {
		
			$session = \Config\Services::session();
			$id = udecode($request->getGet('field_id'));
			$is_active = $request->getGet('is_active');
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
			
			if($is_active == 1) {
				$data = array(
				'is_active' => '1'
				);
				$msg = lang('Language.xin_success_lang_activated');
			} else {
				$data = array(
				'is_active' => '0'
				);
				$msg = lang('Language.xin_success_lang_deactivated');
			}
			$LanguageModel = new LanguageModel();
			$result = $LanguageModel->update($id, $data);		
			
			if ($result == TRUE) {
				$Return['result'] = $msg;
			} else {
				$Return['error'] = $this->lang->line('Main.xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
}

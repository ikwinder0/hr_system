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
 
use App\Models\UsersModel;

class Logout extends BaseController
{	 
	public function index() {
	
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		$last_data = array(
			'is_logged_in' => '0',
			'last_logout_date' => date('d-m-Y H:i:s')
		); 
		$UsersModel->update($usession['sup_user_id'], $last_data);
		// Removing session data
		$session->destroy();
		$Return['result'] = 'Successfully Logout.';
		return redirect()->to(site_url('erp/login'));
	}
} 
?>
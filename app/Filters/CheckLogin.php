<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UsersModel;

class CheckLogin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		if(!$session->has('sup_username')){ 
			$session->setFlashdata('err_not_logged_in',lang('Dashboard.err_not_logged_in'));
			return redirect()->to(site_url('erp/login'));
		}
		$usession = $session->get('sup_username');
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
		if($user_info['is_active']!=1) {
			$session->destroy();
			return redirect()->to(site_url('erp/login'));
		}
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
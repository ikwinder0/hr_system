<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UsersModel;

class CompanyAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$UsersModel = new UsersModel();
		if(!empty($usession)){
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] != 'company' && $user_info['user_type']!='staff'){
				$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
				return redirect()->to(site_url('erp/desk'));
			}
		} else {
			$session->setFlashdata('unauthorized_module',lang('Dashboard.xin_error_unauthorized_module'));
			return redirect()->to(site_url('erp/desk'));
		}
    }
    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
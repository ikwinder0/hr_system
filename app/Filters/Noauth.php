<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Noauth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if($session->has('sup_username')){
			$session->setFlashdata('unauthorized_module',lang('Dashboard.err_already_logged_in_to_system').$usession['sup_username'].lang('Dashboard.err_you_need_to_loggin_in_as_different_user'));
			return redirect()->to(site_url('erp/desk'));
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
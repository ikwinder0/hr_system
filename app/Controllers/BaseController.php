<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form','html','inflector','number','security','text','url','string','main','filesystem','encrypt','timehr'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		$language = \Config\Services::language();
		
		$UsersModel = new \App\Models\UsersModel();
		$SystemModel = new \App\Models\SystemModel();
		if(!empty($usession)){
			$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
			if($user_info['user_type'] == 'super_user'){
				$xin_system = $SystemModel->where('setting_id', 1)->first();
				$language->setLocale($xin_system['default_language']);
				date_default_timezone_set($xin_system['system_timezone']);
			} else {
				$xin_system = erp_company_settings();
				$language->setLocale($xin_system['default_language']);
				date_default_timezone_set($xin_system['system_timezone']);
			}
			$language->setLocale($session->lang);
		}
		//use App\Models\SystemModel;
		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
}

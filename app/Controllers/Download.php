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
namespace App\Controllers;
use App\Controllers\BaseController;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Download extends BaseController {
	
	public function force_download($filename = '', $data = '')
	 {
	  if ($filename == '' OR $data == '')
	  {
	   return FALSE;
	  }
	
	  // Try to determine if the filename includes a file extension.
	  // We need it in order to set the MIME type
	  if (FALSE === strpos($filename, '.'))
	  {
	   return FALSE;
	  }
	 
	  // Grab the file extension
	  $x = explode('.', $filename);
	  $extension = end($x);
	
	  // Load the mime types
	 // @include(APPPATH.'config/mimes'.EXT);
	 
	  // Set a default mime if we can't find it
	  if ( ! isset($mimes[$extension]))
	  {
	   $mime = 'application/octet-stream';
	  }
	  else
	  {
	   $mime = (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
	  }
	 
	  // Generate the server headers
	  if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
	  {
	   header('Content-Type: "'.$mime.'"');
	   header('Content-Disposition: attachment; filename="'.$filename.'"');
	   header('Expires: 0');
	   header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	   header("Content-Transfer-Encoding: binary");
	   header('Pragma: public');
	   header("Content-Length: ".strlen($data));
	  }
	  else
	  {
	   header('Content-Type: "'.$mime.'"');
	   header('Content-Disposition: attachment; filename="'.$filename.'"');
	   header("Content-Transfer-Encoding: binary");
	   header('Expires: 0');
	   header('Pragma: no-cache');
	   header("Content-Length: ".strlen($data));
	  }
	 
	  exit($data);
	}	
	public function index() {	
		
		$request = \Config\Services::request();
		// type
		$type = $this->request->getGet('type');
		
		if($type) {
			//Set the time out
			set_time_limit(0);
			$data = file_get_contents(base_url().'/public/uploads/'.$type.'/'.udecode($this->request->getGet('filename')));
			$this->force_download(udecode($this->request->getGet('filename')), $data);
		}
	}
}

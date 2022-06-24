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

require_once APPPATH . 'ThirdParty/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class Pdf extends BaseController {

	public function index() 
	{
        return view('erp/dompdf/employee_profile');
    }

    function htmlToPDF(){
        $dompdf = new Dompdf(); 
		$options = $dompdf->getOptions();
		$options->setIsRemoteEnabled(true);
		$options->setDefaultFont('Courier');
		$dompdf->setOptions($options);
        $dompdf->loadHtml(view('erp/dompdf/employee_profile'));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream();
		//$domPdf->output();
    }
}

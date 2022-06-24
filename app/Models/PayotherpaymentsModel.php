<?php
namespace App\Models;

use CodeIgniter\Model;
	
class PayotherpaymentsModel extends Model {
 
    protected $table = 'ci_payslip_other_payments';

    protected $primaryKey = 'payslip_other_payment_id';
    
	// get all fields of table
    protected $allowedFields = ['payslip_other_payment_id','payslip_id','staff_id','is_taxable','is_fixed','pay_title','pay_amount','salary_month','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
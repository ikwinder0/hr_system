<?php
namespace App\Models;

use CodeIgniter\Model;
	
class PaystatutorydeductionsModel extends Model {
 
    protected $table = 'ci_payslip_statutory_deductions';

    protected $primaryKey = 'payslip_deduction_id';
    
	// get all fields of table
    protected $allowedFields = ['payslip_deduction_id','payslip_id','staff_id','is_fixed','pay_title','pay_amount','salary_month','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
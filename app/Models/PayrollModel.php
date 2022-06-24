<?php
namespace App\Models;

use CodeIgniter\Model;
	
class PayrollModel extends Model {
 
    protected $table = 'ci_payslips';

    protected $primaryKey = 'payslip_id';
    
	// get all fields of table
    protected $allowedFields = ['payslip_id','payslip_key','company_id','staff_id','salary_month','wages_type','payslip_type','basic_salary','daily_wages','hours_worked','total_allowances','total_commissions','total_statutory_deductions','total_other_payments','net_salary','payment_method','pay_comments','is_payment','year_to_date','is_advance_salary_deduct','advance_salary_amount','is_loan_deduct','loan_amount','status','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
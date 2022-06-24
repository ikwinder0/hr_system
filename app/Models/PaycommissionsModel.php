<?php
namespace App\Models;

use CodeIgniter\Model;
	
class PaycommissionsModel extends Model {
 
    protected $table = 'ci_payslip_commissions';

    protected $primaryKey = 'payslip_commissions_id';
    
	// get all fields of table
    protected $allowedFields = ['payslip_commissions_id','payslip_id','staff_id','is_taxable','is_fixed','pay_title','pay_amount','salary_month','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class AdvancesalaryModel extends Model {
 
    protected $table = 'ci_advance_salary';

    protected $primaryKey = 'advance_salary_id';
    
	// get all fields of table
    protected $allowedFields = ['advance_salary_id','company_id','employee_id','month_year','salary_type','advance_amount','one_time_deduct','monthly_installment','total_paid','reason','status','is_deducted_from_salary','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
<?php
namespace App\Models;

use CodeIgniter\Model;
	
class EstimatesModel extends Model {
 
    protected $table = 'ci_estimates';

    protected $primaryKey = 'estimate_id';
    
	// get all fields of table
    protected $allowedFields = ['estimate_id','estimate_number','company_id','client_id','project_id','estimate_month','estimate_date','estimate_due_date','sub_total_amount','discount_type','discount_figure','total_tax','tax_type','total_discount','grand_total','estimate_note','status','payment_method','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
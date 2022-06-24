<?php
namespace App\Models;

use CodeIgniter\Model;
	
class AwardsModel extends Model {
 
    protected $table = 'ci_awards';

    protected $primaryKey = 'award_id';
    
	// get all fields of table
    protected $allowedFields = ['award_id','company_id','employee_id','award_type_id','associated_goals','gift_item','cash_price','award_photo','award_month_year','award_information','description','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
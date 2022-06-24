<?php
namespace App\Models;

use CodeIgniter\Model;
	
class HolidaysModel extends Model {
 
    protected $table = 'ci_holidays';

    protected $primaryKey = 'holiday_id';
    
	// get all fields of table
    protected $allowedFields = ['holiday_id','company_id','event_name','description','start_date','end_date','is_publish','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
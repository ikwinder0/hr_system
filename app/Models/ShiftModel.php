<?php
namespace App\Models;

use CodeIgniter\Model;

class ShiftModel extends Model {
 
    protected $table = 'ci_office_shifts';

    protected $primaryKey = 'office_shift_id';
    
	// get all fields of table
    protected $allowedFields = ['office_shift_id','company_id','shift_name','monday_in_time','monday_out_time','tuesday_in_time','tuesday_out_time','wednesday_in_time','wednesday_out_time','thursday_in_time','thursday_out_time','friday_in_time','friday_out_time','saturday_in_time','saturday_out_time','sunday_in_time','sunday_out_time','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
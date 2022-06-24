<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TransfersModel extends Model {
 
    protected $table = 'ci_transfers';

    protected $primaryKey = 'transfer_id';
    
	// get all fields of table
    protected $allowedFields = ['transfer_id','company_id','employee_id','transfer_date','transfer_department','transfer_designation','reason','status','added_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
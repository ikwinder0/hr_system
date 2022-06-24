<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TicketsModel extends Model {
 
    protected $table = 'ci_support_tickets';

    protected $primaryKey = 'ticket_id';
    
	// get all fields of table
    protected $allowedFields = ['ticket_id','company_id','ticket_code','subject','employee_id','ticket_priority','department_id','description','ticket_remarks','ticket_status','created_by','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>
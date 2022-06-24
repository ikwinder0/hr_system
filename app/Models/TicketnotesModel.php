<?php
namespace App\Models;

use CodeIgniter\Model;
	
class TicketnotesModel extends Model {
 
    protected $table = 'ci_support_ticket_notes';

    protected $primaryKey = 'ticket_note_id';
    
	// get all fields of table
    protected $allowedFields = ['ticket_note_id','company_id','ticket_id','employee_id','ticket_note','created_at'];
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	
}
?>